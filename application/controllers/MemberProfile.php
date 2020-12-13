<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/MemberLib.php';

Class MemberProfile extends MemberLib {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('member_model');
       
    }

    public function index(){
        $memberId = $this->uri->segment(2);
        
        if(isset($memberId)){

            $memberData = $this->member_model->get_member_profile($memberId);

            if($memberData){

                //echo "<pre>";
                //print_r($memberData);

                $data['title'] = 'Mangalsetu : Member Profile';
                $data['member_details'] = $memberData;
                
                $this->load->view('page/memberProfile',$data);

            }else{
                 redirect('Welcome');
            }
        }else{
            redirect('Welcome');
        }
    }
}
?>