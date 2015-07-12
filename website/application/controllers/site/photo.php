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
$fn = $data['full_path'];
$size = getimagesize($fn);
$ratio = $size[0]/$size[1]; // width/height
	        $jpeg_quality = 90;

if( $ratio > 1) {
    $width = 500;
    $height = 500/$ratio;
}
else {
    $width = 500*$ratio;
    $height = 500;
}
$src = imagecreatefromstring(file_get_contents($fn));
$dst = imagecreatetruecolor($width,$height);
imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
imagedestroy($src);
	        //header('Content-type: image/jpeg');
	        //imagejpeg($dst,null,$jpeg_quality);
//imagedestroy($dst);


          
	        $targ_w = 300;
            $targ_h = 360;
	        $jpeg_quality = 90;

	        //$src = $data['full_path'];
	        $img_r = $dst;
	        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	        imagecopyresampled($dst_r,$img_r,0,0,$this->input->post('x',true),$this->input->post('y',true),
	        $targ_w,$targ_h,$this->input->post('w',true),$this->input->post('h',true));

	        header('Content-type: image/jpeg');
	        imagejpeg($dst_r,null,$jpeg_quality);
            
			print_r($data);
		}


	}
}

/* End of file photo.php */
/* Location: ./application/controllers/site/photo.php */