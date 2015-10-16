<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fortune extends Admin_Base_Controller {
    private $UI_columns = array('[FortuneID]','F.[GUID] AS [GUID]','U.[GUID] AS [UserGUID]','F.[Nickname]','F.[Role]','Lunar','U.[Email]','[PaymentStatus]','[FortuneStatus]','[ST]','[DateST]','[MT]','[DateMT]','[NotifyPaymentStatus]');
    
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(
            array( 'fortune','menu','btn','contextmenu','grid')
        );
        $this->load->model('fortune_model');

    }
    public function detail($GUID)
    {
        $this->additionalColumn();
        $result_info = $this->fortune_model->retrive_row_data_by_GUID($GUID ,   $this->UI_columns);
        $r = (array) $result_info['object']->row();

        
        $this->display_data['fortune_GUID'] = $GUID;
        $orderlist = $this->fortune_model->retrieve_histories($r['UserGUID'],$GUID);
        $message_list = $this->fortune_model->retrieve_response_messages($r['UserGUID'],$GUID);
        $this->display_data['orderlist'] = $orderlist;
        $this->display_data['message_list'] = $message_list;


        $this->load->library('tinymce');
        $this->display_data['head'] = $this->tinymce->createhead();
        $buttons = array(
            array(
                'name' => "Submit",
                'type' => 'submit',
                'class' => "btn-relax btn-xl",
                'value' => "新增"
            ),
            array(
                'name' => "Reset",
                'type' => 'reset',
                'class' => "btn-gray btn-xl",
                'value' => "取消"
            )
        );

        $this->display_data['mce'] = $this->tinymce->textarea(true , 'products_admin/add_process' , $buttons);

        $this->utility_model->parse('site/_default/header',$this->display_data);
        
        $this->utility_model->parse('site/fortune/response',$this->display_data);
        $this->utility_model->parse('admin/_default/popup_footer',$this->display_data);
        
        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);


    }
    public function reply($fortune_GUID)
    {
            $this->load->library('uuid');
            $message_data = array(
                'GUID' => $this->uuid->v4(),
                'FortuneGUID' => $fortune_GUID,
                'ReplyParent' => $this->input->post('reply_parent' , TRUE),
                'UserGUID' => $this->session->userdata('GUID'),
                'PblmTel' => NULL,
                'PblmEmail' => NULL,
                'PblmCode' => 0,
                'FortuneMessage' => $this->input->post('fortune_message' )
            );
            $insert_string = $this->db->insert_string('[dbo].[i_fortune_message]', $message_data);
            $this->db->query( $insert_string );
    }
    public function view($GUID = "00000000-0000-0000-0000-000000000000")
    {
        $top = 0;
        $bottom =37;
        $this->additionalColumn();
        //init data grid
        switch($GUID){
            default:
                    $query = $this->fortune_model->select_data_limit_offset('[dbo].[i_fortune]', $top , $bottom , $this->UI_columns);
                break;
        }
        $data = array(
            'grid_data' => json_encode($query['object']->result()),
            'num_rows' => $query['num_rows'],
            'GUID_list' => json_encode( $query['GUID_list'] ),
            'GUID' => $GUID
        );
        $this->display_data['menu_total_rows'] = sprintf($this->display_data['menu_total_rows'] , $data['num_rows'] );
        $this->display_data = array_merge($this->display_data , $data);
        
		$this->parser->parse('admin/_default/header',$this->display_data);
		$this->parser->parse('admin/_default/navi',$this->display_data);
		$this->parser->parse('admin/fortune/index',$this->display_data);
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
        $payment_status = $this->input->post('PAYMENT_STATUS',true);
        $ST = $this->input->post('ST',true);
        $MT = $this->input->post('MT',true);
        
        $query = $this->fortune_model->select_data_limit_offset('[dbo].[i_fortune]' , $top , $bottom , 
                                                                $this->UI_columns ,
                                                                $payment_status ,
                                                                $ST ,
                                                                $MT ,
                                                                $sort_column_id , $order_method , $search_txt);
        $data = array(
            'grid_data' => $query['object']->result(),
            'GUID_list' => $query['GUID_list'],

            'num_rows' => $query['num_rows'],
            'top' => $top,
            'bottom' => $bottom,
            'sort_column_id' => $sort_column_id,
            'order_method' => $order_method,
            'payment_status' => $payment_status,
            'search_txt' => $search_txt     
        );
        
        header('Content-Type: application/json');
        echo json_encode($data);    }
    public function mt()
    {
        $this->load->model('error_model');
        $GUID = $this->input->post('GUID');
        $update_data = array(
            'MT' => $this->input->post('status'),
            'DateMT' => date('Y-m-d H:i:s')
        );
        if($update_data['MT'] == 0){
            $update_data['DateMT'] = NULL;
        }
        $query = $this->db->update('[dbo].[i_fortune]', $update_data, array('GUID' => $GUID));
       

        $this->additionalColumn();
        $result_info = $this->fortune_model->retrive_row_data_by_GUID($GUID ,   $this->UI_columns);

        header('Content-Type: application/json');
        if($query == true){
            echo $this->error_model->retrieve_error_msg(0 , NULL , (array) $result_info['object']->row() );
        }else{
            echo $this->error_model->retrieve_error_msg(1);
        }    
    }
    public function cancel()
    {
        $this->load->model('error_model');
        $GUID = $this->input->post('GUID');
        $update_data = array(
            'ST' => $this->input->post('status'),
            'DateST' => date('Y-m-d H:i:s')
        );
        if($update_data['ST'] == 0){
            $update_data['DateST'] = NULL;
        }
        $query = $this->db->update('[dbo].[i_fortune]', $update_data, array('GUID' => $GUID));
       

        $this->additionalColumn();
        $result_info = $this->fortune_model->retrive_row_data_by_GUID($GUID ,   $this->UI_columns);

        header('Content-Type: application/json');
        if($query == true){
            echo $this->error_model->retrieve_error_msg(0 , NULL , (array) $result_info['object']->row() );
        }else{
            echo $this->error_model->retrieve_error_msg(1);
        }    
    }
    public function payment_vaildate()
    {
        $this->load->model('error_model');
        $GUID = $this->input->post('GUID');
        $update_data = array(
            'PaymentStatus' => $this->input->post('status'),
            'DatePayment' => date('Y-m-d H:i:s')
        );
        if($update_data['PaymentStatus'] == 0){
            $update_data['DatePayment'] = NULL;
        }
        $query = $this->db->update('[dbo].[i_fortune]', $update_data, array('GUID' => $GUID));
       

        $this->additionalColumn();
        $result_info = $this->fortune_model->retrive_row_data_by_GUID($GUID ,   $this->UI_columns);

        header('Content-Type: application/json');
        if($query == true){
            echo $this->error_model->retrieve_error_msg(0 , NULL , (array) $result_info['object']->row() );
        }else{
            echo $this->error_model->retrieve_error_msg(1);
        }
    }
    public function advise_add($fortune_GUID)
    {
        $advise_GUID = $this->input->post('status',TRUE);
        $advise_data = array(
            'FortuneGUID' => $fortune_GUID,
            'UserGUID' => $this->session->userdata('GUID',TRUE),
            'AdviseMessage' => $this->input->post('advise_message' , TRUE),
            'Publish' => $this->session->userdata('post_publish',TRUE)
        );
        if($advise_GUID){
            $query = $this->db->update('[dbo].[i_fortune_advise]', $advise_data, array('GUID' => $advise_GUID));
        
        }else{
            $this->load->library('uuid');
            $advise_data['GUID'] = $this->uuid->v4();
            $insert_string = $this->db->insert_string('[dbo].[i_fortune_advise]', $advise_data);
            $this->db->query( $insert_string );
        
        }
            redirect( base_url() , 'admin/fortune/detail/'.$fortune_GUID);

    }
    private function additionalColumn()
    {
        array_push( $this->UI_columns , 
                
                $this->utility_model->dbColumnDatetimeNoOffset('F.[Birthday]' , '[Birthday]' , 10),
                $this->utility_model->dbColumnDatetime('[DateST]' ),
                $this->utility_model->dbColumnDatetime('[DateMT]' ),
                $this->utility_model->dbColumnDatetime('F.[DateModify]' , '[DateModify]' ),
                $this->utility_model->dbColumnDatetime('F.[DateCreate]' , '[DateCreate]' ),
                $this->utility_model->dbColumnDatetime('F.[DatePayment]' , '[DatePayment]' ),
                $this->utility_model->dbColumnDatetime('F.[DateNotifyPayment]' , '[DateNotifyPayment]' ),
                $this->utility_model->dbColumnDatetime('U.[LastLoginTime]' , '[LastLoginTime]' )
                
        );
    }
}