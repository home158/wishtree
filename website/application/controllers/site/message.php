<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->login_required_validation();
        $this->parse_display_data(
            array('btn','grid' )
        );
        $this->display_data["highlight_navi"] = "message";
        $this->load->model('message_model');
        $this->load->model('utility_model');
        
    }
	public function index()
	{
        $message_box = $this->message_model->retrieve_message_box($this->session->userdata('GUID'));

        $this->display_data = array_merge( $this->display_data , $message_box);

        $this->parser->parse('site/_default/header',$this->display_data);
	    $this->parser->parse('site/_default/header_logout',$this->display_data);
	    $this->parser->parse('site/_default/female_navi',$this->display_data);
	    $this->parser->parse('site/message/index',$this->display_data);
	    $this->parser->parse('site/_default/footer',$this->display_data);

    }
    public function history()
    {
        $owner = $this->session->userdata('GUID');
        $sender = $this->input->post('GUID');
        $msg = $this->message_model->get_history($owner , $sender);

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
        print_r($target);
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
        }else{
            //無需審核
            $message_box_data = array(
                'UserGUID' => $GUID,
                'FromUserGUID' => $this->session->userdata('GUID'),
                'IsNew' => 1,
                'DateModify' => date('Y-m-d H:i:s')
            );
            $this->message_model->update_message_box($message_box_data);

            $pending_message_data = array(
                'FromUserGUID' => $this->session->userdata('GUID'),
                'TargetUserGUID' => $GUID,
                'MessageContent' => $this->input->post('message_content'),
                'MessageReviewStatus' => 2,
                'MessageReviewTime' => date('Y-m-d H:i:s'),
                'MessageReviewByGUID' => NULL
            );
            $pending_message_insert_string = $this->db->insert_string('[dbo].[i_pending_message]', $pending_message_data);
            $this->db->query( $pending_message_insert_string );
            
            //寫入FILE
            $this->message_model->save_message_history($this->session->userdata('GUID') , $GUID , $pending_message_data['MessageContent'] , 'say');
            $this->message_model->save_message_history($this->session->userdata('GUID') , $GUID , $pending_message_data['MessageContent'] , 'target');
            
        }
    }
}