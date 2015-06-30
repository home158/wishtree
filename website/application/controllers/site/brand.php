<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Brand extends Site_Base_Controller {
    private $display_data = array(
        "highlight_main_list" => "brand",
        "highlight_sub_lsit" => 0,
        "session_control" => "session_not_exist"
    );
    
    public function __construct()
    {
        parent::__construct();
        
        if( $this->session->userdata('user_exist') === true){
            $this->display_data['session_control'] = "session_exist";
        }
        $this->display_data["order_num_rows"] = $this->retrieve_order_num_rows();
    }
	public function index($brand = 'story')
	{
        switch($brand){
            case 'story':
                $this->display_data['highlight_sub_lsit'] = 0;
            break;
            case 'spirite':
                $this->display_data['highlight_sub_lsit'] = 1;
            break;
            case 'concept':
                $this->display_data['highlight_sub_lsit'] = 2;
            break;
        }
        $data = array();
        $session_data = $this->register_model->retrieve_user_session();

        $display_data = array_merge($data, $session_data , $this->display_data);

        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
        $this->load->view('brand/'.$brand);
        $this->load->view('_default/footer');
	}

}

/* End of file brand.php */
/* Location: ./application/controllers/brand.php */