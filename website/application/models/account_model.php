<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    /*
    *   Cheeck agree cookie at register , step 1
    *   
    */
    function retrieve_user_info_by_email($email)
    {
        $query = $this->db->query("
        SELECT 
        * ,
        ".$this->utility_model->dbColumnDatetime('[DateModify]').",
        ".$this->utility_model->dbColumnDatetime('[DateCreate]').",
        ".$this->utility_model->dbColumnDatetime('[LastLoginTime]').",
        ".$this->utility_model->dbColumnDatetime('[ProfileReviewDate]').",
        ".$this->utility_model->dbColumnDatetime('[ValidatedDate]').",
        ".$this->utility_model->dbColumnDatetime('[ProfileLatestUpdateDate]')."
        FROM 
            [dbo].[i_user]
        WHERE 
            Email = '".$email."'");
        return $query->row_array();
    }
    function retrieve_user_info_by_GUID($GUID)
    {
        $query = $this->db->query("
        SELECT
        * ,
        ".$this->utility_model->dbColumnDatetime('[DateModify]').",
        ".$this->utility_model->dbColumnDatetime('[DateCreate]').",
        ".$this->utility_model->dbColumnDatetime('[LastLoginTime]').",
        ".$this->utility_model->dbColumnDatetime('[ProfileReviewDate]').",
        ".$this->utility_model->dbColumnDatetime('[ValidatedDate]').",
        ".$this->utility_model->dbColumnDatetime('[ProfileLatestUpdateDate]')."
        FROM
            [dbo].[i_user] 
        WHERE 
            GUID = '".$GUID."'");
        return $query->row_array();
    }
}

/* End of file account_model.php */
/* Location: ./application/model/account_model.php */