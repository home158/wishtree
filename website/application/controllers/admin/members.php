<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends Admin_Base_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();
    }
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
        
    }

    public function view($GUID = "00000000-0000-0000-0000-000000000000")
	{
        $this->load->model('register_model');
        $this->load->model('easydb_model');
        $top = 0;
        $bottom =37;
        //init data grid
        switch($GUID){
            
            case "6A928D1F-EB98-4D78-A792-F8B35B03E166":
                    $Rank_between_from = 1;
                    $Rank_between_to = 254;
                    $Register_type = "1,2,3";
                    $query = $this->easydb_model->select_data_limit_offset('[dbo].[i_user]', 'UserID' , $top , $bottom , $this->UI_columns , 
                                                                            $Rank_between_from , $Rank_between_to , $Register_type );
                break;
                 
            case "8C06A53F-4971-4954-9C6B-D3EC709A3BC9":
                    $Rank_between_from = 0;
                    $Rank_between_to = 0;
                    $Register_type = "1,2,3";
                    $query = $this->easydb_model->select_data_limit_offset('[dbo].[i_user]', 'UserID' , $top , $bottom , $this->UI_columns , 
                                                                            $Rank_between_from , $Rank_between_to , $Register_type );
                 break;
            case "B5F90B86-52AE-4F8B-BDB6-E7C7CC8325FB":
                    $Rank_between_from = 25;
                    $Rank_between_to = 255;
                    $Register_type = "1,2,3";
                    $query = $this->easydb_model->select_data_limit_offset('[dbo].[i_user]', 'UserID' , $top , $bottom , $this->UI_columns , 
                                                                            $Rank_between_from , $Rank_between_to , $Register_type );

                 break;
            default:
                    $query = $this->easydb_model->select_data_limit_offset('[dbo].[i_user]', 'UserID' , $top , $bottom , $this->UI_columns);
                break;
        }

        $data = array(
            'grid_data' => json_encode($query['object']->result()),
            'num_rows' => $query['num_rows'],
            'GUID' => $GUID
        );
        $this->display_data['members_total_rows'] = sprintf($this->lang->line('members_total_rows') , $query['num_rows']);
        $display_data = array_merge($data,$this->display_data);
		$this->load->view('admin/header');
		$this->parser->parse('admin/navi',$display_data);
		$this->parser->parse('admin/members/index_default',$display_data);
		$this->load->view('admin/footer');
	}
    public function retrieve_member_list_json()
    {
        $this->load->model('easydb_model');
        $top = $this->input->post('top',true);
        $bottom = $this->input->post('bottom',true);
        $Rank_between_from = $this->input->post('RANK_BETWEEN_FROM',true);
        $Rank_between_to = $this->input->post('RANK_BETWEEN_TO',true);
        $Register_type = $this->input->post('REGISTER_TYPE',true);
        $sort_column_id = $this->input->post('SORT_COLUMN_ID',true);
        $order_method = $this->input->post('ORDER_METHOD',true); // true or false
        $search_txt = $this->input->post('SEARCH_TXT',true);
        $query = $this->easydb_model->select_data_limit_offset('[dbo].[i_user]', 'UserID' , $top , $bottom , 
                                                                $this->UI_columns , $Rank_between_from , $Rank_between_to , $Register_type , 
                                                                $sort_column_id , $order_method , $search_txt);
        $data = array(
            'grid_data' => $query['object']->result(),
            'num_rows' => $query['num_rows'],
            'top' => $top,
            'bottom' => $bottom,
            'Rank_between_from' => $Rank_between_from,
            'Rank_between_to' => $Rank_between_to,
            'Register_type' => $Register_type,
            'sort_column_id' => $sort_column_id,
            'order_method' => $order_method,
            'search_txt' => $search_txt
        );
        
        header('Content-Type: application/json');
        echo json_encode($data);
        
    }
    public function delete_members_json(){
        $this->load->model('error_model');
        $this->load->model('easydb_model');
        $GUID = $this->input->post('GUID',true);
        $query = $this->easydb_model->delete_rows_where_in('[dbo].[i_user]' , $GUID);

        if($query == true){
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(0);
        }else{
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(2);
        }
    }
    public function create()
    {
        $this->load->model('register_model');
		$this->load->library('form_validation');
        $this->load->model('easydb_model');
        $display_data = $this->display_data;

        $this->form_validation->set_rules('rank',$display_data['gird_column_Rank'],'trim');
        $this->form_validation->set_message('is_natural_no_zero', $display_data['members_no_city_set_message']);
        
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
		$this->form_validation->set_rules('email', $display_data['gird_column_Email'], 'trim|valid_email|required|email_duplicate_check');
		$this->form_validation->set_rules('password', $display_data['gird_column_Passeord'], 'required|min_length[8]|max_length[20]|password_least_alpha_numeric_check');
		$this->form_validation->set_rules('password_chk', $display_data['gird_column_PasswordEncrypt'], 'required|matches[password]');
		$this->form_validation->set_rules('name', $display_data['gird_column_Name'], 'trim|required');
		$this->form_validation->set_rules('city', $display_data['gird_column_City'], 'is_natural_no_zero');
		if ($this->form_validation->run() == FALSE)
		{
            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/members/popup_create_account',$display_data);
            $this->load->view('_default/popup-footer');
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

            $display_data['post_result_subject_title'] = $display_data['members_create'];
            $display_data['post_result_content_msg'] = $display_data['members_create_success_msg'];

            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/popup_post_result' , $display_data);
            $this->load->view('_default/popup-footer');
        }
    }
    public function edit( $GUID )
    {
        $display_data = $this->display_data;
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
           
            $this->load->model('easydb_model');
            $data = array(
                "GUID" => $GUID
            );
            $query = $this->easydb_model->select_data('[dbo].[i_user]' , $data , $this->UI_columns);

            $db_obj = $query->row();
            $db_obj->Gender = $this->db_Gender_convert[$db_obj->Gender];

            if($db_obj->City){
            $db_obj->City = $this->db_City_convert[$db_obj->City];
            }else{
                $db_obj->City = 0;
            }

            $display_data = array_merge( $display_data, (array) $db_obj );
            $this->load->view('_default/popup-header');
            $this->parser->parse('admin/members/popup_edit_account',$display_data);
            $this->load->view('_default/popup-footer');
        }
        else
		{
            $update_data = array(  
                            'Name' => $this->input->post('name',true),
                            'Gender' => $this->register_model->retrieve_gender( $this->input->post('gender',true) ),
                            'Rank' => $this->input->post('rank',true),
                            'City' => $this->register_model->retrieve_city( $this->input->post('city',true) ),
                            'DateModify' => date('Y-m-d H:i:s')
            );
            if($this->input->post('password',true)){
                $update_data['Password'] = $this->input->post('password',true);
                $update_data['PasswordEncrypt'] = md5($this->input->post('password',true));
            }
            $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID));

            $display_data['post_result_subject_title'] = $display_data['members_edit'];
            $display_data['post_result_content_msg'] = $display_data['members_edit_success_msg'];

            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/popup_post_result' , $display_data);
            $this->load->view('_default/popup-footer');
        }

    }
    public function details($GUID){
        $display_data = $this->display_data;
        $this->load->model('easydb_model');
        $this->load->model('register_model');
        $data = array(
            "GUID" => $GUID
        );
        $query = $this->easydb_model->select_data('[dbo].[i_user]' , $data , $this->UI_columns);

        $db_obj = $query->row();
        $db_obj->Gender = $this->lang->line('members_' . $db_obj->Gender);

        
        $db_obj->RegisterType = $this->register_model->retrieve_register_type( $db_obj->RegisterType );
        $db_obj->Rank = $this->register_model->retrieve_rank( $db_obj->Rank );

        $display_data = array_merge( $display_data, (array) $db_obj );

        $this->load->view('_default/popup-header');
		$this->parser->parse('admin/members/popup_details_account',$display_data);
        $this->load->view('_default/popup-footer');

        
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
        $this->display_data = array(
            'button_close'                  => $this->lang->line('button_close'),
            'button_cancel'                 => $this->lang->line('button_cancel'),
            'button_ok'                     => $this->lang->line('button_ok'),
            'button_submit'                 => $this->lang->line('button_submit'),

            'members_search_alert_msg'      => $this->lang->line('members_search_alert_msg'),
            'members_popup_delete_title'    => $this->lang->line('members_popup_delete_title'),
            'members_popup_delete_msg'      => $this->lang->line('members_popup_delete_msg'),
            'members_tree_search_result'    => $this->lang->line('members_tree_search_result'),
            'members_search_btn'            => $this->lang->line('members_search_btn'),
            'members_search_account'        => $this->lang->line('members_search_account'),
            'members_search_hint'           => $this->lang->line('members_search_hint'),
            'members_total_rows'            => $this->lang->line('members_total_rows'),
            'menu_admin_members'            => $this->lang->line('menu_admin_members'),
            'members_no_city_set_message'   => $this->lang->line('members_no_city_set_message'),
            'members_create'                => $this->lang->line('members_create'),
            'members_create_success_msg'    => $this->lang->line('members_create_success_msg'),
            'members_edit'                  => $this->lang->line('members_edit'),
            'members_edit_success_msg'      => $this->lang->line('members_edit_success_msg'),
            'members_email_no_changed'      => $this->lang->line('members_email_no_changed'),
            'member_passworld_8_20_length'  => $this->lang->line('member_passworld_8_20_length'),
            'member_name_must_real'         => $this->lang->line('member_name_must_real'),
            'members_details'               => $this->lang->line('members_details'),

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
        $this->build_navi();

    }
    public function test(){
        $is_send_success = TRUE;
        $send = TRUE;
        if($send & $is_send_success){
            $is_send_success = TRUE;
        }else{
            $is_send_success = FALSE;
        }
        $send = TRUE;
        if($send & $is_send_success){
            $is_send_success = TRUE;
        }else{
            $is_send_success = FALSE;
        }
        var_dump($is_send_success);
        
    }
}

/* End of file members.php */
/* Location: ./application/controllers/admin/members.php */