<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Admin_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(
            array( 'rank' ,'alert' , 'account' , 'menu', 'message', 'photo')
        );

    }
    public function index()
    {
		$this->parser->parse('admin/_default/header',$this->display_data);
		$this->parser->parse('admin/_default/navi',$this->display_data);

		$this->parser->parse('admin/_default/footer',$this->display_data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/admin/welcome.php */