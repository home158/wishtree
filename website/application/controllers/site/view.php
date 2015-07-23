<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class View extends Site_Base_Controller {
    private $Role;
    public function __construct()
    {
        parent::__construct();
        $this->parse_display_data(
            array('btn', 'grid', 'city', 'income', 'language', 'height', 'bodytype', 'race', 'Education', 'maritalstatus', 'smoking', 'drinking')
        );
        
        $this->login_required_validation();
        $this->load->model('view_model');
    }
    public function index($GUID)
	{
        
        $this->display_data['profile'] = $this->user_profile($GUID);
        $this->display_data['CropBasename'] = $this->view_model->get_cover_photo($GUID , $this->Role);

		$this->parser->parse('site/_default/header',$this->display_data);
		$this->parser->parse('site/_default/header_logout',$this->display_data);
		$this->parser->parse('site/_default/female_navi',$this->display_data);
		$this->parser->parse('site/view/profile',$this->display_data);

		$this->parser->parse('site/_default/footer',$this->display_data);

	}
    private function user_profile($GUID)
    {
        $r = $this->view_model->get_user_info($GUID);
        $this->Role = $r['Role'];
        $profile = array();
        if( !is_null($r['Nickname'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_Nickname_s'] , $r['Nickname']) );

        if( !is_null($r['NationalCode'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_NationalCode_s'] , $r['NationalCode']) );

        if( !is_null($r['City'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_City_s'] , $this->display_data['city_'.$r['City']] ) );

        if( $r['Income'] )
            array_push( $profile , sprintf( $this->display_data['grid_column_Income_s'] , $this->display_data['income_'.$r['Income']] ) );

        if( !is_null($r['Language'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_Language_s'] , $this->display_data['language_'.$r['Language']] ) );

        if( !is_null($r['Birthday'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_old_s'] , $r['Birthday'] ) );

        if( !is_null($r['Height'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_Height_s'] , $this->display_data['height_'.$r['Height']] ) );

        if( !is_null($r['Bodytype'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_Bodytype_s'] , $this->display_data['bodytype_'.$r['Bodytype']] ) );

        if( !is_null($r['Race'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_Race_s'] , $this->display_data['race_'.$r['Race']] ) );

        if( !is_null($r['Education'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_Education_s'] , $this->display_data['education_'.$r['Education']] ) );
            
        if( !is_null($r['Maritalstatus'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_Maritalstatus_s'] , $this->display_data['maritalstatus_'.$r['Maritalstatus']] ) );
            
        if( !is_null($r['Smoking'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_Smoking_s'] , $this->display_data['smoking_'.$r['Smoking']] ) );
            
        if( !is_null($r['Drinking'] ))
            array_push( $profile , sprintf( $this->display_data['grid_column_Drinking_s'] , $this->display_data['drinking_'.$r['Drinking']] ) );
            
        return implode("\n",$profile);
    }
}

