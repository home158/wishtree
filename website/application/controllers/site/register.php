<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(
            array('grid','register','member','city','language','birthday','height','bodytype','race',
                'income','property','education','maritalstatus' ,'smoking','drinking'
            )
        );
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
    public function step_3()
    {
        //Agree error redirect setp 1
        if( !$this->register_model->agree_validation() ){
            redirect(base_url().'register/step_1', 'refresh');
        }
        //Role error redirect setp 2
        if( !$this->register_model->role_validation() ){
            redirect(base_url().'register/step_2', 'refresh');
        }
		
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em class="form_error">', '</em>');
		$this->form_validation->set_rules('email', $this->display_data['grid_column_Email'], 'trim|valid_email|required|email_duplicate_check');
		$this->form_validation->set_rules('password', $this->display_data['grid_column_Password'], 'required|min_length[8]|max_length[20]|password_least_alpha_numeric_check');
		$this->form_validation->set_rules('password_chk', $this->display_data['grid_column_PasswordCheck'], 'required|matches[password]');
		$this->form_validation->set_rules('nickname', $this->display_data['grid_column_Nickname'], 'trim|required|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('aboutme', $this->display_data['grid_column_AboutMe'], 'trim|required');
		$this->form_validation->set_rules('national', $this->display_data['grid_column_National'], 'trim|required');
		$this->form_validation->set_rules('city', $this->display_data['grid_column_City'], 'trim|required');
		$this->form_validation->set_rules('language', $this->display_data['grid_column_Language'], 'trim|required');
		$this->form_validation->set_rules('birthday_date', $this->display_data['birthday_date'], 'trim|required');
		$this->form_validation->set_rules('birthday_month', $this->display_data['birthday_month'], 'trim|required');
		$this->form_validation->set_rules('birthday_year', $this->display_data['birthday_year'], 'trim|required');
		$this->form_validation->set_rules('height', $this->display_data['grid_column_Height'], 'trim|required');
		$this->form_validation->set_rules('bodytype', $this->display_data['grid_column_Bodytype'], 'trim|required');
		$this->form_validation->set_rules('race', $this->display_data['grid_column_Race'], 'trim|required');
		$this->form_validation->set_rules('education', $this->display_data['grid_column_Education'], 'trim');
		$this->form_validation->set_rules('maritalstatus', $this->display_data['grid_column_Maritalstatus'], 'trim');
        $this->form_validation->set_rules('smoking', $this->display_data['grid_column_Smoking'], 'trim|required');
        $this->form_validation->set_rules('drinking', $this->display_data['grid_column_Drinking'], 'trim|required');

        if( $this->input->cookie("WG_role") == 'male' ){
            $this->form_validation->set_rules('income', $this->display_data['grid_column_Income'], 'trim|required');
            $this->form_validation->set_rules('property', $this->display_data['grid_column_Property'], 'trim|required');
        }
		if ($this->form_validation->run() == FALSE)
		{
            $this->display_data['birthday_year_options'] = $this->register_model->birthday_year_options(1997,1917);
            $this->display_data['birthday_month_options'] = $this->register_model->birthday_month_options();
            $this->display_data['birthday_date_options'] = $this->register_model->birthday_date_options();
            $this->parser->parse('site/_default/header',$this->display_data);
            $this->parser->parse('site/_default/header_login',$this->display_data);
		    $this->parser->parse('site/register/step3',$this->display_data);
		    $this->parser->parse('site/_default/footer',$this->display_data);
        }else{

        }
		
    }
}