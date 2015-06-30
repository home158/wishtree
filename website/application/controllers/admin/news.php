<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends Admin_Base_Controller {
    private $UI_columns = array(
        "[NewsID]",
        "[GUID]",
        "[Title]",
        "[ShortDesc]",
        "[CoverImageThumbURLPath]",
        "[IsShow]",
        "[Hits]",
        "CONVERT(VARCHAR(17) , SWITCHOFFSET (DateCreate, '+00:00') ,113)  AS [DateCreate]",
        "CONVERT(VARCHAR(17) , SWITCHOFFSET (DateModify, '+00:00'),113 )  AS [DateModify]"
    );
    private $UI_edit_columns = array(
        "[NewsID]",
        "[GUID]",
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
        $this->parse_display_data();
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

    }
    public function view($CATEGORY = "00000000-0000-0000-0000-000000000000")
	{
        $display_data = $this->display_data;
        $top = 0;
        $bottom =37;
        $this->load->model('news_model');
        //init data grid
        switch($CATEGORY){
            case "02941B48-61BC-4FCA-BD11-2209D4122973"://隱藏新聞
                $IsShow     = "0";
                $query = $this->news_model->select_data_limit_offset($top , $bottom , $this->UI_columns , $IsShow);
                break;
            case "324B11AC-E502-4FCE-9653-3B654F9803C1": //可視新聞
                $IsShow     = "1";

                $query = $this->news_model->select_data_limit_offset($top , $bottom , $this->UI_columns , $IsShow);
                break;
            default:
                $query = $this->news_model->select_data_limit_offset($top , $bottom , $this->UI_columns);
        }
        $data = array(
            'grid_data' => json_encode($query['object']->result()),
            'num_rows' => $query['num_rows'],
            'GUID_list' => json_encode( $query['GUID_list'] ),
            'Category' => $CATEGORY
        );
        $this->display_data['status_total_rows'] = sprintf($this->lang->line('orders_total_rows') , $query['num_rows']);
        $display_data = array_merge($data,$this->display_data);

		$this->load->view('admin/header');
		$this->parser->parse('admin/navi',$display_data);
		$this->parser->parse('admin/news/index_default',$display_data);
		$this->load->view('admin/footer');

    }
    public function retrieve_list()
    {
        $this->load->model('news_model');
        $top = $this->input->post('top',true);
        $bottom = $this->input->post('bottom',true);
        $sort_column_id = $this->input->post('SORT_COLUMN_ID',true);
        $order_method = $this->input->post('ORDER_METHOD',true); // true or false
        $IsShow     = $this->input->post('IsShow',true);
        $search_txt = $this->input->post('SEARCH_TXT',true);

        $query = $this->news_model->select_data_limit_offset($top , $bottom , $this->UI_columns , $IsShow
             , $sort_column_id  , $order_method  ,$search_txt);

        $data = array(
            'grid_data' => $query['object']->result(),
            'num_rows' => $query['num_rows'],
            'top' => $top,
            'bottom' => $bottom,
            'IsShow' => $IsShow,
            'sort_column_id' => $sort_column_id,
            'order_method' => $order_method,
            'GUID_list' => $query['GUID_list'],
            'search_txt' => $search_txt
        );
        
        header('Content-Type: application/json');
        echo json_encode($data); 
    }
    public function create()
    {
        $display_data = $this->display_data;
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
        $this->form_validation->set_rules('news_title',$display_data['gird_column_NewsTitle'],'trim|required');
        $this->form_validation->set_rules('news_short_desc',$display_data['gird_column_ShortDesc'],'trim|required');
        $this->form_validation->set_rules('news_content',$display_data['gird_column_NewsContent'],'trim|required');
        $this->form_validation->set_rules('news_cover_image', $display_data['news_cover_image'], 'trim|required|valid_url');
        $this->form_validation->set_rules('news_cover_image_thumb',$display_data['news_cover_image'],'trim');
        $this->form_validation->set_rules('news_cover_image_position',$display_data['news_cover_image'],'trim');


		if ($this->form_validation->run() == FALSE)
		{
            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/news/popup-create-news' , $display_data);
            $this->load->view('_default/popup-footer');
		}
		else
        {
            $data = array(  
                            '[Title]'           => $this->input->post('news_title',true),
                            '[Content]'        => $this->input->post('news_content'),
                            '[ShortDesc]'               => $this->input->post('news_short_desc',true),
                            '[CoverImageURLPath]'       => $this->input->post('news_cover_image',true),
                            '[CoverImageThumbURLPath]'  => $this->input->post('news_cover_image_thumb',true),
                            '[CoverImageBackgroundPosition]'  => $this->input->post('news_cover_image_position',true),

                            '[IsShow]'    => $this->input->post('news_is_show',true),
                            '[DateCreate]'      => date('Y-m-d H:i:s'),
                            '[DateModify]'      => date('Y-m-d H:i:s')
                );

            $str = $this->db->insert_string('[dbo].[i_news]', $data);
            $this->db->query( $str );
            
            $display_data['post_result_subject_title']  = $display_data['news_create'];
            $display_data['post_result_content_msg']    = $display_data['news_create_success_msg'];

            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/popup_post_result' , $display_data);
            $this->load->view('_default/popup-footer');
        }
    }
    public function edit($GUID)
    {
        $display_data = $this->display_data;
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
        $this->form_validation->set_rules('news_title',$display_data['gird_column_NewsTitle'],'trim|required');
        $this->form_validation->set_rules('news_short_desc',$display_data['gird_column_ShortDesc'],'trim|required');
        $this->form_validation->set_rules('news_content',$display_data['gird_column_NewsContent'],'trim|required');
        $this->form_validation->set_rules('news_cover_image', $display_data['news_cover_image'], 'trim|required|valid_url');
        $this->form_validation->set_rules('news_cover_image_thumb',$display_data['news_cover_image'],'trim');
        $this->form_validation->set_rules('news_cover_image_position',$display_data['news_cover_image'],'trim');

		if ($this->form_validation->run() == FALSE)
		{
            $this->load->model('easydb_model');
            $data = array(
                "GUID" => $GUID
            );
            $query = $this->easydb_model->select_data('[dbo].[i_news]' , $data , $this->UI_edit_columns);
           
            $display_data = array_merge( $display_data, (array) $query->row() );

            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/news/popup-edit-news' , $display_data);
            $this->load->view('_default/popup-footer');
		}
		else
        {
            $update_data = array(
                            '[Title]'                           => $this->input->post('news_title',true),
                            '[ShortDesc]'               => $this->input->post('news_short_desc',true),
                            '[Content]'                         => $this->input->post('news_content'),

                            '[CoverImageURLPath]'               => $this->input->post('news_cover_image',true),
                            '[CoverImageThumbURLPath]'          => $this->input->post('news_cover_image_thumb',true),
                            '[CoverImageBackgroundPosition]'    => $this->input->post('news_cover_image_position',true),

                            '[IsShow]'    => $this->input->post('news_is_show',true),
                            '[DateModify]'      => date('Y-m-d H:i:s')
                            );
            $this->db->update('[dbo].[i_news]', $update_data, array('GUID' => $GUID));
            
            $display_data['post_result_subject_title'] = $display_data['news_edit'];
            $display_data['post_result_content_msg'] = $display_data['news_edit_success_msg'];

            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/popup_post_result' , $display_data);
            $this->load->view('_default/popup-footer');
        }
    }
    public function delete()
    {
        $this->load->model('error_model');
        $this->load->model('easydb_model');
        $GUID = $this->input->post('GUID',true);
        $query = $this->easydb_model->delete_rows_where_in('[dbo].[i_news]' , $GUID);

        if($query == true){
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(0);
        }else{
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(2);
        }
    }
    public function mce($parent_input_name)
    {
        $this->load->library('tinymce');
        $data['tinymce_script_head'] = $this->tinymce->createhead();

        if($parent_input_name == 'content'){
            $data['popup_header_text'] = $this->display_data['gird_column_NewsContent'];
        }
        $data['parent_input_name'] = 'news_'.$parent_input_name;

        $display_data = array_merge($data,$this->display_data);

        $this->load->view('_default/popup-header');
		$this->parser->parse('admin/products/popup-mce' , $display_data);
        $this->load->view('_default/popup-footer');
    }
    public function clear_mce($parent_input_name){
        $this->load->library('tinymce');
        $data['tinymce_script_head'] = $this->tinymce->createhead();

        if($parent_input_name == 'short_desc'){
            $data['popup_header_text'] = $this->display_data['gird_column_ShortDesc'];
        }
        $data['parent_input_name'] = 'news_'.$parent_input_name;
        
        $display_data = array_merge($data,$this->display_data);

        $this->load->view('_default/popup-header');
		$this->parser->parse('admin/popup-clear-mce' , $display_data);
        $this->load->view('_default/popup-footer');
    }
    public function parse_display_data()
    {
        //Language parse
        $this->lang->load('menu');
        $this->lang->load('products');
        $this->lang->load('contextmenu');
        $this->lang->load('gird_column');
        $this->lang->load('button');
        $this->lang->load('news');

        $this->display_data = array(
            'button_ok'              => $this->lang->line('button_ok'),
            'button_close'              => $this->lang->line('button_close'),
            'button_cancel'             => $this->lang->line('button_cancel'),
            'button_submit'             => $this->lang->line('button_submit'),
            'button_search'             => $this->lang->line('button_search'),
            'gird_column_NewsID'     => $this->lang->line('gird_column_NewsID'),
            'gird_column_NewsTitle' => $this->lang->line('gird_column_NewsTitle'),
            'gird_column_NewsContent' => $this->lang->line('gird_column_NewsTitle'),
            'gird_column_IsShow' => $this->lang->line('gird_column_IsShow'),
            'gird_column_Hits' => $this->lang->line('gird_column_Hits'),
            'gird_column_DateCreate' => $this->lang->line('gird_column_DateCreate'),
            'gird_column_DateModify' => $this->lang->line('gird_column_DateModify'),
            'gird_column_NewsContent' => $this->lang->line('gird_column_NewsContent'),
            'gird_column_ShortDesc'     => $this->lang->line('gird_column_ShortDesc'),

            'menu_view_all'                           => $this->lang->line('menu_view_all'),
            'menu_admin_news'   => $this->lang->line('menu_admin_news'),
            'menu_admin_news_disappear'             => $this->lang->line('menu_admin_news_disappear'),
            'menu_admin_news_appear'             => $this->lang->line('menu_admin_news_appear'),
            'popup_mce_confirm_msg'         => $this->lang->line('news_mce_confirm_msg'),

            'news_search_btn'               => $this->lang->line('news_search_btn'),
            'news_search'                   => $this->lang->line('news_search'),
            'news_search_hint'              => $this->lang->line('news_search_hint'),
            'news_create'                   => $this->lang->line('news_create'),
            'news_edit'                     => $this->lang->line('news_edit'),
            'news_cover_image'              => $this->lang->line('news_cover_image'),
            'news_cover_image_note'         => $this->lang->line('news_cover_image_note'),
            'news_thumb'                    => $this->lang->line('news_thumb'),
            'news_image_select'             => $this->lang->line('news_image_select'),
            'news_anchor_here_to_edit'      => $this->lang->line('news_anchor_here_to_edit'),
            'news_disappear'                => $this->lang->line('news_disappear'),
            'news_appear'                   => $this->lang->line('news_appear'),
            'news_create_success_msg'       => $this->lang->line('news_create_success_msg'),
            'news_edit_success_msg'         => $this->lang->line('news_edit_success_msg'),
            'news_popup_delete_title'       => $this->lang->line('news_popup_delete_title'),
            'news_popup_delete_msg'         => $this->lang->line('news_popup_delete_msg'),
            'contextmenu_create'            => $this->lang->line('contextmenu_create'),
            'contextmenu_edit'              => $this->lang->line('contextmenu_edit'),
            'contextmenu_delete'	        => $this->lang->line('contextmenu_delete'),
            'contextmenu_reload'            => $this->lang->line('contextmenu_reload')
        );
        $this->build_navi();
    }
}

/* End of file news.php */
/* Location: ./application/controllers/admin/news.php */