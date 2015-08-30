<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Site_Base_Controller {
	public function index()
	{
		$this->utility_model->parse('site/_default/header',$this->display_data ,null);
		$this->utility_model->parse('site/_default/header_login',$this->display_data,null);
		$this->utility_model->parse('site/_default/no_navi',$this->display_data,null);
        
		$this->utility_model->parse('site/welcome/index',$this->display_data,null);
		$this->utility_model->parse('site/_default/footer',$this->display_data,null);
        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);

	}
    public function mobile()
    {
        $this->load->library('user_agent');
        echo "*";
        echo $this->agent->is_mobile();
        echo "*";
        echo $this->agent->is_browser();

    }
}
