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
}

/* End of file welcome.php */
/* Location: ./application/model/register_model.php */