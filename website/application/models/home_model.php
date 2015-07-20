<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function get_random_user()
    {
        $query = $this->db->query(
        "
        SELECT TOP 10
            U.[GUID],
            U.[Role],
            U.[Nickname],
            P.[ThumbBasename],
            P.[IsPrivate],
            P.[IsCover]
        FROM 
        (
            [dbo].[i_user] AS U
            LEFT JOIN 
            [dbo].[i_photo] AS P
            ON
            P.[UserGUID] = U.[GUID]
			AND
			P.[IsPrivate] = 0
			AND
			P.[IsCover] = 1
        )
		WHERE Role = 'male'
        ORDER BY NEWID()
        ");

        $r = $query->result_array(); 
        foreach($r as $key => $row){
            if( is_null($row['ThumbBasename']) ){
                $r[$key]['ThumbBasename'] = $this->config->item('photo_'.$row['Role'].'_default');
            }else{
                $r[$key]['ThumbBasename'] = $this->config->item('azure_storage_baseurl').$row['GUID'].'/'.$row['ThumbBasename'];
            }
        }
        return $r;
    }
}

/* End of file home_model.php */
/* Location: ./application/model/home_model.php */