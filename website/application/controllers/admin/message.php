<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends Admin_Base_Controller {
    private $UI_columns = array('MessageID' , 'MessageContent', 'MessageReviewStatus',
        'U1.[Nickname] AS [FromUserNickname]' , 
        'U1.[Email] AS [FromUserEmail]' , 
        'U1.[Role] AS [FromUserRole]' , 
        'U2.[Nickname] AS [TargetUserNickname]',
        'U2.[Email] AS [TargetUserEmail]',
        'U2.[Role] AS [TargetUserRole]'
    );
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(
            array( 'btn','alert', 'rank', 'role','photo','menu' , 'grid' , 'contextmenu' , 'message', 'account')
        );
        $this->load->model('message_model');

    }
    public function view($GUID = "00000000-0000-0000-0000-000000000000")
    {
        $top = 0;
        $bottom =37;
        $this->additionalColumn();
        //init data grid
        switch($GUID){
            default:
                    $query = $this->message_model->select_data_limit_offset('[dbo].[i_pending_message]', $top , $bottom , $this->UI_columns);
                break;
        }
        $data = array(
            'grid_data' => json_encode($query['object']->result()),
            'num_rows' => $query['num_rows'],
            'GUID_list' => json_encode( $query['GUID_list'] ),
            'GUID' => $GUID
        );
        $this->display_data['azure_storage_baseurl'] = $this->config->item('azure_storage_baseurl');
        $this->display_data['menu_total_rows'] = sprintf($this->display_data['menu_total_rows'] , $data['num_rows'] );
        $this->display_data = array_merge($this->display_data , $data);
		$this->parser->parse('admin/_default/header',$this->display_data);
		$this->parser->parse('admin/_default/navi',$this->display_data);
		$this->parser->parse('admin/message/index',$this->display_data);
		$this->parser->parse('admin/_default/footer',$this->display_data);

    }
    private function additionalColumn()
    {
        
        array_push( $this->UI_columns , 
                
                $this->utility_model->dbColumnDatetime('M.[MessageReviewDate]' , '[MessageReviewDate]'),
                $this->utility_model->dbColumnDatetime('M.[DateModify]' , '[DateModify]'),
                $this->utility_model->dbColumnDatetime('M.[DateCreate]' , '[DateCreate]')
        );
    }
}
