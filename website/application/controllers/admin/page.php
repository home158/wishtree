<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Admin_Base_Controller {
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
            'L10N_title' => 'menu_notepad_farm_village'
        ),
        'process' => array(
            'GUID' => '180C69E2-2DDF-4F77-96B2-0BBA35813AA5',
            'L10N_title' => 'menu_notepad_process'      
        ),
        'growing' => array(
            'GUID' => '3F66CAC5-59A8-4B7F-8FB4-847C7C6C12FC',
            'L10N_title' => 'menu_notepad_growing'      
        ),
        'vegetable' => array(
            'GUID' => '49CDEBEA-456F-4D7E-B9B6-A487521899AE',
            'L10N_title' => 'menu_notepad_vegetable'      
        ),
        'farmer' => array(
            'GUID' => '1D849C60-2DF7-4C36-A2AD-A3B51B44E56D',
            'L10N_title' => 'menu_notepad_farmer'      
        ),
        'seasonal' => array(
            'GUID' => '2B3FF140-1629-4A0C-A209-2FA39BCB6471',
            'L10N_title' => 'menu_seasonal_seasonal' ,
            'highlight_sub_lsit' => 1
        ),
        'promotion' =>  array(
            'GUID' => '33B702AE-FA7B-4726-8F18-E0F96903DA50',
            'L10N_title' => 'menu_news_promotion' ,
            'highlight_sub_lsit' => 1
        )
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
        $data = $this->get_page($this->dispatch[$page]['GUID']);
        $this->display_data['menu_admin_page_title'] = $this->display_data[$this->dispatch[$page]['L10N_title']];
        $this->display_data['redirect_to'] = uri_string();

        $display_data = array_merge($data , $this->display_data);
		$this->load->view('admin/header');
		$this->parser->parse('admin/navi',$display_data);
		$this->parser->parse('admin/page/index_default',$display_data);
		$this->load->view('admin/footer');
    }
    public function edit()
    {
        $update_data = array(
                        '[Content]'         => $this->input->post('Content'),
                        '[DateModify]'      => date('Y-m-d H:i:s')
                        );
         $this->db->update('[dbo].[i_pages]', $update_data, array('GUID' => $this->input->post('GUID',true)));
         //$this->db->query( "UPDATE [dbo].[i_pages] SET [Content] = N'".$this->input->post('Content')."' , [DateModify] = '".date('Y-m-d H:i:s')."' WHERE [GUID] = '".$this->input->post('GUID',true)."'");
         redirect(base_url().$this->input->post('redirect_to'), 'refresh');
    }
    public function parse_display_data()
    {
        //Language parse
        $this->lang->load('menu');
        $this->lang->load('button');

        $this->display_data = array(
            'button_close'              => $this->lang->line('button_close'),
            'button_cancel'             => $this->lang->line('button_cancel'),
            'button_submit'             => $this->lang->line('button_submit'),
            'button_edit'               => $this->lang->line('button_edit'),


            'menu_notepad_process'      => $this->lang->line('menu_notepad_process'),
            'menu_notepad_farm_village' => $this->lang->line('menu_notepad_farm_village'),
            'menu_notepad_growing'      => $this->lang->line('menu_notepad_growing'),
            'menu_notepad_vegetable'    => $this->lang->line('menu_notepad_vegetable'),
            'menu_notepad_farmer'       => $this->lang->line('menu_notepad_farmer'),
            'menu_seasonal_seasonal'    => $this->lang->line('menu_seasonal_seasonal'),
            'menu_news_promotion'       => $this->lang->line('menu_news_promotion')
        );
        $this->build_navi();
    }
}

/* End of file notepad.php */
/* Location: ./application/controllers/admin/notepad.php */
