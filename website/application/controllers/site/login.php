<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(
            array('btn' , 'login')
        );
        $this->load->model('login_model');        
        $this->logout_required_validation();
    }
    public function index()
	{
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em class="form_error">', '</em>');
		$this->form_validation->set_rules('email', $this->display_data['login_email'], 'trim|valid_email|required');
		$this->form_validation->set_rules('password',  $this->display_data['login_password'], 'trim|required|min_length[8]');
		if ($this->form_validation->run() == FALSE)
		{
            $this->display_data['return_msg'] = '';
            $this->parser->parse('site/_default/header',$this->display_data);
            
		    $this->parser->parse('site/_default/header_login',$this->display_data);
		    $this->parser->parse('site/login/login_normal',$this->display_data);

            $this->parser->parse('site/_default/footer',$this->display_data);
        }else{
            $data = array( 
                            'Email' => $this->input->post('email',true),
                            'PasswordEncrypt' => md5($this->input->post('password',true)),
                            'Rank' => 0
                    );

            if($this->input->post('password_encrypt',true) ){
                $data['PasswordEncrypt'] = $this->input->post('password_encrypt',true);
            }

            $remember_me = $this->input->post('remember_me',true);
                
            $query = $this->login_model->retrieve_user_info_by_account_passwd( $data );
            $row = $query->row();
            //登人成功，轉至會員中心
            if( $query->num_rows == 1){
                //更新最後上線時間
                $new_data = array(
                    'LastLoginTime' => date('Y-m-d H:i:s')
                );
                $result = $this->db->update('[dbo].[i_user]', $new_data, array('GUID' => $row->GUID ));

                switch($row->Rank){
                    //刪除帳號
                    case 0:
                        $this->display_data['return_msg'] = $this->display_data['login_deleted'];

                        $this->parser->parse('site/_default/header',$this->display_data);
		                $this->parser->parse('site/_default/header_login',$this->display_data);
		                $this->parser->parse('site/login/login_normal',$this->display_data);
                        $this->parser->parse('site/_default/footer',$this->display_data);

                    break;
                    //停權帳號
                    case 1:
                        $this->display_data['return_msg'] = $this->display_data['login_forbidden'] . $row->ForbiddenMsg;

                        $this->parser->parse('site/_default/header',$this->display_data);
		                $this->parser->parse('site/_default/header_login',$this->display_data);
		                $this->parser->parse('site/login/login_normal',$this->display_data);
                        $this->parser->parse('site/_default/footer',$this->display_data);

                    break;
                    //未認證會員帳號
                    case 2:
                        $this->login_model->set_login_session($row);
                        $this->login_model->set_info_cookie($row, $remember_me);
                        redirect( base_url().'home' , 'refresh');
                    break;
                    //已認證會員帳號
                    case 3:
                        $this->login_model->set_login_session($row);
                        $this->login_model->set_info_cookie($row, $remember_me);
                        redirect( base_url().'home' , 'refresh');
                    break;
                    //管理員
                    case 255:
                        $this->login_model->set_login_session($row);
                        $this->login_model->set_info_cookie($row, $remember_me);
                        redirect( base_url().'admin' , 'refresh');
                    break;
                }
            }else{
                //登入失敗頁面
                $this->display_data['return_msg'] = $this->display_data['login_email_password_error'];

                $this->parser->parse('site/_default/header',$this->display_data);
		        $this->parser->parse('site/_default/header_login',$this->display_data);
		        $this->parser->parse('site/login/login_normal',$this->display_data);
                $this->parser->parse('site/_default/footer',$this->display_data);

            }
            //Rank = 0 停權
        }
    }
}