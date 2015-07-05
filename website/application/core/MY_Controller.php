<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class BASE_Controller extends CI_Controller{
    public $session_data ;
    public $display_data = array();

    public function __construct() {
        parent::__construct();
        $this->get_lang();
        $this->load->library('my_language');
        date_default_timezone_set('Asia/Taipei');
        $this->parse_display_data();
        
    }
    public function parse_display_data($data = array()){
        foreach($data as $key){
            $arr = $this->my_language->load($key);
            $this->display_data = array_merge( $this->display_data, $arr);
        }
        
    }
    public function get_lang()
    {
        // cookie >> session
        $lang = $this->input->cookie('WG_lang');
        if(!$lang){
            $lang = $this->session->userdata('WG_lang');
        }
        //
        if( in_array($lang, $this->config->item('available_lang') )){
            $this->config->set_item('language', $lang);
        }
        //set cookie data to session
        $this->session->set_userdata('WG_lang' , $this->config->item('language') );
    }
    public function set_cookie(){
        $cookie = array(
            'name'   => 'lang',
            'value'  => 'zh-tw',
            //'domain' => '.wishgirl-wishtree.com',
            'expire' => '86400',
            'prefix' => 'WG_'
        );
        $this->input->set_cookie($cookie);
    }
}
class Admin_Base_Controller extends BASE_Controller {
    public function __construct() {
        parent::__construct();
        $this->parse_display_data();
        //管理者未登入，回到前端首頁
        if( $this->session->userdata('user_exist') == false){
            redirect( base_url() , 'refresh');
        }
        //管理者session失效或無管理者權限，回到前端首頁
        if( $this->session->userdata('user_exist') == false || $this->session_data['Rank'] != 255)
        {
            redirect( base_url() , 'refresh');
        }
    }


}

class Site_Base_Controller extends BASE_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->parse_display_data(array('home' , 'footer'));

        //$cookie2 = $this->input->cookie();
        //var_dump($cookie2);
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */