<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends Site_Base_Controller {
    private $display_data = array(
        "highlight_main_list" => "market",
        "highlight_sub_lsit" => 0,
        "session_control" => "session_not_exist"
    );
    private $UI_columns = array(
        "RANK() OVER( ORDER BY [DetailID]) AS [SerialNo] "
        ,'[DetailID]'
        ,'D.[GUID] AS [O_GUID]'
        ,'[OrderGUID]'
        ,'[SessionID]'
        ,'[UserGUID]'
        ,'[ProductGUID]'
        ,'P.[Title]'
        ,'P.[CoverImageThumbURLPath]'
        ,'D.[Category]'
        //,'D.[ShortDesc]'
        ,"REPLACE(CONVERT(NVARCHAR(20), D.[PriceMSRP], 1), '.00', '') AS [PriceMSRP]"
        ,"REPLACE(CONVERT(NVARCHAR(20), D.[PriceSpecial], 1), '.00', '') AS [PriceSpecial]"
        ,"REPLACE(CONVERT(NVARCHAR(20), D.[PriceActual], 1), '.00', '') AS [PriceActual]"
        ,'[ShippingCounts]'
        ,'[ShippingCountsThisTime]'
        ,'[OrderCounts]'
        ,'P.[Stock] AS [Stock]'
        ,"CONVERT(VARCHAR(17) , SWITCHOFFSET (D.DateCreate, '+00:00') ,113)  AS [DateCreate]"
        ,"CONVERT(VARCHAR(17) , SWITCHOFFSET (D.DateModify, '+00:00'),113 )  AS [DateModify]"
    );
    private $UI_history_columns = array(
            "U.[Name] AS [Name]",
            "U.[Email] AS [Email]",
            "U.[City] AS [City]",
            "U.[Gender] AS [Gender]",
            "O.[OrderID] AS [OrderID]",
            "O.[GUID] AS [GUID]",
            "O.[GUID] AS [OrderGUID]",
            "O.[UserGUID] AS [UserGUID]",
            "REPLACE(CONVERT(NVARCHAR(20), O.[ShippingFare], 1), '.00', '') AS [ShippingFare]",
            "REPLACE(CONVERT(NVARCHAR(20), O.[OtherFare], 1), '.00', '') AS [OtherFare]",
            "O.ShippingFareNote"  =>  "[ShippingFareNote]",

            "O.[IsSubscribe] AS [IsSubscribe]",
            "O.[DateSubscribe] AS [DateSubscribe]",
            "REPLACE(CONVERT(NVARCHAR(20), O.[TotalPayment], 1), '.00', '')AS [TotalPayment]",
            "REPLACE(CONVERT(NVARCHAR(20), O.[TotalMerchandiseAmount], 1), '.00', '')AS [TotalMerchandiseAmount]",
            "O.[IsPayment] AS [IsPayment]",
            "O.[DatePayment] AS [DatePayment]",
            "O.[IsShipping] AS [IsShipping]",
	        "CONVERT(VARCHAR(17) , SWITCHOFFSET (O.[ShippingActualDate], '+00:00') ,113) AS [ShippingActualDate]",
            "O.[ShippingExpectNextDate] AS [ShippingExpectNextDate]",
            "O.[ShippingArrivalAssignDate] AS [ShippingArrivalAssignDate]",
            "O.[ShippingType] AS [ShippingType]",
            "O.[CustomerNote] AS [CustomerNote]",
	        "CONVERT(VARCHAR(17) , SWITCHOFFSET (O.[DateCreate], '+00:00') ,113) AS [DateCreate]",
	        "CONVERT(VARCHAR(17) , SWITCHOFFSET (O.[DateModify], '+00:00') ,113) AS [DateModify]",
            "O.[OrderName] AS [OrderName]",
            "O.[OrderTel] AS [OrderTel]",
            "O.[OrderMobile] AS [OrderMobile]",
            "O.[ReceiveName] AS [ReceiveName]",
            "O.[ReceiveTel] AS [ReceiveTel]",
            "O.[ReceiveMobile] AS [ReceiveMobile]",
            "O.[ReceiveAddress] AS [ReceiveAddress]",
            "O.[ReceiveBankAccount] AS [ReceiveBankAccount]",
            "O.[ReceiveTime] AS [ReceiveTime]"
    );
    private $UI_user_columns = array(
          "[ReceiveName]"
          ,"[ReceiveTel]"
          ,"[ReceiveMobile]"
          ,"[ReceiveAddress]"
          ,"[ReceiveBankAccount]"
          ,"[ReceiveTime]"
          ,"[ReceiveZipCode]"
          ,"[OrderName]"
          ,"[OrderTel]"
          ,"[OrderMobile]"
    );
    private $UI_columns_merchandise_fare = array(
         "CAST(SUM ([OrderCounts] * [PriceSpecial]) AS INT)   AS [MerchandiseTotalAmount]"
    );
    private $UI_columns_shopping_fare = array(
        "Category", 
        "SUM(OrderCounts) AS CategoryCounts",
        "CEILING(70/10) AS PackingCount"
    );
    
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();
        $this->load->model('easydb_model');
        $this->load->model('register_model');
        $this->load->model('error_model');
        $this->load->model('orders_model');
        
        if( $this->session->userdata('user_exist') === true){
            $this->display_data['session_control'] = "session_exist";
        }
        $this->display_data["order_num_rows"] = $this->retrieve_order_num_rows();
        
        $session_data = $this->register_model->retrieve_user_session();

        if( !$this->session->userdata('user_exist') ){
            $this->session->set_userdata('go_back', $this->uri->uri_string());
            redirect( base_url().'login/normal' , 'refresh');
        }
        if($this->session->userdata('Rank') == 1){
            redirect( base_url().'register/normal_register_success' , 'refresh');
        }

    }
    public function shopping_car()
    {
        $session_data = $this->register_model->retrieve_user_session();
        //get by session and user HUID
        $session_id = $this->session->userdata('session_id');  //236b49d78afea90c944690dc58dc400b
        $user_GUID = $this->session->userdata('GUID');         //03E580E2-69CA-4533-A4D2-F80961DDE470
        
        $result = $this->orders_model->retrieve_shopping_car($this->UI_columns ,$user_GUID , $session_id);
        $latest_info = $this->orders_model->retrieve_latest_info($this->UI_user_columns ,$user_GUID);
        $latest_info_data = $latest_info->row();
        $data = array(
            'order_data' => (array) $result['object']->result(),
            'order_data2' => (array) $result['object']->result(),
            'order_num_rows' => $result['num_rows'],
            'ReceiveName' => $latest_info_data->ReceiveName,
            'ReceiveTel'=> $latest_info_data->ReceiveTel,
            'ReceiveMobile'=> $latest_info_data->ReceiveMobile,
            'ReceiveAddress'=> $latest_info_data->ReceiveAddress,
            'ReceiveBankAccount'=> $latest_info_data->ReceiveBankAccount,
            'ReceiveTime'=> $latest_info_data->ReceiveTime,
            'OrderName'=> $latest_info_data->OrderName,
            'OrderTel'=> $latest_info_data->OrderTel,
            'OrderMobile'=> $latest_info_data->OrderMobile,
            'ReceiveZipCode' => $latest_info_data->ReceiveZipCode
        );
        if($result['num_rows'] == 0){
            redirect( base_url().'market/category' , 'refresh');

        }
        $display_data = array_merge($session_data , $this->display_data , $data);


        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
        $this->parser->parse('order/shopping_car', $display_data);
        $this->load->view('_default/footer');

    }
    public function history_detail($GUID)
    {
        $session_data = $this->register_model->retrieve_user_session();
        $this->display_data["highlight_main_list"] = "member";
        $this->display_data["highlight_sub_lsit"] = 1;
        $this->display_data['orders_history_detail_welcome_msg'] = sprintf( $this->lang->line('orders_history_detail_welcome_msg'),$session_data['Name']);

        $result_info = $this->orders_model->select_data_limit_offset(0 , 1 , $this->UI_history_columns ,
                                    "0,1,2",
                                    "0,1",
                                    "0,1",
                                    "0,1",
                                    'OrderID' ,'DESC' , FALSE ,$session_data['GUID'] , $GUID);
        $result_datail = $this->orders_model->retrieve_shopping_car($this->UI_columns ,$session_data['GUID'] ,FALSE , $GUID);
        $result_data = $this->orders_model->select_data_limit_offset(0 , 9999 , $this->UI_history_columns ,
                                    "0,1,2",
                                    "0,1",
                                    "0,1",
                                    "0,1",
                                    'OrderID' ,'DESC' , FALSE ,$session_data['GUID']);
        $order_data = (array) $result_data['object']->result();
        foreach($order_data as $key){
            if($key->IsSubscribe == 0){
                $key->Status =  $this->display_data['orders_IsSubscribe_N'];
            }else{
                $key->Status = $this->display_data['orders_IsPayment_N'];
                if($key->IsPayment == 1){
                    $key->Status = $this->display_data['orders_IsPayment_Y'];
                    if($key->IsShipping == 1){
                        $key->Status = $this->display_data['orders_IsShipping_Y'];
                    }else{
                        $key->Status = $this->display_data['orders_IsShipping_N'];
                   }
                }
            }
        }
        $data = array(
            'order_info' => (array) $result_info['object']->row(),
            'order_datail' => (array) $result_datail['object']->result(),
            'order_data' => $order_data
        );

        $display_data = array_merge($session_data , $this->display_data ,$data);
        $display_data['orders_query_detail_welcome_msg'] = sprintf( $this->lang->line('orders_query_detail_welcome_msg'),$session_data['Name']);
        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
        $this->parser->parse('order/history_detail', $display_data);
        $this->load->view('_default/footer');
    }
    public function history()
    {
        $session_data = $this->register_model->retrieve_user_session();
        $this->display_data["highlight_main_list"] = "member";
        $this->display_data["highlight_sub_lsit"] = 1;
        $this->display_data['orders_history_welcome_msg'] = sprintf( $this->lang->line('orders_history_welcome_msg'),$session_data['Name']);
        $this->display_data['orders_history_empty_welcome_msg'] = sprintf( $this->lang->line('orders_history_empty_welcome_msg'),$session_data['Name']);
        
        $result = $this->orders_model->select_data_limit_offset(0 , 9999 , $this->UI_history_columns ,
                                    "0,1,2",
                                    "0,1",
                                    "0,1",
                                    "0,1",
                                    'OrderID' ,'DESC' , FALSE ,$session_data['GUID']);
        $order_data = (array) $result['object']->result();
        foreach($order_data as $key){
            if($key->IsSubscribe == 0){
                $key->Status =  $this->display_data['orders_IsSubscribe_N'];
            }else{
                $key->Status = $this->display_data['orders_IsPayment_N'];
                if($key->IsPayment == 1){
                    $key->Status = $this->display_data['orders_IsPayment_Y'];
                    if($key->IsShipping == 1){
                        $key->Status = $this->display_data['orders_IsShipping_Y'];
                   }else{
                        $key->Status = $this->display_data['orders_IsShipping_N'];
                   }
                }
            }
        }

        $data = array(
            'order_data' => $order_data,
            'order_num_rows_by_user' => $result['num_rows']
        );
       $display_data = array_merge($session_data , $this->display_data ,$data);


        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
        if($data['order_num_rows_by_user'] == 0){
            $this->parser->parse('order/history_empty', $display_data);
        }else{
            $this->parser->parse('order/history', $display_data);
        }
        $this->load->view('_default/footer');
    }
    public function query_detail($GUID)
    {
        $session_data = $this->register_model->retrieve_user_session();
        $this->display_data["highlight_main_list"] = "member";
        $this->display_data["highlight_sub_lsit"] = 2;
        $this->display_data['orders_query_welcome_msg'] = sprintf( $this->lang->line('orders_query_welcome_msg'),$session_data['Name']);

        $result_info = $this->orders_model->select_data_limit_offset(0 , 1 , $this->UI_history_columns ,
                                    "0",
                                    "0,1",
                                    "0,1",
                                    "0,1",
                                    'OrderID' ,'DESC' , FALSE ,$session_data['GUID'] , $GUID);
        $result_datail = $this->orders_model->retrieve_shopping_car($this->UI_columns ,$session_data['GUID'] ,FALSE , $GUID);
        $result_data = $this->orders_model->select_data_limit_offset(0 , 9999 , $this->UI_history_columns ,
                                    "0",
                                    "0,1",
                                    "0,1",
                                    "0,1",
                                    'OrderID' ,'DESC' , FALSE ,$session_data['GUID']);
        $order_data = (array) $result_data['object']->result();
        foreach($order_data as $key){
            if($key->IsSubscribe == 0){
                $key->Status =  $this->display_data['orders_IsSubscribe_N'];
            }else{
                $key->Status = $this->display_data['orders_IsPayment_N'];
                if($key->IsPayment == 1){
                    $key->Status = $this->display_data['orders_IsPayment_Y'];
                    if($key->IsShipping == 1){
                        $key->Status = $this->display_data['orders_IsShipping_Y'];
                    }else{
                        $key->Status = $this->display_data['orders_IsShipping_N'];
                    }
                }
            }
        }
        $data = array(
            'order_info' => (array) $result_info['object']->row(),
            'order_datail' => (array) $result_datail['object']->result(),
            'order_data' => $order_data
        );

        $display_data = array_merge($session_data , $this->display_data ,$data);
        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
        $this->parser->parse('order/query_detail', $display_data);
        $this->load->view('_default/footer');    }
    public function query()
    {
        $session_data = $this->register_model->retrieve_user_session();
        $this->display_data["highlight_main_list"] = "member";
        $this->display_data["highlight_sub_lsit"] = 2;
        $this->display_data['orders_query_welcome_msg'] = sprintf( $this->lang->line('orders_query_welcome_msg'),$session_data['Name']);
        $this->display_data['orders_query_empty_welcome_msg'] = sprintf( $this->lang->line('orders_query_empty_welcome_msg'),$session_data['Name']);
        
        $result = $this->orders_model->select_data_limit_offset(0 , 9999 , $this->UI_history_columns ,
                                    "0",
                                    "0,1",
                                    "0,1",
                                    "0,1",
                                    'OrderID' ,'DESC' , FALSE ,$session_data['GUID']);
        $order_data = (array) $result['object']->result();
        foreach($order_data as $key){
            if($key->IsSubscribe == 0){
                $key->Status =  $this->display_data['orders_IsSubscribe_N'];
            }else{
                $key->Status = $this->display_data['orders_IsPayment_N'];
                if($key->IsPayment == 1){
                    $key->Status = $this->display_data['orders_IsPayment_Y'];
                    if($key->IsShipping == 1){
                        $key->Status = $this->display_data['orders_IsShipping_Y'];
                    }else{
                        $key->Status = $this->display_data['orders_IsShipping_N'];
                   }
                }
            }
        }

         $data = array(
            'order_data' => $order_data,
            'order_num_rows_by_user' => $result['num_rows']
        );
       $display_data = array_merge($session_data , $this->display_data ,$data);


        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
        if($data['order_num_rows_by_user'] == 0){
            $this->parser->parse('order/query_empty', $display_data);
        }else{
            $this->parser->parse('order/query', $display_data);
        }
        $this->load->view('_default/footer');    
    }
    public function cacl_fare()
    {
        $session_data = $this->register_model->retrieve_user_session();
        //get by session and user HUID
        $session_id = $this->session->userdata('session_id');  //236b49d78afea90c944690dc58dc400b
        $user_GUID = $this->session->userdata('GUID');         //03E580E2-69CA-4533-A4D2-F80961DDE470
        
        $result = $this->orders_model->retrieve_merchandise_fare_in_shopping_car($this->UI_columns_merchandise_fare ,$user_GUID , $session_id);
        $result2 = $this->orders_model->retrieve_shopping_fare_in_shopping_car($this->UI_columns_shopping_fare ,$user_GUID , $session_id);
        
        $data = array(
            'total_merchandise_amount'=> $result->row()->MerchandiseTotalAmount,
            'total_shippount_amount'=> $result2->row()->ShippingTotalAmount,
            'total_amount' => ($result->row()->MerchandiseTotalAmount + $result2->row()->ShippingTotalAmount)
        );
        
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    public function change_order_count()
    {
        $update_query = $this->db->query(
            "UPDATE [dbo].[i_order_details] 
            SET 
                [OrderCounts] = ".$this->input->post('OrderCounts',true)." ,
                [DateModify] = '".date('Y-m-d H:i:s')."'
            WHERE 
                [GUID] = '".$this->input->post('GUID',true)."'");

        header('Content-Type: application/json');
        if($update_query == true){
            echo $this->error_model->retrieve_error_msg(0,NULL,$update_query);
        }else{
            echo $this->error_model->retrieve_error_msg(4);
        }
    }
    public function subscribe()
    {
        $session_data = $this->register_model->retrieve_user_session();
        //get by session and user HUID
        $session_id = $this->session->userdata('session_id');  //236b49d78afea90c944690dc58dc400b
        $user_GUID = $this->session->userdata('GUID');         //03E580E2-69CA-4533-A4D2-F80961DDE470

        $result_amount = $this->orders_model->retrieve_merchandise_fare_in_shopping_car($this->UI_columns_merchandise_fare ,$user_GUID , $session_id);
        $result2_amount = $this->orders_model->retrieve_shopping_fare_in_shopping_car($this->UI_columns_shopping_fare ,$user_GUID , $session_id);
        
        $data_amount = array(
            'total_merchandise_amount'=> $result_amount->row()->MerchandiseTotalAmount,
            'total_shippount_amount'=> $result2_amount->row()->ShippingTotalAmount,
            'total_amount' => ($result_amount->row()->MerchandiseTotalAmount + $result2_amount->row()->ShippingTotalAmount)
        );

        $this->load->model('flow_model');
        $this->load->library('uuid');
        $data = array(
            'GUID' => strtoupper($this->uuid->v4()),
            'UserGUID' => $this->session->userdata('GUID'),
            'ShippingFare' => $data_amount['total_shippount_amount'],
            'ShippingFareNote' => $this->input->post('shipping_fare_note',true),
            'IsSubscribe' => 1,
            'DateSubscribe' => date('Y-m-d H:i:s'),
            'TotalPayment' => $data_amount['total_amount'],
            'TotalMerchandiseAmount' => $data_amount['total_merchandise_amount'],
            'ReceiveName' => $this->input->post('receive_name',true),
            'ReceiveTel' => $this->input->post('receive_tel',true),
            'ReceiveMobile' => $this->input->post('receive_mobile',true),
            'OrderName' => $this->input->post('order_name',true),
            'OrderTel' => $this->input->post('order_tel',true),
            'OrderMobile' => $this->input->post('order_mobile',true),
            'ReceiveAddress' => $this->input->post('receive_address',true),
            'ReceiveBankAccount' => $this->input->post('receive_bank_account',true),
            'ReceiveTime' => $this->input->post('receive_time',true),
            'DateModify' => date('Y-m-d H:i:s'),
            'DateCreate' => date('Y-m-d H:i:s')

        );
        $str = $this->db->insert_string('[dbo].[i_order]',$data);
        $insert_query = $this->db->query( $str );
        $data_user = array(
            'ReceiveName' => $this->input->post('receive_name',true),
            'ReceiveTel' => $this->input->post('receive_tel',true),
            'ReceiveMobile' => $this->input->post('receive_mobile',true),
            'ReceiveTime' => $this->input->post('receive_time',true),
            'OrderName' => $this->input->post('order_name',true),
            'OrderTel' => $this->input->post('order_tel',true),
            'OrderMobile' => $this->input->post('order_mobile',true),
            'ReceiveAddress' => $this->input->post('receive_address_user',true),
            'ReceiveZipCode' => $this->input->post('receive_zip_code',true),
            'ReceiveBankAccount' => $this->input->post('receive_bank_account',true)
        );
        $this->db->update('[dbo].[i_user]', $data_user, array('GUID' => $this->session->userdata('GUID')));

        $this->flow_model->record($data['GUID'] , 'OA');


        $update_i_order_details_query = $this->db->query(
            "UPDATE [dbo].[i_order_details] 
            SET 
                [OrderGUID] = '".$data['GUID']."',
                [PriceActual] = [PriceSpecial]
            WHERE 
                [GUID] IN (".$this->input->post('product_guid',true).")" 
        );
        /*
        $merchandise_amount = $this->orders_model->calc_merchandise_amount($data['GUID']);
        $update_i_order_query = $this->db->query(
            "UPDATE [dbo].[i_order] 
            SET 
                [TotalMerchandiseAmount] = ".$merchandise_amount." ,
                [TotalPayment] = ".($merchandise_amount+intval($this->input->post('shipping_fare',true)))."
            WHERE 
                [GUID] = '".$data['GUID']."' "
        );
        */
        header('Content-Type: application/json');
        if($insert_query == true && $update_i_order_details_query == true){
            $this->orders_model->send_mail_subscribe();
            $this->orders_model->send_mail_to_admin_as_subscribe();
            
            echo $this->error_model->retrieve_error_msg(0,NULL,$data);
        }else{
            echo $this->error_model->retrieve_error_msg(4);
        }
    }   
    public function delete_detail()
    {
        header('Content-Type: application/json');
        $GUID = $this->input->post('GUID',true);
        $delete_query = $this->db->query("DELETE FROM [dbo].[i_order_details] WHERE GUID = '". $GUID ."'");

        $session_id = $this->session->userdata('session_id');  //236b49d78afea90c944690dc58dc400b
        $user_GUID = $this->session->userdata('GUID');         //03E580E2-69CA-4533-A4D2-F80961DDE470
        
        $result = $this->orders_model->retrieve_shopping_car($this->UI_columns ,$user_GUID , $session_id);
        $data = array('order_num_rows' => $result['num_rows'] );

        if($delete_query == true){
            echo $this->error_model->retrieve_error_msg(0,NULL,$data);
        }else{
            echo $this->error_model->retrieve_error_msg(4);
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
        $display_data = array(
            'button_close'                  => $this->lang->line('button_close'),
            'button_cancel'                 => $this->lang->line('button_cancel'),
            'button_submit'                 => $this->lang->line('button_submit'),
            'button_ok'                     => $this->lang->line('button_ok'),
            'button_query'                  => $this->lang->line('button_query'),
            'contextmenu_delete'            => $this->lang->line('contextmenu_delete'),
            'contextmenu_details'           => $this->lang->line('contextmenu_details'),
            'gird_column_OrderStatus'       => $this->lang->line('gird_column_OrderStatus'),
            'gird_column_DateModify'        => $this->lang->line('gird_column_DateModify'),
            'gird_column_ProductTitle'      => $this->lang->line('gird_column_ProductTitle'),
            'gird_column_PriceSpecial'      => $this->lang->line('gird_column_PriceSpecial'),
            'gird_column_OrderCounts'       => $this->lang->line('gird_column_OrderCounts'),
            'gird_column_Stock'             => $this->lang->line('gird_column_Stock'),
            'gird_column_ReceiveName'           => $this->lang->line('gird_column_ReceiveName'),
            'gird_column_ReceiveTel'            => $this->lang->line('gird_column_ReceiveTel'),
            'gird_column_ReceiveMobile'            => $this->lang->line('gird_column_ReceiveMobile'),
            'gird_column_OrderName'           => $this->lang->line('gird_column_OrderName'),
            'gird_column_OrderTel'            => $this->lang->line('gird_column_OrderTel'),
            'gird_column_OrderMobile'            => $this->lang->line('gird_column_OrderMobile'),
            'gird_column_ReceiveAddress'        => $this->lang->line('gird_column_ReceiveAddress'),
            'gird_column_ReceiveBankAccount'    => $this->lang->line('gird_column_ReceiveBankAccount'),
            'gird_column_ReceiveTime'           => $this->lang->line('gird_column_ReceiveTime'),
            'gird_column_ShippingType'          => $this->lang->line('gird_column_ShippingType'),
            'gird_column_ShippingType_normal'   => $this->lang->line('gird_column_ShippingType_normal'),
            'gird_column_ShippingType_cool'     => $this->lang->line('gird_column_ShippingType_cool'),
            'gird_column_OrderNumber'           => $this->lang->line('gird_column_OrderNumber'),
            'gird_column_ShippingActualDate'    => $this->lang->line('gird_column_ShippingActualDate'),
            'gird_column_TotalPayment'          => $this->lang->line('gird_column_TotalPayment'),
            'orders_same_as_contact'             => $this->lang->line('orders_same_as_contact'),
            'orders_same_as_first_time'             => $this->lang->line('orders_same_as_first_time'),
            'orders_note_tel_mobile'            => $this->lang->line('orders_note_tel_mobile'),
            'orders_receive_time_select_one'    => $this->lang->line('orders_receive_time_select_one'),
            'orders_receive_time_AM09PM12'      => $this->lang->line('orders_receive_time_AM09PM12'),
            'orders_receive_time_PM12PM18'      => $this->lang->line('orders_receive_time_PM12PM18'),
            'orders_receive_time_PM18PM21'      => $this->lang->line('orders_receive_time_PM18PM21'),
            'orders_total_amount'               => $this->lang->line('orders_total_amount'),
            'orders_IsSubscribe_Y'        => $this->lang->line('orders_IsSubscribe_Y'),
            'orders_IsSubscribe_N'        => $this->lang->line('orders_IsSubscribe_N'),
            'orders_IsPayment_Y'        => $this->lang->line('orders_IsPayment_Y'),
            'orders_IsPayment_N'        => $this->lang->line('orders_IsPayment_N'),
            'orders_IsShipping_Y'        => $this->lang->line('orders_IsShipping_Y'),
            'orders_IsShipping_N'        => $this->lang->line('orders_IsShipping_N'),
            'orders_total_merchandise_fare'     => $this->lang->line('orders_total_merchandise_fare'),
            'orders_total_shipping_fare'    => $this->lang->line('orders_total_shipping_fare'),
            'orders_query_detail_welcome_msg'    => $this->lang->line('orders_query_detail_welcome_msg')
        );
        $this->display_data = array_merge($this->display_data, $display_data );

    }
}

/* End of file market.php */
/* Location: ./application/controllers/market.php */