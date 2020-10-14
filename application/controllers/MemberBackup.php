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
        
        $this->is_phone_verified();

        $this->global['title'] = "MangalSetu : Dashboard";
        $this->global['content'] = "";
        $this->global['listing'] = $this->member_model->get_listing($this->intrested_in);
        
        $this->loadViews("dashboard", $this->global, NULL , NULL);
    }

    public function setting(){
        
        $this->global['title'] = "MangalSetu : Setting";
        $this->global['content'] = "";
        
        $this->loadViews("setting", $this->global, NULL , NULL);
    }

    public function profile(){
        
        $this->global['title'] = "MangalSetu : Profile";
        $this->global['content'] = "";
        $this->global['member_data'] = $this->member_model->fetch_member_profile($this->id);
        
        $this->loadViews("profile", $this->global, NULL , NULL);
    }

    /**
     * This function is used to send otp to the user
     * @param text $active : This is flag to set the active tab
     */
    function send_otp()
    {   
        $this->load->library('form_validation');
       
        
        if($this->form_validation->run() == FALSE)
        {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );
        }
        else
        {
            $oldPhone = $this->input->post('oldPhone');
            $newPhone = $this->input->post('newPhone');
            
            $resultPas = $this->member_model->matchOldPhone($this->id, $oldPhone);
            
            if(empty($resultPas))
            { 
                $response = array(
                    'status' => 'error',
                    'message'=>'Your old phone number is not correct'
                );
            }
            else
            {
                $creatOtp = $this->member_model->creatOtp($this->id);
                
                $response = array(
                    'status' => 'success',
                    'message'=>'OTP is sent on '.$newPhone
                );
            }
        }
        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
    }

    /**
     * This function is used to send otp to the user
     * @param text $active : This is flag to set the active tab
     */
    function UpdatePhoneNumber()
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
            $newPhone = $this->input->post('newPhone');
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
                if($this->member_model->updatePhone($this->id,$newPhone)){
                    $response = array(
                        'status' => 'success',
                        'message'=>'New Phone Number Changed Successfully'
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'message'=>'New Phone Number Failed to Update'
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
        print_R($filledColumns);
    }

    public function is_phone_verified(){
        
        if($this->member_model->check_phone_verification($this->phone)){
            return true;
        }else{
            redirect('PhoneVerification');
        }
    }

    public function phone_verification(){
        $this->global['title'] = "MangalSetu : Setting";
        $this->global['content'] = "";
        $this->global['memberID'] = $this->id;
        
        $this->loadViews("phone_verify", $this->global, NULL , NULL);
    }

}