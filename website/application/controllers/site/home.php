<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->display_data["highlight_navi"] = "home";
        $this->parse_display_data(
            array('btn' )
        );
        
        $this->login_required_validation();
        $this->load->model('home_model');
    }
    public function index()
	{
        
        $this->display_data['home_welcome'] = sprintf( $this->display_data['home_welcome'] , $this->session->userdata('Nickname') );
        $this->display_data['random_user'] = $this->home_model->get_random_user();

        print_r($this->display_data['random_user']);
		$this->parser->parse('site/_default/header',$this->display_data);
		$this->parser->parse('site/_default/header_logout',$this->display_data);
		$this->parser->parse('site/_default/female_navi',$this->display_data);
		$this->parser->parse('site/home/'.$this->session->userdata('Role').'_index',$this->display_data);

		$this->parser->parse('site/_default/footer',$this->display_data);

	}
    public function do_upload(){
		$config['upload_path'] = './uploads';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
        $config['encrypt_name'] = TRUE;

		$this->load->library('upload',$config);
        $this->load->helper('file');
        $this->load->helper('form');
		if ( !$this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('site/demo/upload_form',$error);
		}
		else
		{
			$data = $this->upload->data();

			print_r($data);
            $this->load->library('azure');
            $blobRestProxy = $this->azure->createBlobService();

            $content = fopen($data['full_path'], "r");
            $blob_name = $data["file_name"];

            //Upload blob
            try{
                $blobRestProxy->createBlockBlob("container-male", $blob_name, $content);
                //chmod('./uploads/'.$data['file_name'], 0777);
                //unlink('./uploads/'.$data['file_name']);
            } catch(ServiceException $e){
                $code = $e->getCode();
                $error_message = $e->getMessage();
                echo $code.": ".$error_message."<br />";
            }
            
		}

    }
    public function test(){
        $this->load->library('azure');
        $blobRestProxy = $this->azure->createBlobService();
        $blob_list = $blobRestProxy->listBlobs("mycontainer");
        $blobs = $blob_list->getBlobs();

        foreach($blobs as $blob)
        {
            echo $blob->getName().": ".$blob->getUrl()."<br />";
            ///echo "<img src='".$blob->getUrl()."'>";
        }
    }

}
