<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Site_Base_Controller {
	public function index()
	{
		$this->parser->parse('site/_default/header',$this->display_data);
		$this->parser->parse('site/_default/header_login',$this->display_data);
		$this->parser->parse('site/welcome/index',$this->display_data);
		$this->parser->parse('site/_default/footer',$this->display_data);

	}
}
