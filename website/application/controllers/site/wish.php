<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wish extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->login_required_validation();
        
        $this->parse_display_data(
            array('btn','grid','alert' ,'message','mywish','view')
        );
        $this->display_data["highlight_navi"] = "wish";
        $this->alertMsg();
        $this->load->model('wish_model');

    }
	public function index()
	{
        $mywish_list = $this->wish_model->retrive_mywish( FALSE , FALSE , 2 ,0, 0 , FALSE);
        $this->display_data['wish_list'] = $mywish_list;

        $this->parser->parse('site/_default/header',$this->display_data);
	    $this->parser->parse('site/_default/header_logout',$this->display_data);
	    $this->parser->parse('site/_default/female_navi',$this->display_data);
	    $this->parser->parse('site/wish/index',$this->display_data);
	    $this->parser->parse('site/_default/footer',$this->display_data);
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

        $mywish_list = $this->wish_model->retrive_mywish( FALSE , $GUID , 2 ,0, 0 , FALSE);
        $this->display_data = array_merge( $this->display_data , $mywish_list );
        $this->parser->parse('site/_default/header',$this->display_data);
	    $this->parser->parse('site/_default/header_logout',$this->display_data);
	    $this->parser->parse('site/_default/female_navi',$this->display_data);
	    $this->parser->parse('site/wish/detail',$this->display_data);
	    $this->parser->parse('site/_default/footer',$this->display_data);
    }
}