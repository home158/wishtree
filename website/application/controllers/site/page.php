<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Site_Base_Controller {
    private $display_data = array(
        "highlight_main_list" => "notepad",
        "highlight_sub_lsit" => 0,
        "session_control" => "session_not_exist"
    );
    private $UI_columns = array(
			'[PageID]',
			'[GUID]',
			'[Title]',
			'[Content]',
			'[Hits]',
			'[DateCreate]',
			'[DateModify]'
    );
    private $dispatch = array(
        'farm_village' => array(
            'GUID' => '3234F813-9D92-47AA-B8C5-F740E3D59E30',
            'L10N_title' => 'menu_notepad_farm_village',
            "highlight_main_list" => "notepad",
            'highlight_sub_lsit' => 0
        ),
        'process' => array(
            'GUID' => '180C69E2-2DDF-4F77-96B2-0BBA35813AA5',
            'L10N_title' => 'menu_notepad_process' ,
            "highlight_main_list" => "notepad",
            'highlight_sub_lsit' => 1     
        ),
        'growing' => array(
            'GUID' => '3F66CAC5-59A8-4B7F-8FB4-847C7C6C12FC',
            'L10N_title' => 'menu_notepad_growing' ,
            "highlight_main_list" => "notepad",
            'highlight_sub_lsit' => 2     
        ),
        'vegetable' => array(
            'GUID' => '49CDEBEA-456F-4D7E-B9B6-A487521899AE',
            'L10N_title' => 'menu_notepad_vegetable' ,
            "highlight_main_list" => "notepad",
            'highlight_sub_lsit' => 3     
        ),
        'farmer' => array(
            'GUID' => '1D849C60-2DF7-4C36-A2AD-A3B51B44E56D',
            'L10N_title' => 'menu_notepad_farmer' ,
            "highlight_main_list" => "notepad",
            'highlight_sub_lsit' => 4     
        ),
        'seasonal' => array(
            'GUID' => '2B3FF140-1629-4A0C-A209-2FA39BCB6471',
            'L10N_title' => 'menu_seasonal_seasonal' ,
            "highlight_main_list" => "seasonal",
            'highlight_sub_lsit' => 1
        ),
        'promotion' =>  array(
            'GUID' => '33B702AE-FA7B-4726-8F18-E0F96903DA50',
            'L10N_title' => 'menu_news_promotion' ,
            "highlight_main_list" => "news",
            'highlight_sub_lsit' => 1
        )
    );
    public function __construct()
    {
        parent::__construct();
        if( $this->session->userdata('user_exist') === true){
            $this->display_data['session_control'] = "session_exist";
        }
        $this->display_data["order_num_rows"] = $this->retrieve_order_num_rows();
    }
	public function index()
	{
        $this->farm_village();
        
	}
    public function get_page($GUID)
    {

        $data_query = array(
            "GUID" => $GUID
        );
        $this->load->model('easydb_model');
        $query_page = $this->easydb_model->select_data('[dbo].[i_pages]' , $data_query , $this->UI_columns);
        return (array) $query_page->row();
    }
	public function preview($page)
	{
        $session_data = $this->register_model->retrieve_user_session();
        $data = $this->get_page($this->dispatch[$page]['GUID']);
        $this->display_data["highlight_sub_lsit"] = $this->dispatch[$page]['highlight_sub_lsit'];
        $this->display_data["highlight_main_list"] = $this->dispatch[$page]['highlight_main_list'];
        $display_data = array_merge($data , $session_data , $this->display_data);
        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
        $this->parser->parse('page/'.$page, $display_data);
        $this->load->view('_default/footer');
        
	}

}

/* End of file notepad.php */
/* Location: ./application/controllers/notepad.php */