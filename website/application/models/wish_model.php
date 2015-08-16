<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wish_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function select_data_limit_offset($table , 
                    $top = 0, $bottom = 20 ,
                    $column ='*',
                    $review_status = '0,1,2',
                    $delete_status= '0,1',
                    $sort_column_id = 'WishID' , $order_method = 'ASC' , 
                    $search_txt = false)
    {
        $W = array( 'DeleteDate' , 'MothballDate' , 'DateModify', 'DateCreate');
        if( in_array( $sort_column_id , $W) ){
            $sort_column_id = 'W.'.$sort_column_id;
        }


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
            (
                    ".$table." AS W
                LEFT JOIN 
                    [dbo].[i_user] AS U
                ON
                    W.[UserGUID] = U.[GUID]
            )                
 
            WHERE 
                WishReviewStatus in (".$review_status.") 
                AND
                W.DeleteStatus in (".$delete_status.") 
                ".$query_search." 
            ORDER BY ".$sort_column_id." ".$order_method."
            OFFSET ".$top."  ROWS
            FETCH NEXT ".$number_rows." ROWS ONLY"
        );

        $query_count = $this->db->query(
            "SELECT 
                W.[GUID] AS [GUID]
            FROM 
            (
                    ".$table." AS W
                LEFT JOIN 
                    [dbo].[i_user] AS U
                ON
                    W.[UserGUID] = U.[GUID]
            )
            WHERE 
                WishReviewStatus in (".$review_status.") 
                AND
                W.DeleteStatus in (".$delete_status.") 
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
    function retrive_row_data_by_GUID($GUID ,  $column = '*')
    {
        if(is_array($column)){
            $column = join(",", $column);
        }
        $query_rows = $this->db->query(
            "SELECT 
                ".$column."
            FROM 
            (
                    [dbo].[i_wish] AS W
                LEFT JOIN 
                    [dbo].[i_user] AS U
                ON
                    W.[UserGUID] = U.[GUID]
            )
            WHERE 
                W.GUID = '".$GUID."' 
        ");
        $result = array(
            'object' => $query_rows
        );
        return $result;
    }
}