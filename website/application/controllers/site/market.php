<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Market extends Site_Base_Controller {
    private $display_data = array(
        "highlight_main_list" => "market",
        "highlight_sub_lsit" => 0,
        "session_control" => "session_not_exist"
    );
    protected  $UI_products_category_columns = array(
			'[CategoryID]' ,
			'[GUID]' ,
			'[CategoryName]' ,
			'[Priority]' ,
			'[IsShow]' ,
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (DateCreate, '+00:00') ,113)  AS [DateCreate]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (DateModify, '+00:00'),113 )  AS [DateModify]"
    );
    private $UI_columns_add = array(
            '[ProductID]',
            '[Title]',
            '[Category]',
            '[ShortDesc]',
            '[GUID] AS [ProductGUID]',
            "REPLACE(CONVERT(NVARCHAR(20), PriceMSRP, 1), '.00', '') AS [PriceMSRP]",
            "REPLACE(CONVERT(NVARCHAR(20), PriceSpecial, 1), '.00', '') AS [PriceSpecial]",
            '[Stock]',
            '[Soldout]',
            //'[Details]',
            '[Hits]',
            '[IsOnShelves]',
            '[CoverImageURLPath]',
            '[CoverImageBackgroundPosition]',
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (OnShelfTime, '+00:00') ,113)  AS [OnShelfTime]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (OffShelfTime, '+00:00') ,113)  AS [OffShelfTime]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (LastViewTime, '+00:00') ,113)  AS [LastViewTime]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (DateCreate, '+00:00') ,113)  AS [DateCreate]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (DateModify, '+00:00'),113 )  AS [DateModify]"
    );
    private $UI_columns = array(
            '[ProductID]',
            '[Title]',
            '[Category]',
            '[ShortDesc]',
            'P.[GUID] AS [ProductGUID]',
            'C.[CategoryName] AS [CategoryName]',
            'C.[ShippingLimit] AS [ShippingLimit]',
            'C.[ShippingFare] AS [ShippingFare]',
            'C.[ShippingType] AS [ShippingType]',
            "REPLACE(CONVERT(NVARCHAR(20), PriceMSRP, 1), '.00', '') AS [PriceMSRP]",
            "REPLACE(CONVERT(NVARCHAR(20), PriceSpecial, 1), '.00', '') AS [PriceSpecial]",
            '[Stock]',
            '[Soldout]',
            //'[Details]',
            '[Hits]',
            '[IsOnShelves]',
            '[CoverImageURLPath]',
            '[CoverImageBackgroundPosition]',
            "CONVERT(VARCHAR(17) , SWITCHOFFSET ([OnShelfTime], '+00:00') ,113)  AS [OnShelfTime]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET ([OffShelfTime], '+00:00') ,113)  AS [OffShelfTime]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET ([LastViewTime], '+00:00') ,113)  AS [LastViewTime]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (P.[DateCreate], '+00:00') ,113)  AS [DateCreate]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (P.[DateModify], '+00:00'),113 )  AS [DateModify]"
    );
    private $UI_product_columns = array(
            '[ProductID]',
            '[Title]',
            '[Category]',
            '[ShortDesc]',
            'P.[GUID] AS [GUID]',
            'C.[ShippingLimit] AS [ShippingLimit]',
            'C.[ShippingFare] AS [ShippingFare]',
            'C.[ShippingType] AS [ShippingType]',
            "CONVERT( INT, PriceMSRP ) AS [PriceMSRP]",
            "REPLACE(CONVERT(NVARCHAR(20), PriceSpecial, 1), '.00', '') AS [PriceSpecial]",
            '[Stock]',
            '[Soldout]',
            '[Details]',
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

            "CONVERT(VARCHAR(10) , SWITCHOFFSET (OffShelfTime, '+00:00'),20 )  AS [OffShelfTimeDate]",
            "RIGHT( CONVERT(VARCHAR(13) , SWITCHOFFSET (OffShelfTime, '+00:00'),20 ) ,2)  AS [OffShelfTimeHour]",
            "RIGHT( CONVERT(VARCHAR(16) , SWITCHOFFSET (OffShelfTime, '+00:00'),20 ) ,2)  AS [OffShelfTimeMinute]",
    );
    private $category_list = array(
        array(
            'CategoryName' => "",
            'GUID' => 'all'
        )
        /*,
        array(
            'NAME' => 'menu_product_seasonal_fruits_and_vegetables',
            'GUID' => '593E7A26-6822-4DD7-ACDE-D6FAF5259417'
        ),
        array(
            'NAME' => 'menu_product_fruits',
            'GUID' => '923B5DD9-F43B-49B6-A9E9-49823BC36B0A'
        ),
        array(
            'NAME' => 'menu_product_vegetables',
            'GUID' => '09C449E9-8D6D-40BF-95D3-12A488A3FE82'
        ),
        array(
            'NAME' => 'menu_product_fruits_and_vegetables_weekly',
            'GUID' => 'CBD89E5F-BD89-4B14-A465-2C69ED9BE2F8'
        ),
        array(
            'NAME' => 'menu_product_snacks',
            'GUID' => '39258F85-E582-4C79-84CE-406FD1ECB49C'
        ),
        array(
            'NAME' => 'menu_product_seasonal_gift',
            'GUID' => '7823C577-4A0C-452F-9ACF-7CFC7A555CB2'
        ),
        array(
            'NAME' => 'menu_product_combined_commodity',
            'GUID' => 'ECBA4E56-7E73-431E-9851-8507327027F4'
        )
        */
    );
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();
        $this->load->model('easydb_model');
        $this->load->model('register_model');
        $this->load->model('error_model');
        
        if( $this->session->userdata('user_exist') === true){
            $this->display_data['session_control'] = "session_exist";
        }
        $this->display_data["order_num_rows"] = $this->retrieve_order_num_rows();

    }
    public function iframe_product_details($GUID){
        $data = array(
            "GUID" => $GUID
        );
        $query = $this->easydb_model->select_data( '[dbo].[i_products]' , $data , array('[Details]') );

        $display_data = array_merge($this->display_data, (array) $query->row());
		$this->parser->parse('market/iframe_product_details', $display_data);
    }
    public function iframe_product_recipe($GUID){
        $data = array(
            "GUID" => $GUID
        );
        $query = $this->easydb_model->select_data( '[dbo].[i_products]' , $data , array('[Recipe]') );
        $display_data = array_merge($this->display_data, (array) $query->row());
		$this->parser->parse('market/iframe_product_recipe', $display_data);
    }
    public function iframe_product_order_note($GUID){
        $data = array(
            "GUID" => $GUID
        );
        $query = $this->easydb_model->select_data( '[dbo].[i_products]' , $data , array('[OrderNote]') );
        $display_data = array_merge($this->display_data, (array) $query->row());
		$this->parser->parse('market/iframe_product_order_note', $display_data);
    }
    public function hit($GUID)
    {
        $this->db->query(
                "UPDATE [dbo].[i_products] 
                SET 
                    [Hits] = [Hits] + 1 ,
                    [LastViewTime] = '".date('Y-m-d H:i:s')."'
                WHERE 
                        [GUID] = '".$GUID."'"
            );
    }
    public function product($GUID){
        $this->load->model('products_model');
        
        $data = array(
            "GUID" => $GUID
        );
        $session_data = $this->register_model->retrieve_user_session();
        $query = $this->products_model->retrieve_products_by_GUID( $this->UI_product_columns , $GUID);
        if($query->num_rows == 0){
            show_404();
        }
        $this->hit($GUID);
        $display_data = array_merge($session_data , $this->display_data, (array) $query->row());
        $display_data['notify_email'] = $this->session->userdata('Email');
        $display_data['product_GUID'] = $GUID;

        $this->load->view('_default/header');

        $this->parser->parse('_default/navi', $display_data);
        $this->parser->parse('market/product', $display_data);
        $this->load->view('_default/footer');

    }
	public function category($category = 'all' , $prepage = 6, $offset = 0 , $query_txt = NULL)
	{
        
        $this->load->model('register_model');
        $this->load->model('products_model');
        $session_data = $this->register_model->retrieve_user_session();
        $this->load->view('_default/header', $session_data);
        $data = array();
        $display_data = array_merge($data, $session_data , $this->display_data);
        if ($category == 'all')
             $q_category = FALSE;
        else    
            $q_category =$category;

        $result = $this->products_model->query_products_by_category('[dbo].[i_products]', $q_category ,$this->UI_columns,$offset , $prepage );
        $display_data['product_lists'] = $result['object']->result();
        $display_data['product_lists_jquery'] = $result['object']->result();
        $display_data['total_rows'] = $result['num_rows'];
        $display_data['notify_email'] = $this->session->userdata('Email');
        

        $display_data['category_navi'] = $this->create_category_navi() ;
        $this->load->library('pagination');

        $pagination_config = $this->config->item('pagination');
        $this->config->load('pagination', TRUE);

        $pagination_config['base_url'] = '/market/category/'.$category.'/'.$prepage;
        $pagination_config['total_rows'] = $result['num_rows'];
        $pagination_config['per_page'] = $prepage; 
        $pagination_config['uri_segment'] = 5;
        $this->pagination->initialize($pagination_config); 

        $display_data['pagination'] = $this->pagination->create_links();


        $this->parser->parse('_default/navi', $display_data);
        $this->parser->parse('market/category', $display_data);
        $this->load->view('_default/footer');
	}
	public function rule()
	{
        $this->display_data["highlight_sub_lsit"] = 1;

        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
        $this->load->view('_default/header', $session_data);
        $data = array();
        $display_data = array_merge($data, $session_data , $this->display_data);

        $this->parser->parse('_default/navi', $display_data);
        $this->load->view('market/rule');
        $this->load->view('_default/footer');
	}
	public function faq()
	{
        $this->display_data["highlight_sub_lsit"] = 2;
        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
        $this->load->view('_default/header', $session_data);
        $data = array();
        $display_data = array_merge($data, $session_data , $this->display_data);

        $this->parser->parse('_default/navi', $display_data);
        $this->load->view('market/faq');
        $this->load->view('_default/footer');
	}
    function add(){
        $query_data = array(
            'GUID' => $this->input->post('ProductGUID',true)
        );
        $query = $this->easydb_model->select_data('[dbo].[i_products]' , $query_data , $this->UI_columns_add);
        $product_obj = $query->row();
        $session_data = $this->register_model->retrieve_user_session();
        $data = array(  'ProductGUID' => $this->input->post('ProductGUID',true),
                        'OrderCounts' => $this->input->post('OrderCounts',true),
                        'Title' => $product_obj->Title,
                        'Category' => $product_obj->Category,
                        'ShortDesc' => $product_obj->ShortDesc,
                        'PriceMSRP' => $product_obj->PriceMSRP,
                        'SessionID' => $session_data['session_id'],
                        //'UserGUID' 
                        'PriceSpecial' => $product_obj->PriceSpecial,
                        'DateCreate' => date('Y-m-d H:i:s'),
                        'DateModify' => date('Y-m-d H:i:s')
        
        );
        if($session_data['GUID']){
            $data['UserGUID'] = $session_data['GUID'];
        }

        $query_exist_in_order_detail = $this->db->query(
                "SELECT * FROM [dbo].[i_order_details] 
                WHERE 
                        [ProductGUID] = '".$this->input->post('ProductGUID',true)."'
                    AND
                        [OrderGUID] IS NULL
                    AND 
                        ([SessionID] = '".$session_data['session_id']."' OR [UserGUID] = '".$session_data['GUID']."' )" 
            );

        header('Content-Type: application/json');
        if( $query_exist_in_order_detail->num_rows() == 0){
            $str = $this->db->insert_string('[dbo].[i_order_details]',$data);
            $insert_query = $this->db->query( $str );

        }else{
            $insert_query = $this->db->query(
                "UPDATE [dbo].[i_order_details] 
                SET 
                    [OrderCounts] = [OrderCounts] + ".$this->input->post('OrderCounts',true)." ,
                    [DateModify] = '".date('Y-m-d H:i:s')."'
                WHERE 
                        [ProductGUID] = '".$this->input->post('ProductGUID',true)."'
                    AND
                        [OrderGUID] IS NULL
                    AND 
                        ([SessionID] = '".$session_data['session_id']."' OR [UserGUID] = '".$session_data['GUID']."' )" 
            );
        }
        if($insert_query == true){
            echo $this->error_model->retrieve_error_msg(0);
        }else{
            echo $this->error_model->retrieve_error_msg(4);
        }

    }
    protected function build_navi(){
        $this->load->model('products_model');
        $r = $this->products_model->retrieve_category($this->UI_products_category_columns , TRUE);
        $grid_data = $r->result();
        foreach($grid_data as $key ){
            array_push ($this->category_list , array(
                'GUID' => $key->GUID,
                'CategoryName' => $key->CategoryName
            ));
        }
    }
    function create_category_navi(){
        $this->lang->load('menu');
        $this->load->model('products_model');
        $this->build_navi();
        $html = '<ul class="category">';
        foreach($this->category_list as $key ){
            if ($key['GUID'] == 'all'){
                 $category = FALSE;
                 $key['CategoryName'] = $this->lang->line('menu_product_all');
            }else{
                $category = $key['GUID'];
            }
            $count = $this->products_model->category_count('[dbo].[i_products]' , $category);
            $html .= '<li>';
            $html .= '<a href="/market/category/'.$key['GUID'].'">'.$key['CategoryName'].'(<span id="">'.$count.'</span>)</a>';
            $html .= '</li>';        
        }
        $html .= '</ul>';
        return $html;
    }
    function notify_add()
    {
        $notify_email =  $this->input->post('notify_email',true);
        $product_GUID =  $this->input->post('product_GUID',true);
        $UserGUID =  $this->session->userdata('GUID');
        if(!$UserGUID){
            $UserGUID = '00000000-0000-0000-0000-000000000000';
        }
        $data = array(
            'ProductGUID' => $product_GUID,
            'Email' => $notify_email ,
            'UserGUID' => $UserGUID
        );
            $str = $this->db->insert_string('[dbo].[i_product_notifications]',$data);
            $insert_query = $this->db->query( $str );
        
        echo json_encode($data);
    }
    public function parse_display_data()
    {
        $this->lang->load('gird_column');
        $this->lang->load('button');
        $this->lang->load('contextmenu');
        $this->lang->load('menu');
        $this->lang->load('orders');
        $this->lang->load('products');
        $display_data = array(
            'button_close'                  => $this->lang->line('button_close'),
            'button_cancel'                 => $this->lang->line('button_cancel'),
            'button_submit'                 => $this->lang->line('button_submit'),
            'button_ok'                     => $this->lang->line('button_ok'),
            'button_search'                 => $this->lang->line('button_search'),
            'gird_column_Details'           => $this->lang->line('gird_column_Details'),
            'gird_column_Recipe'           => $this->lang->line('gird_column_Recipe'),
            'gird_column_OrderNote'           => $this->lang->line('gird_column_OrderNote'),
            'products_available_notify_title' => $this->lang->line('product_available_notify_title'),
            'products_no_data_in_category'  => $this->lang->line('products_no_data_in_category'),
            'products_available_notify_email_error' => $this->lang->line('products_available_notify_email_error')
        );
        $this->display_data = array_merge($this->display_data, $display_data );
    }

}

/* End of file market.php */
/* Location: ./application/controllers/market.php */