<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscribe extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(
            array('btn', 'grid','register','member','city','language','birthday','height','bodytype','race',
                'income','property','education','maritalstatus' ,'smoking','drinking' , 'timezoneoffset' , 'dst' ,'role'
            )
        );
        $this->load->model('register_model');
        
    }
    public function index()
	{
        if($this->ajax){
	        $this->utility_model->parse('site/subscribe/index',$this->display_data,TRUE);
        }else{
            $this->utility_model->parse('site/_default/header',$this->display_data);
	        $this->utility_model->parse('site/_default/header_logout',$this->display_data);
	        $this->utility_model->parse('site/_default/female_navi',$this->display_data);
	        $this->utility_model->parse('site/subscribe/index',$this->display_data);
	        $this->utility_model->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/socket_io',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
}