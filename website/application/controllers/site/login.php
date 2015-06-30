<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Site_Base_Controller {
    private $display_data = array(
        "highlight_main_list" => "else",
        "highlight_sub_lsit" => 0,
        "session_control" => "session_not_exist"
    );
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();
        if( $this->session->userdata('user_exist') === true and $this->session->userdata('Rank') === 255){
            redirect( base_url().'admin' , 'refresh');
        }
        $this->display_data["order_num_rows"] = $this->retrieve_order_num_rows();
    }
    public function index()
    {
        
    }
    public function reset_password($GUID , $ValidateKey)
    {
        $session_data = $this->register_model->retrieve_user_session();
        $display_data = array_merge ($session_data , $this->display_data);

        $result = $this->register_model->validate_reset_password($GUID , $ValidateKey);
        
        if($result == FALSE){
            $this->load->view('_default/header');
            $this->parser->parse('_default/navi', $display_data);
		    $this->parser->parse('register/reset_password_fail', $display_data);
		    $this->load->view('_default/footer');

        }else{
            $session_data = $this->register_model->retrieve_user_session();
            $user_info = $this->register_model->retrieve_user_info_by_account_email_verification(
                        array(
                            'GUID'=>$GUID,
                            'ValidateKey'=>$ValidateKey,
                            'Rank'=>1
                        )
            );
            $display_data = array_merge ($session_data,  (array) $user_info->row() , $this->display_data);
		    $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
		    $this->form_validation->set_rules('password', $display_data['gird_column_PasswordReset'], 'required|min_length[8]|max_length[20]|password_least_alpha_numeric_check');
		    $this->form_validation->set_rules('password_chk', $display_data['gird_column_PasswordEncrypt'], 'required|matches[password]');
		    if ($this->form_validation->run() == FALSE)
		    {
               // var_dump($session_data);
               // $display_data['member_register_sent_email_forgot_password'] = sprintf($display_data['member_register_sent_email_forgot_password'],$session_data['Email']);
                $this->load->view('_default/header');
                $this->parser->parse('_default/navi', $display_data);
    		    $this->parser->parse('register/reset_password', $display_data);
    		    $this->load->view('_default/footer');
            }else{
                
                $update_data['Password'] = $this->input->post('password',true);
                $update_data['PasswordEncrypt'] = md5($this->input->post('password',true));
                $update_data['ValidateKey'] = NULL;
                $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID));


                $this->load->view('_default/header');
                $this->parser->parse('_default/navi', $display_data);
                $this->parser->parse('register/reset_password_success', $display_data);
                $this->load->view('_default/footer');

            }
        }
    }
    public function forgot_password()
    {
        $session_data = $this->register_model->retrieve_user_session();
        $display_data = array_merge ($session_data , $this->display_data);
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
		$this->form_validation->set_rules('email', $display_data['gird_column_Email'], 'trim|valid_email|required|email_exist_check');
		if ($this->form_validation->run() == FALSE)
		{
           // var_dump($session_data);
           // $display_data['member_register_sent_email_forgot_password'] = sprintf($display_data['member_register_sent_email_forgot_password'],$session_data['Email']);
            $this->load->view('_default/header');
            $this->parser->parse('_default/navi', $display_data);
    		$this->parser->parse('register/forgot_password', $display_data);
    		$this->load->view('_default/footer');
        }else{
            $email = $this->input->post('email',true);
            $this->register_model->send_mail_forgot_password($email);
            redirect( base_url().'login/send_mail_forgot_password/'.$email , 'refresh');
        }
    }
    public function send_mail_forgot_password($email)
    {
        $session_data = $this->register_model->retrieve_user_session();
        $display_data = array_merge ($session_data , $this->display_data);
       // var_dump($session_data);
        $display_data['member_login_send_mail_forgot_password'] = sprintf($display_data['member_login_send_mail_forgot_password'],$email);
        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
		$this->parser->parse('register/send_mail_forgot_password', $display_data);
		$this->load->view('_default/footer');
    }
    public function facebook($id , $email)
    {
        $data = array( 
            'Email' => $email,
            'FacebookID' => $id,
            'Rank' => 2
        );
        $query = $this->register_model->retrieve_user_info_by_facebook_account( $data );
        if( $query->num_rows == 1){
            $data_db['user_exist'] = true;
            
            $row = $query->row();
            $this->register_model->update_logintime($row->GUID);
            switch($row->Rank){
                //停權帳號
                case 0:

                break;
                //未認證會員帳號
                case 1:
                    $data_db['Name'] = $row->Name;
                    $data_db['Email'] = $row->Email;
                    $data_db['Rank'] = $row->Rank;
                    $data_db['GUID'] = $row->GUID;
                    $this->session->set_userdata($data_db);
                    redirect( base_url().'member' , 'refresh');
                    
                break;
                //已認證會員帳號
                case 2:
                    $data_db['Name'] = $row->Name;
                    $data_db['Email'] = $row->Email;
                    $data_db['Rank'] = $row->Rank;
                    $data_db['GUID'] = $row->GUID;
                
                    $this->session->set_userdata($data_db);
                    $go_back = $this->session->userdata('go_back');
                    if($go_back){
                        redirect( base_url().$go_back , 'refresh');
                    }else{
                        redirect( base_url().'member' , 'refresh');
                    }
                break;

            }
        }else{
            //登入失敗頁面
            redirect( base_url().'login/fail' , 'refresh');
        }
    }
    public function google($id , $email)
    {
        $data = array( 
            'Email' => $email,
            'GoogleID' => $id,
            'Rank' => 2
        );
        $query = $this->register_model->retrieve_user_info_by_google_account( $data );
        if( $query->num_rows == 1){
            $data_db['user_exist'] = true;

            
            $row = $query->row();
            $this->register_model->update_logintime($row->GUID);
            switch($row->Rank){
                //停權帳號
                case 0:

                break;
                //未認證會員帳號
                case 1:
                    $data_db['Name'] = $row->Name;
                    $data_db['Email'] = $row->Email;
                    $data_db['Rank'] = $row->Rank;
                    $data_db['GUID'] = $row->GUID;
                    $this->session->set_userdata($data_db);
                    redirect( base_url().'member' , 'refresh');
                    
                break;
                //已認證會員帳號
                case 2:
                    $data_db['Name'] = $row->Name;
                    $data_db['Email'] = $row->Email;
                    $data_db['Rank'] = $row->Rank;
                    $data_db['GUID'] = $row->GUID;
                
                    $this->session->set_userdata($data_db);
                    $go_back = $this->session->userdata('go_back');
                    if($go_back){
                        redirect( base_url().$go_back , 'refresh');
                    }else{
                        redirect( base_url().'member' , 'refresh');
                    }
                break;

            }
        }else{
            //登入失敗頁面
            redirect( base_url().'login/fail' , 'refresh');
        }
    }
    public function normal()
    {
		$this->load->library('form_validation');
        
		$this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|required');
		$this->form_validation->set_rules('password', '密碼', 'trim|required|min_length[8]');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');

		if ($this->form_validation->run() == FALSE)
		{

            $this->checke_user_exist();
        
            $this->load->model('register_model');
            $session_data = $this->register_model->retrieve_user_session();
            $this->load->view('_default/header');
            $data = array();
            $display_data = array_merge($data, $session_data , $this->display_data);

            $this->parser->parse('_default/navi', $display_data);

		    $this->load->view('register/normal_login');


		    $this->load->view('_default/footer');
        }else{
            $data = array( 
                            'Email' => $this->input->post('email',true),
                            'PasswordEncrypt' => md5($this->input->post('password',true)),
                            'Rank' => 0
                    );
            
            $query = $this->register_model->retrieve_user_info_by_account_passwd( $data );
            //登人成功，轉至會員中心
            if( $query->num_rows == 1){
                $data_db['user_exist'] = true;

                $row = $query->row();
                $this->register_model->update_logintime($row->GUID);
                switch($row->Rank){
                    //停權帳號
                    case 0:

                    break;
                    //未認證會員帳號
                    case 1:
                        $data_db['Name'] = $row->Name;
                        $data_db['Email'] = $row->Email;
                        $data_db['Rank'] = $row->Rank;
                        $data_db['GUID'] = $row->GUID;
                        $this->session->set_userdata($data_db);
                        redirect( base_url().'register/normal_register_success' , 'refresh');
                        
                    break;
                    //已認證會員帳號
                    case 2:
                        $data_db['Name'] = $row->Name;
                        $data_db['Email'] = $row->Email;
                        $data_db['Rank'] = $row->Rank;
                        $data_db['GUID'] = $row->GUID;
                    
                        $this->session->set_userdata($data_db);
                        $go_back = $this->session->userdata('go_back');
                        if($go_back){
                            redirect( base_url().$go_back , 'refresh');
                        }else{
                            redirect( base_url().'member' , 'refresh');
                        }
                    break;

                }

            }else{
                //登入失敗頁面
                redirect( base_url().'login/fail' , 'refresh');
            }

        }
    }

    public function admin()
    {
		$this->load->library('form_validation');
        
		$this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|required');
		$this->form_validation->set_rules('password', '密碼', 'trim|required|min_length[8]');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');

		if ($this->form_validation->run() == FALSE)
		{
            $this->checke_user_exist();
            $this->load->model('register_model');
            $session_data = $this->register_model->retrieve_user_session();

            $data = array();
            $display_data = array_merge($data, $session_data , $this->display_data);


            $this->load->view('_default/header');
            $this->parser->parse('_default/navi', $display_data);
            $this->load->view('register/admin_login');
            $this->load->view('_default/footer');
		}
		else
		{
            
            $data = array( 
                            'Email' => $this->input->post('email',true),
                            'PasswordEncrypt' => md5($this->input->post('password',true)),
                            'Rank' => 255
                    );

            $query = $this->register_model->retrieve_user_info_by_account_passwd( $data );
            
            //登人成功，轉至Admin首頁
            if( $query->num_rows == 1){
                $data_db['user_exist'] = true;

                
                $row = $query->row();
                $this->register_model->update_logintime($row->GUID);

             
                $data_db['Name'] = $row->Name;
                $data_db['Email'] = $row->Email;
                $data_db['Rank'] = $row->Rank;
                $data_db['GUID'] = $row->GUID;
                
                $this->session->set_userdata($data_db);
                redirect( base_url().'admin' , 'refresh');
            }else{
                //登入失敗頁面
                redirect( base_url().'login/fail' , 'refresh');
            }

		}
    }
    public function fail()
    {
        $this->load->view('_default/header');
        $display_data = array_merge(  $this->display_data);

        $this->parser->parse('_default/navi', $display_data);

		$this->parser->parse('register/login_fail', $display_data);


		$this->load->view('_default/footer');
        //echo "無法登入！帳號不存在或密碼錯誤。";
    }
    public function parse_display_data(){
        //Language parse
        $this->lang->load('members');
        $this->lang->load('button');
        $this->lang->load('gird_column');

        $display_data = array(
            'button_submit' => $this->lang->line('button_submit'),
            'button_reset'  => $this->lang->line('button_reset'),

            'gird_column_Email' => $this->lang->line('gird_column_Email'),
            'gird_column_PasswordReset' => $this->lang->line('gird_column_PasswordReset'),
            'gird_column_PasswordEncrypt' => $this->lang->line('gird_column_PasswordEncrypt'),
            'member_passworld_8_20_length' => $this->lang->line('member_passworld_8_20_length'),
            'member_login_forgot_password' => $this->lang->line('member_login_forgot_password'),
            'member_login_fail'  => $this->lang->line('member_login_fail'),
            'member_login_again' => $this->lang->line('member_login_again'),
            'member_no_account' => $this->lang->line('member_no_account'),
            'member_register_now' => $this->lang->line('member_register_now'),
            'member_register_email_verification'   => $this->lang->line('member_register_email_verification'),
            'member_register_sent_email_verification'   => $this->lang->line('member_register_sent_email_verification'),
            'member_register_sent_again_email_verification'   => $this->lang->line('member_register_sent_again_email_verification'),
            'member_login_send_mail_forgot_password'    => $this->lang->line('member_login_send_mail_forgot_password'),
            'member_login_reset_password'       => $this->lang->line('member_login_reset_password'),
            'member_login_reset_password_fail'  => $this->lang->line('member_login_reset_password_fail'),
            'member_login_reset_password_success'  => $this->lang->line('member_login_reset_password_success')
        );
        $this->display_data = array_merge($this->display_data , $display_data);
        

    }
}


/* End of file login.php */
/* Location: ./application/controllers/login.php */