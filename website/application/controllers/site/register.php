<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends Site_Base_Controller {
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
        redirect(base_url().'register/step_1', 'refresh');
    }
    public function step_1()
    {
        $this->logout_required_validation();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('agree', '', 'is_natural_no_zero');
        $this->display_data["terms_content"] = $this->load->view('site/msg/terms', "" ,true);

		if ($this->form_validation->run() == FALSE)
		{
		    $this->parser->parse('site/_default/header',$this->display_data);
		    $this->parser->parse('site/_default/header_login',$this->display_data);
		    $this->parser->parse('site/register/step1',$this->display_data);
		
		    $this->parser->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }else{
            //save agree to cookie
            $this->register_model->set_agree_cookie();
            redirect(base_url().'register/step_2', 'refresh');
        }
    }
    public function step_2()
    {
        $this->logout_required_validation();
        if( !$this->register_model->agree_validation() ){
            redirect(base_url().'register/step_1', 'refresh');
        }

		$this->parser->parse('site/_default/header',$this->display_data);
		$this->parser->parse('site/_default/header_login',$this->display_data);
		$this->parser->parse('site/register/step2',$this->display_data);
		
		$this->parser->parse('site/_default/footer',$this->display_data);
        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        
        
        
    }
    public function step_3()
    {
        $this->logout_required_validation();

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
		$this->form_validation->set_rules('timezoneoffset', $this->display_data['grid_column_TimezoneOffset'], 'trim|required|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('nickname', $this->display_data['grid_column_Nickname'], 'trim|required');
		$this->form_validation->set_rules('aboutme', $this->display_data['grid_column_AboutMe'], 'trim|required');
		$this->form_validation->set_rules('national_code', $this->display_data['grid_column_NationalCode'], 'trim|required');
		$this->form_validation->set_rules('city', $this->display_data['grid_column_City'], 'trim|required');
		$this->form_validation->set_rules('language', $this->display_data['grid_column_Language'], 'trim|required');
		$this->form_validation->set_rules('birthday_date', $this->display_data['birthday_date_s'], 'trim|required');
		$this->form_validation->set_rules('birthday_month', $this->display_data['birthday_month_s'], 'trim|required');
		$this->form_validation->set_rules('birthday_year', $this->display_data['birthday_year_s'], 'trim|required');
		$this->form_validation->set_rules('height', $this->display_data['grid_column_Height'], 'trim|required');
		$this->form_validation->set_rules('bodytype', $this->display_data['grid_column_Bodytype'], 'trim|required');
		$this->form_validation->set_rules('race', $this->display_data['grid_column_Race'], 'trim|required');
		$this->form_validation->set_rules('education', $this->display_data['grid_column_Education'], 'trim');
		$this->form_validation->set_rules('maritalstatus', $this->display_data['grid_column_Maritalstatus'], 'trim');
        $this->form_validation->set_rules('smoking', $this->display_data['grid_column_Smoking'], 'trim');
        $this->form_validation->set_rules('drinking', $this->display_data['grid_column_Drinking'], 'trim');
        $this->form_validation->set_rules('ideal_desc', $this->display_data['grid_column_IdealDesc'], 'trim|required');

        if( $this->input->cookie("WG_role") == 'male' ){
            $this->form_validation->set_rules('income', $this->display_data['grid_column_Income'], 'trim|required');
            $this->form_validation->set_rules('property', $this->display_data['grid_column_Property'], 'trim|required');
            $this->display_data['register_gender'] = $this->display_data['register_male'];
        }else{
            $this->display_data['register_gender'] = $this->display_data['register_female'];
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
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }else{
            $this->load->library('uuid');
            $uuid = $this->uuid->v4();
            $birthday = date(
                            $this->input->post('birthday_year',true).'-'.
                            $this->input->post('birthday_month',true).'-'.
                            $this->input->post('birthday_date',true) 
                        );
            $register_data = array(
                'GUID' => $uuid,
                'Nickname' => $this->input->post('nickname',true),
                'Role' => $this->input->cookie("WG_role"),
                'Email' => $this->input->post('email',true),
                'Password' => $this->input->post('password',true),
                'PasswordEncrypt' => md5($this->input->post('password',true)),
                'TimezoneOffset' => $this->input->post('timezoneoffset',true),
                'DST' => $this->input->post('dst',true),
                'AboutMe' => $this->input->post('aboutme'),
                'Rank' => 2,
			    'NationalCode' => $this->input->post('national_code',true),
			    'City' => $this->input->post('city',true),
			    'Language' => $this->input->post('language',true),
			    'Lang' => $this->session->userdata('WG_lang'),
			    'Income' => $this->input->post('income',true),
			    'Property' => $this->input->post('property',true),
			    'Birthday' => $birthday,
			    'Height' => $this->input->post('height',true),
			    'Bodytype' => $this->input->post('bodytype',true),
			    'Race' => $this->input->post('race',true),
			    'Education' => $this->input->post('education',true),
			    'Maritalstatus'=> $this->input->post('maritalstatus',true),
			    'Smoking' => $this->input->post('smoking',true),
			    'Drinking'=> $this->input->post('drinking',true),
			    'IdealDesc'=> $this->input->post('ideal_desc'),
                'LastLoginTime' => date('Y-m-d H:i:s'),
                'DateCreate' => date('Y-m-d H:i:s'),
                'DateModify' => date('Y-m-d H:i:s')
			
            );
            
            $insert_string = $this->db->insert_string('[dbo].[i_user]', $register_data);
            $this->db->query( $insert_string );

            $this->session->set_userdata('GUID', $register_data['GUID']);
            $this->session->set_userdata('Email', $register_data['Email']);
            $this->session->set_userdata('Nickname', $register_data['Nickname']);
            $this->session->set_userdata('Rank', 2);//2:註冊未認證;
            $this->session->set_userdata('Role', $register_data['Role']);
            $this->utility_model->setTimezoneOffset($register_data['TimezoneOffset'] , $register_data['DST']);


            $this->register_model->sent_email_verification($register_data['GUID'],$register_data['Email'],$register_data['Nickname']);

            redirect( base_url().'register/sending_validate_mail' , 'refresh');

        }
		
    }
    public function sending_validate_mail(){
        $this->login_required_validation();
        
        $this->display_data['register_sent_email_verification'] = sprintf($this->display_data['register_sent_email_verification'],$this->session->userdata('Email') );

        $this->utility_model->parse('site/_default/header',$this->display_data);
        $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		$this->utility_model->parse('site/register/sending_validate_mail',$this->display_data);
		$this->utility_model->parse('site/_default/footer',$this->display_data);
        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
    }
    public function validate_mail($GUID = NULL , $ValidateKey = NULL)
    {
        $result = $this->register_model->validate_mail($GUID , $ValidateKey);
        if($result == TRUE){
            $data = array(
                'GUID' => $GUID,
                'ValidateKey' => $ValidateKey,
                'Validated' => 1,
                'Rank'  => 3
            );
            //驗證後直接登入
            $query = $this->register_model->retrieve_user_info_by_account_email_verification( $data );
            $row = $query->row();
            $data_db['Email'] = $row->Email;
            $data_db['Nickname'] = $row->Nickname;
            $data_db['Rank'] = $row->Rank;
            $data_db['GUID'] = $row->GUID;
            $data_db['Role'] = $row->Role;
            
            $this->session->set_userdata($data_db);

            //驗證成功
            $this->parser->parse('site/_default/header',$this->display_data);
            $this->parser->parse('site/_default/header_logout',$this->display_data);
		    $this->parser->parse('site/register/validate_mail_success',$this->display_data);
		    $this->parser->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
            //Create Azure storage
            $this->register_model->create_container($row->GUID);
            //Create  repositories
            $this->register_model->create_repository($row->GUID);
 
        }else{
            $this->parser->parse('site/_default/header',$this->display_data);
            $this->parser->parse('site/_default/header_login',$this->display_data);
		    $this->parser->parse('site/register/validate_mail_fail',$this->display_data);
		    $this->parser->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);

        }
    }
    public function sent_email_verification()
    {
        $this->login_required_validation();
        $this->register_model->sent_email_verification($this->session->userdata('GUID') ,$this->session->userdata('Email'), $this->session->userdata('Nickname'));
     //   redirect( base_url().'register/sending_validate_mail' , 'refresh');
    }

}