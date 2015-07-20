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
            *
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
    function get_cover_photo($GUID , $Role)
    {
        $query = $this->db->query(
        "
        SELECT
            P.[CropBasename],
            P.[UserGUID],
            U.[Role]
        FROM 
            [dbo].[i_photo] AS P
			LEFT JOIN 
			[dbo].[i_user] AS U
            ON
            P.[UserGUID] = U.[GUID]
        WHERE 
            [UserGUID] = '".$GUID."'
			AND
			[IsPrivate] = 0
			AND
			[IsCover] = 1
        ");
        if($query->num_rows() == 0){
            return $this->config->item('photo_'.$Role.'_default');
        }else{
            $r = $query->row_array();
            return $this->config->item('azure_storage_baseurl').$r['UserGUID'].'/'.$r['CropBasename'];

        }
    }
}

/* End of file view_model.php */
/* Location: ./application/model/view_model.php */