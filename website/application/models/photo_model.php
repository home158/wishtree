<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Photo_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function saveToAzureStorage($container , $blob_name , $local)
    {
        $this->load->library('azure');
        $blobRestProxy = $this->azure->createBlobService();
        $content = fopen($local, "r");

        //Upload blob
        try{
            $blobRestProxy->createBlockBlob($container, $blob_name , $content);
            //chmod('./uploads/'.$data['file_name'], 0777);
            //unlink('./uploads/'.$data['file_name']);
        } catch(ServiceException $e){
            $code = $e->getCode();
            $error_message = $e->getMessage();
            //echo $code.": ".$error_message."<br />";
        }

    }
}

/* End of file photo_model.php */
/* Location: ./application/model/photo_model.php */