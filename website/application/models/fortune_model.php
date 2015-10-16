<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fortune_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function select_data_limit_offset($table , 
                    $top = 0, $bottom = 20 ,
                    $column ='*',
                    $payment_status = '0,1,2',
                    $ST = '0,1',
                    $MT = '0,1',
                    $sort_column_id = 'FortuneID' , $order_method = 'ASC' , 
                    $search_txt = false)
    {
        if($search_txt === false){
            $query_search = "";
        }else{
            $query_search = " AND (concat(U.Nickname, Email) LIKE '%".$search_txt."%')";
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
                    [dbo].[i_user] AS U
                LEFT JOIN 
                    ".$table." AS F
                ON
                    F.[UserGUID] = U.[GUID]
            )
            WHERE 
                    PaymentStatus in (".$payment_status.") 
                AND
                    ST in (".$ST.") 
                AND
                    MT in (".$MT.") 

                ".$query_search." 
            ORDER BY ".$sort_column_id." ".$order_method."
            OFFSET ".$top."  ROWS
            FETCH NEXT ".$number_rows." ROWS ONLY"
        );

        $query_count = $this->db->query(
            "SELECT 
                F.[GUID] AS [GUID]
            FROM 
            (
                    [dbo].[i_user] AS U
                LEFT JOIN 
                    ".$table." AS F
                ON
                    F.[UserGUID] = U.[GUID]
            )
            WHERE 
                PaymentStatus in (".$payment_status.") 

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
                    [dbo].[i_user] AS U
                LEFT JOIN 
                    [dbo].[i_fortune] AS F
                ON
                    F.[UserGUID] = U.[GUID]
            )
            WHERE 
                F.GUID = '".$GUID."' 
        ");
        $result = array(
            'object' => $query_rows
        );
        return $result;
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
        [NotifyPaymentStatus],
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
        if($r['PaymentStatus'] == 2)
            return $this->lang->line('fortune_no_status');
        if($r['NotifyPaymentStatus'] == 1)
            return $this->lang->line('fortune_no_status');

        if($r['ST'] == 1){
            return $this->lang->line('fortune_st_1');
        }else{
            if($r['PaymentStatus'] < 2){
                return $this->lang->line('fortune_st_0');
            }else{
                return $this->lang->line('fortune_no_status');
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
        if($r['ST'] == 1)
            return $this->lang->line('fortune_no_status');
        
        if($r['PaymentStatus'] == 0)
        {
            return $this->lang->line('fortune_no_status');
        }else{
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
    }
    function order_status($r)
    {
        $this->lang->load('fortune');
        if($r['ST'] == 1)
            return $this->lang->line('fortune_no_status');
        if($r['PaymentStatus'] == 0){
            if($r['NotifyPaymentStatus'] == 0)
                return sprintf( $this->lang->line('fortune_paymentstatus_0') , $r['db_GUID']);
            else
                return $this->lang->line('fortune_paymentstatus_2');
                
        }
        if($r['PaymentStatus'] == 1){
            return $this->lang->line('fortune_payment_vip');
        }
        if($r['PaymentStatus'] == 2){
            return $this->lang->line('fortune_paymentstatus_3');
        }

        
    }
}

/* End of file fortune_model.php */
/* Location: ./application/model/fortune_model.php */