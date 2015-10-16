<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fortune extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->login_required_validation();
        
        $this->parse_display_data(
            array('btn','grid','alert' ,'fortune' ,'birthday','maritalstatus' ,'role')
        );
        $this->display_data["highlight_navi"] = "fortune";
        $this->alertMsg();
        $this->load->model('fortune_model');

    }
    public function new_problem($GUID)
    {
        $this->display_data['fortune_GUID'] = $GUID;
        $orderlist = $this->fortune_model->retrieve_histories($this->session->userdata('GUID'),$GUID);
        $this->display_data['orderlist'] = $orderlist;
        $this->display_data['pblm_radio'] = $this->fortune_model->fortune_pblm_radio(12890);
        $this->display_data['text_count'] = $this->config->item('fotrune_pblm_text_count');;
        
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em class="form_error">', '</em>');
		$this->form_validation->set_rules('pblm_email', $this->display_data['grid_column_pblm_email'], 'trim|required|valid_email');
		$this->form_validation->set_rules('pblm_tel', $this->display_data['grid_column_pblm_tel'], 'trim');
		$this->form_validation->set_rules('fortune_message', $this->display_data['grid_column_fortune_pblm'], 'trim|required');
        
		if ($this->form_validation->run() == FALSE)
		{

		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/fortune/new_problem',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/socket_io',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }else{
            $this->load->library('uuid');
            $message_data = array(
                'GUID' => $this->uuid->v4(),
                'FortuneGUID' => $GUID,
                'UserGUID' => $this->session->userdata('GUID'),
                'PblmTel' => $this->input->post('pblm_tel' , TRUE),
                'PblmEmail' => $this->input->post('pblm_email'),
                'PblmCode' => $this->input->post('pblm_code' , TRUE),
                'FortuneMessage' => $this->input->post('fortune_message' , TRUE)
            );
            $insert_string = $this->db->insert_string('[dbo].[i_fortune_message]', $message_data);
            $this->db->query( $insert_string );

            $update_data = array(
                'PblmTel' => $this->input->post('pblm_tel' , TRUE),
                'PblmEmail' => $this->input->post('pblm_email'),
                'DateModify' => date('Y-m-d H:i:s')
            );
            $query = $this->db->update('[dbo].[i_fortune]', $update_data, 
                array(
                    'GUID' => $GUID,
                    'UserGUID' => $this->session->userdata('GUID')
                )
            );


        }
    }
    public function response($GUID)
    {
        $this->display_data['fortune_GUID'] = $GUID;
        $orderlist = $this->fortune_model->retrieve_histories($this->session->userdata('GUID'),$GUID);
        $message_list = $this->fortune_model->retrieve_response_messages($this->session->userdata('GUID'),$GUID);
        $this->display_data['orderlist'] = $orderlist;
        $this->display_data['message_list'] = $message_list;

        if($this->ajax){
            $this->utility_model->parse('site/fortune/response',$this->display_data,TRUE);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/fortune/response',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/socket_io',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
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
    public function history()
    {
        $this->display_data['orderlist'] = $this->fortune_model->retrieve_histories($this->session->userdata('GUID'));
        if($this->ajax){
            $this->utility_model->parse('site/fortune/history',$this->display_data,TRUE);
        }else{
            $this->utility_model->parse('site/_default/header',$this->display_data);
            $this->utility_model->parse('site/_default/header_logout',$this->display_data);
            $this->utility_model->parse('site/_default/female_navi',$this->display_data);
            $this->utility_model->parse('site/fortune/history',$this->display_data);
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
    public function future()
    {
        $this->load->model('register_model');
        $q = $this->register_model->retrieve_user_info_by_GUID($this->session->userdata('GUID'));
        $user_info = $q->row_array();
		$this->load->library('form_validation');

            $this->display_data['birthday_year_db'] = $user_info['Birthday_Year'];
            $this->display_data['birthday_month_db'] = $user_info['Birthday_Month'];
            $this->display_data['birthday_day_db'] = $user_info['Birthday_Day'];
            $this->display_data['Maritalstatus'] = $user_info['Maritalstatus'];


        $this->display_data['fortune_pblm'] = $this->fortune_model->fortune_pblm_select();



        $this->form_validation->set_error_delimiters('<em class="form_error">', '</em>');
		$this->form_validation->set_rules('nickname', $this->display_data['grid_column_Nickname_or_Real'], 'trim|required');
		$this->form_validation->set_rules('role', $this->display_data['grid_column_Gender'], 'trim');
        
		$this->form_validation->set_rules('maritalstatus', $this->display_data['grid_column_Maritalstatus'], 'trim|required');
		$this->form_validation->set_rules('birthday_hour', $this->display_data['birthday_hour_s'], 'trim|required');
		$this->form_validation->set_rules('birthday_year', $this->display_data['birthday_year_s'], 'trim|required');
		$this->form_validation->set_rules('birthday_month', $this->display_data['birthday_month_s'], 'trim|required');
		$this->form_validation->set_rules('birthday_date', $this->display_data['birthday_date_s'], 'trim|required');

		$this->form_validation->set_rules('pblm_tel', $this->display_data['grid_column_pblm_tel'], 'trim|required');
            
        if( $this->input->post('fortune_message' , TRUE)){
		    $this->form_validation->set_rules('pblm_code', $this->display_data['grid_column_fortune_pblm_code'], 'trim|required');
        }else{
		    $this->form_validation->set_rules('pblm_code', $this->display_data['grid_column_fortune_pblm_code'], 'trim');
        }

        if( $this->input->post('pblm_code' , TRUE)){
		    $this->form_validation->set_rules('fortune_message', $this->display_data['grid_column_fortune_pblm'], 'trim|required');
        }else{
		    $this->form_validation->set_rules('fortune_message', $this->display_data['grid_column_fortune_pblm'], 'trim');
        }
        

		if ($this->form_validation->run() == FALSE)
		{
            $this->display_data['birthday_year_options'] = $this->register_model->birthday_year_options(1997,1917,FALSE);
            $this->display_data['birthday_month_options'] = $this->register_model->birthday_month_options(1,12,FALSE);
            $this->display_data['birthday_date_options'] = $this->register_model->birthday_date_options(1,31,FALSE);
            $this->display_data['birthday_hour_options'] = $this->register_model->birthday_hour_options();
            
            

            if($this->ajax){
                $this->utility_model->parse('site/fortune/request',$this->display_data,TRUE);
            }else{
		        $this->utility_model->parse('site/_default/header',$this->display_data);
		        $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		        $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		        $this->utility_model->parse('site/fortune/future',$this->display_data);
		        $this->utility_model->parse('site/_default/footer',$this->display_data);
		        $this->utility_model->parse('site/_default/socket_io',$this->display_data);
		        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
            }
        }else{
            $this->load->library('uuid');
            $uuid = $this->uuid->v4();
            $insert_data = array(
                'GUID' => $uuid,
                'Services' => $this->input->post('services' , TRUE),
                'UserGUID' => $this->session->userdata('GUID'),
                'Nickname' => $this->input->post('nickname' , TRUE),
                'Role' => $this->input->post('role' , TRUE),
                'Birthday' => date($this->input->post('birthday_year' , TRUE).'-'.$this->input->post('birthday_month' , TRUE).'-'.$this->input->post('birthday_date' , TRUE)),
                'BornHour' => $this->input->post('birthday_hour' , TRUE),
                'Maritalstatus' => $this->input->post('maritalstatus' , TRUE),
                'PblmTel' => $this->input->post('pblm_tel' , TRUE),
                'PblmEmail' => $this->session->userdata('Email'),
                'Lunar' => $this->input->post('lunar' , TRUE) . $this->register_model->birthday_hour_options($this->input->post('birthday_hour' , TRUE))
            );
            $insert_string = $this->db->insert_string('[dbo].[i_fortune]', $insert_data);
            $this->db->query( $insert_string );

            if( $this->input->post('fortune_message' , TRUE)){
                $message_data = array(
                    'GUID' => $this->uuid->v4(),
                    'FortuneGUID' => $uuid,
                    'UserGUID' => $this->session->userdata('GUID'),
                    'PblmTel' => $this->input->post('pblm_tel' , TRUE),
                    'PblmEmail' => $this->session->userdata('Email'),
                    'PblmCode' => $this->input->post('pblm_code' , TRUE),
                    'FortuneMessage' => $this->input->post('fortune_message' , TRUE)
                );
                $insert_string = $this->db->insert_string('[dbo].[i_fortune_message]', $message_data);
                $this->db->query( $insert_string );
            }
            redirect( base_url() , 'fortune/history');
        }
    }
    public function payment_notify()
    {
        $this->load->model('error_model');
        $GUID = $this->input->post('GUID');
        $update_data = array(
            'NotifyPaymentStatus' => 1,
            'DateNotifyPayment' => date('Y-m-d H:i:s')
        );
        if($update_data['NotifyPaymentStatus'] == 0){
            $update_data['DatePayment'] = NULL;
        }
        $query = $this->db->update('[dbo].[i_fortune]', $update_data, array('GUID' => $GUID));

        header('Content-Type: application/json');
        if($query == true){
            echo $this->error_model->retrieve_error_msg(0 , NULL);
        }else{
            echo $this->error_model->retrieve_error_msg(1);
        }
    }

}