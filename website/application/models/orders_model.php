<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Orders_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function select_data_limit_offset($top = 0, $bottom = 20 ,$column ='*' , 
                                    $IsShipping = "0,1,2",
                                    $IsSubscribe = "0,1",
                                    $IsPayment = "0,1",
                                    $ShippingType = "0,1",
                                    $sort_column_id = 'OrderID' , $order_method = 'ASC' , $search_txt = false ,$user_GUID = false,$order_GUID = false)
    {
        if($order_GUID === false){
            $query_order_GUID = "";
        }else{
            $query_order_GUID = " AND O.[GUID] = '".$order_GUID."'";
        }
        if($user_GUID === false){
            $query_user_GUID = "";
        }else{
            $query_user_GUID = " AND UserGUID = '".$user_GUID."'";
        }
        if($search_txt === false){
            $query_search = "";
        }else{
            $query_search = " AND (concat([Name], [Email]) LIKE '%".$search_txt."%')";
        }
        if(is_array($column)){
            $column = join(",", $column);
        }

        $number_rows = $bottom - $top + 1 ;
        $query_rows = $this->db->query(
            "SELECT ".$column."
            FROM 
                (
	                [dbo].[i_order] AS O
	                LEFT JOIN 
	                [dbo].[i_user] AS U
	                ON
	                O.[UserGUID] = U.[GUID]
                )
            WHERE [IsShipping] IN (".$IsShipping.") AND 
                  [IsSubscribe] IN (".$IsSubscribe.") AND 
                  [IsPayment] IN (".$IsPayment.") AND 
                  [ShippingType] IN (".$ShippingType.")  
            ".$query_order_GUID."
            ".$query_user_GUID."
            ".$query_search."
            ORDER BY ".$sort_column_id." ".$order_method."
            OFFSET ".$top."  ROWS
            FETCH NEXT ".$number_rows." ROWS ONLY"
        );
        //echo $this->db->last_query();
        $query_all_list = $this->db->query("SELECT O.[GUID] AS [GUID] FROM (
	                [dbo].[i_order] AS O
	                LEFT JOIN 
	                [dbo].[i_user] AS U
	                ON
	                O.[UserGUID] = U.[GUID]
                ) WHERE [IsShipping] IN (".$IsShipping.") AND 
                  [IsSubscribe] IN (".$IsSubscribe.") AND 
                  [IsPayment] IN (".$IsPayment.") AND 
                  [ShippingType] IN (".$ShippingType.")  
            ".$query_order_GUID."
            ".$query_user_GUID."
            ".$query_search."
            ORDER BY ".$sort_column_id." ".$order_method

        );
        $GUID = array();
        foreach ($query_all_list->result_array() as $row)
        {
            array_push($GUID, $row['GUID']);
        }
        $result = array(
            'object' => $query_rows,
            'num_rows' => $query_all_list->num_rows(),
            'GUID_list' => $GUID
        );
        return $result;
    }
    function retrieve_orderflow($order_GUID , $column_orderflow ='*' , $column_order ='*')
    {
        if(is_array($column_order)){
            $column_order = join(",", $column_order);
        }
        $order_row = $this->db->query(
            "SELECT ".$column_order."
            FROM 
                (
	                [dbo].[i_order] AS O
	                LEFT JOIN 
	                [dbo].[i_user] AS U
	                ON
	                O.[UserGUID] = U.[GUID]
                )
            WHERE O.[GUID] = '".$order_GUID."'"
        );
        if(is_array($column_orderflow)){
            $column_orderflow = join(",", $column_orderflow);
        }

        $flow = $this->db->query(
            "SELECT ".$column_orderflow."
            FROM 
                [dbo].[i_order_flow] AS F
            WHERE F.[OrderGUID] = '".$order_GUID."' 
            ORDER BY [DateCreate] ASC"
        );
        $result = array(
            'flow' => array(
                'object' => $flow,
                'num_rows' => $flow->num_rows()
            ),
            'order' => array(
                'object' => $order_row
            )
            
        );
        return $result;
    }
    function retrieve_details($order_GUID , $column_details ='*' , $column_order ='*')
    {
        if(is_array($column_order)){
            $column_order = join(",", $column_order);
        }
        $order_row = $this->db->query(
            "SELECT ".$column_order."
            FROM 
                (
	                [dbo].[i_order] AS O
	                LEFT JOIN 
	                [dbo].[i_user] AS U
	                ON
	                O.[UserGUID] = U.[GUID]
                )
            WHERE O.[GUID] = '".$order_GUID."'"
        );

        if(is_array($column_details)){
            $column_details = join(",", $column_details);
        }

        $details = $this->db->query(
            "SELECT ".$column_details."
            FROM 
                (
                    [dbo].[i_order_details] AS D
                    LEFT JOIN
                    [dbo].[i_products_category] AS C
                    ON 
	                D.[Category] = C.[GUID]
                )
            WHERE [OrderGUID] = '".$order_GUID."'
            ORDER BY [DateCreate] ASC"
        );

        $result = array(
            'details' => array(
                'object' => $details,
                'num_rows' => $details->num_rows()
            ),
            'order' => array(
                'object' => $order_row
            )
            
        );
        return $result;
    }
    public function retrieve_shopping_fare_in_shopping_car($column ='*' , $user_GUID , $session_id = FALSE, $order_GUID = FALSE)
    {
        if(is_array($column)){
            $column = join(",", $column);
        }

        $query_by_user_GUID = "";
        $query_by_session_id = "";
        if($order_GUID === FALSE){
            $query_by_order_GUID = "[OrderGUID] is NULL";
        }else{
            $query_by_order_GUID = "[OrderGUID] = '".$order_GUID."' ";
        }
        if($user_GUID){
            $query_by_user_GUID = " AND (UserGUID = '".$user_GUID."' OR SessionID = '".$session_id."') ";
        }else{
            if($session_id){
                $query_by_session_id = " AND SessionID = '".$session_id."' ";
            }        
        }
        $query = $this->db->query("
            SELECT CAST(SUM ([ShippingFare] * [PackingCount]) AS INT)  AS [ShippingTotalAmount] FROM
            (
                SELECT Category , CategoryCounts , ShippingLimit , ShippingFare , ceiling(CAST(CategoryCounts AS float) /ShippingLimit)  AS PackingCount
                FROM 
                (           
                    SELECT ".$column."
                    FROM 
                        [dbo].[i_order_details]
                    WHERE "
                    .$query_by_order_GUID
                    .$query_by_user_GUID 
                    .$query_by_session_id .
                    "GROUP BY [Category]
                ) as t1
                LEFT JOIN	
	                (SELECT * FROM [dbo].[i_products_category] ) AS t2
                ON t1.Category = t2.GUID
            ) AS t3
            ");
        return $query;
        
    }
    public function retrieve_merchandise_fare_in_shopping_car($column ='*' , $user_GUID , $session_id = FALSE, $order_GUID = FALSE)
    {
        if(is_array($column)){
            $column = join(",", $column);
        }

        $query_by_user_GUID = "";
        $query_by_session_id = "";
        if($order_GUID === FALSE){
            $query_by_order_GUID = "[OrderGUID] is NULL";
        }else{
            $query_by_order_GUID = "[OrderGUID] = '".$order_GUID."' ";
        }
        if($user_GUID){
            $query_by_user_GUID = " AND (UserGUID = '".$user_GUID."' OR SessionID = '".$session_id."') ";
        }else{
            if($session_id){
                $query_by_session_id = " AND SessionID = '".$session_id."' ";
            }        
        }
        $query = $this->db->query(
            "SELECT ".$column."
            FROM 
                [dbo].[i_order_details]
            WHERE "
            .$query_by_order_GUID
            .$query_by_user_GUID 
            .$query_by_session_id 
        );
        return $query;
    }    
    public function retrieve_shopping_car($column ='*' , $user_GUID , $session_id = FALSE, $order_GUID = FALSE)
    {
        if(is_array($column)){
            $column = join(",", $column);
        }

        $query_by_user_GUID = "";
        $query_by_session_id = "";
        if($order_GUID === FALSE){
            $query_by_order_GUID = "[OrderGUID] is NULL";
        }else{
            $query_by_order_GUID = "[OrderGUID] = '".$order_GUID."' ";
        }
        if($user_GUID){
            $query_by_user_GUID = " AND (UserGUID = '".$user_GUID."' OR SessionID = '".$session_id."') ";
        }else{
            if($session_id){
                $query_by_session_id = " AND SessionID = '".$session_id."' ";
            }        
        }
        $query = $this->db->query(
            "SELECT ".$column."
            FROM 
                (
	                [dbo].[i_order_details] AS D
	                LEFT JOIN 
	                [dbo].[i_products] AS P
	                ON
	                D.[ProductGUID] = P.[GUID]
                )
            WHERE "
            .$query_by_order_GUID
            .$query_by_user_GUID 
            .$query_by_session_id .

            "ORDER BY [SerialNo] ASC"
        );
        
        $result = array(
            'object' => $query,
            'num_rows' => $query->num_rows()
        );
        return $result;

    }
    public function calc_merchandise_amount($order_GUID)
    {
        $query = $this->db->query(
            "SELECT 
                SUM(Total) AS MerchandiseAmount
            FROM (
		            SELECT  
                            (PriceActual * OrderCounts) AS Total
                        FROM 
	                            [dbo].[i_order_details]
                        WHERE [OrderGUID] = '".$order_GUID."'
            )AS T"
        );

        $data = $query->row();

        return $data->MerchandiseAmount;
    }
    public function retrieve_latest_info($column ='*' , $user_GUID)
    {
        if(is_array($column)){
            $column = join(",", $column);
        }
        $query = $this->db->query(
            "SELECT ".$column."
            FROM 
                [dbo].[i_user]
            WHERE GUID = '"
            .$user_GUID."'"
        );
        return $query;
    }
    public function send_mail_to_admin_as_subscribe()
    {
        $display_data = array(
            'base_url' => base_url()
        );
        $this->lang->load('orders');
        $this->config->load('email');
        $this->load->library('email');
        $admin_mail = $this->config->item('admin_mail');
        $this->email->from($this->lang->line('orders_send_mail_subscribe_to_admin_address') , $this->lang->line('orders_send_mail_subscribe_to_admin_name') );
        $this->email->to( $admin_mail ); 
        $this->email->subject( $this->lang->line('orders_send_mail_subscribe_to_admin_subject') );
        $msg = $this->parser->parse('order/send_mail_to_admin_as_subscribe_msg', $display_data ,true);
        $this->email->message( $msg ); 

        if( $this->email->send() ){
            $is_send_success = TRUE;
        }else{
            $is_send_success = FALSE;
        }

        return $is_send_success;
    }
    public function send_mail_subscribe()
    {
        $this->lang->load('orders');
        $this->load->library('email');

        $name = $this->session->userdata('Name');
        $email = $this->session->userdata('Email');
        $GUID = $this->session->userdata('GUID');

        $display_data = array(
            'Name' => $name,
            'Email' => $email,
            'GUID' => $GUID,
            'base_url' => base_url()
        );
        $this->email->from($this->lang->line('orders_send_mail_subscribe_address') , $this->lang->line('orders_send_mail_subscribe_name') );
        $this->email->to( $email ); 
        $this->email->subject( $this->lang->line('orders_send_mail_subscribe_subject') );
        $msg = $this->parser->parse('order/send_mail_subscribe_msg', $display_data ,true);
        $this->email->message( $msg ); 

        if( $this->email->send() ){
            $is_send_success = TRUE;
        }else{
            $is_send_success = FALSE;
        }

        return $is_send_success;
    }
}

/* End of file products_model.php */
/* Location: ./application/model/products_model.php */