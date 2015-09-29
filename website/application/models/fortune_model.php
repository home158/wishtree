<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fortune_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function retrieve_histories($GUID, $fortuneGUID = NULL)
    {
        if($fortuneGUID === NULL){
            $query_fortuneGUID = "";
        }else{
            $query_fortuneGUID = " AND GUID = '".$fortuneGUID."'";
        }
        $query = $this->db->query("
        SELECT
        [FortuneID],
        [GUID] AS [db_GUID],
        [Services],
        [Nickname] AS [db_Nickname],
        [Role] AS [db_Role],
        [Birthday] AS [db_Birthday],
        [Lunar],
        [PblmEmail],
        [PblmTel],
        [Maritalstatus],
        [PaymentStatus],
        [FortuneStatus],
        [ST],
        ".$this->utility_model->dbColumnDatetime('[DateCreate]')."

        FROM
            [dbo].[i_fortune]
        WHERE 
            UserGUID = '".$GUID."'
            ".$query_fortuneGUID."
        ORDER BY FortuneID DESC
            
            ");
        $r = $query->result_array();
        $this->lang->load('role');
        foreach($r as $key => $value){
            $r[$key]['FortuneID'] = 'WP'.strval('000').strval($value['FortuneID']);

            $r[$key]['OderTitle'] = $value['db_Nickname'] . ' ' . $this->lang->line('role_gender_'.$value['db_Role']).', '.$value['Lunar'];
            $r[$key]['OderStatus'] = $this->order_status($value);
            $r[$key]['FortuneStatus'] = $this->fortune_status($value);
            $r[$key]['ST'] = $this->fortune_ST($value);
            $r[$key]['Discussion'] = $this->fortune_discussion($value);
            
        }
        return $r;
    }
    function retrieve_response_messages($GUID, $fortuneGUID)
    {
        $query = $this->db->query("
        SELECT
            [FortuneMessageID],
            [GUID] AS [db_GUID],
            [FortuneGUID],
            [PblmCode],
            [FortuneMessage],
            ".$this->utility_model->dbColumnDatetime('[DateCreate]' , NULL , 19)."
        FROM
            [dbo].[i_fortune_message]
        WHERE 
            UserGUID = '".$GUID."'
            AND
            FortuneGUID = '".$fortuneGUID."'
            AND
            ReplyParent is NULL
        ORDER BY FortuneMessageID ASC
            
        ");
        $r = $query->result_array();
        foreach($r as $key => $value){
            $r[$key]['MessageID'] = 'PR'.strval('000').strval($value['FortuneMessageID']);
            $r[$key]['MessageReply'] = $this->retrieve_reply_messages($value['db_GUID']);
            
        }
        return $r;
    }
    function retrieve_reply_messages($GUID)
    {
        $query = $this->db->query("
        SELECT
            [FortuneMessageID],
            [GUID] AS [db_GUID],
            [FortuneGUID],
            [FortuneMessage],
            ".$this->utility_model->dbColumnDatetime('[DateCreate]' , NULL , 19)."
        FROM
            [dbo].[i_fortune_message]
        WHERE 
            ReplyParent = '".$GUID."'
        ORDER BY FortuneMessageID ASC
            
        ");
        $r = $query->result_array();
        foreach($r as $key => $value){
            $r[$key]['FortuneMessage'] = nl2br($value['FortuneMessage']);
            
        }
        $data['reply'] = $r;
        if(count($r) >0){
            return $this->parser->parse('site/fortune/reply_response',$data , TRUE);
        }else{
            return;
        }
    }
    function fortune_discussion($r)
    {
        $this->lang->load('fortune');
        $str = '';
        $str .= sprintf($this->lang->line('fortune_new_pblm'),$r['db_GUID']);
        $str .= '<br/>';
        $str .= sprintf($this->lang->line('fortune_response') ,$r['db_GUID']);
        return $str;

    }
    function fortune_ST($r)
    {
        $this->lang->load('fortune');
        if($r['ST'] == 1){
            return $this->lang->line('fortune_st_1');
        }else{
            if($r['PaymentStatus'] < 2){
                return $this->lang->line('fortune_st_0');
            }else{
                return '';
            }
        }
    }
    function fortune_pblm_radio($_id = NULL)
    {
        $this->lang->load('fortune');
        $fotrune_plmb = $this->config->item('fotrune_pblm');
        $str = '<ul>';
        foreach($fotrune_plmb as $key){
            if($key == $_id){
                $checked = 'checked';
            }else{
                $checked = '';
            }
            $str .=  '<li><input type="radio" name="pblm_class" '.$checked.' value="'.strval($key).'">'.$this->lang->line('fortune_pblm_'.strval($key)).'</li>';
        }
        $str .= '</ul>';
        return $str;
    }
    function fortune_pblm_select()
    {
        $this->lang->load('fortune');
        $fotrune_plmb = $this->config->item('fotrune_pblm_year');
        $str = '';
        foreach($fotrune_plmb as $key){
            $str .= '<div data-value="'.strval($key).'">'.$this->lang->line('fortune_pblm_'.strval($key)).'</div>';
        }
        return $str;
    }
    function fortune_status($r)
    {
        $this->lang->load('fortune');
        if($r['FortuneStatus'] == 0){
            return $this->lang->line('fortune_status_0');
        }
        if($r['FortuneStatus'] == 1){
            return $this->lang->line('fortune_status_1');
        }
        if($r['FortuneStatus'] == 2){
            return $this->lang->line('fortune_status_2');
        }
        if($r['FortuneStatus'] == 3){
            return $this->lang->line('fortune_status_3');
        }
    }
    function order_status($r)
    {
        $this->lang->load('fortune');
        if($r['PaymentStatus'] == 0){
            return $this->lang->line('fortune_paymentstatus_0');
        }
        if($r['PaymentStatus'] == 1){
            return $this->lang->line('fortune_paymentstatus_1');
        }
        if($r['PaymentStatus'] == 2){
            return $this->lang->line('fortune_paymentstatus_2');
        }
        if($r['PaymentStatus'] == 3){
            return $this->lang->line('fortune_paymentstatus_3');
        }
        
    }
}

/* End of file fortune_model.php */
/* Location: ./application/model/fortune_model.php */