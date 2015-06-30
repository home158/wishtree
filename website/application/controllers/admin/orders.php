<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends Admin_Base_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();
    }
    private $UI_columns = array(
            "U.[Name] AS [Name]",
            "U.[Email] AS [Email]",
            "U.[City] AS [City]",
            "U.[Gender] AS [Gender]",
            "O.[OrderID] AS [OrderID]",
            "O.[GUID] AS [GUID]",
            "O.[UserGUID] AS [UserGUID]",

            "REPLACE(CONVERT(NVARCHAR(20), O.[ShippingFare], 1), '.00', '') AS [ShippingFare]",
            "CAST(O.[ShippingFare] AS NUMERIC(20,0)) AS [ShippingFare_NUMERIC]",

            "REPLACE(CONVERT(NVARCHAR(20), O.[OtherFare], 1), '.00', '') AS [OtherFare]",
            "CAST(O.[OtherFare] AS NUMERIC(20,0)) AS [OtherFare_NUMERIC]",

            "O.ShippingFareNote"  =>  "[ShippingFareNote]",
            "O.[IsSubscribe] AS [IsSubscribe]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (O.[DateSubscribe], '+00:00') ,113) AS [DateSubscribe]",

            "REPLACE(CONVERT(NVARCHAR(20), O.[TotalPayment], 1), '.00', '') AS [TotalPayment]",
            "CAST(O.[TotalPayment] AS NUMERIC(20,0)) AS [TotalPayment_NUMERIC]",

            "REPLACE(CONVERT(NVARCHAR(20), O.[TotalMerchandiseAmount], 1), '.00', '')AS [TotalMerchandiseAmount]",
            "CAST(O.[TotalMerchandiseAmount] AS NUMERIC(20,0)) AS [TotalMerchandiseAmount_NUMERIC]",

            "O.[IsPayment] AS [IsPayment]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (O.[DatePayment], '+00:00') ,113) AS [DatePayment]",
            "O.[IsShipping] AS [IsShipping]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (O.[ShippingActualDate], '+00:00') ,113) AS [ShippingActualDate]",
            "O.[ShippingExpectNextDate] AS [ShippingExpectNextDate]",
            "O.[ShippingArrivalAssignDate] AS [ShippingArrivalAssignDate]",
            "O.[ShippingType] AS [ShippingType]",
            "O.[CustomerNote] AS [CustomerNote]",
	        "CONVERT(VARCHAR(17) , SWITCHOFFSET (O.[DateCreate], '+00:00') ,113) AS [DateCreate]",
	        "CONVERT(VARCHAR(17) , SWITCHOFFSET (O.[DateModify], '+00:00') ,113) AS [DateModify]",
            "O.[OrderName] AS [OrderName]",
            "O.[ReceiveName] AS [ReceiveName]",
            "O.[OrderTel] AS [OrderTel]",
            "O.[ReceiveTel] AS [ReceiveTel]",
            "O.[OrderMobile] AS [OrderMobile]",
            "O.[ReceiveMobile] AS [ReceiveMobile]",
            "O.[ReceiveAddress] AS [ReceiveAddress]",
            "O.[ReceiveBankAccount] AS [ReceiveBankAccount]",
            "O.[ReceiveTime] AS [ReceiveTime]"
    );
    private $UI_to_db_sort_columns = array(
        "Name" => "U.[Name]",
        "Email" => "U.[Email]",
        "City" => "U.[City]",
        "OrderID" => "O.[OrderID]",
        "GUID" => "O.[GUID]",
        "UserGUID" => "O.[UserGUID]",
        "ShippingFare" => "O.[ShippingFare]",
        "OtherFare" => "O.[OtherFare]",
        "IsSubscribe" => "O.[IsSubscribe]",
        "DateSubscribe" => "O.[DateSubscribe]",
        "TotalPayment" => "O.[TotalPayment]",
        "TotalMerchandiseAmount" => "O.[TotalMerchandiseAmount]",
        "ShippingFare" => "O.[ShippingFare]",
        "IsPayment" => "O.[IsPayment]",
        "DatePayment" => "O.[DatePayment]",
        "IsShipping" => "O.[IsShipping]",
        "ShippingActualDate" => "O.[ShippingActualDate]",
        "ShippingExpectNextDate" => "O.[ShippingExpectNextDate]",
        "ShippingArrivalAssignDate" => "O.[ShippingArrivalAssignDate]",
        "ShippingType" => "O.[ShippingType]",
        "CustomerNote" => "O.[CustomerNote]",
	    "DateCreate AS O.[DateCreate]",
	    "DateModify AS O.[DateModify]"

    );
    private $UI_details_columns = array(
        "RANK() OVER( ORDER BY [DetailID]) AS [SerialNo] ",
	    '[DetailID] AS [DetailID]',
	    'D.[GUID] AS [GUID]',
	    '[OrderGUID] AS [OrderGUID]',
	    '[ProductGUID] AS [ProductGUID]',
	    '[Title] AS [Title]',
	    '[Category] AS [Category]',
	    '[CategoryName] AS [CategoryName]',
	    '[ShortDesc] AS [ShortDesc]',
        "REPLACE(CONVERT(NVARCHAR(20), PriceMSRP, 1), '.00', '') AS [PriceMSRP]",
        "REPLACE(CONVERT(NVARCHAR(20), PriceSpecial, 1), '.00', '') AS [PriceSpecial]",
        "REPLACE(CONVERT(NVARCHAR(20), PriceActual, 1), '.00', '') AS [PriceActual]",
        "CAST([PriceActual] AS NUMERIC(20,0)) AS [PriceActual_NUMERIC]",

	    '[ShippingCounts] AS [ShippingCounts]',
	    '[ShippingCountsThisTime] AS [ShippingCountsThisTime]',
	    '[ShippingCountsLastTime] AS [ShippingCountsLastTime]',

	    '[OrderCounts] AS [OrderCounts]',
	    "CONVERT(VARCHAR(17) , SWITCHOFFSET (D.[DateCreate], '+00:00') ,113) AS [DateCreate]",
	    "CONVERT(VARCHAR(17) , SWITCHOFFSET (D.[DateModify], '+00:00') ,113) AS [DateModify]"

    );
    private $UI_orderflow_columns = array(
        "RANK() OVER( ORDER BY [FlowID]) AS [SerialNo] ",
		'[OrderGUID]',
		'F.[UserGUID] AS [UserGUID]',
		'[UserEmail]',
		'[FlowStatu]',
		'[FlowNote]',
	    "CONVERT(VARCHAR(20) , SWITCHOFFSET (F.[DateCreate], '+00:00') ,113) AS [DateCreate]"

    );
    public function view($CATEGORY = "00000000-0000-0000-0000-000000000000")
	{
        $display_data = $this->display_data;
        $top = 0;
        $bottom =37;
        $this->load->model('orders_model');
        //init data grid
        switch($CATEGORY){
            case "CD081E64-8314-4C4F-B010-EF734BCE6FB1"://未出貨訂單
                $IsShipping     = "0";
                $IsSubscribe    = "1";
                $IsPayment      = "0,1";
                $ShippingType   = "0,1";
                $query = $this->orders_model->select_data_limit_offset($top , $bottom , $this->UI_columns , $IsShipping , $IsSubscribe , $IsPayment , $ShippingType);
                break;
            case "9AF999A6-550F-4FCD-93AF-24222D79EB31": //部份出貨訂單
                $IsShipping     = "1";
                $IsSubscribe    = "1";
                $IsPayment      = "1";
                $ShippingType   = "0,1";
                $query = $this->orders_model->select_data_limit_offset($top , $bottom , $this->UI_columns , $IsShipping , $IsSubscribe , $IsPayment , $ShippingType);
                break;
            case "3D06BDFD-B2FB-41DA-A472-E7DB9854D8B4"://已出貨訂單
                $IsShipping     = "2";
                $IsSubscribe    = "1";
                $IsPayment      = "1";
                $ShippingType   = "0,1";
                $query = $this->orders_model->select_data_limit_offset($top , $bottom , $this->UI_columns , $IsShipping , $IsSubscribe , $IsPayment , $ShippingType);
                break;
           case "E958C208-C0DE-4A19-8E4D-F37896D86C1D"://在購物車尚未下訂
                $IsShipping     = "0";
                $IsSubscribe    = "0";
                $IsPayment      = "0";
                $ShippingType   = "0,1";
                $query = $this->orders_model->select_data_limit_offset($top , $bottom , $this->UI_columns , $IsShipping , $IsSubscribe , $IsPayment , $ShippingType);
                 break;
            default:
                $query = $this->orders_model->select_data_limit_offset($top , $bottom , $this->UI_columns);
                break;
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
		$this->parser->parse('admin/orders/index_default',$display_data);
		$this->load->view('admin/footer');

    }
    public function retrieve_list()
    {
        $this->load->model('orders_model');
        $top = $this->input->post('top',true);
        $bottom = $this->input->post('bottom',true);
        $sort_column_id = $this->input->post('SORT_COLUMN_ID',true);
        $order_method = $this->input->post('ORDER_METHOD',true); // true or false
        $IsShipping     = $this->input->post('IsShipping',true);
        $IsSubscribe    = $this->input->post('IsSubscribe',true);
        $IsPayment      = $this->input->post('IsPayment',true);
        $ShippingType   = $this->input->post('ShippingType',true);
        $search_txt = $this->input->post('SEARCH_TXT',true);

        $query = $this->orders_model->select_data_limit_offset($top , $bottom , $this->UI_columns , 
                                $IsShipping , $IsSubscribe , $IsPayment , $ShippingType , $this->UI_to_db_sort_columns[$sort_column_id]  , $order_method  ,$search_txt);

        $data = array(
            'grid_data' => $query['object']->result(),
            'num_rows' => $query['num_rows'],
            'top' => $top,
            'bottom' => $bottom,
            'IsShipping' => $IsShipping,
            'IsSubscribe' => $IsSubscribe,
            'IsPayment' => $IsPayment,
            'ShippingType' => $ShippingType,
            'sort_column_id' => $sort_column_id,
            'order_method' => $order_method,
            'GUID_list' => $query['GUID_list'],
            'search_txt' => $search_txt
        );
        
        header('Content-Type: application/json');
        echo json_encode($data); 
    }
    public function delete()
    {
        $this->load->model('error_model');
        $this->load->model('easydb_model');
        $GUID = $this->input->post('GUID',true);
        $query = $this->easydb_model->delete_rows_where_in('[dbo].[i_order]' , $GUID);

        if($query == true){
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(0);
        }else{
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(2);
        }
    }
    public function unsubscribe()
    {
        $this->load->model('flow_model');
        $this->load->model('error_model');
        $this->load->model('orders_model');
        $this->load->model('easydb_model');

        $order_GUID = $this->input->post('GUID',true);
        $update_i_order_details_query = $this->db->query(
            "UPDATE [dbo].[i_order_details] 
            SET 
                [OrderGUID] = NULL
            WHERE 
                [OrderGUID] = '".$order_GUID."'"
        );
        
        $query = $this->easydb_model->delete_rows_where_in('[dbo].[i_order]' , $order_GUID);

        $this->flow_model->record($order_GUID , 'OC');
        $result_info = $this->orders_model->select_data_limit_offset(0 , 1 , $this->UI_columns ,
                                    "0,1,2",
                                    "0,1",
                                    "0,1",
                                    "0,1",
                                    'OrderID' ,'DESC' , FALSE ,FALSE , $order_GUID);

        if($query == true){
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(0 , NULL , (array) $result_info['object']->row() );
        }else{
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(6);
        } 
    }
    public function shipping_confirm()
    {
        $this->load->model('flow_model');
        $this->load->model('error_model');
        $this->load->model('orders_model');
        $order_GUID = $this->input->post('GUID',true);
        //更新出貨
        $query = $this->db->query(
            "UPDATE [dbo].[i_order] 
            SET
                [IsShipping] = 1,
                [ShippingActualDate] = '".date('Y-m-d H:i:s')."',
                [DateModify] = '".date('Y-m-d H:i:s')."'
            WHERE [GUID] = '".$order_GUID."' "
        );
        $this->flow_model->record($order_GUID , 'SA');
        $result_info = $this->orders_model->select_data_limit_offset(0 , 1 , $this->UI_columns ,
                                    "0,1,2",
                                    "0,1",
                                    "0,1",
                                    "0,1",
                                    'OrderID' ,'DESC' , FALSE ,FALSE , $order_GUID);

        if($query == true){
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(0 , NULL , (array) $result_info['object']->row() );
        }else{
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(6);
        }    
    }
    public function shipping_cancel()
    {
        $this->load->model('flow_model');
        $this->load->model('error_model');
        $this->load->model('orders_model');
        $order_GUID = $this->input->post('GUID',true);
        //更新出貨
        $query = $this->db->query(
            "UPDATE [dbo].[i_order] 
            SET
                [IsShipping] = 0,
                [ShippingActualDate] = NULL,
                [DateModify] = '".date('Y-m-d H:i:s')."'
            WHERE [GUID] = '".$order_GUID."' "
        );
        $this->flow_model->record($order_GUID , 'SC');
        $result_info = $this->orders_model->select_data_limit_offset(0 , 1 , $this->UI_columns ,
                                    "0,1,2",
                                    "0,1",
                                    "0,1",
                                    "0,1",
                                    'OrderID' ,'DESC' , FALSE ,FALSE , $order_GUID);

        if($query == true){
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(0 , NULL , (array) $result_info['object']->row() );
        }else{
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(6);
        }    
    }
    public function palyment_confirm()
    {
        $this->load->model('flow_model');
        $this->load->model('error_model');
        $this->load->model('orders_model');
        $order_GUID = $this->input->post('GUID',true);
        //更新訂單
        $query = $this->db->query(
            "UPDATE [dbo].[i_order] 
            SET
                [IsPayment] = 1,
                [DatePayment] = '".date('Y-m-d H:i:s')."',
                [DateModify] = '".date('Y-m-d H:i:s')."'
            WHERE [GUID] = '".$order_GUID."' "
        );
        $this->flow_model->record($order_GUID , 'PA');
        $result_info = $this->orders_model->select_data_limit_offset(0 , 1 , $this->UI_columns ,
                                    "0,1,2",
                                    "0,1",
                                    "0,1",
                                    "0,1",
                                    'OrderID' ,'DESC' , FALSE ,FALSE , $order_GUID);

        if($query == true){
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(0 , NULL , (array) $result_info['object']->row() );
        }else{
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(6);
        }    
    }
    public function palyment_cancel()
    {
        $this->load->model('flow_model');
        $this->load->model('error_model');
        $this->load->model('orders_model');
        $order_GUID = $this->input->post('GUID',true);
        //更新訂單
        $query = $this->db->query(
            "UPDATE [dbo].[i_order] 
            SET
                [IsPayment] = 0,
                [DatePayment] = NULL,
                [DateModify] = '".date('Y-m-d H:i:s')."'
            WHERE [GUID] = '".$order_GUID."' "
        );
        $this->flow_model->record($order_GUID , 'PC');
        $result_info = $this->orders_model->select_data_limit_offset(0 , 1 , $this->UI_columns ,
                                    "0,1,2",
                                    "0,1",
                                    "0,1",
                                    "0,1",
                                    'OrderID' ,'DESC' , FALSE ,FALSE , $order_GUID);

        if($query == true){
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(0 , NULL , (array) $result_info['object']->row() );
        }else{
            header('Content-Type: application/json');
            echo $this->error_model->retrieve_error_msg(6);
        }
    }
    public function flow($order_GUID){
        
        $this->load->model('orders_model');
        $result = $this->orders_model->retrieve_orderflow($order_GUID , $this->UI_orderflow_columns, $this->UI_columns);
        $data = array(
            'order_data' => (array) $result['order']['object']->row(),
            'grid_data' => json_encode( $result['flow']['object']->result() ),
            'num_rows' => $result['flow']['num_rows'],
            "order_GUID" => $order_GUID
        );
        $this->display_data['status_total_rows'] = sprintf($this->lang->line('orders_total_rows') , $data['num_rows']);

        $display_data = array_merge( $this->display_data , $data  );

        $this->load->view('_default/popup-header');
        $this->parser->parse('admin/orders/popup_flow',$display_data);
        $this->load->view('_default/popup-footer');

    }
    public function edit($order_GUID){
        $display_data = $this->display_data;
        $this->load->model('orders_model');
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
        $this->form_validation->set_rules('OrderName',$display_data['gird_column_OrderName'],'trim|required');
        $this->form_validation->set_rules('OrderTel',$display_data['gird_column_ReceiveTel'],'trim');
        $this->form_validation->set_rules('OrderMobile',$display_data['gird_column_ReceiveTel'],'trim');
        $this->form_validation->set_rules('ReceiveName',$display_data['gird_column_ReceiveName'],'trim|required');
        $this->form_validation->set_rules('ReceiveTel',$display_data['gird_column_ReceiveTel'],'trim');
        $this->form_validation->set_rules('ReceiveMobile',$display_data['gird_column_ReceiveTel'],'trim');
        $this->form_validation->set_rules('ReceiveTime',$display_data['gird_column_ReceiveTime'],'trim|required');
        $this->form_validation->set_rules('ShippingFareNote',$display_data['gird_column_ShippingFareNote'],'trim|required');
        $this->form_validation->set_rules('ReceiveAddress',$display_data['gird_column_ReceiveAddress'],'trim|required');
        
        $this->form_validation->set_rules('TotalMerchandiseAmount_NUMERIC',$display_data['gird_column_TotalMerchandiseAmount'],'trim|required|is_natural');
        $this->form_validation->set_rules('ShippingFare_NUMERIC',$display_data['gird_column_ShippingFare'],'trim|required|is_natural');
        $this->form_validation->set_rules('OtherFare_NUMERIC',$display_data['gird_column_ShippingFare'],'trim|required|integer');
        $this->form_validation->set_rules('TotalPayment_NUMERIC',$display_data['gird_column_ShippingFare'],'trim|required|is_natural');
        
        $this->form_validation->set_rules('UpdateToShippingCountsThisTime[]', $display_data['gird_column_ShippingCountsThisTime'], 'trim|required|is_natural');
        $this->form_validation->set_rules('UpdateToShippingCountsLastTime[]', $display_data['gird_column_ShippingCountsLastTime'], 'trim|required|is_natural');
        $this->form_validation->set_rules('UpdateToShippingCounts[]', $display_data['gird_column_ShippingCounts'], 'trim|required|is_natural');
        $this->form_validation->set_rules('UpdateToOrderCounts[]', $display_data['gird_column_OrderCounts'], 'trim|required|is_natural');
        $this->form_validation->set_rules('UpdateToPriceActual[]', $display_data['gird_column_PriceActual'], 'trim|required|is_natural');

        $result = $this->orders_model->retrieve_details($order_GUID , $this->UI_details_columns, $this->UI_columns);
        $data = array(
            'order_data' => (array) $result['order']['object']->row(),
            'grid_data' => json_encode( $result['details']['object']->result() ),
            'num_rows' => $result['details']['num_rows'],
            "order_GUID" => $order_GUID
        );

        $this->display_data['status_total_rows'] = sprintf($this->lang->line('orders_total_rows') , $data['num_rows']);
        $display_data = array_merge( $this->display_data , $data  );

		if ($this->form_validation->run() == FALSE)
		{
            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/orders/popup_edit',$display_data);
            $this->load->view('_default/popup-footer');
        }else{
            $GUID = $this->input->post('GUID',true);
            $OrderName = $this->input->post('OrderName',true);
            $OrderTel = $this->input->post('OrderTel',true);
            $OrderMobile = $this->input->post('OrderMobile',true);
            $ReceiveName = $this->input->post('ReceiveName',true);
            $ReceiveTel = $this->input->post('ReceiveTel',true);
            $ReceiveMobile = $this->input->post('ReceiveMobile',true);
            $ReceiveTime = $this->input->post('ReceiveTime',true);
            $ShippingFareNote = $this->input->post('ShippingFareNote',true);
            $ReceiveAddress = $this->input->post('ReceiveAddress',true);
        
            $TotalMerchandiseAmount = $this->input->post('TotalMerchandiseAmount_NUMERIC',true);
            $ShippingFare = $this->input->post('ShippingFare_NUMERIC',true);
            $OtherFare = $this->input->post('OtherFare_NUMERIC',true);
            $TotalPayment = $this->input->post('TotalPayment_NUMERIC',true);

            $UpdateToShippingCountsThisTime = $this->input->post('UpdateToShippingCountsThisTime',true);
            $UpdateToShippingCountsLastTime = $this->input->post('UpdateToShippingCountsLastTime',true);
            $UpdateToShippingCounts = $this->input->post('UpdateToShippingCounts',true);
            $UpdateToOrderCounts = $this->input->post('UpdateToOrderCounts',true);
            $UpdateToPriceActual = $this->input->post('UpdateToPriceActual',true);
            $save_to_db = $this->input->post('save_to_db',true);
            $this->db->query(
                "UPDATE [dbo].[i_order]
                SET
                    [OrderName] = '".$OrderName."' ,
                    [OrderTel] = '".$OrderTel."' ,
                    [OrderMobile] = '".$OrderMobile."' ,
                    [ReceiveName] = '".$ReceiveName."' ,
                    [ReceiveTel] = '".$ReceiveTel."' ,
                    [ReceiveMobile] = '".$ReceiveMobile."' ,
                    [ReceiveTime] = '".$ReceiveTime."' ,
                    [ShippingFareNote] = '".$ShippingFareNote."' ,
                    [ReceiveAddress] = '".$ReceiveAddress."' ,

                    [TotalMerchandiseAmount] = ".$TotalMerchandiseAmount." ,
                    [ShippingFare] = ".$ShippingFare." ,
                    [OtherFare] = ".$OtherFare." ,
                    [TotalPayment] = ".$TotalPayment." ,

                    [DateModify] = '".date('Y-m-d H:i:s')."'
                WHERE [GUID] = '".$order_GUID."' "
            );
            $this->load->model('flow_model');
            $this->lang->load('flow');
            $this->flow_model->record($order_GUID , 'UM' ,$this->lang->line('flow_UM_1') );
            if( is_array($save_to_db) ){
                foreach ($save_to_db as $row) {
                    $query = $this->db->query(
                                "SELECT 
                                    [ShippingCountsThisTime] ,
                                    [ShippingCountsLastTime] ,
                                    [ShippingCounts] ,
                                    [OrderCounts] ,
                                    CAST([PriceActual] AS NUMERIC(20,0)) AS [PriceActual],
                                    [DateModify] 
                                FROM[dbo].[i_order_details]
                                WHERE [GUID] = '".$GUID[$row]."' "
                            );
                    $unchange_data = (array) $query->row();
                    $this->db->query(
                        "UPDATE [dbo].[i_order_details]
                        SET
                            [ShippingCountsThisTime] = ".$UpdateToShippingCountsThisTime[$row]." ,
                            [ShippingCountsLastTime] = ".$UpdateToShippingCountsLastTime[$row]." ,
                            [ShippingCounts] = ".$UpdateToShippingCounts[$row]." ,
                            [OrderCounts] = ".$UpdateToOrderCounts[$row]." ,
                            [PriceActual] = ".$UpdateToPriceActual[$row]." ,
                            [DateModify] = '".date('Y-m-d H:i:s')."'
                        WHERE [GUID] = '".$GUID[$row]."' "
                    );
                    //取得訂單項次
                    $item = $row + 1;
                    $note = sprintf(  $this->lang->line('flow_UI_1') ,
                        $item,

                        $unchange_data['ShippingCountsThisTime'].'-'.$unchange_data['ShippingCountsLastTime'].'-'.
                        $unchange_data['ShippingCounts'].'-'.$unchange_data['OrderCounts'].'-'.$unchange_data['PriceActual'],

                        $UpdateToShippingCountsThisTime[$row].'-'.$UpdateToShippingCountsLastTime[$row].'-'.
                        $UpdateToShippingCounts[$row].'-'.$UpdateToOrderCounts[$row].'-'.$UpdateToPriceActual[$row]
                    );
                    $this->flow_model->record($order_GUID , 'UI' ,$note );

                }
            }
            $display_data['post_result_subject_title'] = $display_data['contextmenu_order_edit'];
            $display_data['post_result_content_msg'] = $display_data['orders_edit_success_msg'];

            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/popup_post_result' , $display_data);
            $this->load->view('_default/popup-footer');
        }

    }
    public function details($order_GUID)
    {
        $display_data = $this->display_data;
        $this->load->model('orders_model');
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em>&nbsp;', '</em>');
        $this->form_validation->set_rules('AddToShippingCountsThisTime[]',"",'trim');

        $result = $this->orders_model->retrieve_details($order_GUID , $this->UI_details_columns, $this->UI_columns);
        $data = array(
            'order_data' => (array) $result['order']['object']->row(),
            'grid_data' => json_encode( $result['details']['object']->result() ),
            'num_rows' => $result['details']['num_rows'],
            "order_GUID" => $order_GUID
        );
        $path = __DIR__.'\\..\\..\\..\\order_history\\'.$order_GUID;
        //$directories = glob(__DIR__.'\\..\\..\\..\\order_history\\'.$order_GUID . '/*' , GLOB_ONLYDIR);
        if( is_dir($path) ){
            $file_lists = "<ol style='margin-left:20px;ling-height:20px;'>";
            $files = preg_grep('/^([^.])/', scandir($path));
            foreach($files as $key){
                $file_lists .= '<li><a target="_blank" href="/order_history/'.$order_GUID.'/'.$key.'">'.$key.'</a></li>';
            }
            $file_lists .= "</ol>";
        }else{
            $file_lists = $this->display_data['orders_no_shipping_history'];
        }
        $data['detail_shipping_history_msg'] = $file_lists;

        $this->display_data['status_total_rows'] = sprintf($this->lang->line('orders_total_rows') , $data['num_rows']);
        $display_data = array_merge( $this->display_data , $data  );

		if ($this->form_validation->run() == FALSE)
		{
            $this->load->view('_default/popup-header');
		    $this->parser->parse('admin/orders/popup_details',$display_data);
            $this->load->view('_default/popup-footer');
        }else{
            $GUID = $this->input->post('GUID',true);
            $AddToShippingCountsThisTime = $this->input->post('AddToShippingCountsThisTime',true);
            $save_to_db = $this->input->post('save_to_db',true);
            //var_dump($save_to_db);

            if( is_array($save_to_db) ){
                foreach ($save_to_db as $row) {
                    $this->db->query(
                        "UPDATE [dbo].[i_order_details]
                        SET
                            [ShippingCountsThisTime] = [ShippingCountsThisTime] +".intval($AddToShippingCountsThisTime[$row])." ,
                            [DateModify] = '".date('Y-m-d H:i:s')."'
                        WHERE [GUID] = '".$GUID[$row]."' "
                    );
                }
            }

           // var_dump($AddToShippingCountsThisTime);
            redirect(current_url(), 'refresh');
        }



        
    }
    public function delete_details($order_GUID){
        $GUID = $this->input->post('GUID',true);
        $AddToShippingCountsThisTime = $this->input->post('AddToShippingCountsThisTime',true);
        $save_to_db = $this->input->post('save_to_db',true);
        echo "<pre>";
        var_dump($save_to_db);
        echo "<br>";echo "<br>";
        var_dump($GUID);
        echo "<pre>";
        
        if($save_to_db){
            foreach ($save_to_db as $row) {
                $this->db->query(
                    "DELETE FROM [dbo].[i_order_details]
                    WHERE [GUID] = '".$GUID[$row]."' "
                );
            }
        }
        
        echo(base_url().'admin/orders/details/'.$order_GUID );
        redirect( base_url().'admin/orders/details/'.$order_GUID );

    }
    public function shipping($order_GUID , $type = 0){
        $GUID = $this->input->post('GUID',true);
        $AddToShippingCountsThisTime = $this->input->post('AddToShippingCountsThisTime',true);
        $save_to_db = $this->input->post('save_to_db',true);
        echo "<pre>";
        var_dump($save_to_db);
        echo "<br>";echo "<br>";
        var_dump($GUID);
        echo "<pre>";
        //暫存到本次預計出貨
        switch ($type){
            //暫存
            case 0:
                if($save_to_db){
                    foreach ($save_to_db as $row) {
                        $this->db->query(
                            "UPDATE [dbo].[i_order_details]
                            SET
                                [ShippingCountsThisTime] = [ShippingCountsThisTime] +".intval($AddToShippingCountsThisTime[$row])." ,
                                [DateModify] = '".date('Y-m-d H:i:s')."'
                            WHERE [GUID] = '".$GUID[$row]."' "
                        );
        
                    }
                }
            break;
            //出貨
            case 1:
                if($save_to_db){
                    foreach ($save_to_db as $row) {
                        $this->db->query(
                            "UPDATE [dbo].[i_order_details]
                            SET
                                [ShippingCounts] = [ShippingCountsThisTime] + [ShippingCounts],
                                [ShippingCountsLastTime] = [ShippingCountsThisTime],
                                [ShippingCountsThisTime] = 0,
                                [DateModify] = '".date('Y-m-d H:i:s')."'
                            WHERE [GUID] = '".$GUID[$row]."' "
                        );
        
                    }
                }
            break;
        }

        


        //更新訂單處理時間
        $this->db->query(
            "UPDATE [dbo].[i_order] 
            SET
                [DateModify] = '".date('Y-m-d H:i:s')."'
            WHERE [GUID] = '".$order_GUID."' "
        );

        //製生pdf主訂單記錄
        $this->print_detail( $order_GUID , 1);
        redirect( base_url().'admin/orders/details/'.$order_GUID , 'refresh');
    }
    public function delete_detail($order_GUID){
        $save_to_db = $this->input->post('save_to_db',true);
        $GUID = $this->input->post('GUID',true);
        
        if($save_to_db){
            foreach ($save_to_db as $row) {
                $this->db->query(
                    "delete [dbo].[i_order_details]
                    
                    WHERE [GUID] = '".$GUID[$row]."' "
                );
        
            }
        }
        
        redirect( base_url().'admin/orders/details/'.$order_GUID , 'refresh');
    }
    public function print_detail($order_GUID , $type = 0)
    {
        $this->load->model('orders_model');
        $result = $this->orders_model->retrieve_details($order_GUID , $this->UI_details_columns, $this->UI_columns);
        $order_data = (array) $result['order']['object']->row();
        $grid_data = (array) $result['details']['object']->result();

        switch ($type){
            case 1:
            break;
            default:
            break;
        }
        $this->load->library('Pdf');

        // create new PDF document
        
        // set document information
        $this->pdf->SetCreator(PDF_CREATOR);
        $this->pdf->SetAuthor('小善心農業有限公司');
        $this->pdf->SetTitle('出貨明細');
        $this->pdf->SetSubject('出貨明細');
        $this->pdf->SetKeywords('出貨明細, 小善心');
        
        // set default header data
        //$this->pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 038', PDF_HEADER_STRING);
        
        // set header and footer fonts
        $this->pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // set default monospaced font
        $this->pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // set margins
        $this->pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        // set auto page breaks
        $this->pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // set image scale factor
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        	require_once(dirname(__FILE__).'/lang/eng.php');
        	$this->pdf->setLanguageArray($l);
        }
        //echo __DIR__.'\\..\\..\\libraries\\tcpdf\\fonts\\utf8\\mingliu.ttf';
        // ---------------------------------------------------------
        // set font
        $fontname = TCPDF_FONTS::addTTFfont(__DIR__.'\\..\\..\\libraries\\tcpdf\\fonts\\utf8\\msjh.ttf', 'TrueTypeUnicode');
        //echo $fontname;mingliu
        $this->pdf->SetFont('msjh', '', 12, FALSE);
        //define ('PDF_FONT_NAME_MAIN', 'mingliu');
        //$this->pdf->setFontSubsetting(true); //產生字型子集（有用到的字才放到文件中）

        // add a page
        $this->pdf->AddPage();
        $this->pdf->setCellHeightRatio(2.0);
        $this->pdf->SetFont('msjh', '', 12);
		$this->pdf->SetY(35);

        // ---------------------------------------------------------
        $info = <<<EOD
            <table cellspacing="0" cellpadding="4" border="0">

EOD;
            $info .= '<tr>';
            $info .= '<td >';
            $info .= '訂購EMAIL：'.$order_data['Email'];
            $info .= '<br>';
            $info .= $this->display_data['gird_column_OrderName'].'：'.$order_data['OrderName'];
            $info .= '<br>';
            $info .= $this->display_data['gird_column_OrderTel'].'：'.$order_data['OrderTel'];
            $info .= '<br>';
            $info .= $this->display_data['gird_column_OrderMobile'].'：'.$order_data['OrderMobile'];
            $info .= '<br>';
            $info .= $this->display_data['gird_column_ReceiveName'].'：'.$order_data['ReceiveName'];
            $info .= '<br>';
            $info .= $this->display_data['gird_column_ReceiveTel'].'：'.$order_data['ReceiveTel'];
            $info .= '<br>';
            $info .= $this->display_data['gird_column_ReceiveMobile'].'：'.$order_data['ReceiveMobile'];
            $info .= '<br>';
            $info .= '訂 購 時 間：'.$order_data['DateCreate'];
            $info .= '</td>';

            $info .= '<td>';
            $info .= '訂 單 編 號：'.$order_data['OrderID'];
            $info .= '<br>';
            $info .= '商品總金額：'.$order_data['TotalMerchandiseAmount'];
            $info .= '<br>';
            $info .= '運&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;費：'.$order_data['ShippingFare'];
            $info .= '<br>';
            $info .= '應加減費用：'.$order_data['OtherFare'];
            $info .= '<br>';
            $info .= '付 款 金 額：'.$order_data['TotalPayment'];
            $info .= '<br>';
            $info .= '收 貨 時 間：'.$order_data['ReceiveTime'];
            $info .= '<br>';
            $info .= '配 送 方 式：'.$order_data['ShippingFareNote'];
            $info .= '<br>';
            $info .= '出 貨 時 間：'.$order_data['DateModify'];

            $info .= '</td>';
            $info .= '</tr>';
            $info .= '<tr>';
            $info .= '<td colspan="2">';
            $info .= '配 送 地 址：'.$order_data['ReceiveAddress'];
            $info .= '</td>';
            $info .= '</tr>';

        $info .= <<<EOD
            </table>

EOD;
        $this->pdf->writeHTML($info, true, false, false, false, '');
        // ---------------------------------------------------------

        $txt = '訂 購 明 細：';
        $this->pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);


        $tbl = <<<EOD
        <table cellspacing="0" cellpadding="4" border="0" width="1900">
            <tr>
                <td align="center" width="40">項次</td>
                <td >品名</td>
                <td align="right" width="80">價格</td>
                <td align="center" width="80">出貨數量</td>
                <td align="center" width="80">訂購數量</td>
            </tr>
