<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();

    }
    public function index()
	{
		$this->parser->parse('site/_default/header',$this->display_data);
        
		$this->parser->parse('site/_default/header_login',$this->display_data);
		$this->parser->parse('site/login/login_normal',$this->display_data);

        $this->parser->parse('site/_default/footer',$this->display_data);

    }
    private function parse_display_data(){
        
        $data = array(
        );
        $this->display_data = array_merge( $this->display_data, $data );
    }
}