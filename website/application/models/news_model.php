<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function select_data_limit_offset($top = 0, $bottom = 20 ,$column ='*' , 
                                    $IsShow = "0,1",
                                    $sort_column_id = 'NewsID' , $order_method = 'DESC' , $search_txt = false)
    {
        if($search_txt === false){
            $query_search = "";
        }else{
            $query_search = " AND (concat([Title], [Content]) LIKE '%".$search_txt."%')";
        }
        if(is_array($column)){
            $column = join(",", $column);
        }

        $number_rows = $bottom - $top + 1 ;
        $query_rows = $this->db->query(
            "SELECT ".$column."
            FROM 
                
	                [dbo].[i_news]
                
            WHERE [IsShow] IN (".$IsShow.")  
            ".$query_search."
            ORDER BY ".$sort_column_id." ".$order_method."
            OFFSET ".$top."  ROWS
            FETCH NEXT ".$number_rows." ROWS ONLY"
        );
        //echo $this->db->last_query();
        $query_all_list = $this->db->query(
            "SELECT ".$column."
            FROM 
                
	                [dbo].[i_news]
                
            WHERE [IsShow] IN (".$IsShow.")  
            ".$query_search."
            ORDER BY ".$sort_column_id." ".$order_method
        );
        $GUID = array();
        foreach ($query_all_list->result_array() as $row)
        {
            array_push($GUID, $row['GUID']);
        }
        $result = array(
            'object' => $query_rows,
            'num_rows' => $query_all_list->num_rows(),
            'GUID_list' => $GUID
        );
        return $result;
    }
}

/* End of file news_model.php */
/* Location: ./application/model/news_model.php */