<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    /*
    *   Cheeck agree cookie at register , step 1
    *   
    */
    function retrieve_user_info_by_account_passwd($data)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_user] WHERE Email = '".$data['Email']."' AND PasswordEncrypt = '".$data['PasswordEncrypt']."' AND Rank >= ".$data['Rank']);
        return $query;
    }
    function set_info_cookie($user_info, $remember_me){
        if( $remember_me ){
            $cookie_email = array(
                'name'   => 'email',
                'value'  => $user_info->Email,
                //'domain' => '.wishgirl-wishtree.com',
                'expire' => '7776000',
                'prefix' => 'WG_'
            );
            $this->input->set_cookie($cookie_email);
            $cookie_password = array(
                'name'   => 'password',
                'value'  => $user_info->PasswordEncrypt,
                //'domain' => '.wishgirl-wishtree.com',
                'expire' => '7776000',
                'prefix' => 'WG_'
            );
            $this->input->set_cookie($cookie_password);
        }else{
            delete_cookie('email', "", "", 'WG_');
            delete_cookie('password', "", "", 'WG_');
            delete_cookie('remember_me', "", "", 'WG_');
        }
    }
}

/* End of file login_model.php */
/* Location: ./application/model/login_model.php */