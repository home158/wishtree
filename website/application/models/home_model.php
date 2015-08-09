<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    /*
    *   30日內註冊的會員以亂數排序
    *
    */
    function get_newcomer_user($role)
    {
        $query = $this->db->query(
        "
        SELECT TOP 10
            U.[GUID] AS [UserGUID],
            U.[Role],
            U.[Nickname],
            P.[ThumbBasename],
            P.[IsPrivate],
            P.[IsCover],
            U.[DateCreate]
        FROM 
        (
            [dbo].[i_user] AS U
            LEFT JOIN 
            [dbo].[i_photo] AS P
            ON
                P.[UserGUID] = U.[GUID]
			AND
			    P.[IsPrivate] = 0
			AND
			    P.[IsCover] = 1
            AND
                P.[ReviewStatus] = 2
        )
		WHERE 
				Role = '".$role."'
			AND 
				U.[ProfileReviewStatus] = 2
			AND
				U.[DateCreate] >  DATEADD(d,-30,GETUTCDATE())
        ORDER BY NEWID()
        ");

        $r = $query->result_array(); 
        foreach($r as $key => $row){
            if( is_null($row['ThumbBasename']) ){
                $r[$key]['ThumbBasename'] = $this->config->item('photo_'.$row['Role'].'_default_thumb');
            }else{
                $r[$key]['ThumbBasename'] = $this->config->item('azure_storage_baseurl').$row['UserGUID'].'/'.$row['ThumbBasename'];
            }
        }
        return $r;
    }
    /*
    * 使用者必須完成資料驗證才可以被瀏覽到
    *
    */
    function get_random_user($role)
    {
        $query = $this->db->query(
        "
        SELECT TOP 10
            U.[GUID] AS [UserGUID],
            U.[Role],
            U.[Nickname],
            P.[ThumbBasename],
            P.[IsPrivate],
            P.[IsCover]
        FROM 
        (
            [dbo].[i_user] AS U
            LEFT JOIN 
            [dbo].[i_photo] AS P
            ON
                P.[UserGUID] = U.[GUID]
			AND
			    P.[IsPrivate] = 0
			AND
			    P.[IsCover] = 1
            AND
                P.[ReviewStatus] = 2
        )
		WHERE 
				Role = '".$role."'
			AND 
				U.[ProfileReviewStatus] = 2
        ORDER BY NEWID()

        ");

        $r = $query->result_array(); 
        foreach($r as $key => $row){
            if( is_null($row['ThumbBasename']) ){
                $r[$key]['ThumbBasename'] = $this->config->item('photo_'.$row['Role'].'_default_thumb');
            }else{
                $r[$key]['ThumbBasename'] = $this->config->item('azure_storage_baseurl').$row['UserGUID'].'/'.$row['ThumbBasename'];
            }
        }
        return $r;
    }
}

/* End of file home_model.php */
/* Location: ./application/model/home_model.php */