<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends Admin_Base_Controller {
    private $UI_columns = array('PhotoID', 'P.[GUID]' ,'Email','UserGUID', 'U.[Nickname] AS [Nickname]' , 'ReviewStatus' , 'IsCover' ,'IsPrivate' ,'[FullBasename]' ,'[CropBasename]','U.[Role]');
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(
            array( 'btn','alert', 'rank', 'role','photo','menu' , 'grid' , 'contextmenu', 'message', 'account')
        );
        $this->load->model('photo_model');

    }
    public function view($GUID = "00000000-0000-0000-0000-000000000000")
    {
        $top = 0;
        $bottom =37;
        $this->additionalColumn();
        //init data grid
        switch($GUID){
            default:
                    $query = $this->photo_model->select_data_limit_offset('[dbo].[i_photo]', $top , $bottom , $this->UI_columns);
                break;
        }
        $data = array(
            'grid_data' => json_encode($query['object']->result()),
            'num_rows' => $query['num_rows'],
            'GUID_list' => json_encode( $query['GUID_list'] ),
            'GUID' => $GUID
        );
        $this->display_data['azure_storage_baseurl'] = $this->config->item('azure_storage_baseurl');
        $this->display_data['menu_total_rows'] = sprintf($this->display_data['menu_total_rows'] , $data['num_rows'] );
        $this->display_data = array_merge($this->display_data , $data);
        

		$this->parser->parse('admin/_default/header',$this->display_data);
		$this->parser->parse('admin/_default/navi',$this->display_data);
		$this->parser->parse('admin/photo/index',$this->display_data);
		$this->parser->parse('admin/_default/footer',$this->display_data);
    }
    public function retrieve_list()
    {
        $this->additionalColumn();
        $top = $this->input->post('top',true);
        $bottom = $this->input->post('bottom',true);
        $sort_column_id = $this->input->post('SORT_COLUMN_ID',true);
        $order_method = $this->input->post('ORDER_METHOD',true); // true or false
        $search_txt = $this->input->post('SEARCH_TXT',true);
        $review_status = $this->input->post('REVIEW_STATUS',true);
        $is_private = $this->input->post('IS_PRIVATE',true);
        
        $query = $this->photo_model->select_data_limit_offset('[dbo].[i_photo]' , $top , $bottom , 
                                                                $this->UI_columns ,
                                                                $review_status,$is_private,
                                                                $sort_column_id , $order_method , $search_txt);
        $data = array(
            'grid_data' => $query['object']->result(),
            'GUID_list' => $query['GUID_list'],

            'num_rows' => $query['num_rows'],
            'top' => $top,
            'bottom' => $bottom,
            'sort_column_id' => $sort_column_id,
            'order_method' => $order_method,
            'search_txt' => $search_txt,
            'review_status' => $review_status
        );
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function review()
    {
        $this->load->model('error_model');
        $GUID = $this->input->post('GUID');
        $update_data = array(
            'ReviewStatus' => $this->input->post('status'),
            'ReviewDate' => date('Y-m-d H:i:s')
        );
        if($update_data['ReviewStatus'] == 0){
            $update_data['ReviewDate'] = NULL;
        }
        $query = $this->db->update('[dbo].[i_photo]', $update_data, array('GUID' => $GUID));

        $this->additionalColumn();
        $result_info = $this->photo_model->retrive_row_data_by_GUID($GUID ,   $this->UI_columns);

        header('Content-Type: application/json');
        if($query == true){
            echo $this->error_model->retrieve_error_msg(0 , NULL , (array) $result_info['object']->row() );
        }else{
            echo $this->error_model->retrieve_error_msg(1);
        }

    }
    private function additionalColumn()
    {
        
        array_push( $this->UI_columns , 
                
                $this->utility_model->dbColumnDatetime('P.[ReviewDate]' , '[ReviewDate]'),
                $this->utility_model->dbColumnDatetime('P.[DateModify]' , '[DateModify]'),
                $this->utility_model->dbColumnDatetime('P.[DateCreate]' , '[DateCreate]')
        );
    }
}