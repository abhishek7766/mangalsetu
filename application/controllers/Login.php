<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('member_model');
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
        $member_data = $this->session->userdata ( 'member');
		//$isLoggedIn	= $member_data['isLoggedIn'];
		//$roleid		= $member_data['roleid'];
        
        if(!isset($member_data['isLoggedIn']) || $member_data['isLoggedIn'] != TRUE)
        {
            $data['title']  = "Mangalsetu-Member Login";
            $this->load->view('page/member_login',$data);
        }
        else
        {
            redirect('Member');
        }
    }
    
    
    /**
     * This function used to logged in user
     */
    public function member_login()
    {          
        $this->form_validation->set_rules('phone', 'phone', 'required|min_length[10]|max_length[10]|trim');
        
        if($this->form_validation->run() == FALSE)
        {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );            
        }
        else
        {
            $phone = $this->input->post('phone');
            
            if($this->member_model->is_user_exist($phone))
            { 
                $otp = $this->member_model->generate_otp($phone);
                if($this->send_otp($phone,$otp)){
                    $response = array(
                        'status' => 'success',
                        'message' => 'OTP Send to your number!'
                    );
                }else{
                    $response = array(
                        'status' => 'Failed',
                        'message' => 'Failed to Send OTP!'
                    );
                }
            }
            else
            {
                $response = array(
                    'status' => 'error',
                    'message' => "Member with this number doesnot Exist."
                );                
            }
        }
        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
    }

    public function send_otp($number,$OTP){
		
		$message= "Your OTP For login to Mangalsetu Matrimony is-".$OTP.".Please do not share this OTP.";
		$postdata = "sender_id=MSCONF&message=".$message."&mobile_no=".$number;
		$curl = curl_init();
 
		curl_setopt_array($curl, array(
		CURLOPT_URL => "http://sms.mahalaxmiservice.com/api_v2/message/send",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => $postdata,
		CURLOPT_HTTPHEADER => array(
			"authorization: Bearer ars8zQzo0LKva2DXL5dkxj6x0T8fQMF4D6m0qhPbrf88fEvXlklP1yqvyjjuxf_g",
			"cache-control: no-cache",
			"content-type: application/x-www-form-urlencoded"
		),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		return FALSE;
		} else {
		return TRUE;
		}
	}

    public function verify_otp(){
        $this->form_validation->set_rules('otp', 'otp', 'required|min_length[4]|max_length[4]|trim');
        
        if($this->form_validation->run() == FALSE)
        {
            $response = array(
                'status' => 'error',
                'message' => validation_errors()
            );            
        }
        else
        {
            $phone = $this->input->post('phone');
            $otp = $this->input->post('otp');
            
            $result = $this->member_model->member_login($phone, $otp);
            
            if(!empty($result))
            {
                $lastLogin = $this->member_model->lastLoginInfo($result->member_id);

                $sessionArray = array('id'=>$result->member_id,                    
                                        'email'=>$result->email,
                                        'dob'=>$result->dob,
                                        'gender'=>$result->gender,
                                        'roleid'=>$result->roleid,
                                        'phone'=>$result->phone,
                                        'intrested_in'=>$result->intrested_in,
                                        'refrenceid'=>$result->refrenceid,
                                        'name'=>$result->firstname." ".$result->lastname,
                                        'lastLogin'=> $lastLogin->createdDtm,
                                        'isLoggedIn' => TRUE
                                );

                $this->session->set_userdata('member',$sessionArray);

                $loginInfo = array("member_id"=>$result->member_id, "sessionData" => json_encode($sessionArray), "machineIp"=>$_SERVER['REMOTE_ADDR'], "userAgent"=>getBrowserAgent(), "agentString"=>$this->agent->agent_string(), "platform"=>$this->agent->platform());

                $this->member_model->lastLogin($loginInfo);
              
                $response = array(
                    'status' => 'success',
                    'message' => $loginInfo
                );
            }
            else
            {
                $response = array(
                    'status' => 'error',
                    'message' => "Please enter correct OTP!"
                );                
            }
        }
        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
    }
    /**
     * This function used to load forgot password view
     */
    public function forgotPassword()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('forgotPassword');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    
    /**
     * This function used to generate reset password request link
     */
    function resetPasswordUser()
    {
        $status = '';
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
                
        if($this->form_validation->run() == FALSE)
        {
            $this->forgotPassword();
        }
        else 
        {
            $email = strtolower($this->security->xss_clean($this->input->post('login_email')));
            
            if($this->member_model->checkEmailExist($email))
            {
                $encoded_email = urlencode($email);
                
                $this->load->helper('string');
                $data['email'] = $email;
                $data['activation_id'] = random_string('alnum',15);
                $data['createdDtm'] = date('Y-m-d H:i:s');
                $data['agent'] = getBrowserAgent();
                $data['client_ip'] = $this->input->ip_address();
                
                $save = $this->member_model->resetPasswordUser($data);                
                
                if($save)
                {
                    $data1['reset_link'] = base_url() . "resetPasswordConfirmUser/" . $data['activation_id'] . "/" . $encoded_email;
                    $userInfo = $this->member_model->getCustomerInfoByEmail($email);

                    if(!empty($userInfo)){
                        $data1["name"] = $userInfo->name;
                        $data1["email"] = $userInfo->email;
                        $data1["message"] = "Reset Your Password";
                    }

                    $sendStatus = resetPasswordEmail($data1);

                    if($sendStatus){
                        $status = "send";
                        setFlashData($status, "Reset password link sent successfully, please check mails.");
                    } else {
                        $status = "notsend";
                        setFlashData($status, "Email has been failed, try again.");
                    }
                }
                else
                {
                    $status = 'unable';
                    setFlashData($status, "It seems an error while sending your details, try again.");
                }
            }
            else
            {
                $status = 'invalid';
                setFlashData($status, "This email is not registered with us.");
            }
            redirect('/forgotPassword');
        }
    }

    /**
     * This function used to reset the password 
     * @param string $activation_id : This is unique id
     * @param string $email : This is user email
     */
    function resetPasswordConfirmUser($activation_id, $email)
    {
        // Get email and activation code from URL values at index 3-4
        $email = urldecode($email);
        
        // Check activation id in database
        $is_correct = $this->member_model->checkActivationDetails($email, $activation_id);
        
        $data['email'] = $email;
        $data['activation_code'] = $activation_id;
        
        if ($is_correct == 1)
        {
            $this->load->view('newPassword', $data);
        }
        else
        {
            redirect('/login');
        }
    }
    
    /**
     * This function used to create new password for user
     */
    function createPasswordUser()
    {
        $status = '';
        $message = '';
        $email = strtolower($this->input->post("email"));
        $activation_id = $this->input->post("activation_code");
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('password','Password','required|max_length[20]');
        $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->resetPasswordConfirmUser($activation_id, urlencode($email));
        }
        else
        {
            $password = $this->input->post('password');
            $cpassword = $this->input->post('cpassword');
            
            // Check activation id in database
            $is_correct = $this->member_model->checkActivationDetails($email, $activation_id);
            
            if($is_correct == 1)
            {                
                $this->member_model->createPasswordUser($email, $password);
                
                $status = 'success';
                $message = 'Password reset successfully';
            }
            else
            {
                $status = 'error';
                $message = 'Password reset failed';
            }
            
            setFlashData($status, $message);

            redirect("/login");
        }
    }
}
