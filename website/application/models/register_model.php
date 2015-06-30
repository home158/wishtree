<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function retrieve_user_data($table, $data){
        $str = $this->db->get_where($table, $data );
        return $str;
    }

    
    function retrieve_user_session()
    {
        $userSession = $this->session->all_userdata();
        //var_dump($userSession);
        return $userSession;
    }
    function retrieve_rank($code)
    {
        $this->lang->load('rank');
        
        $this->config->load('rank',true);
        $my_rank = $this->config->item('rank_'.$code,'rank');
        return $this->lang->line('rank_' . $my_rank);
    }

    function retrieve_city($code)
    {
        $this->config->load('city',true);

        return $this->config->item('city_'.$code,'city');
    }
    function retrieve_gender($code){
        $this->config->load('gender',true);

        return $this->config->item('gender_'.$code,'gender');
    }
    function retrieve_register_type($code){
        $this->lang->load('register_type');
        $this->config->load('register_type',true);
        $type = $this->config->item('register_type_'.$code,'register_type');
        return $this->lang->line('register_type_' . $type);
    }
    function is_email_exist($email)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Email = '".$email."'");
        if($query->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function is_email_duplicate($email)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Email = '".$email."'");
        if($query->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function is_password_account_auth_check($password)
    {

        $GUID = $this->session->userdata('GUID');
        $PasswordEncrypt = md5($password);
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE GUID = '".$GUID."' AND PasswordEncrypt = '".$PasswordEncrypt."'");

        if($query->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function retrieve_user_info_by_facebook_account($data)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Email = '".$data['Email']."' AND FacebookID = '".$data['FacebookID']."' AND Rank >= ".$data['Rank']);
        return $query;
    }
    function retrieve_user_info_by_google_account($data)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Email = '".$data['Email']."' AND GoogleID = '".$data['GoogleID']."' AND Rank >= ".$data['Rank']);
        return $query;
    }
    function retrieve_user_info_by_account_passwd($data)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Email = '".$data['Email']."' AND PasswordEncrypt = '".$data['PasswordEncrypt']."' AND Rank >= ".$data['Rank']);
        return $query;
    }
    function retrieve_user_info_by_account_email_verification($data)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE GUID = '".$data['GUID']."' AND ValidateKey = '".$data['ValidateKey']."' AND Rank >= ".$data['Rank']);
        return $query;
    }
    function validate_google_account($id , $email)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Rank = 2 AND Email = '".$email."' AND GoogleID = '".$id."'");

        if($query->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function validate_facebook_account($id , $email)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Rank = 2 AND Email = '".$email."' AND FacebookID = '".$id."'");

        if($query->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function validate_mail($GUID , $ValidateKey)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Rank = 1 AND GUID = '".$GUID."' AND ValidateKey = '".$ValidateKey."'");
        $update_data = array(  
            'Rank' => 2,
            'DateModify' => date('Y-m-d H:i:s')
        );

        if($query->num_rows() > 0){
            $query = $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID));
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function validate_reset_password($GUID , $ValidateKey)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE GUID = '".$GUID."' AND ValidateKey = '".$ValidateKey."'");

        if($query->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function send_mail_forgot_password($email)
    {
        $this->load->library('email');
        $this->load->library('uuid');
        $ValidateKey = strtoupper($this->uuid->v4());
        $update_data = array(  
            'ValidateKey' => $ValidateKey,
            'DateModify' => date('Y-m-d H:i:s')
        );
        $query = $this->db->update('[dbo].[i_user]', $update_data, array('Email' => $email));
        $r = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Email = '".$email."'");
        $row = $r->row();

        $display_data = array(
            'GUID' => $row->GUID,
            'Email' => $email,
            'ValidateKey' => $ValidateKey,
            'base_url' => base_url()
        );
        $this->email->from($this->lang->line('member_login_sending_mail_address') , $this->lang->line('member_login_sending_mail_name') );
        $this->email->to( $email ); 
        $this->email->subject( $this->lang->line('member_login_sending_mail_forgot_password_subject') );
        $msg = $this->parser->parse('register/email_forgot_password_msg', $display_data ,true);
        $this->email->message( $msg ); 

        if( $this->email->send() ){
            $is_send_success = TRUE;
        }else{
            $is_send_success = FALSE;
        }

        return $is_send_success;
    }
    function update_logintime($GUID)
    {
        $update_data = array(  
            'LastLoginTime' => date('Y-m-d H:i:s')
        );
        $query = $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID));

    }
    function sent_email_verification($GUID , $email , $name)
    {
        $this->lang->load('members');
        $this->load->library('uuid');
        $this->load->library('email');
        $ValidateKey = strtoupper($this->uuid->v4());

        $update_data = array(  
            'ValidateKey' => $ValidateKey,
            'DateModify' => date('Y-m-d H:i:s')
        );
        $display_data = array(
            'Name' => $name,
            'Email' => $email,
            'GUID' => $GUID,
            'ValidateKey' => $ValidateKey,
            'base_url' => base_url()
        );
        $query = $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID));
        $this->email->from($this->lang->line('member_register_sending_mail_address') , $this->lang->line('member_register_sending_mail_name') );
        $this->email->to( $email ); 
        $this->email->subject( $this->lang->line('member_register_sending_mail_subject') );
        $msg = $this->parser->parse('register/email_verification_msg', $display_data ,true);
        $this->email->message( $msg ); 

        if( $this->email->send() ){
            $is_send_success = TRUE;
        }else{
            $is_send_success = FALSE;
        }

        return $is_send_success;
    }
}

/* End of file welcome.php */
/* Location: ./application/model/register_model.php */