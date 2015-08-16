<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->lang->load('message');
    }
    function write($targetGUID , $message_content)
    {
        //無需審核
        $message_box_data = array(
            'UserGUID' => $targetGUID,
            'FromUserGUID' => $this->session->userdata('GUID'),
            'IsNew' => 1,
            'DateModify' => date('Y-m-d H:i:s')
        );
        $this->update_message_box($message_box_data);
        //無需審核
        $pending_message_data = array(
            'FromUserGUID' => $this->session->userdata('GUID'),
            'FromUserNickname' => $this->session->userdata('Nickname'),
            'TargetUserGUID' => $targetGUID,
            'MessageContent' => $message_content,
            'MessageReviewStatus' => 2,//無需審核
            'MessageReviewDate' => date('Y-m-d H:i:s'),
            'MessageReviewByGUID' => NULL
        );
        $pending_message_insert_string = $this->db->insert_string('[dbo].[i_pending_message]', $pending_message_data);
        $this->db->query( $pending_message_insert_string );
        //寫入FILE
        $msg = $this->message_model->save_message_history($this->session->userdata('GUID') , $this->session->userdata('Nickname') ,$targetGUID , $pending_message_data['MessageContent'] , 'say');
        $this->message_model->save_message_history($this->session->userdata('GUID') , $this->session->userdata('Nickname') ,$targetGUID , $pending_message_data['MessageContent'] , 'target');
        $msg = $this->message_model->message_to_convert($msg);
        return $msg;
    }
    function select_data_limit_offset($table , 
                    $top = 0, $bottom = 20 ,
                    $column ='*',
                    $review_status = '0,1,2',
                    $sort_column_id = 'MessageID' , $order_method = 'ASC' , 
                    $search_txt = false)
    {
        $P = array('DateModify' , 'MessageReviewDate' , 'DateCreate');
        if( in_array( $sort_column_id , $P) ){
            $sort_column_id = 'P.'.$sort_column_id;
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
                ".$table." AS M
            
                    
                LEFT JOIN 
                    [dbo].[i_user] AS U1
                ON
                    M.[FromUserGUID] = U1.[GUID]
            
                LEFT JOIN 
                    [dbo].[i_user] AS U2 
                ON
                    M.[TargetUserGUID] = U2.[GUID]
            
            WHERE 
                MessageReviewStatus in (".$review_status.") 
                ".$query_search." 
            ORDER BY ".$sort_column_id." ".$order_method."
            OFFSET ".$top."  ROWS
            FETCH NEXT ".$number_rows." ROWS ONLY"
        );

        $query_count = $this->db->query(
            "SELECT 
                M.[GUID] AS [GUID]
            FROM 
            (
                    [dbo].[i_user] AS U
                LEFT JOIN 
                    ".$table." AS M
                ON
                    M.[FromUserGUID] = U.[GUID]
            )
            WHERE 
                MessageReviewStatus in (".$review_status.") 
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
    function retrieve_target_info($GUID)
    {
        $this->config->load('photo');
        $query = $this->db->query(
        "
        SELECT
            U.[GUID],
            U.[Role],
            U.[Nickname],
            P.[CropBasename],
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
        )
        WHERE 
            U.[GUID] = '".$GUID."'

        ");
        $r = $query->row_array(); 
        //沒有圖片及公開圖片時 顯示預設圖片
        if($r['CropBasename'] == NULL or $r['IsPrivate'] == 1){
            $r['CropBasename'] = $this->config->item('photo_'.$r['Role'].'_default');
            $r['ThumbBasename'] = $this->config->item('photo_'.$r['Role'].'_default');
        }else{
            $r['CropBasename'] = $this->config->item('azure_storage_baseurl').$r['GUID'].'/'.$r['CropBasename'];
            $r['ThumbBasename'] = $this->config->item('azure_storage_baseurl').$r['GUID'].'/'.$r['ThumbBasename'];
        }
        return $r;
    }
    function save_message_history($sender , $nickname , $trget , $content , $type)
    {
        $this->load->helper('file');
        if($type == 'say'){
            $path = $this->config->item('repositories_forder') . '/' . $sender . '/' . $trget;
        }
        if($type == 'target'){
            $path = $this->config->item('repositories_forder') . '/' . $trget . '/' . $sender;
        }

        $history = read_file($path);
        if($history){
            $logs = json_decode($history);
        }else{
            $logs = array();
        }
        $this->load->library('uuid');
        $uuid = $this->uuid->v4();
        $line = array(
                'track' => $uuid,
                'sender' => $sender,
                'content' => $content,
                'time' => time(),
                'nickname' => $nickname
            );
        $json_content = array(
            $line
        );
        $new_logs = array_merge($json_content , $logs );
        
        
        write_file($path, json_encode($new_logs));
        return $line;
    }
    function update_message_box($message_box_data)
    {
        //check recorde exist
        $query = null; //emptying in case 

        $UserGUID   = $message_box_data['UserGUID']; //getting from post value
        $FromUserGUID = $message_box_data['FromUserGUID'];

        $query = $this->db->get_where('[dbo].[i_message_box]', array(//making selection
            'UserGUID' => $UserGUID,
            'FromUserGUID' => $FromUserGUID
        ));

        $count = $query->num_rows(); //counting result from query
        if($count === 0){
            $message_box_insert_string = $this->db->insert_string('[dbo].[i_message_box]', $message_box_data);
            $this->db->query( $message_box_insert_string );
        }else{
            $r = $query->row_array();
            $this->db->update('[dbo].[i_message_box]', $message_box_data, array('GUID' => $r['GUID']));

        }
    }
    function retrieve_message_box($GUID)
    {
        $query = $this->db->query(
        "
		SELECT
            B.[FromUserGUID] AS FromUserGUID,
			B.[IsNew] ,
			B.[ReadTime],
            ".$this->utility_model->dbColumnDatetime('B.[DateModify]' , '[DateModify]' ).",

			U.[Nickname] AS [db_Nickname],
			U.[Birthday],
			U.[Role],
			U.[Bodytype],
			U.[City],
            U.[NationalCode]
        FROM 
        (
            [dbo].[i_message_box] AS B

            LEFT JOIN 
            [dbo].[i_user] AS U
            ON
            B.[FromUserGUID] = U.[GUID]


        ) 
        WHERE 
            B.[UserGUID] = '".$GUID."'
        ");
        $r = $query->result_array();
        $this->config->load('photo');
        $this->lang->load('bodytype');
        $this->lang->load('city');
        foreach($r as $key => $row){
            
            if( $row['IsNew'] ){
                $r[$key]['new'] = '<img src="'.$this->config->item('message_new_icon').'">';
            }else{
                $r[$key]['new'] = "";
            }
            $info = $this->retrieve_target_info($row['FromUserGUID']);
            $r[$key]['ThumbBasename'] =  $info['ThumbBasename'];
            $r[$key]['Bodytype'] = $this->lang->line('bodytype_'.$row['Bodytype']);
            $r[$key]['City'] = $this->lang->line('city_'.$row['City']);
        }
        $result['message_box'] = $r;
        return $result;
    }
    function message_to_convert($msg_line )
    {
        if($msg_line){
            $info = $this->retrieve_target_info($msg_line['sender']);

            $msg_line['time'] = date('Y-m-d H:i',$msg_line['time'] );
            $msg_line['thumb_image'] = $info['ThumbBasename'];
            $msg_line['nickname'] = $info['Nickname'];
            $msg_line['read_status'] = $this->lang->line('message_send');
   
        }
        return $msg_line;
    }
    function get_history($owner , $sender)
    {
        $this->load->model('utility_model');
        //message box
        $query = $this->db->query(
        "
		SELECT
            *
        FROM
            [dbo].[i_message_box]
        WHERE
            [UserGUID] = '".$sender."'
            AND
            [FromUserGUID] = '".$owner."'
        ");
        $r = $query->row_array();
      

        $this->load->helper('file');
        $path = $this->config->item('repositories_forder') . '/' . $owner . '/' . $sender;
        $history = read_file($path);

        if($history){
            $logs =json_decode($history);
            
            foreach($logs as $key => $row){
                $info = $this->retrieve_target_info($row->sender);

                $logs[$key]->sender = $row->sender;
                $send_time = $row->time;
                $logs[$key]->time =  $this->utility_model->convertTimestampFormat('Y-m-d H:i', $row->time );
                $logs[$key]->thumb_image = $info['ThumbBasename'];
                $logs[$key]->nickname = $info['Nickname'];
                if($logs[$key]->sender == $owner){
                    if( $query->num_rows() > 0){
                        if($r['ReadTime'] == NULL){
                            $logs[$key]->read_status = '';
                        }else{
                            $ReadTime = new DateTime($r['ReadTime']);
                            if($ReadTime->getTimestamp() >= $send_time){
                                $logs[$key]->read_status = $this->lang->line('message_readed');
                            }else{
                                $logs[$key]->read_status = $this->lang->line('message_unread');
                            }
                            $logs[$key]->read_time = $ReadTime->getTimestamp();
                        }
                         
                        
                    }else{
                        $logs[$key]->read_status = $this->lang->line('message_unread');
                    }
                }else{
                    $logs[$key]->read_status = '';
                }
            }
            
        }else{
            $logs = array();
        }
        return $logs;
    }
}

/* End of file message_model.php */
/* Location: ./application/model/message_model.php */