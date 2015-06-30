<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Admin_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect( base_url() , 'refresh');
    }

    public function logout_successfully()
    {
            
    }
    public function change_password()
    {
 		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');

		$this->form_validation->set_rules('password_old', '原始密碼', 'required|password_account_auth_check');
		$this->form_validation->set_rules('password', '重設密碼', 'required|min_length[8]|max_length[20]|password_least_alpha_numeric_check');
		$this->form_validation->set_rules('password_chk', '再輸入一次密碼', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE)
		{

		    $this->load->view('admin/header');


            $data = array();
            $session_data = $this->register_model->retrieve_user_session();
            $display_data = array_merge($data,$this->display_data);

		    $this->parser->parse('admin/navi',$display_data);
		    $this->load->view('admin/account/change_password',$display_data);
		    $this->load->view('admin/footer');

        }else{
            if($this->input->post('password',true)){
                $update_data['Password'] = $this->input->post('password',true);
                $update_data['PasswordEncrypt'] = md5($this->input->post('password',true));
            }
            $GUID = $this->session->userdata('GUID');
            $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID));
            $this->session->sess_destroy();
            redirect( base_url().'login/admin' , 'refresh');
        }
    }
    public function parse_display_data(){
        //Language parse
        $this->build_navi();
    }
}
