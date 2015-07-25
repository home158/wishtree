<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
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
                [i_user] 
            WHERE 
                GUID = '".$GUID."' 
        ");
        $result = array(
            'object' => $query_rows
        );
        return $result;
    }
    function select_data_limit_offset($table , 
                    $top = 0, $bottom = 20 ,
                    $column ='*',
                    $Rank_between_from = 0, $Rank_between_to = 255 ,
                    $Profile_review_status = '0,1,2', 
                    $sort_column_id = 'UserID' , $order_method = 'ASC' , 
                    $search_txt = false)
    {
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
                ".$table."  
            WHERE 
                ProfileReviewStatus in (".$Profile_review_status.") 
                AND 
                (Rank BETWEEN ".$Rank_between_from." AND ".$Rank_between_to.") 
                ".$query_search." 
            ORDER BY ".$sort_column_id." ".$order_method."
            OFFSET ".$top."  ROWS
            FETCH NEXT ".$number_rows." ROWS ONLY"
        );

        $query_count = $this->db->query(
            "SELECT 
                * 
             FROM 
                ".$table." 
             WHERE 
                ProfileReviewStatus in (".$Profile_review_status.") 
                AND 
                (Rank BETWEEN ".$Rank_between_from." AND ".$Rank_between_to.") 
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


}

/* End of file member_model.php */
/* Location: ./application/model/member_model.php */