EOD;
        //var_dump($grid_data);
        $i = 0;
       
        foreach($grid_data as $key){
            $tbl .= '<tr>';
            $tbl .= '<td align="center">';
            $tbl .= $key->SerialNo;
            $tbl .= '</td>';
            $tbl .= '<td >';
            $tbl .= $key->Title;
            $tbl .= '</td>';
            $tbl .= '<td align="right">';
            $tbl .= $key->PriceActual;
            $tbl .= '</td>';
            $tbl .= '<td align="center">';

            switch ($type){
                case 1:
                    $tbl .= $key->ShippingCountsLastTime;
                break;
                default:
                    $tbl .= $key->ShippingCounts;
                break;
            }

            
            $tbl .= '</td>';
            $tbl .= '<td align="center">';
            $tbl .= $key->OrderCounts;
            $tbl .= '</td>';
            $tbl .= '</tr>';
    
        }
        $tbl .= <<<EOD
            <tr>
                <td align="center" colspan="5">以下空白</td>
            </tr>
        </table>
EOD;

$this->pdf->writeHTML($tbl, true, false, false, false, '');

        //Close and output PDF document
        switch ($type){
            case 1:
                @mkdir(__DIR__.'\\..\\..\\..\\order_history\\'.$order_GUID, 0700);

                $this->pdf->Output(__DIR__.'\\..\\..\\..\\order_history\\'.$order_GUID.'\\details_'.date('Y-m-d_H-i-s').'.pdf', 'F');
            break;
            default:
                $this->pdf->Output('details_'.date('Y-m-d_H-i-s').'.pdf', 'I');
            break;
        }
    }
    public function parse_display_data()
    {
        $this->lang->load('gird_column');
        $this->lang->load('button');
        $this->lang->load('contextmenu');
        $this->lang->load('menu');
        $this->lang->load('orders');
        $this->lang->load('products');
        $this->display_data = array(
            'button_close'                  => $this->lang->line('button_close'),
            'button_cancel'                 => $this->lang->line('button_cancel'),
            'button_submit'                 => $this->lang->line('button_submit'),
            'button_ok'                     => $this->lang->line('button_ok'),
            'button_search'                 => $this->lang->line('button_search'),
            'contextmenu_reload'            => $this->lang->line('contextmenu_reload'),
            'contextmenu_details'           => $this->lang->line('contextmenu_details'),
            'contextmenu_delete'            => $this->lang->line('contextmenu_delete'),
            'contextmenu_order_flow'        => $this->lang->line('contextmenu_order_flow'),
            'contextmenu_save_but_not_ship'             =>  $this->lang->line('contextmenu_save_but_not_ship'),
            'contextmenu_save_and_ship'                 =>  $this->lang->line('contextmenu_save_and_ship'),
            'contextmenu_ship_complete'                 => $this->lang->line('contextmenu_ship_complete'),
            'contextmenu_print_detail_last'             =>  $this->lang->line('contextmenu_print_detail_last'),
            'contextmenu_shipping_history_history'      => $this->lang->line('contextmenu_shipping_history_history'),
            'contextmenu_print_detail_all'              =>  $this->lang->line('contextmenu_print_detail_all'),
            'contextmenu_checkbox'                      => $this->lang->line('contextmenu_checkbox'),
            'contextmenu_palyment_confirm'              => $this->lang->line('contextmenu_palyment_confirm'),
            'contextmenu_palyment_cancel'               => $this->lang->line('contextmenu_palyment_cancel'),
            'contextmenu_shipping'                      => $this->lang->line('contextmenu_shipping'),

            'contextmenu_shipping_confirm'              => $this->lang->line('contextmenu_shipping_confirm'),
            'contextmenu_shipping_cancel'               => $this->lang->line('contextmenu_shipping_cancel'),
            'contextmenu_order_edit'                    => $this->lang->line('contextmenu_order_edit'),
            'orders_search_btn'                         => $this->lang->line('orders_search_btn'),
            'orders_search'                             => $this->lang->line('orders_search'),
            'orders_search_hint'                        => $this->lang->line('orders_search_hint'),
            'orders_deliver_not_yet'                    => $this->lang->line('orders_deliver_not_yet'),
            'orders_deliver_partial'                    => $this->lang->line('orders_deliver_partial'),
            'orders_deliver_already'                    => $this->lang->line('orders_deliver_already'),
            'orders_subscribe_not_yet'                  => $this->lang->line('orders_subscribe_not_yet'),
            'orders_payment_not_yet'                    => $this->lang->line('orders_payment_not_yet'),
            'orders_payment_already'                    => $this->lang->line('orders_payment_already'),
            'orders_shipping_type_single'               => $this->lang->line('orders_shipping_type_single'),
            'orders_shipping_type_multi'                => $this->lang->line('orders_shipping_type_multi'),
            'orders_popup_delete_msg'                   => $this->lang->line('orders_popup_delete_msg'),
            'orders_popup_delete_title'                 => $this->lang->line('orders_popup_delete_title'),
            'orders_check_one_to_save_but_not_ship'     => $this->lang->line('orders_check_one_to_save_but_not_ship'),
            'orders_no_shipping_history'                => $this->lang->line('orders_no_shipping_history'),
            'orders_edit_success_msg'                   => $this->lang->line('orders_edit_success_msg'),
            'gird_column_Name'                          => $this->lang->line('gird_column_Name'),
            'gird_column_Email'                         => $this->lang->line('gird_column_Email'),
            'gird_column_City'                          => $this->lang->line('gird_column_City'),
            'gird_column_OrderID'                       => $this->lang->line('gird_column_OrderID'),
            'gird_column_ShippingFare'                  => $this->lang->line('gird_column_ShippingFare'),
            'gird_column_OtherFare'                     => $this->lang->line('gird_column_OtherFare'),
            'gird_column_IsSubscribe'                   => $this->lang->line('gird_column_IsSubscribe'),
            'gird_column_DateSubscribe'                 => $this->lang->line('gird_column_DateSubscribe'),
            'gird_column_TotalPayment'                  => $this->lang->line('gird_column_TotalPayment'),
            'gird_column_IsPayment'                     => $this->lang->line('gird_column_IsPayment'),
            'gird_column_DatePayment'                   => $this->lang->line('gird_column_DatePayment'),
            'gird_column_TotalMerchandiseAmount'        => $this->lang->line('gird_column_TotalMerchandiseAmount'),
            'gird_column_IsShipping'                    => $this->lang->line('gird_column_IsShipping'),
            'gird_column_ShippingActualDate'            => $this->lang->line('gird_column_ShippingActualDate'),
            'gird_column_ShippingExpectNextDate'        => $this->lang->line('gird_column_ShippingExpectNextDate'),
            'gird_column_ShippingArrivalAssignDates'    => $this->lang->line('gird_column_ShippingArrivalAssignDates'),
            'gird_column_ShippingType'                  => $this->lang->line('gird_column_ShippingType'),
            'gird_column_ShippingFareNote'              => $this->lang->line('gird_column_ShippingFareNote'),
            'gird_column_customerNote'                  => $this->lang->line('gird_column_customerNote'),
            'gird_column_DateModify'                    => $this->lang->line('gird_column_DateModify'),
            'gird_column_DateCreate'                    => $this->lang->line('gird_column_DateCreate'),
            'gird_column_ProductTitle'                  => $this->lang->line('gird_column_ProductTitle'),
            'gird_column_Category'                      => $this->lang->line('gird_column_Category'),
            'gird_column_OrderCounts'                   => $this->lang->line('gird_column_OrderCounts'),
            'gird_column_ShippingCounts'                => $this->lang->line('gird_column_ShippingCounts'),
            'gird_column_PriceActual'                   => $this->lang->line('gird_column_PriceActual'),
            'gird_column_PriceSpecial'                  => $this->lang->line('gird_column_PriceSpecial'),
            'gird_column_PriceMSRP'                     => $this->lang->line('gird_column_PriceMSRP'),
            'gird_column_SerialNo'                      => $this->lang->line('gird_column_SerialNo'),
            'gird_column_ShippingCountsRemain'          => $this->lang->line('gird_column_ShippingCountsRemain'),
            'gird_column_ShippingCountsThisTime'        => $this->lang->line('gird_column_ShippingCountsThisTime'),
            'gird_column_ShippingCountsLastTime'        => $this->lang->line('gird_column_ShippingCountsLastTime'),
            'gird_column_OrderCreateTime'               => $this->lang->line('gird_column_OrderCreateTime'),
            'gird_column_OrderName'                     => $this->lang->line('gird_column_OrderName'),
            'gird_column_ReceiveName'                   => $this->lang->line('gird_column_ReceiveName'),
            'gird_column_OrderTel'                      => $this->lang->line('gird_column_OrderTel'),
            'gird_column_ReceiveTel'                    => $this->lang->line('gird_column_ReceiveTel'),
            'gird_column_OrderMobile'                   => $this->lang->line('gird_column_OrderMobile'),
            'gird_column_ReceiveMobile'                 => $this->lang->line('gird_column_ReceiveMobile'),
            'gird_column_ReceiveAddress'                => $this->lang->line('gird_column_ReceiveAddress'),
            'gird_column_ReceiveTime'                   => $this->lang->line('gird_column_ReceiveTime'),
            'gird_column_FlowID'                        => $this->lang->line('gird_column_FlowID'),
            'gird_column_FlowUserEmail'                 => $this->lang->line('gird_column_FlowUserEmail'),
            'gird_column_FlowDateCreate'                => $this->lang->line('gird_column_FlowDateCreate'),
            'gird_column_FlowStatu'                     => $this->lang->line('gird_column_FlowStatu'),
            'gird_column_FlowNote'                      => $this->lang->line('gird_column_FlowNote'),
            'gird_column_OrderNumber'                   => $this->lang->line('gird_column_OrderNumber'),
            
            'orders_receive_time_AM09PM12'      => $this->lang->line('orders_receive_time_AM09PM12'),
            'orders_receive_time_PM12PM18'      => $this->lang->line('orders_receive_time_PM12PM18'),
            'orders_receive_time_PM18PM21'      => $this->lang->line('orders_receive_time_PM18PM21'),
            'gird_column_ItemNo'                        => $this->lang->line('gird_column_ItemNo'),
            'menu_view_all'                             => $this->lang->line('menu_view_all'),
            'menu_admin_orders'                         => $this->lang->line('menu_admin_orders')

        );
        $this->build_navi();
    }
}

/* End of file order.php */
/* Location: ./application/controllers/admin/order.php */