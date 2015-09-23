<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class View_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function get_user_info($GUID)
    {
      
        $query = $this->db->query(
        "
        SELECT
            *,
            DATEDIFF(YEAR, [Birthday] ,GETDATE()) AS [YearsOld]
        FROM 
            [dbo].[i_user]
        WHERE 
            [GUID] = '".$GUID."'
        ");
        if($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return FALSE;
        }
    }
    function get_private_photo($GUID)
    {
        $query = $this->db->query(
        "
        SELECT
            P.[FullBasename],
            P.[CropBasename],
            P.[ThumbBasename],
            P.[UserGUID],
            P.[IsPrivate],
            P.[IsCover] 
        FROM 
            [dbo].[i_photo] AS P
			LEFT JOIN 
			[dbo].[i_user] AS U
            ON
            P.[UserGUID] = U.[GUID]
        WHERE 
                P.[UserGUID] = '".$GUID."'
			AND
			    [IsPrivate] = 1
			AND
			    P.[ReviewStatus] = 2
        ");
        $r = $query->result_array();
        foreach($r as $key => $row)
        {
            $r[$key]['_ThumbBasename'] = $this->config->item('azure_storage_baseurl').$row['UserGUID'].'/'.$row['ThumbBasename'];
            $r[$key]['_CropBasename'] = $this->config->item('azure_storage_baseurl').$row['UserGUID'].'/'.$row['CropBasename'];
            $r[$key]['_FullBasename'] = $this->config->item('azure_storage_baseurl').$row['UserGUID'].'/'.$row['FullBasename'];
        }
        return $r;
    }
    function get_public_photo($GUID)
    {
        $query = $this->db->query(
        "
        SELECT
            P.[FullBasename],
            P.[CropBasename],
            P.[ThumbBasename],
            P.[UserGUID],
            P.[IsPrivate],
            P.[IsCover] 
        FROM 
            [dbo].[i_photo] AS P
			LEFT JOIN 
			[dbo].[i_user] AS U
            ON
            P.[UserGUID] = U.[GUID]
        WHERE 
                P.[UserGUID] = '".$GUID."'
			AND
			    [IsPrivate] = 0
			AND
			    P.[ReviewStatus] = 2
        ");
        $r = $query->result_array();
        foreach($r as $key => $row)
        {
            $r[$key]['_ThumbBasename'] = $this->config->item('azure_storage_baseurl').$row['UserGUID'].'/'.$row['ThumbBasename'];
            $r[$key]['_CropBasename'] = $this->config->item('azure_storage_baseurl').$row['UserGUID'].'/'.$row['CropBasename'];
            $r[$key]['_FullBasename'] = $this->config->item('azure_storage_baseurl').$row['UserGUID'].'/'.$row['FullBasename'];
        }
        return $r;
    }
    function get_cover_photo($GUID , $Role)
    {
        $query = $this->db->query(
        "
        SELECT
            P.[CropBasename],
            P.[FullBasename],
            P.[UserGUID],
            U.[Nickname],
            U.[Role],
            U.[City]
        FROM 
            [dbo].[i_photo] AS P
			LEFT JOIN 
			[dbo].[i_user] AS U
            ON
            P.[UserGUID] = U.[GUID]
        WHERE 
                P.[UserGUID] = '".$GUID."'
			AND
			    [IsPrivate] = 0
			AND
			    [IsCover] = 1
			AND
			    P.[ReviewStatus] = 2
        ");
        if($query->num_rows() == 0){
            $r['CropBasename'] = $this->config->item('photo_'.$Role.'_default_crop');
            $r['FullBasename'] = $this->config->item('photo_'.$Role.'_default_crop');
            return $r;
        }else{
            $r = $query->row_array();
            $r['CropBasename'] = $this->config->item('azure_storage_baseurl').$r['UserGUID'].'/'.$r['CropBasename'];
            $r['FullBasename'] = $this->config->item('azure_storage_baseurl').$r['UserGUID'].'/'.$r['FullBasename'];
            return $r;

        }
    }
}

/* End of file view_model.php */
/* Location: ./application/model/view_model.php */