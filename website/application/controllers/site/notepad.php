<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notepad extends Site_Base_Controller {
    private $display_data = array(
        "highlight_main_list" => "notepad",
        "highlight_sub_lsit" => 3,
        "session_control" => "session_not_exist"
    );
    private $species_column = array(
            '[GUID]',
            '[SpeciesDisplay]',
            '[SpeciesCategoryR1]',
            '[SpeciesCategoryR2]',
            '[SpeciesTitle]',
            '[SpeciesIcon]',
            '[SpeciesContent]',
            '[IsOnShelves]',
            '[SpeciesImageURLPath]',
            '[SpeciesImageBackgroundPosition]'

    );
    public function __construct()
    {
        parent::__construct();
        if( $this->session->userdata('user_exist') === true){
            $this->display_data['session_control'] = "session_exist";
        }
        $this->display_data["order_num_rows"] = $this->retrieve_order_num_rows();
    }
	public function index()
	{
        $this->farm_village();
        
	}
	public function vegetable($r = 1 , $p = 0)
	{
        $this->load->model('products_model');
        $r = ($r > 2)? 0 : $r;
        $p = ($p > 4)? 0 : $p;
        $session_data = $this->register_model->retrieve_user_session();
        $this->display_data["r"] = $r;
        $this->display_data["p"] = 0;
        $this->display_data["m"] = $r;
        $this->display_data["n"] = ($r != 1)? 1 : $p;

        if($r == 1){
            $result = $this->products_model->retrieve_vegetable($this->species_column ,'[dbo].[i_products]' , $r , $p);
        }else{
            $result = $this->products_model->retrieve_vegetable($this->species_column ,'[dbo].[i_products]' , $r);
        }
        $data = array(
            'grid_data' => (array) $result->result(),
            'grid_data_jquery' => (array) $result->result()
        );
        $display_data = array_merge($data , $session_data , $this->display_data);
        $this->load->view('_default/header');
        $this->parser->parse('_default/navi', $display_data);
        $this->parser->parse('notepad/vegetable', $display_data);
        $this->load->view('_default/footer');
        
	}

}

/* End of file notepad.php */
/* Location: ./application/controllers/notepad.php */