<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(array('grid','register','member'));
        $this->load->model('register_model');        
    }
    public function index()
	{
        redirect(base_url().'register/step_1', 'refresh');
    }
    public function step_1()
    {
		$this->load->library('form_validation');
		$this->form_validation->set_rules('agree', '', 'is_natural_no_zero');
        $this->display_data["terms_content"] = $this->load->view('site/msg/terms', "" ,true);

		if ($this->form_validation->run() == FALSE)
		{
		    $this->parser->parse('site/_default/header',$this->display_data);
		    $this->parser->parse('site/_default/header_login',$this->display_data);
		    $this->parser->parse('site/register/step1',$this->display_data);
		
		    $this->parser->parse('site/_default/footer',$this->display_data);
        }else{
            //save agree to cookie
            $this->register_model->set_agree_cookie();
            redirect(base_url().'register/step_2', 'refresh');
        }
    }
    public function step_2()
    {
        if( !$this->register_model->agree_validation() ){
            redirect(base_url().'register/step_1', 'refresh');
        }

		$this->parser->parse('site/_default/header',$this->display_data);
		$this->parser->parse('site/_default/header_login',$this->display_data);
		$this->parser->parse('site/register/step2',$this->display_data);
		
		$this->parser->parse('site/_default/footer',$this->display_data);
        
        
        
    }
    public function male()
    {
        //Agree error redirect setp 1
        if( !$this->register_model->agree_validation() ){
            redirect(base_url().'register/step_1', 'refresh');
        }
		
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
		$this->form_validation->set_rules('email', $this->display_data['grid_column_Email'], 'trim|valid_email|required|email_duplicate_check');
		$this->form_validation->set_rules('password', $this->display_data['grid_column_Password'], 'required|min_length[8]|max_length[20]|password_least_alpha_numeric_check');
		$this->form_validation->set_rules('password_chk', $this->display_data['grid_column_PasswordCheck'], 'required|matches[password]');
		$this->form_validation->set_rules('nickname', $this->display_data['grid_column_Nickname'], 'trim|required|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('aboutme', $this->display_data['grid_column_AboutMe'], 'trim|required');
        
		if ($this->form_validation->run() == FALSE)
		{
            $this->parser->parse('site/_default/header',$this->display_data);
            $this->parser->parse('site/_default/header_login',$this->display_data);
		    $this->parser->parse('site/register/step3_male',$this->display_data);
		    $this->parser->parse('site/_default/footer',$this->display_data);
        }else{

        }
		
    }
    public function female()
    {
        //Agree error redirect setp 1
        if( !$this->register_model->agree_validation() ){
            redirect(base_url().'register/step_1', 'refresh');
        }
		$this->parser->parse('site/_default/header',$this->display_data);
		$this->parser->parse('site/_default/header_login',$this->display_data);
		$this->parser->parse('site/register/step3_female',$this->display_data);
		
		$this->parser->parse('site/_default/footer',$this->display_data);
    }
    /*
    private function parse_display_data(){


        $this->load->library('my_language');
        $grid = $this->my_language->load('grid');
        $register = $this->my_language->load('register');

        $this->display_data = array_merge( $this->display_data, $register , $grid );
    }
    */
}