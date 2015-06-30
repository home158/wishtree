<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notify_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function select_data_limit_offset($table , $top = 0, $bottom = 20 ,$column ='*' , 
                                    $ProductGUID, 
                                    $sort_column_id = 'NotifyID' , $order_method = 'DESC')
    {
        if(is_array($column)){
            $column = join(",", $column);
        }
        $number_rows = $bottom - $top + 1 ;
        $query_rows = $this->db->query(

            "SELECT "
            .$column. 
            " FROM 
            (
                (
                    [dbo].[i_product_notifications] AS N
                    LEFT JOIN 
                    [dbo].[i_products] AS P
                    ON
                    N.[ProductGUID] = P.[GUID]
                )
                LEFT JOIN 
                [dbo].[i_user] AS U 
                ON
                N.[UserGUID] = U.[GUID]
            ) WHERE N.[ProductGUID] IN ( ".$ProductGUID." )  
            ORDER BY ".$sort_column_id." ".$order_method."
            OFFSET ".$top."  ROWS
            FETCH NEXT ".$number_rows." ROWS ONLY"
        );

        $query_all_list = $this->db->query(
            "SELECT N.[GUID] AS [GUID] FROM 
            (
                (
                    [dbo].[i_product_notifications] AS N
                    LEFT JOIN 
                    [dbo].[i_products] AS P
                    ON
                    N.[ProductGUID] = P.[GUID]
                )
                LEFT JOIN 
                [dbo].[i_user] AS U 
                ON
                N.[UserGUID] = U.[GUID]
            ) WHERE N.[ProductGUID] IN ( ".$ProductGUID." )  
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
    function retrieve_mail_list($table , $GUID , $db_mail_column ='*' , 
                    $sort_column_id = '[Email]' , $order_method = 'ASC')
    {
        if(is_array($db_mail_column)){
            $db_mail_column = join(",", $db_mail_column);
        }
        $query_all_list = $this->db->query(
            "SELECT "
            .$db_mail_column. 
            " FROM 
            (
                (
                    [dbo].[i_product_notifications] AS N
                    LEFT JOIN 
                    [dbo].[i_products] AS P
                    ON
                    N.[ProductGUID] = P.[GUID]
                )
                LEFT JOIN 
                [dbo].[i_user] AS U 
                ON
                N.[UserGUID] = U.[GUID]
            ) WHERE N.[GUID] IN ( ".$GUID." )  
            ORDER BY ".$sort_column_id." ".$order_method
        );
        $result = array(
            'object' => $query_all_list
        );
        return $result;
    }
    function notify_times_add_one($table ,$GUID)
    {
        $this->db->query(
            "UPDATE ".$table." 
            SET [NotifyTimes] = [NotifyTimes] + 1 ,
            [LastNotifyDate] = '".date('Y-m-d H:i:s')."'
            WHERE [GUID] IN ( ".$GUID." )  "
        );
        return;
    }
    

}

/* End of file notify_model.php */
/* Location: ./application/model/notify_model.php */