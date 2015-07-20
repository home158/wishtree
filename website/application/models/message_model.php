<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->lang->load('message');
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
            B.[DateModify],
			U.[Nickname],
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

                $logs[$key]->time = date('Y-m-d H:i',$row->time );
                $logs[$key]->thumb_image = $info['ThumbBasename'];
                $logs[$key]->nickname = $info['Nickname'];
                if($logs[$key]->sender == $owner){
                    if( $query->num_rows() > 0){
                        if($r['ReadTime'] >= $logs[$key]->time){
                            $logs[$key]->read_status = $this->lang->line('message_readed');
                        }else{
                            $logs[$key]->read_status = $this->lang->line('message_unread');
                        }
                        $logs[$key]->read_time = $r['ReadTime'];
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