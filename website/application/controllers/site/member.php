<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends Site_Base_Controller {
    private $UI_columns = array(
            'UserID',
            'Name',
            'GUID',
            'Email',
            'RegisterType',
            'Gender',
            'City',
            'Rank',
            "CONVERT(VARCHAR(20) , SWITCHOFFSET (DateCreate, '+00:00') ,113)  AS [DateCreate]",
            "CONVERT(VARCHAR(20) , SWITCHOFFSET (LastLoginTime, '+00:00'),113 )  AS [LastLoginTime]",
            "CONVERT(VARCHAR(20) , SWITCHOFFSET (DateModify, '+00:00') ,113)  AS [DateModify]"
    );
    private $display_data = array(
        "highlight_main_list" => "member",
        "highlight_sub_lsit" => 0,
        "session_control" => "session_exist"
    );
    private $db_Gender_convert = array(
        'male' => 0,
        'female' => 1,
    );
    private $db_City_convert = array(
        "基隆市" => 1,
        "台北市" => 2,
        "新北市" => 3,
        "桃園縣" => 4,
        "新竹市" => 5,
        "新竹縣" => 6,
        "苗栗縣" => 7,
        "台中市" => 8,
        "彰化縣" => 9,
        "南投縣" => 10,
        "雲林縣" => 11,
        "嘉義市" => 12,
        "嘉義縣" => 13,
        "台南市" => 14,
        "高雄市" => 15,
        "屏東縣" => 16,
        "台東縣" => 17,
        "花蓮縣" => 18,
        "宜蘭縣" => 19,
        "澎湖縣" => 20,
        "金門縣" => 21,
        "連江縣" => 22
    );
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();
        $this->load->model('easydb_model');
        //var_dump(  $this->session->userdata('user_exist') );
        $this->display_data["order_num_rows"] = $this->retrieve_order_num_rows();

        if( !$this->session->userdata('user_exist') ){
            redirect( base_url().'login/normal' , 'refresh');
        }
        if($this->session->userdata('Rank') == 1){
            redirect( base_url().'register/normal_register_success' , 'refresh');
        }

    }
	public function modify($GUID = NULL)
	{
        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
        $display_data = array_merge( $session_data , $this->display_data);

        $this->load->model('register_model');
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
        $this->load->model('easydb_model');
        $this->form_validation->set_rules('rank',$display_data['gird_column_Rank'],'trim');
        $this->form_validation->set_message('is_natural_no_zero', $display_data['members_no_city_set_message']);

        //如果要修改密碼
        if($this->input->post('password',true)){
		    $this->form_validation->set_rules('password', $display_data['gird_column_Passeord'], 'required|min_length[8]|max_length[20]|password_least_alpha_numeric_check');
		    $this->form_validation->set_rules('password_chk', $display_data['gird_column_PasswordEncrypt'], 'required|matches[password]');
        }
		$this->form_validation->set_rules('name', $display_data['gird_column_Name'], 'trim|required');
		$this->form_validation->set_rules('city', $display_data['gird_column_City'], 'is_natural_no_zero');




		if ($this->form_validation->run() == FALSE)
		{
            $data = array(
                "GUID" => $session_data['GUID']
            );
            $query = $this->easydb_model->select_data('[dbo].[i_user]' , $data , $this->UI_columns);

            $db_obj = $query->row();
            $db_obj->Gender = $this->db_Gender_convert[$db_obj->Gender];

            if($db_obj->City){
                $db_obj->City = $this->db_City_convert[$db_obj->City];
            }else{
                $db_obj->City = 0;
            }
            switch($db_obj->Rank){
                case 1:
                case 2:
                    $display_data['Rank_txt'] = $display_data['rank_normal_confirmed'];
                    break;
                case 0:
                    $display_data['Rank_txt'] = $display_data['rank_forbidden'];
                    break;
                case 255:
                    $display_data['Rank_txt'] = $display_data['rank_admin'];
                    break;
            }
            $display_data = array_merge(  $display_data ,(array) $db_obj );
            $this->load->view('_default/header');

            $this->parser->parse('_default/navi', $display_data);
            $this->parser->parse('member/modify', $display_data);
            $this->load->view('_default/footer');
        }else{
            $update_data = array(  
                            'Name' => $this->input->post('name',true),
                            'Gender' => $this->register_model->retrieve_gender( $this->input->post('gender',true) ),
                            'City' => $this->register_model->retrieve_city( $this->input->post('city',true) ),
                            'DateModify' => date('Y-m-d H:i:s')
            );
            if($this->input->post('password',true)){
                $update_data['Password'] = $this->input->post('password',true);
                $update_data['PasswordEncrypt'] = md5($this->input->post('password',true));
            }
            $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID));

            $display_data['post_result_content_msg'] = $display_data['members_edit_success_msg'];

            $this->load->view('_default/header');
            $this->parser->parse('_default/navi', $display_data);
            $this->parser->parse('site/post_result', $display_data);
            $this->load->view('_default/footer');

        }
	}
	public function index(){
        $this->display_data["highlight_sub_lsit"] = 99;
        
        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
        $query_data = array(
            "GUID" => $session_data['GUID']
        );

        $query = $this->easydb_model->select_data('[dbo].[i_user]' , $query_data , $this->UI_columns);
        $db_obj = $query->row();

        $data['Gender'] = $this->lang->line('gender_'.$db_obj->Gender);
        switch($db_obj->Rank){
            case 1:
            case 2:
                $data['Rank_txt'] = $this->display_data['rank_normal_confirmed'];
                break;
            case 0:
                $data['Rank_txt'] = $this->display_data['rank_forbidden'];
                break;
            case 255:
                $data['Rank_txt'] = $this->display_data['rank_admin'];
                break;
        }
        $display_data = array_merge($session_data  , $this->display_data , (array)$db_obj , $data);
        $this->load->model('register_model');
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
        $this->load->model('easydb_model');
        $this->form_validation->set_rules('rank',$display_data['gird_column_Rank'],'trim');
        $this->form_validation->set_message('is_natural_no_zero', $display_data['members_no_city_set_message']);


        $this->load->view('_default/header');

        $this->parser->parse('_default/navi', $display_data);
        $this->parser->parse('member/index_default', $display_data);
        $this->load->view('_default/footer');

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
            'button_reset'                  => $this->lang->line('button_reset'),
            'button_register'               => $this->lang->line('button_register'),
            'member_passworld_8_20_length'  => $this->lang->line('member_passworld_8_20_length'),
            'member_name_must_real'         => $this->lang->line('member_name_must_real'),
            'members_email_no_changed'      => $this->lang->line('members_email_no_changed'),
            'members_no_city_set_message'   => $this->lang->line('members_no_city_set_message'),
            'members_edit_success_msg'      => $this->lang->line('members_edit_success_msg'),

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
            'gird_column_Passeord'          => $this->lang->line('gird_column_Passeord'),
            'gird_column_PasswordEncrypt'   => $this->lang->line('gird_column_PasswordEncrypt'),
            'gird_column_PasswordReset'     => $this->lang->line('gird_column_PasswordReset'),
            
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
}

/* End of file member.php */
/* Location: ./application/controllers/member.php */