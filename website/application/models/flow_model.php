<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flow_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    function record($orderGUID , $code , $FlowNote = NULL)
    {
        $this->config->load('flow',true);
        $data = array(
            "OrderGUID" => $orderGUID ,
            "UserGUID" => $this->session->userdata('GUID'),
            "UserEmail" => $this->session->userdata('Email'),
            "FlowStatu" => $this->config->item('flow_'.$code,'flow'),
            "FlowNote" => $FlowNote,
            "DateCreate" =>  date('Y-m-d H:i:s')
        );
        $str = $this->db->insert_string('[dbo].[i_order_flow]', $data);
        $this->db->query( $str );
        return;
    }
}

/* End of file flow_model.php */
/* Location: ./application/model/flow_model.php */