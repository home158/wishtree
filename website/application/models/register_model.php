<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    /*
    *   Cheeck agree cookie at register , step 1
    *   
    */
    function agree_validation(){
        if( $this->input->cookie("WG_agree") != 1){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    function role_validation(){
        if( $this->input->cookie("WG_role") != 'male' and $this->input->cookie("WG_role") != 'female' ){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    function set_agree_cookie(){
        $cookie = array(
            'name'   => 'agree',
            'value'  => 1,
            //'domain' => '.wishgirl-wishtree.com',
            'expire' => '86400',
            'prefix' => 'WG_'
        );
        $this->input->set_cookie($cookie);
    }
    function is_email_duplicate($email)
    {
        return FALSE;
        /*
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Email = '".$email."'");
        if($query->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
        */
    }
    function birthday_year_options($from = 1997 , $to = 1917)
    {
        $this->lang->load('birthday');
        $str = '<div data-value="%s">%s</div>';
        $option = sprintf($str , "" , $this->lang->line('birthday_year') );
        for( $i = $from ; $i>= $to ; $i--){
            $option .= sprintf($str , strval($i) , strval($i));
        }
        return $option;
    }
    function birthday_month_options($from = 1 , $to = 12)
    {
        $this->lang->load('birthday');
        $str = '<div data-value="%s">%s</div>';
        $option = sprintf($str , "" , $this->lang->line('birthday_month') );
        for( $i = $from ; $i<= $to ; $i++){
            $option .= sprintf($str , strval($i) , strval($i));
        }
        return $option;
    }
    function birthday_date_options($from = 1 , $to = 31)
    {
        $this->lang->load('birthday');
        $str = '<div data-value="%s">%s</div>';
        $option = sprintf($str , "" , $this->lang->line('birthday_date') );
        for( $i = $from ; $i<= $to ; $i++){
            $option .= sprintf($str , strval($i) , strval($i));
        }
        return $option;
    }
    function sent_email_verification($GUID , $email , $nickname)
    {
        $this->config->load('email');
        $this->lang->load('register');
        $this->load->library('uuid');
        $this->load->library('email');
        $ValidateKey = strtoupper($this->uuid->v4());
        $update_data = array(
            'ValidateKey' => $ValidateKey,
            'DateModify' => date('Y-m-d H:i:s'),
            'DateValidate' => date('Y-m-d H:i:s')
        );
        $display_data = array(
            'Nickname' => $nickname,
            'Email' => $email,
            'GUID' => $GUID,
            'ValidateKey' => $ValidateKey,
            'base_url' => base_url()
        );
        $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID));

        $this->email->from($this->config->item('sending_address') , $this->config->item('sending_name') );
        $this->email->to( $email ); 
        $this->email->subject( $this->lang->line('register_email_verification_subject') );
        $msg = $this->parser->parse('site/register/email_verification_msg', $display_data ,true);
        $this->email->message( $msg ); 
        $this->email->print_debugger();
        echo $msg;

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