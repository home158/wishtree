<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mywish extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->login_required_validation();
        
        $this->parse_display_data(
            array('btn','grid','alert' ,'mywish','view')
        );
        $this->display_data["highlight_navi"] = "mywish";
        $this->alertMsg();
        $this->load->model('wish_model');

    }
	public function index()
	{

        $mywish_list = $this->wish_model->retrive_mywish( $this->session->userdata('GUID') ,FALSE , NULL ,  2 ,0, 0 , FALSE);
        $this->display_data['mywish_list'] = $mywish_list;

        if($this->ajax){
            $this->utility_model->parse('site/mywish/index',$this->display_data,TRUE);
        }else{
            $this->utility_model->parse('site/_default/header',$this->display_data);
	        $this->utility_model->parse('site/_default/header_logout',$this->display_data);
	        $this->utility_model->parse('site/_default/female_navi',$this->display_data);
	        $this->utility_model->parse('site/mywish/index',$this->display_data);
	        $this->utility_model->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/socket_io',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
    public function action_mothball()
    {
        $this->load->model('error_model');
        $GUID = $this->input->post('GUID');
        //check GUID is exist in i_user
        $mywish = $this->wish_model->retrive_mywish_by_GUID( $GUID );

        if($mywish == FALSE)
        {
            echo $this->error_model->retrieve_error_msg(7 , NULL , $this->display_data['mywish_no_record']);
            exit;
        }
        if($mywish['MothballStatus'] == 1 )
        {
            echo $this->error_model->retrieve_error_msg(11 , NULL , $this->display_data['mywish_mothballed_already']);
            exit;
        }
        if($mywish['WishReviewStatus'] == 0 )
        {
            if($mywish['DeleteStatus'] == 0 ){
                echo $this->error_model->retrieve_error_msg(11 , NULL , $this->display_data['mywish_mothballed_pending']);
                exit;
            }
        }

        $update_data = array(
            'MothballStatus' => 1,
            'MothballDate' => date('Y-m-d H:i:s'),
            'DateModify' => date('Y-m-d H:i:s')
        );
        
        
        $this->db->update('[dbo].[i_wish]', $update_data , array('GUID'=> $GUID));
        
        echo $this->error_model->retrieve_error_msg(0, NULL , $this->display_data['mywish_mothballed_success'] );
        exit;

    }
    public function delete()
    {
        $this->load->model('error_model');
        $GUID = $this->input->post('GUID');
        //check GUID is exist in i_user
        $mywish = $this->wish_model->retrive_mywish_by_GUID( $GUID );

        if($mywish == FALSE)
        {
            echo $this->error_model->retrieve_error_msg(7 , NULL , $this->display_data['mywish_no_record']);
            exit;
        }
        if($mywish['MothballStatus'] == 1 )
        {
            echo $this->error_model->retrieve_error_msg(10 , NULL , $this->display_data['mywish_cannot_update_mothballed']);
            exit;
        }
        if($mywish['DeleteDate'] == 1 )
        {
            echo $this->error_model->retrieve_error_msg(9 , NULL , $this->display_data['mywish_cannot_update_deleted']);
            exit;
        }

        if( $mywish['DeleteStatus'] == 0 ){
            $update_data = array(
                'DeleteStatus' => 1,
                'DeleteDate' => date('Y-m-d H:i:s'),
                'DateModify' => date('Y-m-d H:i:s')
            );


            $this->db->update('[dbo].[i_wish]', $update_data , array('GUID'=> $GUID));
            
            echo $this->error_model->retrieve_error_msg(0, NULL , $this->display_data['mywish_update_success'] );
            exit;
        }else{
            echo $this->error_model->retrieve_error_msg(9 , NULL , $this->display_data['mywish_cannot_update_deleted']);
            exit;
        }

    }
    public function update()
    {
        $this->load->model('error_model');
        $this->load->model('wish_model');
        
        $userGUID = $this->session->userdata('GUID');
        $GUID = $this->input->post('GUID');
        //check GUID is exist in i_user
        $mywish = $this->wish_model->retrive_mywish_by_GUID( $GUID );
        if($mywish == FALSE)
        {
            echo $this->error_model->retrieve_error_msg(7 , NULL , $this->display_data['mywish_no_record']);
            exit;
        }
        if($mywish['WishReviewStatus'] > 0 )
        {
            echo $this->error_model->retrieve_error_msg(8 , NULL , $this->display_data['mywish_cannot_update_reviewed']);
            exit;
        }
        if($mywish['DeleteDate'] == 1 )
        {
            echo $this->error_model->retrieve_error_msg(9 , NULL , $this->display_data['mywish_cannot_update_deleted']);
            exit;
        }
        if($mywish['MothballStatus'] == 1 )
        {
            echo $this->error_model->retrieve_error_msg(10 , NULL , $this->display_data['mywish_cannot_update_mothballed']);
            exit;
        }
        if( $mywish['WishReviewStatus'] == 0 ){
            $update_data = array(
                'WishCategory' => $this->input->post('wish_category',true),
                'WishTitle' => $this->input->post('wish_title',true),
                'WishContent' => $this->input->post('wish_content'),
                'DateModify' => date('Y-m-d H:i:s')
            );


            $this->db->update('[dbo].[i_wish]', $update_data , array('GUID'=> $GUID));
            
            echo $this->error_model->retrieve_error_msg(0, NULL , 
                array(
                    'result' =>  $this->display_data['mywish_update_success'],
                    'wish_category' => $this->display_data['mywish_category_'.$update_data['WishCategory']],
                    'wish_title' => $update_data['WishTitle'],
                    'wish_content' => nl2br($update_data['WishContent'])
                )
            );
            exit;
        }


    }
    public function removed()
    {
        $mywish_list = $this->wish_model->retrive_mywish( $this->session->userdata('GUID') ,FALSE , NULL ,  '0,1,2' ,1 , 0);
        $this->display_data['mywish_list'] = $mywish_list;


        $this->parser->parse('site/_default/header',$this->display_data);
	    $this->parser->parse('site/_default/header_logout',$this->display_data);
	    $this->parser->parse('site/_default/female_navi',$this->display_data);
	    $this->parser->parse('site/mywish/removed',$this->display_data);
	    $this->parser->parse('site/_default/footer',$this->display_data);
        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
    }
    public function pending()
    {
        $mywish_list = $this->wish_model->retrive_mywish( $this->session->userdata('GUID') ,FALSE , NULL ,  0 ,0 , 0);
        $this->display_data['mywish_list'] = $mywish_list;


        $this->parser->parse('site/_default/header',$this->display_data);
	    $this->parser->parse('site/_default/header_logout',$this->display_data);
	    $this->parser->parse('site/_default/female_navi',$this->display_data);
	    $this->parser->parse('site/mywish/pending',$this->display_data);
	    $this->parser->parse('site/_default/footer',$this->display_data);
        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
    }
    public function mothball()
    {
        $mywish_list = $this->wish_model->retrive_mywish( $this->session->userdata('GUID') ,FALSE , NULL ,  '0,1,2' , '0,1' , 1);
        $this->display_data['mywish_list'] = $mywish_list;

        $this->parser->parse('site/_default/header',$this->display_data);
	    $this->parser->parse('site/_default/header_logout',$this->display_data);
	    $this->parser->parse('site/_default/female_navi',$this->display_data);
	    $this->parser->parse('site/mywish/mothball',$this->display_data);
	    $this->parser->parse('site/_default/footer',$this->display_data);
        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
    }
    public function expire()
    {
        $mywish_list = $this->wish_model->retrive_mywish( $this->session->userdata('GUID') ,FALSE , NULL ,  '2' , '0' , '0',TRUE);
        $this->display_data['mywish_list'] = $mywish_list;

        $this->parser->parse('site/_default/header',$this->display_data);
	    $this->parser->parse('site/_default/header_logout',$this->display_data);
	    $this->parser->parse('site/_default/female_navi',$this->display_data);
	    $this->parser->parse('site/mywish/expire',$this->display_data);
	    $this->parser->parse('site/_default/footer',$this->display_data);
        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
    }
    public function reject()
    {
        $mywish_list = $this->wish_model->retrive_mywish( $this->session->userdata('GUID') ,FALSE , NULL,  1 ,0 , 0);
        $this->display_data['mywish_list'] = $mywish_list;


        $this->parser->parse('site/_default/header',$this->display_data);
	    $this->parser->parse('site/_default/header_logout',$this->display_data);
	    $this->parser->parse('site/_default/female_navi',$this->display_data);
	    $this->parser->parse('site/mywish/reject',$this->display_data);
	    $this->parser->parse('site/_default/footer',$this->display_data);
        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
    }
    public function rule()
    {
            $this->parser->parse('site/_default/header',$this->display_data);
	        $this->parser->parse('site/_default/header_logout',$this->display_data);
	        $this->parser->parse('site/_default/female_navi',$this->display_data);
	        $this->parser->parse('site/mywish/rule',$this->display_data);
	        $this->parser->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
    }
    public function make()
    {
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em class="form_error">', '</em>');
        $this->form_validation->set_rules('wish_category', $this->display_data['mywish_category'], 'trim|required');
        $this->form_validation->set_rules('wish_content', $this->display_data['mywish_write_your_wish'], 'trim|required');
        $this->form_validation->set_rules('wish_title', $this->display_data['mywish_title'], 'trim|required');

		if ($this->form_validation->run() == FALSE)
		{
            $this->parser->parse('site/_default/header',$this->display_data);
	        $this->parser->parse('site/_default/header_logout',$this->display_data);
	        $this->parser->parse('site/_default/female_navi',$this->display_data);
	        $this->parser->parse('site/mywish/make',$this->display_data);
	        $this->parser->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }else{
            $this->load->library('uuid');
            $uuid = $this->uuid->v4();
            $expire = strtotime("+7 day");
            $wish_data = array(
                'GUID' => $uuid,
                'UserGUID' => $this->session->userdata('GUID'),
                'WishCategory' => $this->input->post('wish_category',true),
                'WishTitle' => $this->input->post('wish_title',true),
                'WishContent' => $this->input->post('wish_content'),
                'WishReviewStatus' => 0,
                'DateExpire' => date('Y-m-d H:i:s',$expire),
                'DateCreate' => date('Y-m-d H:i:s'),
                'DateModify' => date('Y-m-d H:i:s')
			
            );
            
            $insert_string = $this->db->insert_string('[dbo].[i_wish]', $wish_data);
            $this->db->query( $insert_string );
            redirect(base_url().'mywish/pending', 'refresh');

        }
    }
}