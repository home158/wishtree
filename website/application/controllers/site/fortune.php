<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fortune extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->login_required_validation();
        
        $this->parse_display_data(
            array('btn','grid','alert' ,'fortune' ,'birthday','maritalstatus')
        );
        $this->display_data["highlight_navi"] = "fortune";
        $this->alertMsg();
        $this->load->model('wish_model');

    }
	public function index()
	{
        if($this->ajax){
            $this->utility_model->parse('site/fortune/index',$this->display_data,TRUE);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/fortune/index',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/socket_io',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }

    }
    public function request()
    {
        if($this->ajax){
            $this->utility_model->parse('site/fortune/request',$this->display_data,TRUE);
        }else{


		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/fortune/request',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/socket_io',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
    public function year()
    {
        $this->load->model('register_model');
        $q = $this->register_model->retrieve_user_info_by_GUID($this->session->userdata('GUID'));
        $user_info = $q->row_array();
		$this->load->library('form_validation');
		if ($this->form_validation->run() == FALSE)
		{
            $this->display_data['birthday_year_options'] = $this->register_model->birthday_year_options(1997,1917,FALSE);
            $this->display_data['birthday_month_options'] = $this->register_model->birthday_month_options(1,12,FALSE);
            $this->display_data['birthday_date_options'] = $this->register_model->birthday_date_options(1,31,FALSE);
            $this->display_data['birthday_hour_options'] = $this->register_model->birthday_hour_options();
            
            $this->display_data['birthday_year'] = $user_info['Birthday_Year'];
            $this->display_data['birthday_month'] = $user_info['Birthday_Month'];
            $this->display_data['birthday_day'] = $user_info['Birthday_Day'];
            $this->display_data['Maritalstatus'] = $user_info['Maritalstatus'];
            

            if($this->ajax){
                $this->utility_model->parse('site/fortune/request',$this->display_data,TRUE);
            }else{
		        $this->utility_model->parse('site/_default/header',$this->display_data);
		        $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		        $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		        $this->utility_model->parse('site/fortune/year',$this->display_data);
		        $this->utility_model->parse('site/_default/footer',$this->display_data);
		        $this->utility_model->parse('site/_default/socket_io',$this->display_data);
		        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
            }
        }else{

        }
    }
    public function future()
    {
    }

}