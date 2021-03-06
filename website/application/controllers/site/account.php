<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends Site_Base_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->not_Forbidden_required_validation();
        $this->parse_display_data(
            array( 'account' , 'rank' , 'email' , 'role' ,'btn', 'grid','register','member','city','language','birthday','height','bodytype','race',
                'income','property','education','maritalstatus' ,'smoking','drinking' , 'timezoneoffset' , 'dst' , 'alert' ,'view','message')
        );
        $this->load->model('account_model');
        $this->load->model('photo_model');
        $this->load->model('register_model');
        $this->display_data["highlight_navi"] = "account";
        $this->alertMsg();

    }
    public function alertMsg()
    {
        if ( $this->session->userdata('Validated') == 0){
            $this->display_data['alert_content'] = $this->display_data['alert_mail_need_to_vaildate_at_account'];
            return;
        }

        //等待審核中
        if ( $this->session->userdata('ProfileReviewStatus') == 0){
            $this->display_data['alert_content'] = $this->display_data['alert_prifile_review_processing'];
            return;
        }

        //審核不通過
        if ( $this->session->userdata('ProfileReviewStatus') == 1){
            $this->display_data['alert_content'] = $this->display_data['alert_prifile_review_reject'];
            return;
        }

        if ( $this->session->userdata('ForbiddenStatus') == 1){
            $this->display_data['alert_content'] = $this->display_data['alert_this_account_has_been_forbidden'];
            return;
        }
    }

	public function index()
	{
        $this->rank_validated_role_profileReview_updateProfile();
        $this->public_photos();
        $this->private_photos();
        $this->whilelist();
        $this->blockedlist();

        if($this->ajax){
		    $this->utility_model->parse('site/account/index',$this->display_data,TRUE);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/account/index',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/socket_io',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
	}
    public function profile()
    {
        if($this->ajax){
		    $this->utility_model->parse('site/account/profile',$this->display_data);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/account/profile',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
    public function private_approved()
    {
        $this->load->model('action_model');

        $approved_list = $this->photo_model->retrieve_private_privilege( $this->session->userdata('GUID') , 2 );
        $this->display_data['approved_list'] = $approved_list;

        if($this->ajax){
		    $this->utility_model->parse('site/account/approved',$this->display_data,TRUE);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/account/approved',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }

    public function private_reject()
    {
        $this->load->model('action_model');

        $reject_list = $this->photo_model->retrieve_private_privilege( $this->session->userdata('GUID') , 1 );
        $this->display_data['reject_list'] = $reject_list;

        if($this->ajax){
		    $this->utility_model->parse('site/account/reject',$this->display_data,TRUE);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/account/reject',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
    public function private_pendding()
    {
        $this->load->model('action_model');

        $pending_list = $this->photo_model->retrieve_private_privilege( $this->session->userdata('GUID') , 0 );
        $this->display_data['pending_list'] = $pending_list;

        if($this->ajax){
		    $this->utility_model->parse('site/account/pending',$this->display_data,TRUE);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/account/pending',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
    public function private_all()
    {
        $this->load->model('action_model');

        $all_list = $this->photo_model->retrieve_private_privilege( $this->session->userdata('GUID') );
        $this->display_data['all_list'] = $all_list;

        $list = $this->action_model->retrieve_whitelist( $this->session->userdata('GUID') );
        if($this->ajax){
		    $this->utility_model->parse('site/account/private_all',$this->display_data,TRUE);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/account/private_all',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
    public function blocked()
    {
        $this->load->model('action_model');
        $blocked_list = $this->action_model->retrieve_blockedlist( $this->session->userdata('GUID') );
        $this->display_data['blocked_list'] = $blocked_list;

        $list = $this->action_model->retrieve_whitelist( $this->session->userdata('GUID') );
        if($this->ajax){
		    $this->utility_model->parse('site/account/blocked',$this->display_data,TRUE);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/account/blocked',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
    public function favorite()
    {
        $this->load->model('action_model');
        $favorite_list = $this->action_model->retrieve_whitelist( $this->session->userdata('GUID') );
        $this->display_data['favorite_list'] = $favorite_list;

        $list = $this->action_model->retrieve_whitelist( $this->session->userdata('GUID') );
        if($this->ajax){
		    $this->utility_model->parse('site/account/favorite',$this->display_data,TRUE);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/account/favorite',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
    public function added_to_while_list()
    {
        $this->load->model('action_model');
        $added_list = $this->action_model->retrieve_has_been_added_to_whitelist( $this->session->userdata('GUID') );
        $this->display_data['added_list'] = $added_list;

        $list = $this->action_model->retrieve_whitelist( $this->session->userdata('GUID') );
        if($this->ajax){
		    $this->utility_model->parse('site/account/added_to_while_list',$this->display_data,TRUE);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/account/added_to_while_list',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
            $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }
    }
    public function update_profile()
    {
        $GUID = $this->session->userdata('GUID');
		$this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<em class="form_error">', '</em>');
		$this->form_validation->set_rules('timezoneoffset', $this->display_data['grid_column_TimezoneOffset'], 'trim|required|min_length[3]|max_length[50]');
		$this->form_validation->set_rules('aboutme', $this->display_data['grid_column_AboutMe'], 'trim|required');
		$this->form_validation->set_rules('national_code', $this->display_data['grid_column_NationalCode'], 'trim|required');
		$this->form_validation->set_rules('city', $this->display_data['grid_column_City'], 'trim|required');
		$this->form_validation->set_rules('language', $this->display_data['grid_column_Language'], 'trim|required');
		$this->form_validation->set_rules('birthday_date', $this->display_data['birthday_date'], 'trim|required');
		$this->form_validation->set_rules('birthday_month', $this->display_data['birthday_month'], 'trim|required');
		$this->form_validation->set_rules('birthday_year', $this->display_data['birthday_year'], 'trim|required');
		$this->form_validation->set_rules('height', $this->display_data['grid_column_Height'], 'trim|required');
		$this->form_validation->set_rules('bodytype', $this->display_data['grid_column_Bodytype'], 'trim|required');
		$this->form_validation->set_rules('race', $this->display_data['grid_column_Race'], 'trim|required');
		$this->form_validation->set_rules('education', $this->display_data['grid_column_Education'], 'trim');
		$this->form_validation->set_rules('maritalstatus', $this->display_data['grid_column_Maritalstatus'], 'trim');
        $this->form_validation->set_rules('smoking', $this->display_data['grid_column_Smoking'], 'trim|required');
        $this->form_validation->set_rules('drinking', $this->display_data['grid_column_Drinking'], 'trim|required');
        $this->form_validation->set_rules('ideal_desc', $this->display_data['grid_column_IdealDesc'], 'trim|required');

        if( $this->input->cookie("WG_role") == 'male' ){
            $this->form_validation->set_rules('income', $this->display_data['grid_column_Income'], 'trim|required');
            $this->form_validation->set_rules('property', $this->display_data['grid_column_Property'], 'trim|required');
        }
		if ($this->form_validation->run() == FALSE)
		{
            
            $user_data = $this->account_model->retrieve_user_info_by_GUID( $GUID );
            $this->display_data = array_merge($this->display_data , $user_data);
            $this->display_data['Y'] = date('Y',strtotime($user_data['Birthday']));
            $this->display_data['n'] = date('n',strtotime($user_data['Birthday']));
            $this->display_data['j'] = date('j',strtotime($user_data['Birthday']));

            $this->display_data['birthday_year_options'] = $this->register_model->birthday_year_options(1997,1917);
            $this->display_data['birthday_month_options'] = $this->register_model->birthday_month_options();
            $this->display_data['birthday_date_options'] = $this->register_model->birthday_date_options();

            if($this->ajax){
		        $this->utility_model->parse('site/account/update_profile',$this->display_data,TRUE);
            }else{
                $this->utility_model->parse('site/_default/header',$this->display_data);
                $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		        $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		        $this->utility_model->parse('site/account/update_profile',$this->display_data);
		        $this->utility_model->parse('site/_default/footer',$this->display_data);
		        $this->utility_model->parse('site/_default/socket_io',$this->display_data);
                $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
            }
        }else{
            $birthday = date(
                            $this->input->post('birthday_year',true).'-'.
                            $this->input->post('birthday_month',true).'-'.
                            $this->input->post('birthday_date',true) 
                        );
            $update_data = array(
                'TimezoneOffset' => $this->input->post('timezoneoffset'),
                'DST' => $this->input->post('dst'),
                'AboutMe' => $this->input->post('aboutme'),
			    'NationalCode' => $this->input->post('national_code',true),
			    'City' => $this->input->post('city',true),
			    'Language' => $this->input->post('language',true),
			    'Lang' => $this->session->userdata('WG_lang'),
			    'Income' => $this->input->post('income',true),
			    'Property' => $this->input->post('property',true),
			    'Birthday' => $birthday,
			    'Height' => $this->input->post('height',true),
			    'Bodytype' => $this->input->post('bodytype',true),
			    'Race' => $this->input->post('race',true),
			    'Education' => $this->input->post('education',true),
			    'Maritalstatus'=> $this->input->post('maritalstatus',true),
			    'Smoking' => $this->input->post('smoking',true),
			    'Drinking'=> $this->input->post('drinking',true),
			    'IdealDesc'=> $this->input->post('ideal_desc'),
                'ProfileReviewStatus' => 0,
                'ProfileReviewDate' => NULL,
                'ProfileReviewStatus' => 0 , // 0:等待審核
                'ProfileReviewRejectReason' => NULL , 
                'ProfileReviewDate' => NULL , 
                'ProfileLatestUpdateDate' => date('Y-m-d H:i:s') , 
                'DateModify' => date('Y-m-d H:i:s')
            );
            $this->utility_model->setTimezoneOffset($update_data['TimezoneOffset'] , $update_data['DST']);


            $result = $this->db->update('[dbo].[i_user]', $update_data, array('GUID' => $GUID ));
            if($result == TRUE){
                redirect( base_url().'account/update_profile_success' , 'refresh');
            }else{
                //DB error
            }
        }
    }
    public function update_profile_success()
    {
		$this->utility_model->parse('site/_default/header',$this->display_data);
		$this->utility_model->parse('site/_default/header_logout',$this->display_data);
		$this->utility_model->parse('site/_default/female_navi',$this->display_data);
		$this->utility_model->parse('site/account/update_profile_success',$this->display_data);
		$this->utility_model->parse('site/_default/footer',$this->display_data);
        $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);

    }
    private function blockedlist()
    {
        //我的黑名單
        $this->load->model('action_model');
        $list = $this->action_model->retrieve_blockedlist( $this->session->userdata('GUID') );
        $this->display_data['account_my_blocked_list'] = sprintf( $this->display_data['account_my_blocked_list'] , count($list) );
    }
    private function whilelist()
    {
        //我的收藏
        $this->load->model('action_model');
        $list = $this->action_model->retrieve_whitelist( $this->session->userdata('GUID') );
        $this->display_data['account_my_favorite'] = sprintf( $this->display_data['account_my_favorite'] , count($list) );

        //已被加入收藏
        $added_list = $this->action_model->retrieve_has_been_added_to_whitelist( $this->session->userdata('GUID') );
        $this->display_data['account_has_been_added_to_white_list'] = sprintf( $this->display_data['account_has_been_added_to_white_list'] , count($added_list) );

    }

    private function public_photos()
    {
        $public = $this->photo_model->retrieve_my_photos( $this->session->userdata('GUID') , 'public');
        $public_photo = count($public);
        $public_photo_reviewed = 0;
        foreach( $public as $key => $row){
            if($row['ReviewStatus'] == 2){
                $public_photo_reviewed++;
            }
        }
        $this->display_data['public_photo_review'] = sprintf( $this->display_data['account_photo_review_count'] , $public_photo , $public_photo_reviewed );
        $this->display_data['account_public_photo'] = sprintf( $this->display_data['account_public_photo'] , $public_photo );
        
    }
    private function private_photos()
    {
        $private = $this->photo_model->retrieve_my_photos( $this->session->userdata('GUID') , 'private');
        $approve_private = $this->photo_model->retrieve_private_privilege( $this->session->userdata('GUID') , 2 );
        $approve_private_count = count($approve_private);
        $private_photo = count($private);
        $private_photo_reviewed = 0;
        foreach( $private as $key => $row){
            if($row['ReviewStatus'] == 2){
                $private_photo_reviewed++;
            }
        }
        $this->display_data['private_photo_review'] = sprintf( $this->display_data['account_photo_review_count'] , $private_photo , $private_photo_reviewed );
        $this->display_data['account_private_photo'] = sprintf( $this->display_data['account_private_photo'] , $private_photo );
        $this->display_data['account_priviliege_check_my_private_photo'] = sprintf( $this->display_data['account_priviliege_check_my_private_photo'] , $approve_private_count );
    }
    //會員資格
    private function rank_validated_role_profileReview_updateProfile()
    {
        $data = $this->account_model->retrieve_user_info_by_email( $this->session->userdata('Email') );
        switch($data['Rank']){
            case 0:
                $this->display_data['member_ship'] = $this->display_data['rank_deleted'];
            break;
            case 1:
                $this->display_data['member_ship'] = $this->display_data['rank_forbidden'];
            break;
            case 2:
                $this->display_data['member_ship'] = $this->display_data['rank_normal'];
            break;
            case 3:
                $this->display_data['member_ship'] = $this->display_data['rank_normal'];
            break;
            case 5:
                $this->display_data['member_ship'] = $this->display_data['rank_normal_trial'];
            break;
            case 10:
                $this->display_data['member_ship'] = $this->display_data['rank_advance'];
            break;
            case 100:
                $this->display_data['member_ship'] = $this->display_data['rank_advance_vip'];
            break;
            case 255:
                $this->display_data['member_ship'] = $this->display_data['rank_administrator'];
            break;
        }
        switch($data['Validated']){
            case 0:
                $this->display_data['email_validated'] = $this->display_data['email_validated_wait_to_pass'];
                $this->display_data['send_email_validated_again'] = '<a href="/register/sent_email_verification">'.$this->display_data['email_send_validated_again'].'</a>';
            break;
            case 1:
                $this->display_data['email_validated'] = sprintf($this->display_data['email_validated_pass'] , $data['ValidatedDate']);
                $this->display_data['send_email_validated_again'] = '';
            break;

        }
        switch($data['Role']){
            case 'male':
                $this->display_data['role'] = $this->display_data['role_male'];
            break;
            case 'female':
                $this->display_data['role'] = $this->display_data['role_female'];
            break;
        }
        switch($data['ProfileReviewStatus']){
            case 0:
                $this->display_data['profile_review_date'] = '';
                $this->display_data['profile_review'] = $this->display_data['account_profile_review_pending'];
            break;
            case 1:
                $this->display_data['profile_review_date'] = sprintf( $this->display_data['account_profile_review_date'] , $data['ProfileReviewDate']);
                $this->display_data['profile_review'] = sprintf( $this->display_data['account_profile_review_reject'] , $data['ProfileReviewRejectReason']);
            break;
            case 2:
                $this->display_data['profile_review_date'] = sprintf( $this->display_data['account_profile_review_date'] , $data['ProfileReviewDate']);
                $this->display_data['profile_review'] = $this->display_data['account_profile_review_pass'];
            break;

        }
        if( $data['ProfileLatestUpdateDate'] ){
            $this->display_data['profile_latest_update_date']   = sprintf( $this->display_data['account_profile_latest_update_date'] , $data['ProfileLatestUpdateDate']);
        }else{
            $this->display_data['profile_latest_update_date'] = NULL;
        }
    }
    
}

/* End of file logout.php */
/* Location: ./application/controllers/site/logout.php */