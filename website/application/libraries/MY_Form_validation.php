<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class MY_Form_validation extends CI_Form_validation {
 	protected $CI;
 	function __construct() {
		parent::__construct();
                // reference to the CodeIgniter super object 
 		$this->CI =& get_instance();
	}
    function password_least_alpha_numeric_check($str) {           
        $this->CI->form_validation->set_message('password_least_alpha_numeric_check', '%s 至少要有一個數字與英文字母。');

        if( preg_match("/^(?=.*\d)(?=.*[A-Za-z]).{8,}$/",$str) ) {
            return true;
        } else {
            return false;
        }
    }
    function password_account_auth_check($password){
        $this->CI->form_validation->set_message('password_account_auth_check', '%s 錯誤。');
        $this->CI->load->model('register_model');
        if( $this->CI->register_model->is_password_account_auth_check($password) == TRUE){
            return TRUE;
        }else{
            return FALSE;
        }
    }
    function email_exist_check($email) {
        $this->CI->form_validation->set_message('email_exist_check', '您輸入的 %s 不是小善心的會員。');
        $this->CI->load->model('register_model');
        //E-mail是否存在
        if( $this->CI->register_model->is_email_exist($email) == TRUE){
            return TRUE;
        }else{
            return FALSE;
        }

    }
    function email_duplicate_check($email) {           
        $this->CI->form_validation->set_message('email_duplicate_check', '相同 %s 不能重複註冊使用。');
        
        
        $this->CI->load->model('register_model');
        //不允許E-mail重覆
        if( $this->CI->register_model->is_email_exist($email) == TRUE){
            return FALSE;
        }else{
            return TRUE;
        }

    }
    /**
     * Validate URL
     *
     * @access    public
     * @param    string
     * @return    string
     */
    function valid_url($url)
    {
        $this->CI->form_validation->set_message('valid_url', '%s 必須選擇一個有效的圖片。');

        $pattern = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
        if (!preg_match($pattern, $url)){
            return FALSE;
        }
        return TRUE;
    }

}

/* End of file MY_Form_validation.php */
/* Location: ./system/language/english/MY_Form_validation.php */