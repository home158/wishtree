<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Favor extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->display_data["highlight_navi"] = "home";
        $this->parse_display_data(
            array('btn' ,'alert' ,'role' , 'favor')
        );
        
        $this->login_required_validation();
        $this->load->model('home_model');

        //$this->alertMsg();
        $this->load->model('favor_model');

    }
    public function index()
    {
    }
    public function tracker()
    {
        $this->load->model('error_model');
        $userGUID = $this->session->userdata('GUID');
        $r = $this->favor_model->get_tracker( $userGUID);

        header('Content-Type: application/json');
        echo json_encode($r);
        exit;
    }
    public function add()
    {
        $this->load->model('error_model');
        $trackUserGUID = $this->input->post('trackUserGUID');
        $userGUID = $this->session->userdata('GUID');
        header('Content-Type: application/json');
        //check GUID is exist in i_user
        $user_exist = $this->utility_model->is_user_exist_by_GUID( $userGUID);
        $favor_exist = $this->favor_model->is_favor_exist( $userGUID , $trackUserGUID);
        if($user_exist == TRUE and $favor_exist == FALSE){
            $insert_data = array(
                'UserGUID' => $userGUID,
                'TrackUserGUID' => $trackUserGUID,
                'DateCreate' => date('Y-m-d H:i:s'),
                'DateModify' => date('Y-m-d H:i:s')
            );
            $insert_string = $this->db->insert_string('[dbo].[i_favor]', $insert_data);
            $this->db->query( $insert_string );

            echo $this->error_model->retrieve_error_msg(0, NULL , $this->display_data['favor_add_success']);
            exit;
        }
        
        if($user_exist == FALSE)
        {
            echo $this->error_model->retrieve_error_msg(2 , NULL , $this->display_data['favor_target_user_not_exist']);
            exit;
        }
        if($favor_exist == TRUE)
        {
            echo $this->error_model->retrieve_error_msg(3 , NULL , $this->display_data['favor_has_record']);
            exit;
        }

    }
}