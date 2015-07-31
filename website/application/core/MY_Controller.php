<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class BASE_Controller extends CI_Controller{
    public $session_data ;
    public $display_data = array();
    public $timezoneOffset;

    public function __construct() {
        parent::__construct();
        $this->get_lang();
        $this->load->library('my_language');
        $this->load->model('utility_model');
        date_default_timezone_set('UTC');

        $this->timezoneOffset = $this->utility_model->getTimezoneOffset();
        $this->parse_display_data();
        
    }
    public function parse_display_data($data = array()){
        foreach($data as $key){
            $arr = $this->my_language->load($key);
            $this->display_data = array_merge( $this->display_data, $arr);
        }
        $this->display_data = array_merge( $this->display_data, $this->session->all_userdata() );
        $this->display_data["highlight_navi"] = "none";
        $this->display_data["alert_content"] = "";

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
        $this->parse_display_data(array('home' , 'footer'));

    }


}

class Site_Base_Controller extends BASE_Controller {
    private $except_page = array('validate_mail' , 'setp_4');
    public function __construct() {
        parent::__construct();
        $this->parse_display_data(array('home' , 'footer'));

        //$cookie2 = $this->input->cookie();
        //var_dump($cookie2);
    }

    public function logout_required_validation()
    {
        /*
        if( in_array($this->uri->segment(2) , $this->except_page) ){
            return;
        }
        */
        
        if( $this->session->userdata('Email') ){
            redirect( base_url().'home' );
        }
    }
    public function login_required_validation()
    {
        if( !$this->session->userdata('Email') ){
            redirect( base_url() );
        }
    }
    public function alertMsg()
    {
        return;
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */