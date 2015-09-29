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
    function birthday_year_options($from = 1997 , $to = 1917 , $header = TRUE)
    {
        $this->lang->load('birthday');
        $str = '<div data-value="%s">%s</div>';
        if($header){
            $option = sprintf($str , "" , $this->lang->line('birthday_year_s') );
        }else{
            $option = "";
        }
        for( $i = $from ; $i>= $to ; $i--){
            $option .= sprintf($str , strval($i) , strval($i));
        }
        return $option;
    }
    function birthday_month_options($from = 1 , $to = 12, $header = TRUE)
    {
        $this->lang->load('birthday');
        $str = '<div data-value="%s">%s</div>';
        if($header){
            $option = sprintf($str , "" , $this->lang->line('birthday_month_s') );
        }else{
            $option = "";
        }
        for( $i = $from ; $i<= $to ; $i++){
            $option .= sprintf($str , strval($i) , strval($i));
        }
        return $option;
    }
    function birthday_date_options($from = 1 , $to = 31, $header = TRUE)
    {
        $this->lang->load('birthday');
        $str = '<div data-value="%s">%s</div>';
        if($header){
            $option = sprintf($str , "" , $this->lang->line('birthday_date_s') );
        }else{
            $option = "";
        }
        for( $i = $from ; $i<= $to ; $i++){
            $option .= sprintf($str , strval($i) , strval($i));
        }
        return $option;
    }
    function birthday_hour_options($n = NULL)
    {
        $this->lang->load('birthday');
        if( !is_null($n)){
            return $this->lang->line('birthday_hour_'.strval($n).'_s');
        }else{
            $str = '<div data-value="%s">%s</div>';
            $option = sprintf($str , "" , $this->lang->line('birthday_hour') );
            $option .= sprintf($str , strval(0) ,  $this->lang->line('birthday_hour_0'));
            $option .= sprintf($str , strval(1) ,  $this->lang->line('birthday_hour_1'));
            $option .= sprintf($str , strval(3) ,  $this->lang->line('birthday_hour_3'));
            $option .= sprintf($str , strval(5) ,  $this->lang->line('birthday_hour_5'));
            $option .= sprintf($str , strval(7) ,  $this->lang->line('birthday_hour_7'));
            $option .= sprintf($str , strval(9) ,  $this->lang->line('birthday_hour_9'));
            $option .= sprintf($str , strval(11) ,  $this->lang->line('birthday_hour_11'));
            $option .= sprintf($str , strval(13) ,  $this->lang->line('birthday_hour_13'));
            $option .= sprintf($str , strval(15) ,  $this->lang->line('birthday_hour_15'));
            $option .= sprintf($str , strval(17) ,  $this->lang->line('birthday_hour_17'));
            $option .= sprintf($str , strval(19) ,  $this->lang->line('birthday_hour_19'));
            $option .= sprintf($str , strval(21) ,  $this->lang->line('birthday_hour_21'));
            $option .= sprintf($str , strval(23) ,  $this->lang->line('birthday_hour_23'));
            
            return $option;
        }
    }
    
    function sent_email_verification($GUID , $email , $nickname)
    {
        $this->config->load('email');
        $this->lang->load('register');
        $this->load->library('uuid');
        $this->load->library('email');
        $ValidateKey = $this->uuid->v4();
        $update_data = array(
            'ValidateKey' => $ValidateKey,
            'DateModify' => date('Y-m-d H:i:s'),
            'Validated' => 0
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
        $msg = $this->parser->parse('site/msg/'.$this->config->item('language').'/email_verification_msg', $display_data ,true);
        $this->email->message( $msg ); 
        
        

        if( $this->email->send() ){
            $is_send_success = TRUE;
        }else{
            $is_send_success = FALSE;
        }

        return $is_send_success;

    }
    function retrieve_user_info_by_account_passwd($data)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Email = '".$data['Email']."' AND PasswordEncrypt = '".$data['PasswordEncrypt']."' AND Rank >= ".$data['Rank']);
        return $query;
    }
    function retrieve_user_info_by_GUID($GUID)
    {
        $query = $this->db->query("
            SELECT 
                datepart(month,[Birthday]) AS Birthday_Month,
                datepart(year,[Birthday]) AS Birthday_Year,
                datepart(day,[Birthday]) AS Birthday_Day,
                datepart(hour,[Birthday]) AS Birthday_Hour,
                Maritalstatus
            FROM 
                [dbo].[i_user] 
            WHERE 
                GUID = '".$GUID."'");
        return $query;
    }
    function validate_mail($GUID , $ValidateKey)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Rank = 2 AND GUID = '".$GUID."' AND ValidateKey = '".$ValidateKey."'");
        $update_data = array(  
            'Rank' => 3,
            'Validated' =>1,
            'ValidatedDate' => date('Y-m-d H:i:s'),
            'DateModify' => date('Y-m-d H:i:s')
        );

        if($query->num_rows() > 0){
            $query = $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID));
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function retrieve_user_info_by_account_email_verification($data)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE GUID = '".$data['GUID']."' AND ValidateKey = '".$data['ValidateKey']."' AND Rank >= ".$data['Rank']);
        return $query;
    }
    function create_container($container)
    {
        $this->load->library('azure');
        $createContainerOptions = $this->azure->createContainerOptions(); 
           
        $blobRestProxy = $this->azure->createBlobService();
        $blobRestProxy->createContainer($container , $createContainerOptions);
    }
    function create_repository($GUID)
    {
        $path = $this->config->item('repositories_forder') . '/' . $GUID;
        
        if(!is_dir($path)) //create the folder if it's not already exists
        {
            mkdir($path,0755,TRUE);
        }
    }

}

/* End of file register_model.php */
/* Location: ./application/model/register_model.php */