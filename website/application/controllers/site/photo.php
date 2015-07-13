<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->login_required_validation();
        $this->parse_display_data(
            array('btn' )
        );
        $this->login_required_validation();
        $this->display_data["highlight_navi"] = "photo";
        $this->load->model('photo_model');

    }

	public function index()
	{

		$config['upload_path'] = './uploads';
		$config['allowed_types'] = 'gif|jpg|png';
		//$config['max_size']	= '1000';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
        $config['encrypt_name'] = TRUE;

		$this->load->library('upload',$config);
        $this->load->helper('file');
        $this->load->helper('form');

		if ( ! $this->upload->do_upload())
		{
			$this->display_data['error'] = $this->upload->display_errors();

		    $this->parser->parse('site/_default/header',$this->display_data);
		    $this->parser->parse('site/_default/header_logout',$this->display_data);
		    $this->parser->parse('site/_default/female_navi',$this->display_data);
		    $this->parser->parse('site/photo/index',$this->display_data);
		    $this->parser->parse('site/_default/footer',$this->display_data);
		}
		else
		{
			$data = $this->upload->data();
            
            //resize to 500 x 500px
            $full_path = $data['full_path'];
            $thumb_path = $config['upload_path'].'/'.$data['raw_name'].'_thumb'.$data['file_ext'];

            $size = getimagesize($full_path);
            $ratio = $size[0]/$size[1]; // width/height

            if($size[0] > 500 or $size[1] > 500){
                if( $ratio > 1) {
                    $width = 500;
                    $height = 500/$ratio;
                }
                else {
                    $width = 500*$ratio;
                    $height = 500;
                }
                $src = imagecreatefromstring(file_get_contents($full_path));
                $dst = imagecreatetruecolor($width,$height);
                imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
                imagedestroy($src);
            }else{
                $dst = imagecreatefromstring(file_get_contents($full_path));
            }


            //crop thumb image
	        $targ_w = 300;
            $targ_h = 360;
	        $jpeg_quality = 90;

	        //$src = $data['full_path'];
	        $img_r = $dst;
	        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	        imagecopyresampled($dst_r,$img_r,0,0,$this->input->post('x',true),$this->input->post('y',true),
	        $targ_w,$targ_h,$this->input->post('w',true),$this->input->post('h',true));
	        imagejpeg($dst_r,$thumb_path,$jpeg_quality);
            


            //Save to Azure Storage
            $full_path_parts = pathinfo($full_path);
            $thumb_path_parts = pathinfo($thumb_path);

            $container = 'container-'.$this->session->userdata('Role');
            $this->photo_model->saveToAzureStorage($container , $full_path_parts['basename'] , $full_path );
            $this->photo_model->saveToAzureStorage($container , $thumb_path_parts['basename'] , $thumb_path );

            //Save to db_photo
            $photo_data = array(
                'UserGUID' => $this->session->userdata('GUID'),
                'Container' => $container,
                'FullBasename' => $full_path_parts['basename'] ,
                'ThumbBasename' => $thumb_path_parts['basename']
            );
            $insert_string = $this->db->insert_string('[dbo].[i_photo]', $photo_data);
            $this->db->query( $insert_string );

		}


	}
    public function test(){
        $this->load->library('azure');
        $blobRestProxy = $this->azure->createBlobService();
        $blob_list = $blobRestProxy->listBlobs("container-male");
        $blobs = $blob_list->getBlobs();

        foreach($blobs as $blob)
        {
            echo $blob->getName().": ".$blob->getUrl()."<br />";
            echo "<img src='".$blob->getUrl()."'>";
        }
    }
}

/* End of file photo.php */
/* Location: ./application/controllers/site/photo.php */