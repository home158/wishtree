<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utility_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    function setTimezoneOffset($offset , $DST)
    {
        if($DST)
        {
            switch($offset){
                case '-12:00':
                    $offset = '-11:00';
                break;
                case '-11:00':
                    $offset = '-10:00';
                break;
                case '-10:00':
                    $offset = '-09:00';
                break;
                case '-09:00':
                    $offset = '-08:00';
                break;
                case '-08:00':
                    $offset = '-07:00';
                break;
                case '-07:00':
                    $offset = '-06:00';
                break;
                case '-06:00':
                    $offset = '-05:00';
                break;
                case '-05:00':
                    $offset = '-04:00';
                break;
                case '-04:30':
                    $offset = '-03:30';
                break;
                case '-04:00':
                    $offset = '-03:00';
                break;
                case '-03:30':
                    $offset = '-02:30';
                break;
                case '-03:00':
                    $offset = '-02:00';
                break;
                case '-02:00':
                    $offset = '-01:00';
                break;
                case '-01:00':
                    $offset = '+00:00';
                break;
                case '+00:00':
                    $offset = '+01:00';
                break;
                case '+01:00':
                    $offset = '+02:00';
                break;
                case '+02:00':
                    $offset = '+03:00';
                break;
                case '+03:00':
                    $offset = '+04:00';
                break;
                case '+03:30':
                    $offset = '+04:30';
                break;
                case '+04:00':
                    $offset = '+05:00';
                break;
                case '+04:30':
                    $offset = '+05:30';
                break;
                case '+05:00':
                    $offset = '+06:00';
                break;
                case '+05:30':
                    $offset = '+06:30';
                break;
                case '+05:45':
                    $offset = '+06:45';
                break;
                case '+06:00':
                    $offset = '+07:00';
                break;
                case '+06:30':
                    $offset = '+07:30';
                break;
                case '+07:00':
                    $offset = '+08:00';
                break;
                case '+08:00':
                    $offset = '+09:00';
                break;
                case '+09:00':
                    $offset = '+10:00';
                break;
                case '+09:30':
                    $offset = '+10:30';
                break;
                case '+10:00':
                    $offset = '+1:00';
                break;
                case '+11:00':
                    $offset = '+12:00';
                break;
                case '+12:00':
                    $offset = '+13:00';
                break;

            }
        }
        $this->session->set_userdata('TimezoneOffset' , $offset);
        $cookie = array(
            'name'   => 'TimezoneOffset',
            'value'  => $offset,
            //'domain' => '.wishgirl-wishtree.com',
            'expire' => '7776000',
            'prefix' => 'WG_'
        );
        $this->input->set_cookie($cookie);
    }
    function getTimezoneOffset()
    {
        $__session = $this->session->userdata('TimezoneOffset' );
        if( $__session ){
            return $__session;
        }
        $__cookie = $this->input->cookie('WG_TimezoneOffset');
        if( $__cookie ){
            return $__cookie;
        }
        return '+00:00';
    }
    function dbColumnDatetime($column , $AS_column = NULL)
    {
        if(  $AS_column == NULL)  $AS_column = $column;

        $str = "CONVERT(VARCHAR(22) , SWITCHOFFSET ( CONVERT(datetimeoffset, ".$column."), '".$this->getTimezoneOffset()."')  ,121 ) AS ".$AS_column;

        return $str;
    }
    function is_user_exist_by_GUID($GUID)
    {
      
        $query = $this->db->query(
        "
        SELECT
            *
        FROM 
            [dbo].[i_user]
        WHERE 
            [GUID] = '".$GUID."'
        ");
        if($query->num_rows() > 0) {
            return TRUE;
        }else{
            return FALSE;
        }
    }
}

/* End of file utility_model.php */
/* Location: ./application/model/utility_model.php */