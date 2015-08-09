<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Whitelist_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function get_tracker($userGUID)
    {
        $query = $this->db->query(
        "
        SELECT
            [UserGUID]
        FROM 
            [dbo].[i_white_list]
        WHERE 
            [TrackUserGUID] = '".$userGUID."'
        ");
        $tracker = array();
        foreach( $query->result_array() as $row )
        {
            array_push($tracker , $row['UserGUID']);
        }
        return $tracker;
    }
    function is_exist($userGUID , $targetGUID)
    {
        $query = $this->db->query(
        "
        SELECT
            *
        FROM 
            [dbo].[i_white_list]
        WHERE 
                [UserGUID] = '".$userGUID."'
            AND
                [TrackUserGUID] = '".$targetGUID."'
        ");
        if($query->num_rows() > 0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }
}

/* End of file whitelist_model.php */
/* Location: ./application/model/whitelist_model.php */