<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

    
    function retrieve_error_msg($code , $debug = NULL , $arr =NULL)
    {
        $this->config->load('error',true);

        $status = array(
            'error_code' => $code,
            'msg' => $this->config->item('error_code_'.$code,'error')
        );
        if($debug){
            $status['debug'] = $debug;
        }
        if($arr != NULL){
            $status['content'] = $arr;
        }
        return json_encode($status);
    }
}

/* End of file welcome.php */
/* Location: ./application/model/error_model.php */