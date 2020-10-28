<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('member_model');
        $this->load->database();
    }

	public function index()
	{
        $this->isLoggedIn();
    }

    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        if($this->session->has_userdata('member')){
            $isLoggedIn = $this->session->member['isLoggedIn'];       
        }else{
            $isLoggedIn = false;
        }
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $data['title']      = "Mangalsetu Member Registration";
            $data['content']    = "";
            $data['refrenceids']= $this->get_refrenceids();
            $data['states']     = $this->get_states();

            $this->load->view('page/member_registration',$data);
        }
        else
        {
            redirect('Member');
        }
    }

    public function CreatNewMember(){
        
        $status = '';
        $message = '';
        
        $this->form_validation->set_rules('firstname', 'Firstname', 'required');
        $this->form_validation->set_rules('lastname','Lastname','required');
        $this->form_validation->set_rules('email','Email','',);
        $this->form_validation->set_rules('dob','dob','required');
        $this->form_validation->set_rules('state','State','required');
        $this->form_validation->set_rules('city','city','required');
        $this->form_validation->set_rules('intrested_in','Intrested In','required');
        $this->form_validation->set_rules('gender','gender','required');
        $this->form_validation->set_rules('phone','phone','required|is_unique[tbl_member.phone]');

        if ($this->form_validation->run() == FALSE)
            {
                $status = "error";
                $message = validation_errors();
            }
            else
            {
                $data['firstname']      = ucfirst($this->input->post('firstname'));
                $data['lastname']       = ucfirst($this->input->post('lastname'));
                $data['member_id']      = $this->get_memberID();
                $data['phone']          = $this->input->post('phone');
                $data['dob']            = $this->input->post('dob');
                $data['gender']         = $this->input->post('gender');
                $data['state']          = $this->input->post('state');
                $data['city']           = $this->input->post('city');
                $data['intrested_in']   = $this->input->post('intrested_in');
                $data['refrenceid']     = $this->input->post('refrenceid');
                $data['email']          = strtolower($this->input->post('email'));
                $data['roleid']         = "4";
                $data['email_verify']   = md5(rand());
                $data['phone_verify']   = mt_rand(1000, 9999);
                $data['created_on']     = date('Y-m-d H:i:s');
                
                if($this->member_model->creat_new_member($data)){

                    $emaildata['body']   = $this->load->view('emails/welcome_email','',TRUE);
                    $emaildata['email']= $data['email'];
                    $emaildata['subject']= "Welcome To Mangalsetu.";

                    $email_status = $this->sendMail($emaildata);

                    $page_date['passcode'] = $data['email_verify'];
                    $emaildata['body']   = $this->load->view('emails/email_verification',$page_date,TRUE);
                    $emaildata['email']= $data['email'];
                    $emaildata['subject']= "Email Verification";

                    $email_status = $this->sendMail($emaildata);
                    
                    if($email_status){
                        $status = "success";
                        $message = "You have successfully register! Email has been sent!";
                    }else{
                        $status = "success";
                        $message = "You have successfully register!";
                    }
                }else{
                    $status = "error";
                    $message = "Failed to insert";
                }
            }
        
        header("Content-Type: application/json");
        echo json_encode(array('status' => $status, 'message' => $message));
        exit;
    }

    public function is_email_unique($email){
        if($this->member_model->is_email_unique($email)){
            $this->form_validation->set_message('is_email_unique', 'The {field} already exist!');
            return false;
        }else{
            return true;
        }
    }

    public function get_MemberId(){
        $last_id = $this->member_model->lastId();
        $last_id++;
        $new_id = "MSM-".str_pad($last_id, 4, "0", STR_PAD_LEFT);
        return $new_id;
    }

    public function get_states(){
        $data = $this->member_model->fetch_states();
        return $data;
    }

    public function get_cities(){
        if($this->input->post('state_id'))
        {
        echo $this->member_model->fetch_city($this->input->post('state_id'));
        }
    }

    public function get_refrenceids(){
        $data = $this->member_model->fetch_refrenceid();
        return $data;
    }

    public function VerifyEmail($code=null){
        if($code != Null){
            if($this->member_model->VerifyEmail($code)){
                $this->load->view('emails/EmailVerify_success');
            }else{
                $this->load->view('emails/EmailVerify_failed');
            }
        }else{
            redirect('Registration');
        }
    }

    public function sendMail($data=null){   
        
         // Load PHPMailer library
         $this->load->library('phpmailer_lib');
        
         // PHPMailer object
         $mail = $this->phpmailer_lib->load();
         
         // SMTP configuration
         $mail->isSMTP();
         $mail->Host     = 'ssl://smtp.gmail.com';
         $mail->SMTPAuth = true;
         $mail->Username = 'mangalsetuconference@gmail.com';
         $mail->Password = 'jaishrikrishna';
         $mail->SMTPSecure = 'ssl';
         $mail->Port     = 465;
         
         $mail->setFrom('mangalsetuconference@gmail.com', 'Mangalsetu');
         $mail->addReplyTo('mangalsetuconference@gmail.com', 'Mangalsetu');
         
         // Add a recipient
         $mail->addAddress($data['email']);
         
         // Add cc or bcc 
         //$mail->addCC('cc@example.com');
         //$mail->addBCC('bcc@example.com');
         
         // Email subject
         $mail->Subject = $data['subject'];
         
         // Set email format to HTML
         $mail->isHTML(true);
         
         // Email body content
         $mailContent = $data['body'];
         $mail->MsgHTML($mailContent);
         $mail->AddEmbeddedImage('logo.jpg', 'logo', 'logo.jpg','base64','image/jpeg');
          
         // Send email
         if(!$mail->send()){
             return FALSE;
         }else{
             return TRUE;
         }
    }
}
