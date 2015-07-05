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
        return TRUE;
        /*
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Email = '".$email."'");
        if($query->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
        */
    }

}

/* End of file welcome.php */
/* Location: ./application/model/register_model.php */