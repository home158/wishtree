<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products_admin extends CI_Controller {

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
        ini_set('display_errors', 1);
        //$this->load->database();
        
  
        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
		$this->load->view('_default/header', $session_data);


        $data = array();

		$this->load->view('products/products_admin_index.php',$data);
		$this->load->view('_default/footer');
	}
	/**
	 * add Page for product.
	 *
     */
    public function add()
    {
        ini_set('display_errors', 1);
        //$this->load->database();
        
  
        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
		$this->load->view('_default/header', $session_data);
    
        $this->load->library('tinymce');
        $data['head'] = $this->tinymce->createhead();

        $buttons = array(
            array(
                'name' => "Submit",
                'type' => 'submit',
                'class' => "btn-relax btn-xl",
                'value' => "新增"
            ),
            array(
                'name' => "Reset",
                'type' => 'reset',
                'class' => "btn-gray btn-xl",
                'value' => "取消"
            )
        );
        $data['mce'] = $this->tinymce->textarea(true , 'products_admin/add_process' , $buttons);
		$this->load->view('products/products_admin_add_edit_copy.php',$data);
		$this->load->view('_default/footer');
    }
	/**
	 * add product to db.
	 *
     */
	public function add_process()
	{
        $this->load->database();
        echo $this->input->post('tinymce',true);
        $this->load->model('easydb_model');

        $insert_data = array(
                    'Details' => $this->input->post('tinymce',true)
                );
    
        
        $this->easydb_model->insert_data('[dbo].[i_products]',$insert_data);
        header('Content-Type: application/json');
        echo $this->error_model->retrieve_error_msg(0);

	}
    public function update(){
        
  
        $this->load->model('register_model');
        $session_data = $this->register_model->retrieve_user_session();
		$this->load->view('_default/header', $session_data);
    
        $this->load->library('tinymce');
        $data['head'] = $this->tinymce->createhead();

        $buttons = array(
            array(
                'name' => "Submit",
                'type' => 'submit',
                'class' => "btn-relax btn-xl",
                'value' => "另存"
            ),
            array(
                'name' => "Submit",
                'type' => 'submit',
                'class' => "btn-relax btn-xl",
                'value' => "更新"
            ),
            array(
                'name' => "Reset",
                'type' => 'reset',
                'class' => "btn-gray btn-xl",
                'value' => "取消"
            )
        );
        $data['mce'] = $this->tinymce->textarea(true , 'products_admin/add_process' , $buttons);
		$this->load->view('products/products_admin_add_edit_copy.php',$data);
		$this->load->view('_default/footer');
    }
    public function update_process(){
    }
    public function delete_process(){
    }
   
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */