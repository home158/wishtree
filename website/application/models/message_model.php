<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function retrieve_target_info($GUID)
    {
        $this->config->load('photo');
        $query = $this->db->query(
        "
        SELECT
            U.[GUID],
            U.[Role],
            U.[Nickname],
            P.[CropBasename],
            P.[IsPrivate]
        FROM 
        (
            [dbo].[i_user] AS U
            LEFT JOIN 
            [dbo].[i_photo] AS P
            ON
            P.[UserGUID] = U.[GUID]
        )
        WHERE 
            U.[GUID] = '".$GUID."'
        ORDER BY P.[IsPrivate] DESC , P.[PhotoID] ASC
        OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
        ");
        $r = $query->row_array(); 
        //沒有圖片及公開圖片時 顯示預設圖片
        if($r['CropBasename'] == NULL or $r['IsPrivate'] == 0){
            $r['CropBasename'] = $this->config->item('photo_'.$r['Role'].'_default');
        }
        return $r;
    }
}

/* End of file message_model.php */
/* Location: ./application/model/message_model.php */