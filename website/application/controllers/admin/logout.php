<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends Admin_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->login_required_validation();
    }

	public function index()
	{
        $this->session->sess_destroy();
        redirect( base_url() , 'refresh');
	}

    
}

/* End of file logout.php */
/* Location: ./application/controllers/site/logout.php */