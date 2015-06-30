<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class About_us extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	public function index()
	{
        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();

		$this->load->view('_default/header', $session_data);
		$this->load->view('about/index_default');
		$this->load->view('_default/footer');
	}

    
}

/* End of file about.php */
/* Location: ./application/controllers/about.php */