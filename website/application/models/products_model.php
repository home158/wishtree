<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Products_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    function select_data_limit_offset($table , $order_by , $top = 0, $bottom = 20 ,$column ='*' , 
                                    $Category = false, $IsOnShelves = "0,1",
                                    $sort_column_id = 'ProductID' , $order_method = 'ASC' , $search_txt = false)
    {
        if($search_txt === false){
            $query_search = "";
        }else{
            $query_search = " AND (concat(Title, ShortDesc) LIKE '%".$search_txt."%')";
        }
        if(is_array($column)){
            $column = join(",", $column);
        }
        if($Category === false){
            $query_category = "";
        }else{
            $query_category = "AND Category = '".$Category."'";
        }
        $number_rows = $bottom - $top + 1 ;
        $query_rows = $this->db->query(
            "SELECT ".$column."
            FROM ".$table."  
            WHERE IsOnShelves IN (".$IsOnShelves.") ".$query_category." ".$query_search." 
            ORDER BY ".$sort_column_id." ".$order_method."
            OFFSET ".$top."  ROWS
            FETCH NEXT ".$number_rows." ROWS ONLY"
        );
        $query_count = $this->db->query("SELECT * FROM ".$table." WHERE IsOnShelves IN (".$IsOnShelves.") ".$query_category." ".$query_search);
        $result = array(
            'object' => $query_rows,
            'num_rows' => $query_count->num_rows()
        );
        return $result;
    }
    public function creact_category_options($arr)
    {
        $html = "";
        foreach ($arr as $key => $value)
        {
            $html .= '<option value="'.$key.'" >'.$value.'</option>';
        }
        return $html;
    }
    public function retrieve_products_by_GUID($column = "*" , $GUID)
    {
        if(is_array($column)){
            $column = join(",", $column);
        }
        $query_rows = $this->db->query(
            "SELECT ".$column."
            FROM 
            (
	                [dbo].[i_products] AS P
	                LEFT JOIN 
	                [dbo].[i_products_category] AS C
	                ON
	                P.[Category] = C.[GUID]
            )
            WHERE P.[GUID] = '".$GUID."'"
        );
        return $query_rows;
    }
    public function query_products_by_category($table, $Category = false ,$column ,
                        $offset = 0 , $next = 6 , 
                        $sort_column_id = 'ProductID' , $order_method = 'ASC', 
                        $search_txt = false)
    {
        if($search_txt === false){
            $query_search = "";
        }else{
            $query_search = " AND (concat(Title, ShortDesc) LIKE '%".$search_txt."%')";
        }
        if(is_array($column)){
            $column = join(",", $column);
        }
        if($Category === false){
            $query_category = "";
        }else{
            $query_category = "AND Category = '".$Category."'";
        }

        $query_rows = $this->db->query(
            "SELECT ".$column."
            FROM 
            (
	                [dbo].[i_products] AS P
	                LEFT JOIN 
	                [dbo].[i_products_category] AS C
	                ON
	                P.[Category] = C.[GUID]
            )
            WHERE IsOnShelves IN (1) ".$query_category." ".$query_search." 
            ORDER BY ".$sort_column_id." ".$order_method."
            OFFSET ".$offset."  ROWS
            FETCH NEXT ".$next." ROWS ONLY"
        );
        $query_count = $this->db->query("SELECT * FROM ".$table." WHERE IsOnShelves IN (1) ".$query_category." ".$query_search);

        $result = array(
            'object' => $query_rows,
            'num_rows' => $query_count->num_rows()
        );
        return $result;
    }
    public function category_count($table , $Category = false)
    {
        if($Category === false){
            $query_category = "";
        }else{
            $query_category = "AND Category = '".$Category."'";
        }
        $query_count = $this->db->query("SELECT * FROM ".$table." WHERE IsOnShelves IN (1) ".$query_category );
        return $query_count->num_rows();
    }
    public function retrieve_vegetable($column ,$table , $r1,$r2 = NULL)
    {
        if(is_array($column)){
            $column = join(",", $column);
        }
        if($r2 == NULL){
            $result = $this->db->query("SELECT ".$column." FROM ".$table." WHERE SpeciesCategoryR1 = ".$r1." AND IsOnShelves = 1" );
        }else{
            $result = $this->db->query("SELECT ".$column." FROM ".$table." WHERE SpeciesCategoryR1 = ".$r1." AND SpeciesCategoryR2 = ".$r2." AND IsOnShelves = 1");
        }
        return $result;
    }
    public function retrieve_category($column , $frontend = FALSE)
    {
        if(is_array($column)){
            $column = join(",", $column);
        }
        if($frontend == TRUE){
            $isShow = "WHERE IsShow = 1  ORDER BY [Priority] ASC";
        }else{
            $isShow = "ORDER BY [CategoryID] ASC ";
        }
        $query = $this->db->query("SELECT ".$column." FROM [dbo].[i_products_category] ".$isShow );
        return $query;
    }
}

/* End of file products_model.php */
/* Location: ./application/model/products_model.php */