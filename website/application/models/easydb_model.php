<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Easydb_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function insert_data($table , $data)
    {
        $str = $this->db->insert_string($table, $data);
        $this->db->query( $str );
        return;
    }

    function select_data($table , $data , $column ='*')
    {
        if(is_array($column)){
            $column = join(",", $column);
        }
        $this->db->select($column);
        $result = $this->db->get_where($table, $data );
        return $result;
    }
    function select_data_limit_offset($table , $order_by , $top = 0, $bottom = 20 ,$column ='*',$Rank_between_from = 0, $Rank_between_to = 255 ,$Register_type="1,2,3", $sort_column_id = 'UserID' , $order_method = 'ASC' , $search_txt = false)
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
            "SELECT ".$column."
            FROM ".$table."  
            WHERE RegisterType IN (".$Register_type.") AND (Rank BETWEEN ".$Rank_between_from." AND ".$Rank_between_to.") ".$query_search." 
            ORDER BY ".$sort_column_id." ".$order_method."
            OFFSET ".$top."  ROWS
            FETCH NEXT ".$number_rows." ROWS ONLY"
        );
        /*
        $query_rows = $this->db->query(
            "SELECT * from ( 
                SELECT TOP ".$number_rows." * from (
                        SELECT ".$column.", ROW_NUMBER() OVER (order by ".$order_by.") as r_n_n 
                            FROM ".$table." WHERE RegisterType in (".$Register_type.") AND Rank BETWEEN ".$Rank_between_from." AND ".$Rank_between_to."  
                ) xx WHERE r_n_n > ".$top." 
            ) xx ORDER BY ".$sort_column_id." ".$order_method );
        */
        $query_count = $this->db->query("SELECT * FROM ".$table." WHERE RegisterType in (".$Register_type.") AND (Rank BETWEEN ".$Rank_between_from." AND ".$Rank_between_to.") " . $query_search);
        //echo "SELECT * FROM ".$table." WHERE Rank BETWEEN ".$Rank_between_from." AND ".$Rank_between_to;
        $result = array(
            'object' => $query_rows,
            'num_rows' => $query_count->num_rows()
        );
        return $result;
    }
    function delete_rows_where_in($table , $guid , $column = 'GUID')
    {
        $result = $this->db->query( "DELETE FROM ".$table." WHERE ".$column." IN (".$guid.")" );
        return $result;
    }

}

/* End of file easydb_model.php */
/* Location: ./application/model/easydb_model.php */