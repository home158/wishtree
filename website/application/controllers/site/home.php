<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();

    }
    public function index()
	{
        print_r($this->display_data);
		$this->load->view('site/_default/header');
		$this->load->view('site/_default/female_navi');
		$this->load->view('site/_default/footer');

	}
    private function parse_display_data(){
        
        $data = array(
        );
        $this->display_data = array_merge( $this->display_data, $data );
    }
    public function test(){
        $this->set_cookie();
    }
}
