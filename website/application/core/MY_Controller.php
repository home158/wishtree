<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class BASE_Controller extends CI_Controller{
    public $session_data;
    public function __construct() {
        parent::__construct();

        date_default_timezone_set('Asia/Taipei');

        $this->load->model('register_model');
        $this->session_data = $this->register_model->retrieve_user_session();
        
    }
}
class Admin_Base_Controller extends BASE_Controller {
    public $display_data;
    public function __construct() {
        parent::__construct();
        
        //管理者未登入，回到前端首頁
        if( $this->session->userdata('user_exist') == false){
            redirect( base_url() , 'refresh');
        }
        //管理者session失效或無管理者權限，回到前端首頁
        if( $this->session->userdata('user_exist') == false || $this->session_data['Rank'] != 255)
        {
            redirect( base_url() , 'refresh');
        }
    }
    protected  $UI_products_category_columns = array(
			'[CategoryID]' ,
			'[GUID]' ,
			'[CategoryName]' ,
			'[Priority]' ,
			'[IsShow]'
    );
    protected function build_navi(){
        $this->load->model('products_model');
        $r = $this->products_model->retrieve_category($this->UI_products_category_columns);
        $grid_data = $r->result();
        $navi_list = array();
        foreach($grid_data as $key ){
            array_push ($navi_list , array(
                'GUID' => $key->GUID,
                'CategoryName' => $key->CategoryName
            ));
        }
        $this->display_data['navi_list'] = $navi_list;
    }
}

class Site_Base_Controller extends BASE_Controller {
    public function __construct() {
        parent::__construct();
        //var_dump($this->session_data);
    }
    public function checke_user_exist()
    {
        
        //使用者未登入，回到前端首頁
        if( $this->session->userdata('user_exist') ){
            redirect( base_url() , 'refresh');
        }
    }
    public function retrieve_order_num_rows(){
        $this->load->model('orders_model');
        $session_id = $this->session->userdata('session_id');  //236b49d78afea90c944690dc58dc400b
        $user_GUID = $this->session->userdata('GUID');         //03E580E2-69CA-4533-A4D2-F80961DDE470
        
        $result = $this->orders_model->retrieve_shopping_car('RANK() OVER( ORDER BY [DetailID]) AS [SerialNo]' ,$user_GUID , $session_id);

 
        return $result['num_rows'];
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */