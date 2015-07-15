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
        $my_photos = $this->photo_model->retrieve_my_photos( $this->session->userdata('GUID') );
        $this->display_data['my_photos'] = $my_photos;


		$config['upload_path'] = $this->config->item('azure_storage_temp_forder');
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		//$config['max_size']	= '1000';
		//$config['max_width']  = '1024';
		//$config['max_height']  = '768';
        $config['encrypt_name'] = TRUE;

		$this->load->library('upload',$config);
        $this->load->helper('file');
        $this->load->helper('form');

		if ( ! $this->upload->do_upload() )
		{
			$this->display_data['error'] = $this->upload->display_errors( '<p class="redF tl">','</p>');

		    $this->parser->parse('site/_default/header',$this->display_data);
		    $this->parser->parse('site/_default/header_logout',$this->display_data);
		    $this->parser->parse('site/_default/female_navi',$this->display_data);
		    $this->parser->parse('site/photo/index',$this->display_data);
		    $this->parser->parse('site/_default/footer',$this->display_data);
		}
		else
		{
			$data = $this->upload->data();
            $container = 'container-'.$this->session->userdata('Role');

            //Scale
            $full_path = $data['full_path'];
            $scale_image = $this->photo_model->scale($full_path , 500 ,500);
            //Upload image to Azure Storage
            $full_path_parts = pathinfo($full_path);
            $this->photo_model->saveToAzureStorage($container , $full_path_parts['basename'] , $full_path );


            //Crop
            $crop_path = $this->config->item('azure_storage_temp_forder').'/'.$data['raw_name'].'_crop'.$data['file_ext'];
            $this->photo_model->crop($scale_image , $crop_path , 300 , 360 ,
                $this->input->post('x',true),
                $this->input->post('y',true),
                $this->input->post('w',true),
                $this->input->post('h',true)
            );
            //Upload image to Azure Storage
            $crop_path_parts = pathinfo($crop_path);
            $this->photo_model->saveToAzureStorage($container , $crop_path_parts['basename'] , $crop_path );


            //thumb
            $thumb_path = $this->config->item('azure_storage_temp_forder').'/'.$data['raw_name'].'_thumb'.$data['file_ext'];
            $this->photo_model->crop($scale_image , $thumb_path , 100 , 120 ,
                $this->input->post('x',true),
                $this->input->post('y',true),
                $this->input->post('w',true),
                $this->input->post('h',true)
            );
            //Upload image to Azure Storage
            $thumb_path_parts = pathinfo($thumb_path);
            $this->photo_model->saveToAzureStorage($container , $thumb_path_parts['basename'] , $thumb_path );
           

            //Save to db_photo
            $photo_data = array(
                'UserGUID' => $this->session->userdata('GUID'),
                'Container' => $container,
                'FullBasename' => $full_path_parts['basename'] ,
                'ThumbBasename' => $thumb_path_parts['basename'],
                'CropBasename' => $crop_path_parts['basename'],
                'ReviewStatus' => 0,
                'DateModify' => date('Y-m-d H:i:s'),
                'DateCreate' => date('Y-m-d H:i:s')
            );
            $insert_string = $this->db->insert_string('[dbo].[i_photo]', $photo_data);
            $this->db->query( $insert_string );
            redirect( base_url().'photo' , 'refresh');
		}


	}
    public function update()
    {
        $image_data = $this->photo_model->download_remote_file_to_local($this->session->userdata('GUID') , $this->input->post('GUID') );
        if(! $image_data){
            redirect( base_url().'photo' , 'refresh');
            exit;
        }
        $container = 'container-'.$this->session->userdata('Role');

        //Scale
        $full_path = $this->config->item('azure_storage_temp_forder').'/'.$image_data['FullBasename'];
        $scale_image = $this->photo_model->scale($full_path , 500 ,500);


        //Crop
        $crop_path = $this->config->item('azure_storage_temp_forder').'/'.$image_data['CropBasename'];
        $this->photo_model->crop($scale_image , $crop_path , 300 , 360 ,
            $this->input->post('x',true),
            $this->input->post('y',true),
            $this->input->post('w',true),
            $this->input->post('h',true)
        );
        //Upload image to Azure Storage
        $crop_path_parts = pathinfo($crop_path);
        $this->photo_model->saveToAzureStorage($container , $crop_path_parts['basename'] , $crop_path );


        //thumb
        $thumb_path = $this->config->item('azure_storage_temp_forder').'/'.$image_data['ThumbBasename'];
        $this->photo_model->crop($scale_image , $thumb_path , 100 , 120 ,
            $this->input->post('x',true),
            $this->input->post('y',true),
            $this->input->post('w',true),
            $this->input->post('h',true)
        );
        //Upload image to Azure Storage
        $thumb_path_parts = pathinfo($thumb_path);
        $this->photo_model->saveToAzureStorage($container , $thumb_path_parts['basename'] , $thumb_path );

        $update_data = array(
            'ReviewStatus' => 2,
            'ReviewRejectReason' => NULL,
            'DateModify' => date('Y-m-d H:i:s')
        );
        
        
        $result = $this->db->update('[dbo].[i_photo]', $update_data, array('GUID' => $image_data['GUID'] ));
        if($result == TRUE){
            redirect( base_url().'photo' , 'refresh');
        }else{
            //DB error
        }

        

    }
    public function delete()
    {
        $GUID = $this->input->post('GUID');
        $row = $this->photo_model->retrieve_photo($GUID);
        $this->db->query( "DELETE FROM [dbo].[i_photo] WHERE GUID = '".$GUID."'" );

        $this->load->library('azure');
        $blobRestProxy = $this->azure->createBlobService();
        $blobRestProxy->deleteBlob($row['Container'], $row['FullBasename']);
        $blobRestProxy->deleteBlob($row['Container'], $row['CropBasename']);
        $blobRestProxy->deleteBlob($row['Container'], $row['ThumbBasename']);
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