<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends Site_Base_Controller {
    private $display_data = array(
        "highlight_main_list" => "else",
        "highlight_sub_lsit" => 0,
        "session_control" => "session_not_exist"
    );
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();
        $this->load->model('register_model');
        if( $this->session->userdata('user_exist') === true and $this->session->userdata('Rank') === 255){
            redirect( base_url().'admin' , 'refresh');
        }
        $this->display_data["order_num_rows"] = $this->retrieve_order_num_rows();
        if( $this->session->userdata('user_exist') ){
            $this->display_data["session_control"] = "session_exist";
        }
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
        $data = array();
        $display_data = array_merge($data, $session_data , $this->display_data);


        $this->load->model('easydb_model');
		$this->load->library('form_validation');
        $this->form_validation->set_message('is_natural_no_zero', $display_data['members_no_city_set_message']);
        
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
		$this->form_validation->set_rules('email', $display_data['gird_column_Email'], 'trim|valid_email|required|email_duplicate_check');
		$this->form_validation->set_rules('password', $display_data['gird_column_Password'], 'required|min_length[8]|max_length[20]|password_least_alpha_numeric_check');
		$this->form_validation->set_rules('password_chk', $display_data['gird_column_PasswordEncrypt'], 'required|matches[password]');
		$this->form_validation->set_rules('name', $display_data['gird_column_Name'], 'trim|required');
		$this->form_validation->set_rules('city', $display_data['gird_column_City'], 'is_natural_no_zero');


		if ($this->form_validation->run() == FALSE)
		{

            $this->checke_user_exist();
        

            $this->load->view('_default/header', $session_data);
            $this->parser->parse('_default/navi', $display_data);
		    $this->parser->parse('register/normal_register', $display_data);
		    $this->load->view('_default/footer');
        }else{
            $this->load->library('uuid');
            $uuid = strtoupper($this->uuid->v4());
            $data = array(  
                            'GUID' => $uuid,

                            'Name' => $this->input->post('name',true),
                            'Email' => $this->input->post('email',true),
                            'Password' => $this->input->post('password',true),
                            'PasswordEncrypt' => md5($this->input->post('password',true)),
                            'Gender' => $this->register_model->retrieve_gender( $this->input->post('gender',true) ),
                            'RegisterType' => 1,
                            'Rank' => 1,
                            'City' => $this->register_model->retrieve_city( $this->input->post('city',true) ),
                            'DateCreate' => date('Y-m-d H:i:s'),
                            'LastLoginTime' =>date('Y-m-d H:i:s'),
                            'DateModify' => date('Y-m-d H:i:s')

            );
            $this->easydb_model->insert_data('[dbo].[i_user]',$data);
            $this->session->set_userdata('GUID', $data['GUID']);
            $this->session->set_userdata('Email', $data['Email']);
            $this->session->set_userdata('Name', $data['Name']);
            $this->session->set_userdata('user_exist', TRUE);
            $this->session->set_userdata('Rank', 1);

            $this->register_model->sent_email_verification($data['GUID'],$data['Email'],$data['Name']);

            redirect( base_url().'register/normal_register_success' , 'refresh');


        }
	}
    public function validate_mail($GUID = NULL , $ValidateKey = NULL)
    {
        $session_data = $this->register_model->retrieve_user_session();
        $display_data = array_merge ($session_data , $this->display_data);

        $result = $this->register_model->validate_mail($GUID , $ValidateKey);

        $this->load->view('_default/header');
        if($result == TRUE){

            $data = array(
                'GUID' => $GUID,
                'ValidateKey' => $ValidateKey,
                'Rank'  => 2
            );
            //驗證後直接登入
            $query = $this->register_model->retrieve_user_info_by_account_email_verification( $data );
            //登人成功，轉至會員中心
            $data_db['user_exist'] = true;

            
            $row = $query->row();

            
            $data_db['Name'] = $row->Name;
            $data_db['Email'] = $row->Email;
            $data_db['Rank'] = $row->Rank;
            $data_db['GUID'] = $row->GUID;
            
            $this->session->set_userdata($data_db);
            $session_data = $this->register_model->retrieve_user_session();
            $display_data = array_merge ($session_data , $this->display_data);
            $this->parser->parse('_default/navi', $display_data);
		    $this->parser->parse('register/validate_mail_success', $display_data);

        }else{
            $this->parser->parse('_default/navi', $display_data);
		    $this->parser->parse('register/validate_mail_fail', $display_data);
        }
		$this->load->view('_default/footer');
        
    }
    public function sent_email_verification()
    {
        $session_data = $this->register_model->retrieve_user_session();
        $this->register_model->sent_email_verification($session_data['GUID'],$session_data['Email'],$session_data['Name']);
        redirect( base_url().'register/normal_register_success' , 'refresh');
    }
    public function normal_register_success()
    {
        $session_data = $this->register_model->retrieve_user_session();
        $display_data = array_merge ($session_data , $this->display_data);
       // var_dump($session_data);
        $display_data['member_register_sent_email_verification'] = sprintf($display_data['member_register_sent_email_verification'],$session_data['Email']);
        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
		$this->parser->parse('register/normal_register_success', $display_data);
		$this->load->view('_default/footer');
    }
    public function google_login()
    {
        $this->load->model('easydb_model');
        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
        $display_data = array_merge( $session_data , $this->display_data);
		$this->load->library('form_validation');
        $this->form_validation->set_message('is_natural_no_zero', $display_data['members_no_city_set_message']);
        
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
		$this->form_validation->set_rules('register_type', $display_data['gird_column_Email'], 'trim');
		$this->form_validation->set_rules('id', $display_data['gird_column_Email'], 'trim');
		$this->form_validation->set_rules('email', $display_data['gird_column_Email'], 'trim');
		$this->form_validation->set_rules('name', $display_data['gird_column_Name'], 'trim|required');
		$this->form_validation->set_rules('city', $display_data['gird_column_City'], 'is_natural_no_zero');
		if ($this->form_validation->run() == FALSE)
		{
            $this->load->view('_default/header');
            $data = array();

            $this->parser->parse('_default/navi', $display_data);
            if(!$this->input->post('email',true)){
		        $this->load->view('register/google_login');
            }
		    $this->parser->parse('register/register_confirm_form', $display_data);
		    $this->load->view('_default/footer');
        }else{
            $this->load->library('uuid');
            $uuid = strtoupper($this->uuid->v4());

            $data = array(  
                            'GUID' => $uuid,
                            'Name' => $this->input->post('name',true),
                            'Email' => $this->input->post('email',true),
                            'Gender' => $this->register_model->retrieve_gender( $this->input->post('gender',true) ),
                            'GoogleID' => $this->input->post('id',true),
                            'Rank' => 2,
                            'RegisterType' => $this->input->post('register_type',true),
                            'City' => $this->register_model->retrieve_city( $this->input->post('city',true) )
            );

            $this->easydb_model->insert_data('[dbo].[i_user]',$data);
            
            $this->session->set_userdata('GUID', $data['GUID']);
            $this->session->set_userdata('Email', $data['Email']);
            $this->session->set_userdata('Name', $data['Name']);
            $this->session->set_userdata('user_exist', TRUE);
            $this->session->set_userdata('Rank', 2);

            redirect( base_url().'register/third_party_success' , 'refresh');
        }
    }
    public function third_party_success()
    {
        $session_data = $this->register_model->retrieve_user_session();
        $display_data = array_merge ($session_data , $this->display_data);
        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
        $this->parser->parse('register/register_3rd_success', $display_data);
		$this->load->view('_default/footer');

    }
	public function google_login_process()
	{
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('error_model');
        $this->load->model('easydb_model');
        $this->load->model('register_model');
        
        $data = array(  'Name' => $this->input->post('name',true),
                        'LastName' => $this->input->post('family_name',true),
                        'FirstName' => $this->input->post('given_name',true),
                        'Email' => $this->input->post('email',true),
                        'Gender' => $this->register_model->retrieve_gender( $this->input->post('gender',true) ),
                        'GoogleID' => $this->input->post('id',true),
                        'Rank' => 2,
                        'RegisterType' => 3,
                        'City' => $this->register_model->retrieve_city( $this->input->post('city',true) )
        );

        $this->easydb_model->insert_data('[dbo].[i_user]',$data);
        $data['user_exist'] = true;
        $this->session->set_userdata($data);
                        
        header('Content-Type: application/json');
        echo $this->error_model->retrieve_error_msg(0);
		
	}
	public function fb_login()
    {
        $this->load->model('easydb_model');
        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
        $display_data = array_merge( $session_data , $this->display_data);
		$this->load->library('form_validation');
        $this->form_validation->set_message('is_natural_no_zero', $display_data['members_no_city_set_message']);
        
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
        
		$this->form_validation->set_rules('register_type', $display_data['gird_column_Email'], 'trim');
		$this->form_validation->set_rules('id', $display_data['gird_column_Email'], 'trim');
		$this->form_validation->set_rules('email', $display_data['gird_column_Email'], 'trim');
		$this->form_validation->set_rules('name', $display_data['gird_column_Name'], 'trim|required');
		$this->form_validation->set_rules('city', $display_data['gird_column_City'], 'is_natural_no_zero');
		if ($this->form_validation->run() == FALSE)
		{
            $this->load->view('_default/header');
            $data = array();

            $this->parser->parse('_default/navi', $display_data);
            if(!$this->input->post('email',true)){
		        $this->load->view('register/fb_login');
            }
		    $this->parser->parse('register/register_confirm_form', $display_data);
		    $this->load->view('_default/footer');
        }else{
            $this->load->library('uuid');
            $uuid = strtoupper($this->uuid->v4());

            $data = array(  
                            'GUID' => $uuid,
                            'Name' => $this->input->post('name',true),
                            'Email' => $this->input->post('email',true),
                            'Gender' => $this->register_model->retrieve_gender( $this->input->post('gender',true) ),
                            'FacebookID' => $this->input->post('id',true),
                            'Rank' => 2,
                            'RegisterType' => $this->input->post('register_type',true),
                            'City' => $this->register_model->retrieve_city( $this->input->post('city',true) )
            );

            $this->easydb_model->insert_data('[dbo].[i_user]',$data);
            
            $this->session->set_userdata('GUID', $data['GUID']);
            $this->session->set_userdata('Email', $data['Email']);
            $this->session->set_userdata('Name', $data['Name']);
            $this->session->set_userdata('user_exist', TRUE);
            $this->session->set_userdata('Rank', 2);
            redirect( base_url().'register/third_party_success' , 'refresh');
        }
/*

        $this->checke_user_exist();

        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
		$this->load->view('_default/header', $session_data);
        print_r($session_data);
		$this->load->view('register/fb_login');
		$this->load->view('register/register_confirm_form');
		$this->load->view('_default/footer');
*/
    }
    public function fb_login_process()
    {
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('error_model');
        $this->load->model('easydb_model');
        $this->load->model('register_model');

        $data = array(  'Name' => $this->input->post('name',true),
                        'LastName' => $this->input->post('last_name',true),
                        'FirstName' => $this->input->post('first_name',true),
                        'Email' => $this->input->post('email',true),
                        'Gender' => $this->register_model->retrieve_gender( $this->input->post('gender',true) ),
                        'Locale' => $this->input->post('locale',true),
                        'Timezone' => $this->input->post('timezone',true),
                        'FacebookID' => $this->input->post('id',true),
                        'Rank' => 2,
                        'RegisterType' => 2,
                        'City' => $this->register_model->retrieve_city( $this->input->post('city',true) )
        );
        $this->easydb_model->insert_data('[dbo].[i_user]',$data);
        
        $data['user_exist'] = true;
        
        $this->session->set_userdata($data);
        header('Content-Type: application/json');
        echo $this->error_model->retrieve_error_msg(0);
    }

    public function create_account_process($from)
    {
        $this->load->model('register_model');
		$this->load->library('form_validation');
        $this->load->model('easydb_model');
        $this->form_validation->set_rules('rank','角色','trim');
        $this->form_validation->set_message('is_natural_no_zero', '必須選擇一個 居住地區。');

        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
		$this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email|required|email_duplicate_check');
		$this->form_validation->set_rules('password', '密碼', 'required|min_length[8]|max_length[20]|password_least_alpha_numeric_check');
		$this->form_validation->set_rules('password_chk', '再輸入一次密碼', 'required|matches[password]');
		$this->form_validation->set_rules('name', '姓名', 'trim|required');
		$this->form_validation->set_rules('city', '居住地區', 'is_natural_no_zero');
		if ($this->form_validation->run() == FALSE)
		{
           
            switch ($from) {
                case 0: // Go to Admin popup-create-account
                    $this->load->view('_default/popup-header');
		            $this->load->view('admin/members/popup-create-account');
                    $this->load->view('_default/popup-footer');
                case 1:
                    echo "i equals 1";
                    break;

            }

		}
		else
		{
            $data = array(  'Name' => $this->input->post('name',true),
                            'Email' => $this->input->post('email',true),
                            'Password' => $this->input->post('password',true),
                            'PasswordEncrypt' => md5($this->input->post('password',true)),
                            'Gender' => $this->register_model->retrieve_gender( $this->input->post('gender',true) ),
                            'RegisterType' => 1,
                            'Rank' => $this->input->post('rank',true),
                            'City' => $this->register_model->retrieve_city( $this->input->post('city',true) ),
                            'DateCreate' => date('Y-m-d H:i:s'),
                            'LastLoginTime' =>date('Y-m-d H:i:s'),
                            'DateModify' => date('Y-m-d H:i:s')

            );
            $this->easydb_model->insert_data('[dbo].[i_user]',$data);
            switch ($from) {
                case 0: // Go to Admin popup-create-account-result
                   
                    $this->load->view('_default/popup-header');
		            $this->load->view('admin/members/popup-create-account-result');
                    $this->load->view('_default/popup-footer');
                case 1:
                    echo "i equals 1";
                    break;
            }
        }
    }
    public function check_3rd_user_exist($type){
        $this->load->model('register_model');
        if($type == 'google'){
            $id = $this->input->post('id',true);
            $email = $this->input->post('email',true);
            $result = $this->register_model->validate_google_account( $id , $email );
            

        }
        if($type == 'facebook'){
            $id = $this->input->post('id',true);
            $email = $this->input->post('email',true);
            $result = $this->register_model->validate_facebook_account( $id , $email );
        }
        if($result == TRUE){
            $status['access'] = 'pass';
            $status['email'] = $email;
            $status['id'] = $id;
        
        }else{
            $status['access'] = 'deny';
        }
        header('Content-Type: application/json');
        echo json_encode($status);
    }   
    public function parse_display_data(){
        //Language parse
        $this->lang->load('button');
        $this->lang->load('menu');
        $this->lang->load('members');
        $this->lang->load('gird_column');
        $this->lang->load('rank');
        $this->lang->load('register_type');
        $this->lang->load('gender');
        $this->lang->load('contextmenu');
        
        $display_data = array(
            'button_close'                  => $this->lang->line('button_close'),
            'button_cancel'                 => $this->lang->line('button_cancel'),
            'button_ok'                     => $this->lang->line('button_ok'),
            'button_submit'                 => $this->lang->line('button_submit'),
            'button_register'               => $this->lang->line('button_register'),
            'member_passworld_8_20_length'  => $this->lang->line('member_passworld_8_20_length'),
            'member_name_must_real'         => $this->lang->line('member_name_must_real'),
            'member_city_must_select'       => $this->lang->line('member_city_must_select'),
            'members_email_no_changed'      => $this->lang->line('members_email_no_changed'),
            'members_no_city_set_message'   => $this->lang->line('members_no_city_set_message'),
            'member_register_email_verification'   => $this->lang->line('member_register_email_verification'),
            'member_register_sent_email_verification'   => $this->lang->line('member_register_sent_email_verification'),
            'member_register_sent_again_email_verification'   => $this->lang->line('member_register_sent_again_email_verification'),
            'member_register_validate_mail_fail'    => $this->lang->line('member_register_validate_mail_fail'),
            'member_register_validate_mail_success'    => $this->lang->line('member_register_validate_mail_success'),
            'member_register_3rd_success'   => $this->lang->line('member_register_3rd_success'),
            'gird_column_UserID'            => $this->lang->line('gird_column_UserID'),
            'gird_column_Name'              => $this->lang->line('gird_column_Name'),
            'gird_column_RegisterType'      => $this->lang->line('gird_column_RegisterType'),
            'gird_column_Rank'              => $this->lang->line('gird_column_Rank'),
            'gird_column_Email'             => $this->lang->line('gird_column_Email'),
            'gird_column_Gender'            => $this->lang->line('gird_column_Gender'),
            'gird_column_City'              => $this->lang->line('gird_column_City'),
            'gird_column_LastLoginTime'     => $this->lang->line('gird_column_LastLoginTime'),
            'gird_column_DateModify'        => $this->lang->line('gird_column_DateModify'),
            'gird_column_DateCreate'        => $this->lang->line('gird_column_DateCreate'),
            'gird_column_Password'          => $this->lang->line('gird_column_Password'),
            'gird_column_PasswordEncrypt'   => $this->lang->line('gird_column_PasswordEncrypt'),
            'gird_column_PasswordReset'     => $this->lang->line('gird_column_PasswordReset'),
            'gender_male'                   => $this->lang->line('gender_male'),
            'gender_female'                 => $this->lang->line('gender_female'),
            'rank_view_all'                 => $this->lang->line('rank_view_all'),
            'rank_forbidden'                => $this->lang->line('rank_forbidden'),
            'rank_normal_but_not_confirm'   => $this->lang->line('rank_normal_but_not_confirm'),
            'rank_normal_confirmed'	        => $this->lang->line('rank_normal_confirmed'),
            'rank_admin'	                => $this->lang->line('rank_admin'),
            'register_type_normal'          => $this->lang->line('register_type_normal'),
            'register_type_facebook'        => $this->lang->line('register_type_facebook'),
            'register_type_google'          => $this->lang->line('register_type_google'),

            'gender_male'                   => $this->lang->line('gender_male'),
            'gender_female'                 => $this->lang->line('gender_female'),

            'contextmenu_details'           => $this->lang->line('contextmenu_details'),
            'contextmenu_create'            => $this->lang->line('contextmenu_create'),
            'contextmenu_edit'              => $this->lang->line('contextmenu_edit'),
            'contextmenu_delete'	        => $this->lang->line('contextmenu_delete'),
            'contextmenu_reload'            => $this->lang->line('contextmenu_reload')

        );
        $this->display_data = array_merge($this->display_data , $display_data);

    }
	public function phpinfo()
	{
        $this->load->model('error_model');
        echo $this->error_model->retrieve_error_mag(1);
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */