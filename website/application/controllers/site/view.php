<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View extends Site_Base_Controller {
    private $Role;
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(
            array('btn', 'grid', 'city', 'income', 'language', 'height', 'bodytype', 'race', 'Education', 'maritalstatus', 'smoking', 'drinking' , 'view')
        );
        $this->display_data["highlight_navi"] = "home";
        
        $this->login_required_validation();
        $this->mail_required_validation();
        $this->load->model('view_model');
    }
    private function mail_required_validation()
    {
        if($this->session->userdata('Validated') ==0){
            redirect( base_url().'account' );
        }
    }
    public function index($GUID)
	{
        
        $this->display_data['profile'] = $this->user_profile($GUID);
        $r = $this->view_model->get_cover_photo($GUID , $this->Role);
        $this->display_data['CropBasename'] = $r['CropBasename'];
        $this->display_data['FullBasename'] = $r['FullBasename'];
        $this->display_data['view_lightbox_data_title'] = sprintf($this->display_data['view_lightbox_data_title'] , $this->session->userdata['Nickname']);
        
        $this->display_data['public_photo'] = $this->view_model->get_public_photo($GUID);
        $myGUID = $this->session->userdata('GUID');
        $private_photos = $this->view_model->get_private_photo($GUID);

        
        $this->load->model('photo_model');
        $privilege = $this->photo_model->retrieve_privilege($GUID  , $myGUID);
        
        //是否有瀏覽私人照片權限
        if($privilege == 0 ){
            $this->display_data['private_photo'] = array();
            //沒有私人照片權限時，私人照片wording 替換
            if(count($private_photos)==0 ){
                $this->display_data['view_photo_private'] = '';
            }else{
                $this->display_data['view_photo_private'] = '<a id="ask_private_photo_privilege" href="javascript:;" data-tracker="'.$GUID.'">'.$this->display_data['view_ask_private_photo_privilege'].'</a>';
            }
        }else{
            $this->display_data['private_photo'] = $private_photos;
        }


        $this->display_data['UserGUID'] = $GUID;

        if($this->ajax){
		    $this->utility_model->parse('site/view/profile',$this->display_data , TRUE);
        }else{
		    $this->utility_model->parse('site/_default/header',$this->display_data);
		    $this->utility_model->parse('site/_default/header_logout',$this->display_data);
		    $this->utility_model->parse('site/_default/female_navi',$this->display_data);
		    $this->utility_model->parse('site/view/profile',$this->display_data);
		    $this->utility_model->parse('site/_default/footer',$this->display_data);
		    $this->utility_model->parse('site/_default/footer_body_html',$this->display_data);
        }

	}
    private function user_profile($GUID)
    {
        $r = $this->view_model->get_user_info($GUID);
        $this->Role = $r['Role'];
        $profile = array();
        if( !is_null($r['Nickname'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_Nickname_s'] , $r['Nickname']) );

        if( $r['NationalCode'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_NationalCode_s'] , $r['NationalCode']) );

        if( $r['City'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_City_s'] , $this->display_data['city_'.$r['City']] ) );

        if( $r['Income'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_Income_s'] , $this->display_data['income_'.$r['Income']] ) );

        if( $r['Language'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_Language_s'] , $this->display_data['language_'.$r['Language']] ) );

        if( $r['YearsOld'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_old_s'] , $r['YearsOld'] ) );

        if( $r['Height'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_Height_s'] , $this->display_data['height_'.$r['Height']] ) );

        if( $r['Bodytype'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_Bodytype_s'] , $this->display_data['bodytype_'.$r['Bodytype']] ) );

        if( $r['Race'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_Race_s'] , $this->display_data['race_'.$r['Race']] ) );

        if( $r['Education'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_Education_s'] , $this->display_data['education_'.$r['Education']] ) );
            
        if( $r['Maritalstatus'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_Maritalstatus_s'] , $this->display_data['maritalstatus_'.$r['Maritalstatus']] ) );
            
        if( $r['Smoking'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_Smoking_s'] , $this->display_data['smoking_'.$r['Smoking']] ) );
            
        if( $r['Drinking'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_Drinking_s'] , $this->display_data['drinking_'.$r['Drinking']] ) );
            
        return implode("\n",$profile);
    }
}

