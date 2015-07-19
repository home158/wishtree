<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
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
            P.[IsPrivate]
        FROM 
        (
            [dbo].[i_user] AS U
            LEFT JOIN 
            [dbo].[i_photo] AS P
            ON
            P.[UserGUID] = U.[GUID]
        )
        WHERE 
            U.[GUID] = '".$GUID."'
        ORDER BY P.[IsPrivate] ASC , P.[PhotoID] ASC
        OFFSET 0 ROWS FETCH NEXT 1 ROWS ONLY
        ");
        $r = $query->row_array(); 
        //沒有圖片及公開圖片時 顯示預設圖片
        if($r['CropBasename'] == NULL or $r['IsPrivate'] == 1){
            $r['CropBasename'] = $this->config->item('photo_'.$r['Role'].'_default');
        }else{
            $r['CropBasename'] = $this->config->item('azure_storage_baseurl').$r['GUID'].'/'.$r['CropBasename'];
        }
        return $r;
    }
    function save_message_history($say , $trget , $content , $type)
    {
        $this->load->helper('file');
        if($type == 'say'){
            $path = $this->config->item('repositories_forder') . '/' . $say . '/' . $trget;
        }
        if($type == 'target'){
            $path = $this->config->item('repositories_forder') . '/' . $trget . '/' . $say;
        }

        $history = read_file($path);
        if($history){
            $logs = json_decode($history);
        }else{
            $logs = array();
        }
        $this->load->library('uuid');
        $uuid = $this->uuid->v4();

        $json_content = array(
            array(
                'track' => $uuid,
                's' => $say,
                'c' => $content,
                't' => time()
            )
        );
        $new_logs = array_merge($json_content , $logs );
        
        
        write_file($path, json_encode($new_logs));

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
            U.[NationalCode],
			P.[ThumbBasename],
			P.[IsPrivate]
        FROM 
        (
            [dbo].[i_message_box] AS B

            LEFT JOIN 
            [dbo].[i_user] AS U
            ON
            B.[FromUserGUID] = U.[GUID]

			LEFT JOIN 
				[dbo].[i_photo] AS P
			ON
				B.[FromUserGUID] = P.[UserGUID]
				AND
				P.[IsCover] = 1
				AND
				P.[IsPrivate] = 0

        ) 
        WHERE 
            B.[UserGUID] = '".$GUID."'
        ");
        $r = $query->result_array();
        $this->config->load('photo');
        $this->lang->load('bodytype');
        $this->lang->load('city');
        foreach($r as $key => $row){
            if( is_null($row['ThumbBasename']) ){
                $r[$key]['ThumbBasename'] = $this->config->item('photo_'.$row['Role'].'_default');
            }else{
                $r[$key]['ThumbBasename'] = $this->config->item('azure_storage_baseurl').$row['FromUserGUID'].'/'.$row['ThumbBasename'];
            }
            $r[$key]['Bodytype'] = $this->lang->line('bodytype_'.$row['Bodytype']);
            $r[$key]['City'] = $this->lang->line('city_'.$row['City']);
        }
        $result['message_box'] = $r;
        return $result;
    }
    function get_history($owner , $sender)
    {
        $this->load->helper('file');
        $path = $this->config->item('repositories_forder') . '/' . $owner . '/' . $sender;
        $history = read_file($path);
        if($history){
            $logs = json_decode($history);
        }else{
            $logs = array();
        }
        return $logs;
    }
}

/* End of file message_model.php */
/* Location: ./application/model/message_model.php */