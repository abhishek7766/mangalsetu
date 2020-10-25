<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/MemberLib.php';

Class Member extends MemberLib {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_model');
        $this->isLoggedIn();
       
    }

    public function index(){

        $this->is_payment_complete();

        $this->global['title'] = "MangalSetu : Dashboard";
        $this->global['profile_percent'] = $this->claculate_profile_per($this->id);

        $searchText = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;
        //print_r($searchText);die;
        $listing = $this->member_model->get_listing($searchText,$this->intrested_in);
        foreach($listing as $k => $list){
            $listing[$k]['favourate'] = false;
            if($this->member_model->isFav($this->id,$list['member_id'])){
                $listing[$k]['favourate'] = true;
            }
        }
        
        $data['listing'] = $listing;
        $this->global['member_details'] = $this->member_model->get_member_profile($this->id);
        $this->loadViews("dashboard", $this->global, $data , NULL);
    }

    public function addFavourate(){
        $member_id = $this->input->post('memberid');
        if($this->member_model->check_fav_list($this->id,$member_id,)){
            
            $result = $this->member_model->remove_fav_list($member_id,$this->id);
            echo(json_encode(array('status'=>FALSE)));

        }else{

            $result = $this->member_model->add_fav_list($member_id,$this->id);
            echo(json_encode(array('status'=>TRUE)));
        }
    }

    public function setting(){
        
        $this->is_payment_complete();

        $this->global['title'] = "MangalSetu : Setting";
        
        $this->loadViews("setting", $this->global, NULL , NULL);
    }

    public function favourate(){
        
        $this->is_payment_complete();

        $this->global['title'] = "MangalSetu : Favouraties";
        $this->global['profile_percent'] = $this->claculate_profile_per($this->id);

        $searchText = $this->security->xss_clean($this->input->post('searchText'));
        $data['searchText'] = $searchText;
        //print_r($searchText);die;
        $listing = $this->member_model->get_favourate($searchText,$this->id);
        if(!empty($listing)){
            foreach($listing as $k => $list){
                $listing[$k]['favourate'] = false;
                if($this->member_model->isFav($this->id,$list['member_id'])){
                    $listing[$k]['favourate'] = true;
                }
            }
            
            $data['listing'] = $listing;
        }
        $this->global['member_details'] = $this->member_model->get_member_profile($this->id);
        $this->loadViews("favouraties.php", $this->global, $data , NULL);
    }

    public function profile(){
        
        $this->is_payment_complete();
        $this->global['title'] = "MangalSetu : Profile";
        $this->global['profile_percent'] = $this->claculate_profile_per($this->id);
        $this->global['member_details'] = $this->member_model->get_member_profile($this->id);
        
        $this->loadViews("profile", $this->global, NULL , NULL);
    }

    public function EditProfile(){
        $this->global['title'] = "MangalSetu : Edit Profile";
        $this->global['member_details'] = $this->member_model->get_member_profile($this->id);
        $this->global['is_prime'] = $this->member_model->check_payment($this->id);
        
        $this->loadViews("editprofile", $this->global, NULL , NULL);
    }
    
    public function saveEdit(){

        $status = '';
        $message = '';

        $data['weight']                 = $this->input->post('weight');
        $data['color']                  = $this->input->post('color');
        $data['currentplace']           = $this->input->post('currentplace');
        $data['address']                = $this->input->post('address');
        $data['zip_code']               = $this->input->post('zip_code');
        $data['fathername']             = $this->input->post('fathername');
        $data['father_occupation']      = $this->input->post('father_occupation');
        $data['mothername']             = $this->input->post('mothername');
        $data['mother_occupation']      = $this->input->post('mother_occupation');
        $data['gotra']                  = $this->input->post('gotra');
        $data['no_of_sisters']          = $this->input->post('no_of_sisters');
        $data['no_of_married_sisters']  = $this->input->post('no_of_married_sisters');
        $data['no_of_brothers']         = $this->input->post('no_of_brothers');
        $data['no_of_married_brothers'] = $this->input->post('no_of_brothers');
        $data['age']                    = $this->input->post('age');
        $data['hobbies']                = $this->input->post('hobbies');
        $data['family']                 = $this->input->post('family');
        $data['language']               = $this->input->post('language');
        $data['occupation']             = $this->input->post('occupation');
        $data['horoscope']              = $this->input->post('horoscope');
        $data['birth_place']            = $this->input->post('birth_place');
        $data['nakshatra']              = $this->input->post('nakshatra');
        $data['bith_time']              = $this->input->post('bith_time');
        $data['short_bio']              = $this->input->post('short_bio');
        
        if($this->member_model->update_member_profile($data,$this->id)){
            $percent = $this->claculate_profile_per($this->id);
            $status = "success";
            $message = "Profile has been saved Successfully!";
        }else{
            $status = "error";
            $message = "Failed to save Profile!";
        }

        header("Content-Type: application/json");
        echo json_encode(array('status' => $status, 'message' => $message));
        exit;
    }
    /**
     * This function is used to send otp to the user
     * @param text $active : This is flag to set the active tab
     */
    function send_otp()
    {   
        $creatOtp = $this->member_model->creatOtp($this->id);
        
        if(isset($creatOtp)|| $creatOtp != false){
            $response = array(
                'status' => 'success',
                'message'=>'OTP is sent!'
            );
        }else{
            $response = array(
                'status' => 'error',
                'message'=>'Your phone number is not correct'
            );
        }

        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
    }

    /**
     * This function is used to send otp to the user
     * @param text $active : This is flag to set the active tab
     */
    function VerifyPhoneNumber()
    {   
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('verifyotp','OTP','required|min_length[4]|max_length[4]');
        
        if($this->form_validation->run() == FALSE)
        {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );
        }
        else
        {
            $otp = $this->input->post('verifyotp');

            $resultPas = $this->member_model->matchOtp($this->id,$otp);
            
            if(empty($resultPas))
            { 
                $response = array(
                    'status' => 'error',
                    'message'=>'Plese insert correct OTP!'
                );
            }
            else
            {
                $success_message =  'Phone Number Verified Successfully proceed to <a href="'.base_url('member').'" style="color:red !important;">Dashboard</a>';
                
                if($this->member_model->PhoneVerified($this->id)){
                    $response = array(
                        'status' => 'success',
                        'message'=> $success_message
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'message'=>'Phone Number Verification Failed'
                    );
                }
            }
        }
        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
    }

    public function claculate_profile_per($member_id){
        $profile = $this->member_model->get_member_profile($member_id);
        $percent = 0;
        //echo "<pre>";print_R($profile);
        if(!empty($profile->age)&&$profile->age != 0 ){
            $percent += 2.9;
        }
        if(!empty($profile->weight)&&$profile->weight != 0 ){
            $percent += 2.9;
        }
        if(!empty($profile->color)&&$profile->color != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->currentplace)&&$profile->currentplace != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->address)&&$profile->address != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->zip_code)&&$profile->zip_code != 0 ){
            $percent += 2.9;
        }
        if(!empty($profile->fathername)&&$profile->fathername != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->mothername)&&$profile->mothername != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->father_occupation)&&$profile->father_occupation != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->mother_occupation)&&$profile->mother_occupation != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->gotra)&&$profile->gotra != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->no_of_sisters)&&$profile->no_of_sisters != 0 ){
            $percent += 2.9;
        }
        if(!empty($profile->no_of_brothers)&&$profile->no_of_brothers != 0 ){
            $percent += 2.9;
        }
        if(!empty($profile->no_of_married_sisters)&&$profile->no_of_married_sisters != 0 ){
            $percent += 2.9;
        }
        if(!empty($profile->no_of_married_brothers)&&$profile->no_of_married_brothers != 0 ){
            $percent += 2.9;
        }
        if(!empty($profile->hobbies)&&$profile->hobbies != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->short_bio)&&$profile->short_bio != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->family)&&$profile->family != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->language)&&$profile->language != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->occupation)&&$profile->occupation != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->horoscope)&&$profile->horoscope != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->birth_place)&&$profile->birth_place != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->bith_time)&&$profile->bith_time != "0000-00-00 00:00:00 " ){
            $percent += 2.9;
        }
        if(!empty($profile->nakshatra)&&$profile->nakshatra != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->image_1)&&$profile->image_1 != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->image_2)&&$profile->image_2 != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->image_3)&&$profile->image_3 != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->image_4)&&$profile->image_4 != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->firstname)&&$profile->firstname != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->lastname)&&$profile->lastname != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->dob)&&$profile->lastname != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->email)&&$profile->email != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->gender)&&$profile->gender != " " ){
            $percent += 2.9;
        }
        if(!empty($profile->state)&&$profile->state != 0 ){
            $percent += 2.9;
        }
        if(!empty($profile->city)&&$profile->city != 0 ){
            $percent += 1.4;
        }
        $data['profile_percent'] = $percent;
        $this->member_model->update_member_profile($data,$this->id);
        return $percent;

    }

    public function is_payment_complete(){
        if(!$this->member_model->check_payment($this->id)){
            redirect('Member/EditProfile'); 
        }else{
            return false;
        }
    }

    function do_upload(){
       
        $type = $this->input->post('type');
        $config['upload_path']      ="./assets/profile_img";
        $config['allowed_types']    = 'gif|jpg|jpeg|png|';
        $config['overwrite']        = TRUE;

        $new_name = $this->id.'-'.$type;
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);

        if ( !$this->upload->do_upload('image'))
        {
            $response = array(
                'status' => 'failed',
                'message'=> $this->upload->display_errors()
            );
        }
        else
        {
            $upload_data = $this->upload->data();
            $data = array(
                $type => $upload_data['file_name']
            );
            if($this->member_model->save_upload($data,$this->id)){
                $response = array(
                    'status' => 'success',
                    'message'=> "Image Upload Successfully!"
                );
            }else{
                $response = array(
                    'status' => 'failed',
                    'message'=> "Error in upload Image!"
                );
            }            
        }
        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
     }
}