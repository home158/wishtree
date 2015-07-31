<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Admin_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(
            array( 'account' , 'rank' , 'email' , 'role' ,'btn', 'grid','register','member','city','language','birthday','height','bodytype','race',
                'income','property','education','maritalstatus' ,'smoking','drinking' , 'timezoneoffset' , 'dst' , 'alert' , 'menu', 'message')
        );

    }
    public function logout()
    {
		$this->parser->parse('admin/_default/header',$this->display_data);
		$this->parser->parse('admin/_default/navi',$this->display_data);

		$this->parser->parse('admin/_default/footer',$this->display_data);
    }
    public function change_password_fail()
    {
		$this->parser->parse('admin/_default/header',$this->display_data);
		$this->parser->parse('admin/_default/navi',$this->display_data);
		$this->parser->parse('admin/account/change_password_fail',$this->display_data);
		$this->parser->parse('admin/_default/footer',$this->display_data);
    }
    public function change_password_success()
    {
		$this->parser->parse('admin/_default/header',$this->display_data);
		$this->parser->parse('admin/_default/navi',$this->display_data);
		$this->parser->parse('admin/account/change_password_success',$this->display_data);
		$this->parser->parse('admin/_default/footer',$this->display_data);
    }
    public function _notMatch($password, $old_password)
    {
       if( $password == $this->input->post($old_password) ){
           $this->form_validation->set_message('_notMatch', $this->display_data['account_change_password_not_match']);
           return false;
       }
       return true;
    }
    public function settings()
    {
        $GUID = $this->session->userdata('GUID');
        $this->load->model('account_model');
        $user_data = $this->account_model->retrieve_user_info_by_GUID( $GUID );
        $this->display_data = array_merge($this->display_data , $user_data);

		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em class="form_error">', '</em>');
		$this->form_validation->set_rules('timezoneoffset', $this->display_data['grid_column_TimezoneOffset'], 'trim|required|min_length[3]|max_length[50]');
		if ($this->form_validation->run() == FALSE)
		{

		    $this->parser->parse('admin/_default/header',$this->display_data);
		    $this->parser->parse('admin/_default/navi',$this->display_data);
		    $this->parser->parse('admin/account/settings',$this->display_data);
		    $this->parser->parse('admin/_default/footer',$this->display_data);
        }else{
            
            $new_data = array(
                'TimezoneOffset' => $this->input->post('timezoneoffset',true),
                'DST' => $this->input->post('dst',true)
            );
            $result = $this->db->update('[dbo].[i_user]', $new_data, array('GUID' => $GUID ));
            if($result){
                $this->utility_model->setTimezoneOffset($new_data['TimezoneOffset'] , $new_data['DST']);
                $this->display_data['alert_type'] = 'success';
                $this->display_data['alert_content'] = $this->display_data['account_settings_success'];
            }else{
                $this->display_data['alert_type'] = 'danger';
                $this->display_data['alert_content'] = $this->display_data['account_settings_fail'];
            }

		    $this->parser->parse('admin/_default/header',$this->display_data);
		    $this->parser->parse('admin/_default/navi',$this->display_data);
		    $this->parser->parse('admin/account/settings',$this->display_data);
		    $this->parser->parse('admin/_default/footer',$this->display_data);

            
        }
    }
    public function change_password()
    {
        $this->load->model('login_model');
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em class="form_error">', '</em>');
		$this->form_validation->set_rules('old_password', $this->display_data['grid_column_OldPassword'], 'required|min_length[8]|max_length[20]');
		$this->form_validation->set_rules('password', $this->display_data['grid_column_NewPassword'], 'required|min_length[8]|max_length[20]|password_least_alpha_numeric_check|callback__notMatch[old_password]');
		$this->form_validation->set_rules('password_chk', $this->display_data['grid_column_PasswordCheck'], 'required|matches[password]');

		if ($this->form_validation->run() == FALSE)
		{
		    $this->parser->parse('admin/_default/header',$this->display_data);
		    $this->parser->parse('admin/_default/navi',$this->display_data);
		    $this->parser->parse('admin/account/change_password',$this->display_data);
		    $this->parser->parse('admin/_default/footer',$this->display_data);
        }else{
            $old_data = array(
                'Email' => $this->session->userdata('Email'),
                'PasswordEncrypt' => md5($this->input->post('old_password',true)),
                'Rank' => 255
            );
            $old_query = $this->login_model->retrieve_user_info_by_account_passwd($old_data);
            if($old_query->num_rows() == 1){
                $result = $old_query->row_array();
                $new_data = array(
                    'PasswordEncrypt' => md5($this->input->post('password',true))
                );
                $this->db->update('[dbo].[i_user]', $new_data, array('GUID' => $result['GUID']));
                redirect( base_url().'/admin/account/change_password_success' , 'refresh');
            }else{
                redirect( base_url().'/admin/account/change_password_fail' , 'refresh');

            }
        }
    }
}

/* End of file account.php */
/* Location: ./application/controllers/admin/account.php */