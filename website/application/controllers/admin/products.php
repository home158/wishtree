<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products extends Admin_Base_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();
        $this->parse_product_category();
    }
    private $UI_columns = array(
            '[ProductID]',
            '[Title]',
            '[Category]',
            '[ShortDesc]',
            '[GUID]',
            "REPLACE(CONVERT(NVARCHAR(20), PriceMSRP, 1), '.00', '') AS [PriceMSRP]",
            "REPLACE(CONVERT(NVARCHAR(20), PriceSpecial, 1), '.00', '') AS [PriceSpecial]",
            '[Stock]',
            '[Soldout]',
            //'[Details]',
            '[Hits]',
            '[IsOnShelves]',
            //'[CoverImageURLPath]',
            '[CoverImageThumbURLPath]',
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (OnShelfTime, '+00:00') ,113)  AS [OnShelfTime]",
            //"CONVERT(VARCHAR(17) , SWITCHOFFSET (OffShelfTime, '+00:00') ,113)  AS [OffShelfTime]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (LastViewTime, '+00:00') ,113)  AS [LastViewTime]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (DateCreate, '+00:00') ,113)  AS [DateCreate]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (DateModify, '+00:00'),113 )  AS [DateModify]"
    );
    private $UI_edit_columns = array(
            '[ProductID]',
            '[Title]',
            '[Category]',
            '[ShortDesc]',
            '[GUID]',
            "CONVERT( INT, PriceMSRP ) AS [PriceMSRP]",
            "CONVERT( INT, PriceSpecial ) AS [PriceSpecial]",
            '[Stock]',
            '[Soldout]',
            '[Details]',
            '[Recipe]',
            '[OrderNote]',
            '[Hits]',
            '[IsOnShelves]',

            '[CoverImageURLPath]',
            '[CoverImageThumbURLPath]',
            '[CoverImageBackgroundPosition]',

            '[SubImage0URLPath]',
            '[SubImage0ThumbURLPath]',
            '[SubImage0BackgroundPosition]' ,
            
            '[SubImage1URLPath]',
            '[SubImage1ThumbURLPath]',
            '[SubImage1BackgroundPosition]',
            
            '[SubImage2URLPath]',
            '[SubImage2ThumbURLPath]',
            '[SubImage2BackgroundPosition]',

            //"CONVERT(VARCHAR(10) , SWITCHOFFSET (OffShelfTime, '+00:00'),20 )  AS [OffShelfTimeDate]",
            //"RIGHT( CONVERT(VARCHAR(13) , SWITCHOFFSET (OffShelfTime, '+00:00'),20 ) ,2)  AS [OffShelfTimeHour]",
            //"RIGHT( CONVERT(VARCHAR(16) , SWITCHOFFSET (OffShelfTime, '+00:00'),20 ) ,2)  AS [OffShelfTimeMinute]",

            '[SpeciesDisplay]',
            '[SpeciesCategoryR1]',
            '[SpeciesCategoryR2]',
            '[SpeciesTitle]',
            '[SpeciesIcon]',
            '[SpeciesContent]',
            '[SpeciesImageURLPath]',
            '[SpeciesImageThumbURLPath]',
            '[SpeciesImageBackgroundPosition]'

    );
    protected  $UI_products_category_columns = array(
			'[CategoryID]' ,
			'[GUID]' ,
			'[CategoryName]' ,
			'[Priority]' ,
			'[IsShow]' ,
			'[ShippingLimit]' ,
			'convert(int, round([ShippingFare], 0)) AS [ShippingFare]' ,
			'[ShippingType]' ,
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (DateCreate, '+00:00') ,113)  AS [DateCreate]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (DateModify, '+00:00'),113 )  AS [DateModify]"
    );

    private $product_category = array();
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
        $this->load->model('products_model');
        $top = 0;
        $bottom =37;

        //init data grid
        switch($CATEGORY){
            
            case "593E7A26-6822-4DD7-ACDE-D6FAF5259417":
            case "923B5DD9-F43B-49B6-A9E9-49823BC36B0A":
            case "09C449E9-8D6D-40BF-95D3-12A488A3FE82":
            case "CBD89E5F-BD89-4B14-A465-2C69ED9BE2F8":
            case "39258F85-E582-4C79-84CE-406FD1ECB49C":
            case "7823C577-4A0C-452F-9ACF-7CFC7A555CB2":
            case "ECBA4E56-7E73-431E-9851-8507327027F4":
            case "ACC8B2B5-612F-445C-A342-BDE3B22E95E0":
            case "CB3FB523-7CE9-401E-9EC9-1C51BB2E570A":
            case "D73162C2-ADA4-432F-923B-415FE39A7888":
                $query = $this->products_model->select_data_limit_offset('[dbo].[i_products]', 'ProductID' , $top , $bottom , $this->UI_columns, $CATEGORY);
                 break;
            default:
                $query = $this->products_model->select_data_limit_offset('[dbo].[i_products]', 'ProductID' , $top , $bottom , $this->UI_columns);

                break;
        }
       
        $data = array(
            'grid_data' => json_encode($query['object']->result()),
            'num_rows' => $query['num_rows'],
            'Category' => $CATEGORY
        );
        $this->display_data['products_total_rows'] = sprintf($this->lang->line('products_total_rows') , $query['num_rows']);
        $display_data = array_merge($data,$this->display_data);

		$this->load->view('admin/header');
		$this->parser->parse('admin/navi',$display_data);
		$this->parser->parse('admin/products/index_default',$display_data);
		$this->load->view('admin/footer');
    }
    public function retrieve_list()
    {
        $this->load->model('products_model');
        $top = $this->input->post('top',true);
        $bottom = $this->input->post('bottom',true);
        $sort_column_id = $this->input->post('SORT_COLUMN_ID',true);
        $order_method = $this->input->post('ORDER_METHOD',true); // true or false
        $Category = $this->input->post('CATEGORY',true);
        if($Category == "00000000-0000-0000-0000-000000000000"){
            $Category = FALSE;
        }
        $search_txt = $this->input->post('SEARCH_TXT',true);
        $IsOnShelves = $this->input->post('IsOnShelves',true);
        $query = $this->products_model->select_data_limit_offset('[dbo].[i_products]', 'ProductID' , $top , $bottom , $this->UI_columns,
                                $Category , $IsOnShelves , $sort_column_id  , $order_method  , $search_txt);

        $data = array(
            'grid_data' => $query['object']->result(),
            'num_rows' => $query['num_rows'],
            'top' => $top,
            'bottom' => $bottom,
            'Category' => $Category,
            'sort_column_id' => $sort_column_id,
            'order_method' => $order_method,
            'IsOnShelves' => $IsOnShelves,
            'search_txt' => $search_txt
        );
        
        header('Content-Type: application/json');
        echo json_encode($data);            
    }
    public function create()
    {
        $this->load->model('products_model');
        $display_data = $this->display_data;
        $display_data['product_category_options'] = $this->products_model->creact_category_options( $this->product_category );

		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
        
        $this->form_validation->set_rules('products_category',$display_data['products_category'],'trim');
        $this->form_validation->set_rules('product_title',$display_data['gird_column_ProductTitle'],'trim|required');
        $this->form_validation->set_rules('product_short_desc',$display_data['gird_column_ShortDesc'],'trim|required');
        $this->form_validation->set_rules('product_details',$display_data['gird_column_Details'],'trim|required');
        $this->form_validation->set_rules('product_recipe',$display_data['gird_column_Recipe'],'trim|required');
        $this->form_validation->set_rules('product_order_note',$display_data['gird_column_OrderNote'],'trim|required');

        $this->form_validation->set_rules('product_price_MSRP',$display_data['gird_column_PriceMSRP'],'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('product_price_special',$display_data['gird_column_PriceSpecial'],'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('product_stock',$display_data['gird_column_Stock'],'trim|required|is_natural');
        $this->form_validation->set_rules('product_soldout',$display_data['gird_column_Soldout'],'trim|required|is_natural');
        //$this->form_validation->set_rules('product_off_shelf_time_date',$display_data['gird_column_OffShelfTime'],'trim|required');
        $this->form_validation->set_rules('product_cover_image', $display_data['product_cover_image'], 'trim|required|valid_url');
        $this->form_validation->set_rules('product_cover_image_thumb',$display_data['product_cover_image'],'trim');
        $this->form_validation->set_rules('product_cover_image_position',$display_data['product_cover_image'],'trim');

        $this->form_validation->set_rules('product_sub_image_0',$display_data['product_sub_image'],'trim|required');
        $this->form_validation->set_rules('product_sub_image_0_thumb',$display_data['product_sub_image'],'trim');
        $this->form_validation->set_rules('product_sub_image_0_position',$display_data['product_sub_image'],'trim');

        $this->form_validation->set_rules('product_sub_image_1',$display_data['product_sub_image'],'trim|required');
        $this->form_validation->set_rules('product_sub_image_1_thumb',$display_data['product_sub_image'],'trim');
        $this->form_validation->set_rules('product_sub_image_1_position',$display_data['product_sub_image'],'trim');

        $this->form_validation->set_rules('product_sub_image_2',$display_data['product_sub_image'],'trim|required');
        $this->form_validation->set_rules('product_sub_image_2_thumb',$display_data['product_sub_image'],'trim');
        $this->form_validation->set_rules('product_sub_image_2_position',$display_data['product_sub_image'],'trim');
        $this->form_validation->set_rules('species_display',$display_data['product_species_display'],'trim');

        if($this->input->post('species_display',true) == 1)
        {
            $this->form_validation->set_message('is_natural', $display_data['product_species_no_category_set_message']);

            $this->form_validation->set_rules('product_species_category_r1',$display_data['product_species_category'],'trim|is_natural');
            $this->form_validation->set_rules('product_species_category_r2',$display_data['product_species_category'],'trim');
            $this->form_validation->set_rules('product_species_icon',$display_data['product_species_icon'],'trim');
            
            $this->form_validation->set_rules('product_species_title',$display_data['product_species_title'],'trim|required');
            $this->form_validation->set_rules('product_species_content',$display_data['product_species_content'],'trim|required');
            $this->form_validation->set_rules('product_species_image',$display_data['product_species_image'],'trim|required');
            $this->form_validation->set_rules('product_species_image_thumb',$display_data['product_species_image'],'trim');
            $this->form_validation->set_rules('product_species_image_position',$display_data['product_species_image'],'trim');
        }
        
		if ($this->form_validation->run() == FALSE)
		{
            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/products/popup-create-product' , $display_data);
            $this->load->view('_default/popup-footer');
		}
		else
        {
		/*
            $OffShelfTime = $this->input->post('product_off_shelf_time_date',true) . ' ' . 
                            $this->input->post('product_off_shelf_time_hour',true) . ':'.
                            $this->input->post('product_off_shelf_time_minute',true) . ':59';
        */
            $data = array(  '[Title]'           => $this->input->post('product_title',true),
                            '[Category]'        => $this->input->post('products_category',true),
                            '[ShortDesc]'       => $this->input->post('product_short_desc',true),
                            '[PriceMSRP]'       => $this->input->post('product_price_MSRP',true),
                            '[PriceSpecial]'    => $this->input->post('product_price_special',true),
                            '[Stock]'           => $this->input->post('product_stock',true),
                            '[Soldout]'         => $this->input->post('product_soldout',true),

                            '[Details]'         => $this->input->post('product_details'),
                            '[Recipe]'          => $this->input->post('product_recipe'),
                            '[OrderNote]'       => $this->input->post('product_order_note'),

                            '[IsOnShelves]'     => $this->input->post('product_is_on_shelves',true),

                            '[CoverImageURLPath]'       => $this->input->post('product_cover_image',true),
                            '[CoverImageThumbURLPath]'  => $this->input->post('product_cover_image_thumb',true),
                            '[CoverImageBackgroundPosition]'  => $this->input->post('product_cover_image_position',true),

                            '[SubImage0URLPath]'       => $this->input->post('product_sub_image_0',true),
                            '[SubImage0ThumbURLPath]'  => $this->input->post('product_sub_image_0_thumb',true),
                            '[SubImage0BackgroundPosition]'  => $this->input->post('product_sub_image_0_position',true),

                            '[SubImage1URLPath]'       => $this->input->post('product_sub_image_1',true),
                            '[SubImage1ThumbURLPath]'  => $this->input->post('product_sub_image_1_thumb',true),
                            '[SubImage1BackgroundPosition]'  => $this->input->post('product_sub_image_1_position',true),

                            '[SubImage2URLPath]'       => $this->input->post('product_sub_image_2',true),
                            '[SubImage2ThumbURLPath]'  => $this->input->post('product_sub_image_2_thumb',true),
                            '[SubImage2BackgroundPosition]'  => $this->input->post('product_sub_image_2_position',true),

                            //'[OffShelfTime]'    => $OffShelfTime,
                            '[OnShelfTime]'     => date('Y-m-d H:i:s'),
                            '[DateCreate]'      => date('Y-m-d H:i:s'),
                            '[DateModify]'      => date('Y-m-d H:i:s'),
                            '[LastViewTime]'    => date('Y-m-d H:i:s'),

                            '[SpeciesDisplay]'    =>  $this->input->post('species_display',true),
                            '[SpeciesCategoryR1]'    =>  $this->input->post('product_species_category_r1',true),
                            '[SpeciesCategoryR2]'    =>  $this->input->post('product_species_category_r2',true),
                            '[SpeciesTitle]'    =>  $this->input->post('product_species_title',true),
                            '[SpeciesContent]'    =>  $this->input->post('product_species_content'),
                            '[SpeciesIcon]'         => $this->input->post('product_species_icon',true),
                            '[SpeciesImageURLPath]'    =>  $this->input->post('product_species_image',true),
                            '[SpeciesImageThumbURLPath]'    =>  $this->input->post('product_species_image_thumb',true),
                            '[SpeciesImageBackgroundPosition]'    =>  $this->input->post('product_species_image_position',true)
                );

            $str = $this->db->insert_string('[dbo].[i_products]', $data);
            $this->db->query( $str );
            
            $display_data['post_result_subject_title'] = $display_data['products_create'];
            $display_data['post_result_content_msg'] = $display_data['products_create_success_msg'];

            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/popup_post_result' , $display_data);
            $this->load->view('_default/popup-footer');
        }
    }
    public function edit($GUID)
    {
        $this->load->model('products_model');
        $display_data = $this->display_data;
        $display_data['product_category_options'] = $this->products_model->creact_category_options( $this->product_category );
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');

        $this->form_validation->set_rules('products_category',$display_data['products_category'],'trim');
        $this->form_validation->set_rules('product_title',$display_data['gird_column_ProductTitle'],'trim|required');
        $this->form_validation->set_rules('product_short_desc',$display_data['gird_column_ShortDesc'],'trim|required');
        $this->form_validation->set_rules('product_details',$display_data['gird_column_Details'],'trim|required');
        $this->form_validation->set_rules('product_recipe',$display_data['gird_column_Recipe'],'trim|required');
        $this->form_validation->set_rules('product_order_note',$display_data['gird_column_OrderNote'],'trim|required');
        $this->form_validation->set_rules('product_price_MSRP',$display_data['gird_column_PriceMSRP'],'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('product_price_special',$display_data['gird_column_PriceSpecial'],'trim|required|is_natural_no_zero');
        $this->form_validation->set_rules('product_stock',$display_data['gird_column_Stock'],'trim|required|is_natural');
        $this->form_validation->set_rules('product_soldout',$display_data['gird_column_Soldout'],'trim|required|is_natural');
        //$this->form_validation->set_rules('product_off_shelf_time_date',$display_data['gird_column_OffShelfTime'],'trim|required');
        
        $this->form_validation->set_rules('product_is_on_shelves',$display_data['gird_column_IsOnShelves'],'trim');

        $this->form_validation->set_rules('product_cover_image', $display_data['product_cover_image'], 'trim|required|valid_url');
        $this->form_validation->set_rules('product_cover_image_thumb',$display_data['product_cover_image'],'trim');
        $this->form_validation->set_rules('product_cover_image_position',$display_data['product_cover_image'],'trim');

        $this->form_validation->set_rules('product_sub_image_0',$display_data['product_sub_image'],'trim');
        $this->form_validation->set_rules('product_sub_image_0_thumb',$display_data['product_sub_image'],'trim');
        $this->form_validation->set_rules('product_sub_image_0_position',$display_data['product_sub_image'],'trim');

        $this->form_validation->set_rules('product_sub_image_1',$display_data['product_sub_image'],'trim');
        $this->form_validation->set_rules('product_sub_image_1_thumb',$display_data['product_sub_image'],'trim');
        $this->form_validation->set_rules('product_sub_image_1_position',$display_data['product_sub_image'],'trim');

        $this->form_validation->set_rules('product_sub_image_2',$display_data['product_sub_image'],'trim');
        $this->form_validation->set_rules('product_sub_image_2_thumb',$display_data['product_sub_image'],'trim');
        $this->form_validation->set_rules('product_sub_image_2_position',$display_data['product_cover_image'],'trim');
        $this->form_validation->set_rules('species_display',$display_data['product_species_display'],'trim');

        if($this->input->post('species_display',true) == 1)
        {
            $this->form_validation->set_message('is_natural', $display_data['product_species_no_category_set_message']);

            $this->form_validation->set_rules('product_species_category_r1',$display_data['product_species_category'],'trim|is_natural');
            $this->form_validation->set_rules('product_species_category_r2',$display_data['product_species_category'],'trim');
            $this->form_validation->set_rules('product_species_icon',$display_data['product_species_icon'],'trim');
            
            $this->form_validation->set_rules('product_species_title',$display_data['product_species_title'],'trim|required');
            $this->form_validation->set_rules('product_species_content',$display_data['product_species_content'],'trim|required');
            $this->form_validation->set_rules('product_species_image',$display_data['product_species_image'],'trim|required');
            $this->form_validation->set_rules('product_species_image_thumb',$display_data['product_species_image'],'trim');
            $this->form_validation->set_rules('product_species_image_position',$display_data['product_species_image'],'trim');
        }

		if ($this->form_validation->run() == FALSE)
		{
            $this->load->model('easydb_model');
            $data = array(
                "GUID" => $GUID
            );
            $query = $this->easydb_model->select_data('[dbo].[i_products]' , $data , $this->UI_edit_columns);
           
            $display_data = array_merge( $display_data, (array) $query->row() );

            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/products/popup-edit-product' , $display_data);
            $this->load->view('_default/popup-footer');
		}
		else
        {
            /*
            $OffShelfTime = $this->input->post('product_off_shelf_time_date',true) . ' ' . 
                            $this->input->post('product_off_shelf_time_hour',true) . ':'.
                            $this->input->post('product_off_shelf_time_minute',true) . ':59';
            */
            $product_is_on_shelves_old = $this->input->post('product_is_on_shelves_old',true);
            $update_data = array(
                            '[Title]'           => $this->input->post('product_title',true),
                            '[Category]'        => $this->input->post('products_category',true),
                            '[ShortDesc]'       => $this->input->post('product_short_desc'),
                            '[PriceMSRP]'       => $this->input->post('product_price_MSRP',true),
                            '[PriceSpecial]'    => $this->input->post('product_price_special',true),
                            '[Stock]'           => $this->input->post('product_stock',true),
                            '[Soldout]'         => $this->input->post('product_soldout',true),

                            '[Details]'         => $this->input->post('product_details'),
                            '[Recipe]'          => $this->input->post('product_recipe'),
                            '[OrderNote]'       => $this->input->post('product_order_note'),

                            '[IsOnShelves]'     => $this->input->post('product_is_on_shelves',true),
                            '[CoverImageURLPath]'       => $this->input->post('product_cover_image',true),
                            '[CoverImageThumbURLPath]'  => $this->input->post('product_cover_image_thumb',true),
                            '[CoverImageBackgroundPosition]'  => $this->input->post('product_cover_image_position',true),

                            '[SubImage0URLPath]'       => $this->input->post('product_sub_image_0',true),
                            '[SubImage0ThumbURLPath]'  => $this->input->post('product_sub_image_0_thumb',true),
                            '[SubImage0BackgroundPosition]'  => $this->input->post('product_sub_image_0_position',true),

                            '[SubImage1URLPath]'       => $this->input->post('product_sub_image_1',true),
                            '[SubImage1ThumbURLPath]'  => $this->input->post('product_sub_image_1_thumb',true),
                            '[SubImage1BackgroundPosition]'  => $this->input->post('product_sub_image_1_position',true),

                            '[SubImage2URLPath]'       => $this->input->post('product_sub_image_2',true),
                            '[SubImage2ThumbURLPath]'  => $this->input->post('product_sub_image_2_thumb',true),
                            '[SubImage2BackgroundPosition]'  => $this->input->post('product_sub_image_2_position',true),
                            //'[OffShelfTime]'    => $OffShelfTime,
                            '[DateModify]'      => date('Y-m-d H:i:s'),

                            '[SpeciesDisplay]'    =>  $this->input->post('species_display',true),
                            '[SpeciesCategoryR1]'    =>  $this->input->post('product_species_category_r1',true),
                            '[SpeciesCategoryR2]'    =>  $this->input->post('product_species_category_r2',true),
                            '[SpeciesTitle]'    =>  $this->input->post('product_species_title',true),
                            '[SpeciesContent]'    =>  $this->input->post('product_species_content'),
                            '[SpeciesIcon]'         => $this->input->post('product_species_icon',true),
                            '[SpeciesImageURLPath]'    =>  $this->input->post('product_species_image',true),
                            '[SpeciesImageThumbURLPath]'    =>  $this->input->post('product_species_image_thumb',true),
                            '[SpeciesImageBackgroundPosition]'    =>  $this->input->post('product_species_image_position',true)
                            );
            //下架中改成上架狀態，更新上架時間
            if($update_data['[IsOnShelves]'] == 1 and $product_is_on_shelves_old != $update_data['[IsOnShelves]'])
            {
                $update_data['[OnShelfTime]'] = date('Y-m-d H:i:s');
            }
            $this->db->update('[dbo].[i_products]', $update_data, array('GUID' => $GUID));
            
            $display_data['post_result_subject_title'] = $display_data['products_edit'];
            $display_data['post_result_content_msg'] = $display_data['products_edit_success_msg'];

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
        $query = $this->easydb_model->delete_rows_where_in('[dbo].[i_products]' , $GUID);

        if($query == true){
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(0);
        }else{
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(2);
        }
    }
    public function transition_arrival()
    {
        $this->load->view('_default/popup-header');
		$this->load->view('admin/products/popup_transition_arrival');
        $this->load->view('_default/popup-footer');
    }

    public function mce($parent_input_name)
    {
        $this->load->library('tinymce');
        $data['tinymce_script_head'] = $this->tinymce->createhead();

        if($parent_input_name == 'short_desc'){
            $data['popup_header_text'] = $this->display_data['gird_column_ShortDesc'];
        }
        if($parent_input_name == 'details'){
            $data['popup_header_text'] = $this->display_data['gird_column_Details'];
        }
        if($parent_input_name == 'recipe'){
            $data['popup_header_text'] = $this->display_data['gird_column_Recipe'];
        }
        if($parent_input_name == 'order_note'){
            $data['popup_header_text'] = $this->display_data['gird_column_OrderNote'];
        }
        if($parent_input_name == 'species_content'){
            $data['popup_header_text'] = $this->display_data['product_species'] .' / '.$this->display_data['product_species_content'];
        }

        $data['parent_input_name'] = 'product_'.$parent_input_name;

        $display_data = array_merge($data,$this->display_data);

        $this->load->view('_default/popup-header');
		$this->parser->parse('admin/products/popup-mce' , $display_data);
        $this->load->view('_default/popup-footer');
    }
    public function parse_product_category()
    {
        $this->load->model('products_model');
        $r = $this->products_model->retrieve_category($this->UI_products_category_columns);
        $grid_data = $r->result();
        $this->product_category = array();
        //$navi_list = array();
        foreach($grid_data as $key ){
            //var_dump($key);
            $this->product_category[ $key->GUID ] = $key->CategoryName;
            $this->display_data[ $key->GUID ] = $key->CategoryName;
            //array_push ($navi_list , array(
            //    'GUID' => $key->GUID,
            //    'CategoryName' => $key->CategoryName
            //));
        }
        //$this->display_data['navi_list'] = $navi_list;
        /*
        $this->product_category = array(
            '593E7A26-6822-4DD7-ACDE-D6FAF5259417' => $this->display_data['menu_product_seasonal_fruits_and_vegetables'],
            '923B5DD9-F43B-49B6-A9E9-49823BC36B0A' => $this->display_data['menu_product_fruits'],
            '09C449E9-8D6D-40BF-95D3-12A488A3FE82' => $this->display_data['menu_product_vegetables'],
            'CBD89E5F-BD89-4B14-A465-2C69ED9BE2F8' => $this->display_data['menu_product_fruits_and_vegetables_weekly'],
            '39258F85-E582-4C79-84CE-406FD1ECB49C' => $this->display_data['menu_product_snacks'],
            '7823C577-4A0C-452F-9ACF-7CFC7A555CB2' => $this->display_data['menu_product_seasonal_gift'],
            'ECBA4E56-7E73-431E-9851-8507327027F4' => $this->display_data['menu_product_combined_commodity']
        );
        */
    }
    public function category()
    {
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
        $this->load->model('products_model');
        $this->form_validation->set_rules('placehost','placehost','trim');
		if ($this->form_validation->run() == FALSE)
		{
            $this->load->model('easydb_model');
            $r = $this->products_model->retrieve_category($this->UI_products_category_columns);
            $data = array(
                'grid_data' => $r->result(),
                'grid_data2' => $r->result()
            );
            $display_data = array_merge($data,$this->display_data);
		    $this->load->view('admin/header');
		    $this->parser->parse('admin/navi',$display_data);
		    $this->parser->parse('admin/products/category',$display_data);
		    $this->load->view('admin/footer');
        }else{
            $GUID = $this->input->post('GUID',TRUE);
            $CategoryName = $this->input->post('CategoryName',TRUE);
            $IsShow = $this->input->post('IsShow',TRUE);
            $Priority = $this->input->post('Priority',TRUE);
            $ShippingLimit = $this->input->post('ShippingLimit',TRUE);
            $ShippingFare = $this->input->post('ShippingFare',TRUE);
            $ShippingType = $this->input->post('ShippingType',TRUE);
            foreach( $GUID as $key => $n ) {
                $update_data = array(
                    '[CategoryName]' => $CategoryName[$key],
                    '[IsShow]' => $IsShow[$key],
                    '[Priority]' => $Priority[$key],
                    '[ShippingLimit]' => $ShippingLimit[$key],
                    '[ShippingFare]' => $ShippingFare[$key],
                    '[ShippingType]' => $ShippingType[$key],
                    '[DateModify]'      => date('Y-m-d H:i:s')
                );
                $this->db->update('[dbo].[i_products_category]', $update_data, array('GUID' => $n));

            }
            $display_data = array_merge($this->display_data);
		    $this->load->view('admin/header');
		    $this->parser->parse('admin/navi',$display_data);
		    $this->parser->parse('admin/products/category_result',$display_data);
		    $this->load->view('admin/footer');
            
        }
    }
    public function parse_display_data()
    {
        //Language parse
        $this->lang->load('menu');
        $this->lang->load('products');
        $this->lang->load('contextmenu');
        $this->lang->load('gird_column');
        $this->lang->load('button');

        $this->display_data = array(
            'button_close'              => $this->lang->line('button_close'),
            'button_cancel'             => $this->lang->line('button_cancel'),
            'button_submit'             => $this->lang->line('button_submit'),

            'gird_column_ProductID'     => $this->lang->line('gird_column_ProductID'),
            'gird_column_ProductTitle'  => $this->lang->line('gird_column_ProductTitle'),
            'gird_column_ShortDesc'     => $this->lang->line('gird_column_ShortDesc'),
            'gird_column_Details'       => $this->lang->line('gird_column_Details'),
            'gird_column_Recipe'        => $this->lang->line('gird_column_Recipe'),
            'gird_column_OrderNote'     => $this->lang->line('gird_column_OrderNote'),

            'gird_column_PriceMSRP'     => $this->lang->line('gird_column_PriceMSRP'),
            'gird_column_PriceSpecial'  => $this->lang->line('gird_column_PriceSpecial'),
            'gird_column_Stock'         => $this->lang->line('gird_column_Stock'),
            'gird_column_Soldout'       => $this->lang->line('gird_column_Soldout'),
            'gird_column_Hits'          => $this->lang->line('gird_column_Hits'),
            'gird_column_IsOnShelves'   => $this->lang->line('gird_column_IsOnShelves'),
            'gird_column_OnShelfTime'   => $this->lang->line('gird_column_OnShelfTime'),
            'gird_column_OffShelfTime'  => $this->lang->line('gird_column_OffShelfTime'),
            'gird_column_LastViewTime'  => $this->lang->line('gird_column_LastViewTime'),
            'gird_column_DateModify'    => $this->lang->line('gird_column_DateModify'),
            'gird_column_DateCreate'    => $this->lang->line('gird_column_DateCreate'),

            'menu_admin_procucts'                           => $this->lang->line('menu_admin_procucts'),
            'menu_product_seasonal_fruits_and_vegetables'   => $this->lang->line('menu_product_seasonal_fruits_and_vegetables'),
            'menu_product_fruits'                           => $this->lang->line('menu_product_fruits'),
            'menu_product_vegetables'                       => $this->lang->line('menu_product_vegetables'),
            'menu_product_fruits_and_vegetables_weekly'     => $this->lang->line('menu_product_fruits_and_vegetables_weekly'),
            'menu_product_snacks'                           => $this->lang->line('menu_product_snacks'),
            'menu_product_seasonal_gift'                    => $this->lang->line('menu_product_seasonal_gift'),
            'menu_product_combined_commodity'               => $this->lang->line('menu_product_combined_commodity'),
            
            'product_on_shelves'            => $this->lang->line('product_on_shelves'),
            'product_off_shelves'           => $this->lang->line('product_off_shelves'),
            'products_view_all'             => $this->lang->line('products_view_all'),
            'products_search_btn'           => $this->lang->line('products_search_btn'),
            'products_search_account'       => $this->lang->line('products_search_account'),
            'products_search_hint'          => $this->lang->line('products_search_hint'),
            'products_total_rows'           => $this->lang->line('products_total_rows'),
            'products_tree_search_result'   => $this->lang->line('products_tree_search_result'),
            'products_search_alert_msg'     => $this->lang->line('products_search_alert_msg'),
            'products_popup_delete_title'   => $this->lang->line('products_popup_delete_title'),
            'products_popup_delete_msg'     => $this->lang->line('products_popup_delete_msg'),
            'products_create'               => $this->lang->line('products_create'),
            'products_create_success_msg'   => $this->lang->line('products_create_success_msg'),
            'popup_mce_confirm_msg'         => $this->lang->line('product_mce_confirm_msg'),
            'products_category'             => $this->lang->line('products_category'),
            'products_create'               => $this->lang->line('products_create'),
            'products_create_msg'           => $this->lang->line('products_create_msg'),
            'products_edit'                 => $this->lang->line('products_edit'),
            'products_edit_success_msg'     => $this->lang->line('products_edit_success_msg'),
            'product_anchor_here_to_edit'   => $this->lang->line('product_anchor_here_to_edit'),
            'product_cover_image'           => $this->lang->line('product_cover_image'),
            'product_cover_image_note'      => $this->lang->line('product_cover_image_note'),
            'product_image_upload'          => $this->lang->line('product_image_upload'),
            'product_image_select'          => $this->lang->line('product_image_select'),
            'product_thumb'                 => $this->lang->line('product_thumb'),
            'product_click_me_preview'      => $this->lang->line('product_click_me_preview'),
            'product_sub_image'             => $this->lang->line('product_sub_image'),
            'product_sub_image_0_note'       => $this->lang->line('product_sub_image_0_note'),
            'product_sub_image_1_note'       => $this->lang->line('product_sub_image_1_note'),
            'product_sub_image_2_note'       => $this->lang->line('product_sub_image_2_note'),
            'product_species'                => $this->lang->line('product_species'),
            'product_species_display'        => $this->lang->line('product_species_display'),
            'product_species_title'         => $this->lang->line('product_species_title'),
            'product_species_image'         => $this->lang->line('product_species_image'),
            'product_species_icon'          => $this->lang->line('product_species_icon'),
            'product_species_content'       => $this->lang->line('product_species_content'),
            'product_species_image_note'    => $this->lang->line('product_species_image_note'),
            'product_species_category'      => $this->lang->line('product_species_category'),
            'product_search_alert_msg'      => $this->lang->line('product_search_alert_msg'),
            
            'product_species_category_0'      => $this->lang->line('product_species_category_0'),
            'product_species_category_1'      => $this->lang->line('product_species_category_1'),
            'product_species_category_2'      => $this->lang->line('product_species_category_2'),
            'product_species_category_3'      => $this->lang->line('product_species_category_3'),
            'product_species_category_4'      => $this->lang->line('product_species_category_4'),
            'product_species_category_5'      => $this->lang->line('product_species_category_5'),
            'product_species_category_6'      => $this->lang->line('product_species_category_6'),
            'product_species_category_7'      => $this->lang->line('product_species_category_7'),
            'product_species_category_8'      => $this->lang->line('product_species_category_8'),
            'product_species_no_category_set_message' => $this->lang->line('product_species_no_category_set_message'),
            'menu_admin_procucts_category'  => $this->lang->line('menu_admin_procucts_category'),
            'contextmenu_details'           => $this->lang->line('contextmenu_details'),
            'contextmenu_create'            => $this->lang->line('contextmenu_create'),
            'contextmenu_edit'              => $this->lang->line('contextmenu_edit'),
            'contextmenu_delete'	        => $this->lang->line('contextmenu_delete'),
            'contextmenu_reload'            => $this->lang->line('contextmenu_reload'),
            'contextmenu_arrvival'          => $this->lang->line('contextmenu_arrvival')
        );
        $this->build_navi();
    }
}

/* End of file products.php */
/* Location: ./application/controllers/admin/products.php */