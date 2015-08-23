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
                    $mothball_status = '0,1',
                    $expire = '0',
                    $sort_column_id = 'WishID' , $order_method = 'ASC' , 
                    $search_txt = false)
    {
        $W = array( 'DeleteDate' , 'MothballDate' , 'DateModify', 'DateCreate');
        if( in_array( $sort_column_id , $W) ){
            $sort_column_id = 'W.'.$sort_column_id;
        }
        if($expire == '1'){
            $query_expire = " AND W.[DateExpire] < '".date('Y-m-d ').'23:59:59'."' ";
        }else{
            $query_expire = '';
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
                    W.MothballStatus in (".$mothball_status.") 
                AND
                    W.DeleteStatus in (".$delete_status.") 
                ".$query_search." 
                ".$query_expire."
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
                    W.MothballStatus in (".$mothball_status.") 
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
    function retrive_mywish($UserGUID = FALSE , $wishGUID = FALSE, $w_role = NULL,  $ReviewStatus = '0,1,2' , $DeleteStatus = '0,1' , $MothballStatus = '0,1' , $expire = NULL)
    {
        if(is_null($w_role )){
            $query_role = "";
        }else{
            $query_role = " AND U.Role = '".$w_role."'";
        }
                
        if(is_null($expire )){
            $expire_str = "";
        }else{
            if($expire === TRUE){
                $expire_str = " AND W.[DateExpire] < '".date('Y-m-d ').'23:59:59'."' ";
            }
            if($expire === FALSE){
                $expire_str = " AND W.[DateExpire] > '".date('Y-m-d ').'23:59:59'."' ";
            }
 
        }
        if($wishGUID){
            $query_wishGUID = " AND W.GUID = '".$wishGUID."'";
        }else{
            $query_wishGUID = "";
        }
        if($UserGUID){
            $query_userGUID = " AND W.UserGUID = '".$UserGUID."'";
        }else{
            $query_userGUID = "";
        }
        $query = $this->db->query("
        SELECT 
            [Privilege] ,
            W.[GUID] AS [db_GUID],
            W.[UserGUID] AS [UserGUID],
            W.[WishCategory] AS [WishCategory],
            W.[WishTitle] AS [WishTitle],
            W.[WishContent] AS [WishContent],
            W.[WishReviewStatus] AS [WishReviewStatus],
            
            ".$this->utility_model->dbColumnDatetime('W.[DateExpire]' , '[DateExpire]' , 10).",
            P.[ThumbBasename] AS [ThumbBasename],
            P.[CropBasename] AS [CropBasename],
            U.[Nickname] AS [db_Nickname],
            U.[Role] AS [Role],
            U.[City] AS [City],
            DATEDIFF(YEAR, [Birthday] ,GETDATE()) AS [YearsOld]
        FROM 
                [dbo].[i_wish] AS W
            LEFT JOIN 
                [dbo].[i_user] AS U
            ON
                W.[UserGUID] = U.[GUID]
            LEFT JOIN 
                [dbo].[i_photo] AS P 
            ON
                    W.[UserGUID] = P.[UserGUID]
                AND
                    P.[IsCover] = 1
                AND 
                    p.[IsPrivate] = 0
            LEFT JOIN [dbo].[i_photo_privilege] AS R
            ON 
                    R.TrackUserGUID = W.[UserGUID]
                AND
                    R.UserGUID = '".$this->session->userdata('GUID')."'
        WHERE 
                W.WishReviewStatus IN (".$ReviewStatus.")
            AND
                W.DeleteStatus IN (".$DeleteStatus.")
            AND 
                W.MothballStatus IN (".$MothballStatus.")
            ".$query_userGUID."
            ".$query_wishGUID."
            ".$query_role."
            ".$expire_str."
        ORDER BY
            W.DateCreate DESC
        ");
        
        $r = $query->result_array();
        $this->lang->load('city');
        $this->lang->load('mywish');
        foreach($r as $key => $value){
             $r[$key]['City'] = $this->lang->line('city_'.$value['City']);
             $r[$key]['WishCategory'] = $this->lang->line('mywish_category_'.$value['WishCategory']);
             $r[$key]['db_WishCategory'] = $value['WishCategory'];
             $r[$key]['WishContent'] = nl2br($value['WishContent']);
             $r[$key]['db_WishContent'] = $value['WishContent'];
             
            if($value['ThumbBasename']){
                $r[$key]['ThumbBasename'] = $this->config->item('azure_storage_baseurl') . $value['UserGUID'] . '/' . $value['ThumbBasename'];
            }else{
                $r[$key]['ThumbBasename'] = $this->config->item('photo_'.$value['Role'].'_default_thumb');
            }
            if($value['CropBasename']){
                $r[$key]['CropBasename'] = $this->config->item('azure_storage_baseurl') . $value['UserGUID'] . '/' . $value['CropBasename'];
            }else{
                $r[$key]['CropBasename'] = $this->config->item('photo_'.$value['Role'].'_default_crop');
            }
            if($value['WishReviewStatus'] == 1 ){
                $r[$key]['DateExpire'] = $this->lang->line('mywish_wish_reject_s');
                $r[$key]['DateExpireClass'] = 'danger';
            }
            if($value['WishReviewStatus'] == 0 ){
                $r[$key]['DateExpireClass'] = 'warning';
                $r[$key]['DateExpire'] = $this->lang->line('mywish_wish_not_review');

            }
            if($value['WishReviewStatus'] == 2 ){
                $r[$key]['DateExpireClass'] = 'success';


            }
        }
        if($wishGUID){
            return $r[0];
        }else{
            return $r;
        }
    }
    function retrive_mywish_by_GUID($GUID)
    {
        $query = $this->db->query("
        SELECT 
            *
        FROM 
            [dbo].[i_wish]
        WHERE
            GUID = '".$GUID."'
        ");
        if($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->row_array();
        }

    }
    function retrive_reply($wishGUID)
    {
        $query = $this->db->query("
        SELECT 
            R.[UserGUID] AS [db_userGUID],
            [ReplyContent],
            U.[Nickname] AS [db_nickname],
            U.[Role] AS [Role],
            U.[City] AS [City],
            ".$this->utility_model->dbColumnDatetime('R.[DateCreate]' , '[time]' , 16).",
            [ThumbBasename]
        FROM 
                [dbo].[i_wish_reply] AS R
            LEFT JOIN 
                [dbo].[i_user] AS U
            ON
                R.[UserGUID] = U.[GUID]
            LEFT JOIN 
                [dbo].[i_photo] AS P 
            ON
                    R.[UserGUID] = P.[UserGUID]
                AND
                    P.[IsCover] = 1
                AND 
                    p.[IsPrivate] = 0       
        WHERE
            WishGUID = '".$wishGUID."'
        ORDER BY
            R.[DateCreate] DESC
        ");

        $r = $query->result_array();
        $this->lang->load('city');
        $this->lang->load('mywish');
        foreach($r as $key => $value){
            if($value['ThumbBasename']){
                $r[$key]['ThumbBasename'] = $this->config->item('azure_storage_baseurl') . $value['db_userGUID'] . '/' . $value['ThumbBasename'];
            }else{
                $r[$key]['ThumbBasename'] = $this->config->item('photo_'.$value['Role'].'_default_thumb');
            }
            $r[$key]['content'] = nl2br($value['ReplyContent']);
        }
        return $r;
    }
}