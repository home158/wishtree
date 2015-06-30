<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notify extends Admin_Base_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();
    }
    private $UI_columns = array(
            "N.[NotifyID] AS [NotifyID]",
            "N.[GUID] AS [GUID]",
            //"N.[ProductGUID] AS [ProductGUID]",
            //"N.[UserGUID] AS [UserGUID]",
            "N.[NotifyTimes] AS [NotifyTimes]",
            "P.[Title] AS [ProductTitle]",
            "N.[Email] AS [Email]",
            "U.[Name] AS [Name]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (N.[LastNotifyDate], '+00:00') ,113)  AS [LastNotifyDate]",
            "CONVERT(VARCHAR(17) , SWITCHOFFSET (N.[DateCreate], '+00:00') ,113)  AS [DateCreate]"
    );
    private $db_sending_mail_column = array(
	        "DISTINCT	P.[GUID] AS [ProductGUID]",
			"N.[Email] AS [Email]",
			"P.[Title] AS [ProductTitle]", 
			"U.[Name] AS [Name]"
    );
    public function view()
	{
        $display_data = $this->display_data;
        $ProductGUID = $this->input->post('ProductGUID',true);
        $top = 0;
        $bottom =37;
        
        $this->load->model('notify_model');

        $query = $this->notify_model->select_data_limit_offset('[dbo].[i_product_notifications]' , $top , $bottom , $this->UI_columns , $ProductGUID);
        $data = array(
            'grid_data' => json_encode($query['object']->result()),
            'num_rows' => $query['num_rows'],
            'GUID_list' => json_encode( $query['GUID_list'] ),
            'ProductGUID' => $ProductGUID
        );

        $this->display_data['status_total_rows'] = sprintf($this->lang->line('notify_total_rows') , $query['num_rows']);
        $display_data = array_merge($data,$this->display_data);

        $this->load->view('_default/popup-header');
		$this->parser->parse('admin/notify/popup_overview' , $display_data);
        $this->load->view('_default/popup-footer');

    }
    public function retrieve_list()
    {
        $this->load->model('notify_model');

        $top = $this->input->post('top',true);
        $bottom = $this->input->post('bottom',true);
        $sort_column_id = $this->input->post('SORT_COLUMN_ID',true);
        $order_method = $this->input->post('ORDER_METHOD',true); // true or false
        $ProductGUID = $this->input->post('ProductGUID',true);

        $query = $this->notify_model->select_data_limit_offset('[dbo].[i_product_notifications]' , $top , $bottom , 
                    $this->UI_columns , $ProductGUID , $sort_column_id  , $order_method);

        $data = array(
            'grid_data' => $query['object']->result(),
            'num_rows' => $query['num_rows'],
            'GUID_list' => $query['GUID_list'],
            'top' => $top,
            'bottom' => $bottom,
            'ProductGUID' => $ProductGUID,
            'sort_column_id' => $sort_column_id,
            'order_method' => $order_method
        );
        
        header('Content-Type: application/json');
        echo json_encode($data);            
    }
    public function sending_mail()
    {
        $display_data = $this->display_data;
        $this->load->model('error_model');
        $this->load->model('notify_model');
        $this->load->library('email');
        $GUID_list = $this->input->post('GUID_list',true);
        $query = $this->notify_model->retrieve_mail_list( '[dbo].[i_product_notifications]' , $GUID_list, $this->db_sending_mail_column);
        
        $is_send_success = TRUE;

        $this->email->from($display_data['notify_sending_mail_address'] , $display_data['notify_sending_mail_name'] );
        foreach ($query['object']->result_array() as $row)
        {
            $this->email->to( $row['Email'] ); 
            $this->email->subject( $display_data['notify_sending_mail_subject'] );
            $display_data['product_arrival_title'] = $row['ProductTitle'];
            $display_data['product_arrival_date'] = date('Y-m-d');
            $msg = $this->parser->parse('admin/notify/product_arrival_msg', $display_data ,true);

            $this->email->message( $msg ); 
            //Send mail and check if it would be All true
            
            if( $this->email->send()  & $is_send_success){
                $is_send_success = TRUE;
            }else{
                $is_send_success = FALSE;
            }
            
        }

        $this->notify_model->notify_times_add_one('[dbo].[i_product_notifications]' ,$GUID_list);


        


        header('Content-Type: application/json');
        
        if($is_send_success){
            echo $this->error_model->retrieve_error_msg(0, $this->email->print_debugger() ,$query['object']->result_array());
        }else{
            echo $this->error_model->retrieve_error_msg( 3, $this->email->print_debugger() );
        }

        
    }
    public function parse_display_data()
    {
        $this->lang->load('gird_column');
        $this->lang->load('button');
        $this->lang->load('contextmenu');
        $this->lang->load('notify');

        $this->display_data = array(
            'button_close'                  => $this->lang->line('button_close'),
            'button_cancel'                 => $this->lang->line('button_cancel'),
            'button_submit'                 => $this->lang->line('button_submit'),
            'button_ok'                     => $this->lang->line('button_ok'),
            'notify_total_rows'             => $this->lang->line('notify_total_rows'),
            'notify_sending_mail_subject'   => $this->lang->line('notify_sending_mail_subject'),
            'notify_sending_mail_address'       => $this->lang->line('notify_sending_mail_address'),
            'notify_sending_mail_name'          => $this->lang->line('notify_sending_mail_name'),
            'notify_popup_sending_mail_title'   => $this->lang->line('notify_popup_sending_mail_title'),
            'notify_popup_sending_mail_msg' => $this->lang->line('notify_popup_sending_mail_msg'),
            'contextmenu_reload'            => $this->lang->line('contextmenu_reload'),
            'contextmenu_email_notify'      => $this->lang->line('contextmenu_email_notify'),
            'contextmenu_arrvival'          => $this->lang->line('contextmenu_arrvival'),
            'gird_column_NotifyID'          => $this->lang->line('gird_column_NotifyID'),
            'gird_column_NotifyID'          => $this->lang->line('gird_column_NotifyID'),
            'gird_column_NotifyTimes'       => $this->lang->line('gird_column_NotifyTimes'),
            'gird_column_ProductTitle'      => $this->lang->line('gird_column_ProductTitle'),
            'gird_column_Email'             => $this->lang->line('gird_column_Email'),
            'gird_column_LastNotifyDate'    => $this->lang->line('gird_column_LastNotifyDate'),
            'gird_column_DateCreate'        => $this->lang->line('gird_column_DateCreate'),
            'gird_column_Name'              => $this->lang->line('gird_column_Name')
            
        );
    }

}

/* End of file notify.php */
/* Location: ./application/controllers/admin/notify.php */