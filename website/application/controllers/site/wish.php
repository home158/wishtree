<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wish extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->login_required_validation();
        
        $this->parse_display_data(
            array('btn','grid','alert' ,'message','wish','view')
        );
        $this->display_data["highlight_navi"] = "wish";
        $this->alertMsg();
        $this->load->model('wish_model');

    }
	public function index()
	{
        if($this->session->userdata['Role']=='male'){
            $w_role = 'female';
        }else{
            $w_role = 'male';
        }
        $mywish_list = $this->wish_model->retrive_mywish( FALSE , FALSE , $w_role , 2 ,0, 0 , FALSE);
        $this->display_data['wish_list'] = $mywish_list;

        if($this->ajax){
            $this->utility_model->parse('site/wish/index',$this->display_data , TRUE);
        }else{
            $this->utility_model->parse('site/_default/header',$this->display_data);
	        $this->utility_model->parse('site/_default/header_logout',$this->display_data);
	        $this->utility_model->parse('site/_default/female_navi',$this->display_data);
	        $this->utility_model->parse('site/wish/index',$this->display_data);
	        $this->utility_model->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/socket_io',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
    public function view($GUID = NULL)
    {
        if(is_null($GUID)){
            redirect(base_url().'wish', 'refresh');
        }
        $wish = $this->wish_model->retrive_mywish_by_GUID($GUID);
        if($wish == FALSE){
            redirect(base_url().'wish', 'refresh');
        }

        $mywish_list = $this->wish_model->retrive_mywish( FALSE , $GUID , NULL , 2 ,0, 0 , FALSE);
        $this->display_data = array_merge( $this->display_data , $mywish_list );
        if($this->ajax){
            $this->utility_model->parse('site/wish/detail',$this->display_data , TRUE);
        }else{

            $this->utility_model->parse('site/_default/header',$this->display_data);
	        $this->utility_model->parse('site/_default/header_logout',$this->display_data);
	        $this->utility_model->parse('site/_default/female_navi',$this->display_data);
	        $this->utility_model->parse('site/wish/detail',$this->display_data);
	        $this->utility_model->parse('site/_default/footer',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
    public function get_reply()
    {
        $this->display_data['reply'] = $this->wish_model->retrive_reply( $this->input->post('wishGUID',true) );
        echo $this->parser->parse('site/wish/reply_msg',$this->display_data , true);
    }
    public function reply()
    {
        $this->load->model('error_model');
        $reply_data = array(
            'WishGUID' => $this->input->post('wish_GUID',true),
            'UserGUID' => $this->session->userdata('GUID'),
            'ReplyContent' => $this->input->post('wish_content'),
            'DateCreate' => date('Y-m-d H:i:s'),
            'DateModify' => date('Y-m-d H:i:s')
        );
        
        $insert_string = $this->db->insert_string('[dbo].[i_wish_reply]', $reply_data);
        $r = $this->db->query( $insert_string );
        if($r == TRUE){
            $this->display_data['reply'] = $this->wish_model->retrive_reply($reply_data['WishGUID']);
            echo $this->parser->parse('site/wish/reply_msg',$this->display_data , true);
            exit;
        }
    }
}