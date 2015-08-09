<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function retrieve_has_been_added_to_whitelist($GUID)
    {
        $query = $this->db->query("
        SELECT
            W.[UserGUID] AS [UserGUID],
            P.[ThumbBasename] AS [ThumbBasename],
            U.[Nickname] AS [db_Nickname],
            U.[Role] AS [Role],
            U.[City] AS [City],
            DATEDIFF(YEAR, [Birthday] ,GETDATE()) AS [YearsOld]
        FROM
                [dbo].[i_white_list] AS W
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
            TrackUserGUID = '".$GUID."'");
        $r = $query->result_array();
        $this->lang->load('city');
        foreach($r as $key => $value){
             $r[$key]['City'] = $this->lang->line('city_'.$value['City']);
            if($value['ThumbBasename']){
                $r[$key]['ThumbBasename'] = $this->config->item('azure_storage_baseurl') . $value['UserGUID'] . '/' . $value['ThumbBasename'];
            }else{
                $r[$key]['ThumbBasename'] = $this->config->item('photo_'.$value['Role'].'_default_thumb');
            }
        }
        return $r;

    }
    function retrieve_whitelist($GUID)
    {
        $query = $this->db->query("
        SELECT
            W.[TrackUserGUID] AS [TrackUserGUID],
            P.[ThumbBasename] AS [ThumbBasename],
            U.[Nickname] AS [db_Nickname],
            U.[Role] AS [Role],
            U.[City] AS [City],
            DATEDIFF(YEAR, [Birthday] ,GETDATE()) AS [YearsOld]
        FROM
                [dbo].[i_white_list] AS W
            LEFT JOIN 
                [dbo].[i_user] AS U
            ON
                W.[TrackUserGUID] = U.[GUID]
            
            LEFT JOIN 
                [dbo].[i_photo] AS P 
            ON
                    W.[TrackUserGUID] = P.[UserGUID]
                AND
                    P.[IsCover] = 1
                AND 
                    p.[IsPrivate] = 0
        WHERE 
            W.UserGUID = '".$GUID."'");
        $r = $query->result_array();
        $this->lang->load('city');
        foreach($r as $key => $value){
             $r[$key]['City'] = $this->lang->line('city_'.$value['City']);
            if($value['ThumbBasename']){
                $r[$key]['ThumbBasename'] = $this->config->item('azure_storage_baseurl') . $value['TrackUserGUID'] . '/' . $value['ThumbBasename'];
            }else{
                $r[$key]['ThumbBasename'] = $this->config->item('photo_'.$value['Role'].'_default_thumb');
            }
        }
        return $r;
    }
    function retrieve_blockedlist($GUID)
    {
        $query = $this->db->query("
        SELECT
            B.[TrackUserGUID] AS [TrackUserGUID],
            P.[ThumbBasename] AS [ThumbBasename],
            U.[Nickname] AS [db_Nickname],
            U.[Role] AS [Role],
            U.[City] AS [City],
            DATEDIFF(YEAR, [Birthday] ,GETDATE()) AS [YearsOld]
        FROM
                [dbo].[i_blocked_list] AS B
            LEFT JOIN 
                [dbo].[i_user] AS U
            ON
                B.[TrackUserGUID] = U.[GUID]
            
            LEFT JOIN 
                [dbo].[i_photo] AS P 
            ON
                    B.[TrackUserGUID] = P.[UserGUID]
                AND
                    P.[IsCover] = 1
                AND 
                    p.[IsPrivate] = 0
        WHERE 
            B.UserGUID = '".$GUID."'");
        $r = $query->result_array();
        $this->lang->load('city');
        foreach($r as $key => $value){
             $r[$key]['City'] = $this->lang->line('city_'.$value['City']);
            if($value['ThumbBasename']){
                $r[$key]['ThumbBasename'] = $this->config->item('azure_storage_baseurl') . $value['TrackUserGUID'] . '/' . $value['ThumbBasename'];
            }else{
                $r[$key]['ThumbBasename'] = $this->config->item('photo_'.$value['Role'].'_default_thumb');
            }
        }
        return $r;

    }
}

/* End of file action_model.php */
/* Location: ./application/model/action_model.php */