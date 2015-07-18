<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utility_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function is_user_exist_by_GUID($GUID)
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
            return TRUE;
        }else{
            return FALSE;
        }
    }
}

/* End of file utility_model.php */
/* Location: ./application/model/utility_model.php */