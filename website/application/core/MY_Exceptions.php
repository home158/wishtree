<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions {

    public function show_404()
    {
        $CI =& get_instance();
        $CI->load->view('_default/notfound_view');

        echo $CI->output->get_output();
        exit;
    }
}
/* End of file MY_Exceptions.php */
/* Location: ./application/core/MY_Exceptions.php */