<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Action extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->display_data["highlight_navi"] = "home";
        $this->parse_display_data(
            array('btn' ,'alert' ,'role' , 'action')
        );
        
        $this->login_required_validation();
        $this->load->model('home_model');

        //$this->alertMsg();
        $this->load->model('whitelist_model');
        $this->load->model('blockedlist_model');
        
    }
    public function save_lang()
    {
        $GUID = $this->session->userdata('GUID');
        $update_data = array(
            'Lang' => $this->input->post('lang' , TRUE),
            'DateModify' => date('Y-m-d H:i:s')
        );
        $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID ));
    }
    public function set_privilege()
    {
        $this->load->model('photo_model');
        $trackUserGUID = $this->input->post('trackUserGUID' , TRUE);
        $GUID = $this->session->userdata('GUID');
        $privilege_exist = $this->photo_model->is_privilege_exist( $trackUserGUID ,$GUID );

        if($privilege_exist == FALSE){
            $insert_data = array(
                'UserGUID' => $GUID,
                'TrackUserGUID' => $trackUserGUID,
                'Privilege' => $this->input->post('privilege' , TRUE),
                'DateModify' => date('Y-m-d H:i:s'),
                'DateCreate' => date('Y-m-d H:i:s')
            );


            $insert_string = $this->db->insert_string('[dbo].[i_photo_privilege]', $insert_data);
            $this->db->query( $insert_string );

        }else{
            $update_data = array(
                'Privilege' => $this->input->post('privilege' , TRUE),
                'DateModify' => date('Y-m-d H:i:s')
            );

            $this->db->update('[dbo].[i_photo_privilege]', $update_data, array('UserGUID' => $GUID, 'TrackUserGUID'=> $trackUserGUID));
        }
    }
    public function ask_private_photo_privilege()
    {
        $this->load->model('error_model');
        $this->load->model('photo_model');
        $this->load->model('message_model');
        
        $userGUID = $this->session->userdata('GUID');
        $askGUID = $this->input->post('askGUID' , TRUE);
        //check GUID is exist in i_user
        $user_exist = $this->utility_model->is_user_exist_by_GUID( $askGUID);
        $privilege_exist = $this->photo_model->is_privilege_exist( $userGUID , $askGUID);

        if($user_exist == TRUE and $privilege_exist == FALSE){
            $insert_data = array(
                'UserGUID' => $askGUID,
                'TrackUserGUID' => $userGUID,
                'Privilege' => 0,
                'DateModify' => date('Y-m-d H:i:s'),
                'DateCreate' => date('Y-m-d H:i:s')
            );


            $insert_string = $this->db->insert_string('[dbo].[i_photo_privilege]', $insert_data);
            $this->db->query( $insert_string );
            $this->message_model->write($askGUID ,  $this->display_data['action_ask_for_photo_privilege']);
            echo $this->error_model->retrieve_error_msg(0, NULL , $this->display_data['action_ask_photo_privilege_success']);
            exit;
        }
        if($user_exist == FALSE)
        {
            echo $this->error_model->retrieve_error_msg(2 , NULL , $this->display_data['action_target_user_not_exist']);
            exit;
        }
        if($privilege_exist == TRUE)
        {
            echo $this->error_model->retrieve_error_msg(6 , NULL , $this->display_data['action_privilege_has_record']);
            exit;
        }

    }
    public function tracker()
    {
        $this->load->model('error_model');
        $userGUID = $this->session->userdata('GUID');
        $r = $this->whitelist_model->get_tracker( $userGUID);

        header('Content-Type: application/json');
        echo json_encode($r);
        exit;
    }
    public function blocked_list_add()
    {
        $this->load->model('error_model');
        $trackUserGUID = $this->input->post('trackUserGUID');
        $userGUID = $this->session->userdata('GUID');
        header('Content-Type: application/json');
        //check GUID is exist in i_user
        $user_exist = $this->utility_model->is_user_exist_by_GUID( $userGUID);
        $blockedlist_exist = $this->blockedlist_model->is_exist( $userGUID , $trackUserGUID);
        if($user_exist == TRUE and $blockedlist_exist == FALSE){
            $insert_data = array(
                'UserGUID' => $userGUID,
                'TrackUserGUID' => $trackUserGUID,
                'DateCreate' => date('Y-m-d H:i:s'),
                'DateModify' => date('Y-m-d H:i:s')
            );
            $insert_string = $this->db->insert_string('[dbo].[i_blocked_list]', $insert_data);
            $this->db->query( $insert_string );

            echo $this->error_model->retrieve_error_msg(0, NULL , $this->display_data['action_blockedlist_add_success']);
            exit;
        }
        
        if($user_exist == FALSE)
        {
            echo $this->error_model->retrieve_error_msg(2 , NULL , $this->display_data['action_target_user_not_exist']);
            exit;
        }
        if($blockedlist_exist == TRUE)
        {
            echo $this->error_model->retrieve_error_msg(5 , NULL , $this->display_data['action_blockedlist_has_record']);
            exit;
        }
    }
    public function white_list_add()
    {
        $this->load->model('error_model');
        $trackUserGUID = $this->input->post('trackUserGUID');
        $userGUID = $this->session->userdata('GUID');
        header('Content-Type: application/json');
        //check GUID is exist in i_user
        $user_exist = $this->utility_model->is_user_exist_by_GUID( $userGUID);
        $whitelist_exist = $this->whitelist_model->is_exist( $userGUID , $trackUserGUID);
        if($user_exist == TRUE and $whitelist_exist == FALSE){
            $insert_data = array(
                'UserGUID' => $userGUID,
                'TrackUserGUID' => $trackUserGUID,
                'DateCreate' => date('Y-m-d H:i:s'),
                'DateModify' => date('Y-m-d H:i:s')
            );
            $insert_string = $this->db->insert_string('[dbo].[i_white_list]', $insert_data);
            $this->db->query( $insert_string );

            echo $this->error_model->retrieve_error_msg(0, NULL , $this->display_data['action_whitelist_add_success']);
            exit;
        }
        
        if($user_exist == FALSE)
        {
            echo $this->error_model->retrieve_error_msg(2 , NULL , $this->display_data['action_target_user_not_exist']);
            exit;
        }
        if($whitelist_exist == TRUE)
        {
            echo $this->error_model->retrieve_error_msg(3 , NULL , $this->display_data['action_whitelist_has_record']);
            exit;
        }

    }
}