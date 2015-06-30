<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends Site_Base_Controller {
    private $display_data = array(
        "highlight_main_list" => "news",
        "highlight_sub_lsit" => 99,
        "session_control" => "session_not_exist"
    );
    private $UI_columns = array(
        "[NewsID]",
        "[GUID]",
        "[GUID] AS [NEWS_GUID]",
        "[Title]",
        "[ShortDesc]",
        "[Content]",
        "[CoverImageURLPath]",
        "[CoverImageThumbURLPath]",
        "[CoverImageBackgroundPosition]",
        "[IsShow]",
        "[Hits]",
        "CONVERT(VARCHAR(17) , SWITCHOFFSET (DateCreate, '+00:00') ,113)  AS [DateCreate]",
        "CONVERT(VARCHAR(17) , SWITCHOFFSET (DateModify, '+00:00'),113 )  AS [DateModify]"
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
        $this->load->model('news_model');
        $session_data = $this->register_model->retrieve_user_session();

        $result = $this->news_model->select_data_limit_offset(0 , 1 , $this->UI_columns , 1 );
        $this->display_data['news_lists'] = $result['object']->result();
        
        $data = array();
        $display_data = array_merge($data , $session_data , $this->display_data);

        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
        $this->parser->parse('news/index_default', $display_data);
        $this->load->view('_default/footer');
	}
    public function hit($GUID)
    {
        $this->db->query(
                "UPDATE [dbo].[i_news] 
                SET 
                    [Hits] = [Hits] + 1 
                WHERE 
                        [GUID] = '".$GUID."'"
            );
    }
    public function more($GUID = NULL)
    {
        $this->display_data["highlight_sub_lsit"] = 0;

        $this->load->model('news_model');
        $this->load->model('easydb_model');

        if(is_array($this->UI_columns)){
            $column = join(",", $this->UI_columns);
        }

        if($GUID == NULL){
            show_404();
        }else{
            $data_query = array(
                "GUID" => $GUID
            );
            $query_news = $this->easydb_model->select_data('[dbo].[i_news]' , $data_query , $this->UI_columns);
            if($query_news->num_rows()==0){
                show_404();
            }
        }
        $this->hit($GUID);
        $result = $this->news_model->select_data_limit_offset(0 , 3 , $this->UI_columns , 1 );
        $this->display_data['news_lists'] = $result['object']->result();
        


        $session_data = $this->register_model->retrieve_user_session();

        $data = array();
        $display_data = array_merge($data , $session_data , $this->display_data , (array) $query_news->row());

        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
        $this->parser->parse('news/more_details', $display_data);
        $this->load->view('_default/footer');
    }
}

/* End of file news.php */
/* Location: ./application/controllers/news.php */