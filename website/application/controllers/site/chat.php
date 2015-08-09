<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->login_required_validation();
        $this->parse_display_data(
            array('btn', 'alert','chat')
        );
        $this->login_required_validation();
        $this->display_data["highlight_navi"] = "chat";
        $this->alertMsg();

    }
    public function alertMsg()
    {
        $this->load->model('photo_model');
        if ( $this->session->userdata('Rank') <= 2){
            $this->display_data['alert_content'] = $this->display_data['alert_mail_need_to_vaildate_at_account'];
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
                $this->display_data['alert_content'] = $this->display_data['alert_upload_a_photo_to_public_before_chat'];
            }else{
                if( $public_photo_reviewed_count == 0){
                    $this->display_data['alert_content'] = $this->display_data['alert_upload_a_photo_to_public_under_review_before_chat'];
                }
            }
        }

    }

	public function index()
	{
		$this->parser->parse('site/_default/header',$this->display_data);
		$this->parser->parse('site/_default/header_logout',$this->display_data);
		$this->parser->parse('site/_default/female_navi',$this->display_data);
		$this->parser->parse('site/chat/index',$this->display_data);
		$this->parser->parse('site/_default/footer',$this->display_data);
	}
    public function room()
    {
        $this->load->model('photo_model');
        $userGUID = $this->session->userdata('GUID');
        
        $this->display_data['Thumb'] = $this->photo_model->retrieve_public_cover_photo($userGUID);

		$this->parser->parse('site/chat/room',$this->display_data);
    }
}