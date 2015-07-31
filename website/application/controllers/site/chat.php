<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->login_required_validation();
        $this->parse_display_data(
            array( 'account' , 'rank' , 'email' , 'role' ,'btn', 'grid','register','member','city','language','birthday','height','bodytype','race',
                'income','property','education','maritalstatus' ,'smoking','drinking' , 'timezoneoffset' , 'dst' , 'alert')
        );
        $this->login_required_validation();
        $this->display_data["highlight_navi"] = "chat";
        $this->alertMsg();

    }
    private function alertMsg()
    {
        if ( $this->session->userdata('Rank') <= 2){
            $this->display_data['alert_content'] = $this->display_data['alert_mail_need_to_vaildate_at_account'];
        }
    }

	public function index()
	{
        $this->display_data['UserGUID'] = $this->session->userdata('GUID');
		$this->parser->parse('site/_default/header',$this->display_data);
		$this->parser->parse('site/_default/header_logout',$this->display_data);
		$this->parser->parse('site/_default/female_navi',$this->display_data);
		$this->parser->parse('site/chat/index',$this->display_data);
		$this->parser->parse('site/_default/footer',$this->display_data);
	}
}