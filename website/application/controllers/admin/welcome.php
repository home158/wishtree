<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Admin_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data();
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        //ini_set('display_errors', 1);
        //$this->load->database();
        
  
        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
		$this->load->view('admin/header', $session_data);


        $data = array();
        $display_data = array_merge($data , $this->display_data);

		$this->parser->parse('admin/navi',$display_data);
		$this->parser->parse('admin/index_default',$display_data);
		$this->load->view('admin/footer');
	}
    public function parse_display_data(){
        $this->build_navi();
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/admin/welcome.php */