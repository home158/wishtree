<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mywish_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function retrive_mywish($UserGUID ,  $ReviewStatus = '0,1,2' , $DeleteStatus = '0,1' , $MothballStatus = '0,1' , $expire = NULL)
    {
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
        $query = $this->db->query("
        SELECT 
            W.[GUID] AS [db_GUID],
            W.[UserGUID] AS [UserGUID],
            W.[WishCategory] AS [WishCategory],
            W.[WishTitle] AS [WishTitle],
            W.[WishContent] AS [WishContent],
            W.[WishReviewStatus] AS [WishReviewStatus],
            
            ".$this->utility_model->dbColumnDatetime('W.[DateExpire]' , '[DateExpire]' , 10).",
            P.[ThumbBasename] AS [ThumbBasename],
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
        WHERE 
                W.UserGUID = '".$UserGUID."'
            AND
                W.WishReviewStatus IN (".$ReviewStatus.")
            AND
                W.DeleteStatus IN (".$DeleteStatus.")
            AND 
                W.MothballStatus IN (".$MothballStatus.")
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
        return $r;
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
}

/* End of file mywish_model.php */
/* Location: ./application/model/mywish_model.php */