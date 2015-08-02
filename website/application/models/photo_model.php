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
            echo $code.": ".$error_message."<br />";
        }

    }
    function retrieve_photo($GUID)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_photo] WHERE GUID = '".$GUID."'");
        if ($query->num_rows() > 0)
        {
            return $query->row_array(); 
        }else{
            return FALSE;
        }
    }
    function retrieve_public_cover_photo($userGUID)
    {
        $query = $this->db->query("
            SELECT 
                * 
            FROM 
                [dbo].[i_photo] 
            WHERE 
                    UserGUID = '".$userGUID."' 
                AND 
                    IsPrivate = 0
                AND
                    IsCover = 1
        ");
        $row = $query->row_array();
        $thumb_image_url = $this->config->item('azure_storage_baseurl') . $row['UserGUID'] . '/' . $row['ThumbBasename'].'?'.time();

        return $thumb_image_url;

    }
    function retrieve_my_photos($userGUID , $type)
    {
        if($type == 'public'){
            $query = $this->db->query("SELECT * FROM [dbo].[i_photo] WHERE UserGUID = '".$userGUID."' AND IsPrivate = 0 ORDER BY PhotoID");
        }
        if($type == 'private'){
            $query = $this->db->query("SELECT * FROM [dbo].[i_photo] WHERE UserGUID = '".$userGUID."' AND IsPrivate = 1 ORDER BY PhotoID");
        }
        $r = $query->result_array();
        $this->lang->load('photo');
        $my_photo = array();
        foreach($r as $key => $row){

            switch($row['ReviewStatus']){
                case 0:
                    $review_status = $this->lang->line('photo_review_pending');
                break;
                case 1:
                    $review_status = $this->lang->line('photo_review_reject');
                break;
                case 2:
                    $review_status = $this->lang->line('photo_review_pass');
                break;
            }
            $photo = array(
                'IsPrivate' => $row['IsPrivate'],
                'GUID' => $row['GUID'],
                'full_image_url' => $this->config->item('azure_storage_baseurl') . $row['UserGUID'] . '/' . $row['FullBasename'].'?'.time(),
                'crop_image_url' =>$this->config->item('azure_storage_baseurl') . $row['UserGUID'] . '/' . $row['CropBasename'].'?'.time(),
                'thumb_image_url' =>$this->config->item('azure_storage_baseurl') . $row['UserGUID'] . '/' . $row['ThumbBasename'].'?'.time(),
                'review_status' => $review_status,
                'ReviewStatus' => $row['ReviewStatus'],
                'IsCover' => ($row['IsCover']==1)?'on':'off'
            );
            
            array_push($my_photo , $photo);
            
        }


        return $my_photo;

    }
    function download_remote_file_to_local( $userGUID , $GUID)
    {
        $query = $this->db->query("SELECT * FROM [dbo].[i_photo] WHERE UserGUID = '".$userGUID."' AND GUID = '".$GUID."'");
       
        if ($query->num_rows() > 0)
        {
            $row = $query->row_array(); 
            $this->load->library('azure');
            $blobRestProxy = $this->azure->createBlobService();
            $blob = $blobRestProxy->getBlob( $row['UserGUID'] , $row['FullBasename']);
            $source = stream_get_contents($blob->getContentStream());
            
            $file = $this->config->item('azure_storage_temp_forder').'/'.$row['FullBasename'];
            $result = file_put_contents($file, $source);
            return $row;
        }else{
            return FALSE;
        }
        
    }
    function scale($full_path , $min_width , $min_height )
    {
        $size = getimagesize($full_path);
        $ratio = $size[0]/$size[1]; // width/height
    
        if($size[0] > $min_width or $size[1] > $min_height){
            if( $ratio > 1) {
                $width = $min_width;
                $height = $min_width/$ratio;
            }
            else {
                $width = $min_width*$ratio;
                $height = $min_height;
            }
            $src = imagecreatefromstring(file_get_contents($full_path));
            $dst = imagecreatetruecolor($width,$height);
            imagecopyresampled($dst,$src,0,0,0,0,$width,$height,$size[0],$size[1]);
            imagedestroy($src);
        }else{
            $dst = imagecreatefromstring(file_get_contents($full_path));
        }
        return $dst;
    }
    function crop($scale_image , $target_path , $targ_w, $targ_h ,$x , $y , $w , $h)
    {
    
        //crop image
        $jpeg_quality = 90;
    
        $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
    
        imagecopyresampled($dst_r,$scale_image,0,0,$x,$y,
        $targ_w,$targ_h, $w,$h);
        imagejpeg($dst_r,$target_path,$jpeg_quality);
    }
    function select_data_limit_offset($table , 
                    $top = 0, $bottom = 20 ,
                    $column ='*',
                    $review_status = '0,1,2',
                    $is_private= '0,1',
                    $sort_column_id = 'PhotoID' , $order_method = 'ASC' , 
                    $search_txt = false)
    {
        $P = array('DateModify' , 'ReviewDate' , 'DateCreate');
        if( in_array( $sort_column_id , $P) ){
            $sort_column_id = 'P.'.$sort_column_id;
        }


        if($search_txt === false){
            $query_search = "";
        }else{
            $query_search = " AND (concat(Name, Email) LIKE '%".$search_txt."%')";
        }
        if(is_array($column)){
            $column = join(",", $column);
        }
        $number_rows = $bottom - $top + 1 ;
        $query_rows = $this->db->query(
            "SELECT 
                ".$column."
            FROM 
            (
                    [dbo].[i_user] AS U
                LEFT JOIN 
                    ".$table." AS P
                ON
                    P.[UserGUID] = U.[GUID]
            )                
 
            WHERE 
                ReviewStatus in (".$review_status.") 
                AND
                IsPrivate in (".$is_private.") 
                ".$query_search." 
            ORDER BY ".$sort_column_id." ".$order_method."
            OFFSET ".$top."  ROWS
            FETCH NEXT ".$number_rows." ROWS ONLY"
        );

        $query_count = $this->db->query(
            "SELECT 
                P.[GUID] AS [GUID]
            FROM 
            (
                    [dbo].[i_user] AS U
                LEFT JOIN 
                    ".$table." AS P
                ON
                    P.[UserGUID] = U.[GUID]
            )
            WHERE 
                ReviewStatus in (".$review_status.") 
                AND
                IsPrivate in (".$is_private.") 
                ".$query_search." 
            ORDER BY ".$sort_column_id." ".$order_method.""
        );
        $GUID = array();
        foreach ($query_count->result_array() as $row)
        {
            array_push($GUID, $row['GUID']);
        }

        $result = array(
            'object' => $query_rows,
            'num_rows' => $query_count->num_rows(),
            'GUID_list' => $GUID
        );
        return $result;
    }
    function retrive_row_data_by_GUID($GUID ,  $column = '*')
    {
        if(is_array($column)){
            $column = join(",", $column);
        }
        $query_rows = $this->db->query(
            "SELECT 
                ".$column."
            FROM 
            (
                    [dbo].[i_user] AS U
                LEFT JOIN 
                    [dbo].[i_photo] AS P
                ON
                    P.[UserGUID] = U.[GUID]
            )
            WHERE 
                P.GUID = '".$GUID."' 
        ");
        $result = array(
            'object' => $query_rows
        );
        return $result;
    }
    function set_public_cover($userGUID)
    {
        $public_cover = $this->db->query("
            SELECT 
                [GUID] 
            FROM 
                [dbo].[i_photo] 
            WHERE 
                    UserGUID = '".$userGUID."' 
                AND 
                    IsPrivate = 0
                AND 
                    IsCover = 1
            ORDER BY PhotoID
        ");
        $public = $this->db->query("SELECT [GUID] FROM [dbo].[i_photo] WHERE UserGUID = '".$userGUID."' AND IsPrivate = 0 ORDER BY PhotoID");

        if($public->num_rows() == 0 ){
            return TRUE;
        }
        if($public_cover->num_rows() != 1 ){
            //Set all public photo Cover is false
            $reset_data = array(
                'IsCover' => 0
            );

            $this->db->update('[dbo].[i_photo]', $reset_data, array('IsPrivate' => 0, 'UserGUID'=> $userGUID));

            $update_data = array(
                'IsCover' => 1,
                'DateModify' => date('Y-m-d H:i:s')
            );
            $public_row = $public->row_array();
            $this->db->update('[dbo].[i_photo]', $update_data, array('GUID' => $public_row['GUID'], 'UserGUID'=> $userGUID));

            return TRUE;
        }
        return TRUE;

    }
}

/* End of file photo_model.php */
/* Location: ./application/model/photo_model.php */