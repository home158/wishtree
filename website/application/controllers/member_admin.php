<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_admin extends Admin_Base_Controller {
    public function __construct()
    {
        parent::__construct();
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
            "CONVERT(VARCHAR(20) , SWITCHOFFSET (DateCreate, '+08:00') ,113)  AS [DateCreate]",
            "CONVERT(VARCHAR(20) , SWITCHOFFSET (LastLoginTime, '+08:00'),113 )  AS [LastLoginTime]",
            "CONVERT(VARCHAR(20) , SWITCHOFFSET (DateModify, '+08:00') ,113)  AS [DateModify]"
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
        ini_set('display_errors', 1);
        //$this->load->database();
        
  
        $this->load->model('register_model');
        $this->load->model('easydb_model');
        $session_data = $this->register_model->retrieve_user_session();
		$this->load->view('admin/header', $session_data);

        //init data grid
        $query = $this->easydb_model->select_data_limit_offset('[dbo].[i_user]', 'UserID' , 0 , 37 , $this->UI_columns);

        $data = array(
            'grid_data' => json_encode($query['object']->result()),
            'num_rows' => $query['num_rows']
        );
		$this->parser->parse('admin/navi',$data);

		$this->parser->parse('member_admin/index_default',$data);
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
        $query = $this->easydb_model->select_data_limit_offset('[dbo].[i_user]', 'UserID' , $top , $bottom , $this->UI_columns , $Rank_between_from , $Rank_between_to , $Register_type , $sort_column_id , $order_method , $search_txt);
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
    public function test(){
        $a = 0 ;
        if(!empty($Rank_between_to)){
            echo "true";
        }else{
            echo "false";
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/member_admin.php */