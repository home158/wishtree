<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
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
        

		//$this->load->view('_default/header_image');

		$this->load->view('site/index_default2');
		$this->load->view('_default/footer_image');
	}
	public function index2()
	{
       // ini_set('display_errors', 1);
        
  
        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
        //print_r($session_data);
		$this->load->view('_default/header', $session_data);
  
        $query = $this->db->query('SELECT *
        FROM [dbo].[i_user]
        GO');
    
    
        $this->load->library('tinymce');
        $data['head'] = $this->tinymce->createhead();
        $data['mce'] = $this->tinymce->textarea(true);

        

		$this->load->view('site/index_default',$data);
		$this->load->view('_default/footer');
	}
	public function tinymce()
	{

        $this->load->library('tinymce');
        //echo $this->tinymce->createhead();
        $data['head'] = $this->tinymce->createhead();
        $data['mce'] = $this->tinymce->textarea(true);

        $this->load->view('welcome_message',$data);        
		//$this->load->view('welcome_message');

    
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */