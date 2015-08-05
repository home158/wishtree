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
    
    function set_login_session($row)
    {
        $data_db['Nickname'] = $row->Nickname;
        $data_db['Email'] = $row->Email;
        $data_db['Rank'] = $row->Rank;
        $data_db['GUID'] = $row->GUID;
        $data_db['Role'] = $row->Role;
        $data_db['Validated'] = $row->Validated;//電子郵件認證
        $data_db['DeleteStatus'] = $row->DeleteStatus;//刪除註記
        $data_db['ForbiddenStatus'] = $row->ForbiddenStatus;//停權註記
        
        $this->utility_model->setTimezoneOffset($row->TimezoneOffset , $row->DST);
        $this->session->set_userdata($data_db);
    }
    function set_info_cookie($user_info, $remember_me)
    {
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