<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(
            array('btn' ,'alert' ,'role','status')
        );
        $this->display_data["highlight_navi"] = "home";

        $this->login_required_validation();
        $this->load->model('home_model');

        $this->alertMsg();

    }
    public function alertMsg()
    {
        if ( $this->session->userdata('Rank') <= 2){
            if($this->session->userdata('Role') == 'male'){
                $this->display_data['alert_content'] = $this->display_data['alert_mail_need_to_vaildate_before_view_femele_profile'];
            }else{
                $this->display_data['alert_content'] = $this->display_data['alert_mail_need_to_vaildate_before_view_mele_profile'];
            }
        }
    }
    public function index()
	{
        $this->display_data['home_welcome'] = sprintf( $this->display_data['home_welcome'] , $this->session->userdata('Nickname') );

        if($this->session->userdata('Role') == 'male'){
            $this->display_data['random_user'] = $this->home_model->get_random_user('female');
            $this->display_data['newcomer_user'] = $this->home_model->get_newcomer_user('female');
        }else{
            $this->display_data['random_user'] = $this->home_model->get_random_user('male');
            $this->display_data['newcomer_user'] = $this->home_model->get_newcomer_user('male');
        }
        if($this->session->userdata('Role') == 'male'){
            $this->display_data['role_random_title'] = $this->display_data['role_female_long'];
           
        }else{
            $this->display_data['role_random_title'] = $this->display_data['role_male_long'];
        }
        if($this->ajax){
            $this->utility_model->parse('site/home/index',$this->display_data , TRUE);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/home/index',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/socket_io',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
	}
    public function phpinfo()
    {
        print_r(openssl_get_cert_locations());
        echo phpinfo();
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
    public function test2(){
        echo date('Y-m-d H:i:s');



        $this->db->update('[dbo].[i_test]', array('DateCreate' =>date('Y-m-d H:i:s')), array('UserID' => 1 ));

        $query = $this->db->query(
        "
        SELECT *
                
	          ,
              ".$this->utility_model->dbColumnDatetime('[DateCreate]')."
              
          FROM [db_wishtree].[dbo].[i_test]
        ");
        $r = $query->result_array();
        print_r($r);
        //            "CONVERT(VARCHAR(20) , SWITCHOFFSET (DateCreate, '+00:00') ,113)  AS [DateCreate]",
        echo $this->timezoneOffset;

        echo "<br>";

$timezone_offset    = '+08:00'; # 2H
$sign               = substr($timezone_offset, 0, 1) == '+'? '': '-';
$offset_h             = substr($timezone_offset, 1, 2);
$offset_m             = substr($timezone_offset, 4, 2);
$offset = $offset_h * 3600 + $offset_m*60;

if($sign == '-'){
    $offset = 0 - $offset;
}

echo date('Y-m-d H:i:s' , time() +$offset );

    }
}
