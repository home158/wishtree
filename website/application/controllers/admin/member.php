<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Admin_Base_Controller {
    private $UI_columns = array('UserID','Nickname','GUID','ProfileReviewStatus','DeleteStatus','ForbiddenStatus');
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(
            array( 'account' , 'rank' , 'email' , 'role' ,'btn', 'grid','register','member','city','language','birthday','height','bodytype','race',
                'income','property','education','maritalstatus' ,'smoking','drinking' , 'timezoneoffset' , 'dst' , 'alert' , 'menu','photo' , 'contextmenu')
        );
        $this->load->model('member_model');

    }
    public function view($GUID = "00000000-0000-0000-0000-000000000000")
    {
        $top = 0;
        $bottom =37;
        $this->additionalColumn();
        //init data grid
        switch($GUID){
            default:
                    $query = $this->member_model->select_data_limit_offset('[dbo].[i_user]', $top , $bottom , $this->UI_columns);
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
		$this->parser->parse('admin/member/index',$this->display_data);
		$this->parser->parse('admin/_default/footer',$this->display_data);
    }
    public function retrieve_member_list()
    {
        $this->additionalColumn();
        $top = $this->input->post('top',true);
        $bottom = $this->input->post('bottom',true);
        $Rank_between_from = $this->input->post('RANK_BETWEEN_FROM',true);
        $Rank_between_to = $this->input->post('RANK_BETWEEN_TO',true);
        $sort_column_id = $this->input->post('SORT_COLUMN_ID',true);
        $order_method = $this->input->post('ORDER_METHOD',true); // true or false
        $search_txt = $this->input->post('SEARCH_TXT',true);
        $profile_review_status = $this->input->post('PROFILE_REVIEW_STATUS',true);
        $delete_status = $this->input->post('DELETE_STATUS',true);
        $forbidden_status = $this->input->post('FORBIDDEN_STATUS',true);

        $query = $this->member_model->select_data_limit_offset('[dbo].[i_user]' , $top , $bottom , 
                                                                $this->UI_columns , $Rank_between_from , $Rank_between_to , 
                                                                $profile_review_status, $delete_status , $forbidden_status,
                                                                $sort_column_id , $order_method , $search_txt);
        $data = array(
            'grid_data' => $query['object']->result(),
            'GUID_list' => $query['GUID_list'],

            'num_rows' => $query['num_rows'],
            'top' => $top,
            'bottom' => $bottom,
            'Rank_between_from' => $Rank_between_from,
            'Rank_between_to' => $Rank_between_to,
            'sort_column_id' => $sort_column_id,
            'order_method' => $order_method,
            'search_txt' => $search_txt,
            'profile_review_status' => $profile_review_status,
            'delete_status' => $delete_status,
            'forbidden_status' => $forbidden_status
        );
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function account_delete()
    {
        $this->load->model('error_model');
        $GUID = $this->input->post('GUID');
        $update_data = array(
            'DeleteStatus' => $this->input->post('status'),
            'DeleteDate' => date('Y-m-d H:i:s')
        );
        if($update_data['DeleteStatus'] == 0){
            $update_data['DeleteDate'] = NULL;
        }
        $query = $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID));

        $this->additionalColumn();
        $result_info = $this->member_model->retrive_row_data_by_GUID($GUID ,   $this->UI_columns);

        header('Content-Type: application/json');
        if($query == true){
            echo $this->error_model->retrieve_error_msg(0 , NULL , (array) $result_info['object']->row() );
        }else{
            echo $this->error_model->retrieve_error_msg(1);
        }
    }
    public function account_forbidden()
    {
        $this->load->model('error_model');
        $GUID = $this->input->post('GUID');
        $update_data = array(
            'ForbiddenStatus' => $this->input->post('status'),
            'ForbiddenDate' => date('Y-m-d H:i:s')
        );
        if($update_data['ForbiddenStatus'] == 0){
            $update_data['ForbiddenDate'] = NULL;
        }
        $query = $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID));

        $this->additionalColumn();
        $result_info = $this->member_model->retrive_row_data_by_GUID($GUID ,   $this->UI_columns);

        header('Content-Type: application/json');
        if($query == true){
            echo $this->error_model->retrieve_error_msg(0 , NULL , (array) $result_info['object']->row() );
        }else{
            echo $this->error_model->retrieve_error_msg(1);
        }
    }
    public function profile_review()
    {
        $this->load->model('error_model');
        $GUID = $this->input->post('GUID');
        $update_data = array(
            'ProfileReviewStatus' => $this->input->post('status'),
            'ProfileReviewDate' => date('Y-m-d H:i:s')
        );
        if($update_data['ProfileReviewStatus'] == 0){
            $update_data['ProfileReviewDate'] = NULL;
        }
        $query = $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID));

        $this->additionalColumn();
        $result_info = $this->member_model->retrive_row_data_by_GUID($GUID ,   $this->UI_columns);

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
                $this->utility_model->dbColumnDatetime('[LastLoginTime]' ),
                $this->utility_model->dbColumnDatetime('[DateModify]' ),
                $this->utility_model->dbColumnDatetime('[DateCreate]' ),
                $this->utility_model->dbColumnDatetime('[ProfileReviewDate]' ),
                $this->utility_model->dbColumnDatetime('[DeleteDate]' ),
                $this->utility_model->dbColumnDatetime('[ForbiddenDate]' )
        );
    }

}

/* End of file member.php */
/* Location: ./application/controllers/admin/member.php */