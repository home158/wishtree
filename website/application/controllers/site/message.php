<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->login_required_validation();
        
        $this->parse_display_data(
            array('btn','grid' ,'message' ,'alert')
        );
        $this->display_data["highlight_navi"] = "message";
        $this->load->model('message_model');
        $this->load->model('utility_model');
        $this->load->model('photo_model');
        $this->alertMsg();

    }
    public function alertMsg()
    {
        if ( $this->session->userdata('Rank') <= 2){
            if($this->session->userdata('Role') == 'male'){
                $this->display_data['alert_content'] = $this->display_data['alert_mail_need_to_vaildate_before_message_to_femele'];
            }else{
                $this->display_data['alert_content'] = $this->display_data['alert_mail_need_to_vaildate_before_message_to_mele'];
            }
            return;
        }
        if( $this->session->userdata('Rank') <= 3  ){
            $public = $this->photo_model->retrieve_my_photos( $this->session->userdata('GUID') , 'public');
            $public_photo_count = count($public);

            $public_photo_reviewed_count = 0;
            foreach( $public as $key => $row){
                if($row['ReviewStatus'] == 2){
                    $public_photo_reviewed_count++;
                }
            }
            if( $public_photo_count == 0){
                $this->display_data['alert_content'] = $this->display_data['alert_upload_a_photo_to_public_before_send_message'];
            }else{
                if( $public_photo_reviewed_count == 0){
                    $this->display_data['alert_content'] = $this->display_data['alert_upload_a_photo_to_public_under_review_before_send_message'];
                }
            }
        }
    }
	public function index()
	{
        $message_box = $this->message_model->retrieve_message_box($this->session->userdata('GUID'));

        $this->display_data = array_merge( $this->display_data , $message_box);

        if($this->ajax){
	        $this->utility_model->parse('site/message/index',$this->display_data,TRUE);
        }else{
            $this->utility_model->parse('site/_default/header',$this->display_data);
	        $this->utility_model->parse('site/_default/header_logout',$this->display_data);
	        $this->utility_model->parse('site/_default/female_navi',$this->display_data);
	        $this->utility_model->parse('site/message/index',$this->display_data);
	        $this->utility_model->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/socket_io',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
    function require_public_photo()
    {
        $this->parser->parse('site/_default/header',$this->display_data);
	    $this->parser->parse('site/_default/header_logout',$this->display_data);
	    $this->parser->parse('site/_default/female_navi',$this->display_data);
	    $this->parser->parse('site/message/require_public_photo',$this->display_data);
	    $this->parser->parse('site/_default/footer',$this->display_data);
        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);

        exit;
    }
    public function history()
    {
        $owner = $this->session->userdata('GUID');
        $sender = $this->input->post('GUID');

        //設定為沒有新訊息
        $message_box_data = array(
            'UserGUID' => $this->session->userdata('GUID'),
            'FromUserGUID' => $sender,
            'IsNew' => 0,
            'ReadTime' => date('Y-m-d H:i:s')
        );
        $this->message_model->update_message_box($message_box_data);


        $privilege_state = $this->photo_model->retrieve_privilege($owner , $sender);
        $msg = $this->message_model->get_history($owner , $sender);

        $this->display_data['privilege_state'] = $privilege_state;
        $this->display_data['msg'] = $msg;

	    echo $this->parser->parse('site/message/history',$this->display_data , true);

    }
    public function write($GUID = NULL)
    {
        if($GUID == NULL){
            redirect( base_url().'message' , 'refresh');
        }
        if( ! $this->utility_model->is_user_exist_by_GUID($GUID) ){
            redirect( base_url().'message' , 'refresh');
        }
        $target = $this->message_model->retrieve_target_info($GUID);
        
        $this->display_data = array_merge( $this->display_data , $target);
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em class="form_error">', '</em>');
		$this->form_validation->set_rules('message_content', $this->display_data['grid_column_MessageContent'], 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
            $this->parser->parse('site/_default/header',$this->display_data);
	        $this->parser->parse('site/_default/header_logout',$this->display_data);
	        $this->parser->parse('site/_default/female_navi',$this->display_data);
	        $this->parser->parse('site/message/write',$this->display_data);
	        $this->parser->parse('site/_default/footer',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }else{
            $message_content = $this->input->post('message_content');
            $this->message_model->write($GUID ,  $message_content);
            redirect( base_url().'view/'.$GUID , 'refresh');
        }
    }
    public function send()
    {
        $GUID = $this->input->post('targetGUID' , TRUE);
        $msg_content = $this->input->post('content');

        $msg = $this->message_model->write($GUID ,  $msg_content);
        $this->display_data['msg'] = array($msg);

	    echo $this->parser->parse('site/message/history',$this->display_data , true);
        
    }
}