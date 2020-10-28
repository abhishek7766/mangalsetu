<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class User extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->isLoggedIn();   
    }
    
    /**
     * This function used to load the first screen of the user
     */
    public function index()
    {   
        $this->global['pageTitle'] = 'Mangalsetu : Dashboard';
        $data['noOfMembers'] = $this->user_model->getNoOfMembers();
        $data['noOfEmployees'] = $this->user_model->noOfEmployees();
        $data['noOfPMember'] = $this->user_model->noOfPMember();
        $data['states'] = $this->get_states();
        
        $this->loadViews("dashboard", $this->global, $data , NULL);
    }
    
    public function get_states(){
        $data = $this->user_model->fetch_states();
        return $data;
    }

    public function get_cities(){
        if($this->input->post('state_id'))
        {
        echo $this->user_model->fetch_city($this->input->post('state_id'));
        }
    }

    function announcement()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->announceListingCount($searchText);

			$returns = $this->paginationCompress ( "announcement/", $count, 10 );
            
            $data['announceRecords'] = $this->user_model->announcements($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'MangalSetu : Announcements';
            
            $this->loadViews("announcement", $this->global, $data, NULL);
        }
    }

    function newAnnouncement()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();
            
            $this->global['pageTitle'] = 'MangalSetu : Add New Announcement';

            $this->loadViews("newAnnouncement", $this->global, $data, NULL);
        }
    }

    function addAnnouncement()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('title','Title','trim|required');
            $this->form_validation->set_rules('on_date','Date','trim|required');
            $this->form_validation->set_rules('from_time','From Time','required');
            $this->form_validation->set_rules('to_time','To Time','trim|required');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->newAnnouncement();
            }
            else
            {
                $data['title']      = $this->input->post('title');
                $data['on_date']       = $this->input->post('on_date');
                $data['from_time']  = $this->input->post('from_time');
                $data['to_time']    = $this->input->post('to_time');
                $data['created_on'] = date('Y-m-d H:i:s');

                    $this->load->model('user_model');
                $result = $this->user_model->addAnnouncement($data);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New Announcement created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Announcement creation failed');
                }
                
                redirect('newAnnouncement');
            }
        }
    }
    /**
     * This function is used to load the user list
     */
    function userListing()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

			$returns = $this->paginationCompress ( "userListing/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'MangalSetu : User Listing';
            
            $this->loadViews("users", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to load the add new form
     */
    function addNew()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();
            
            $this->global['pageTitle'] = 'MangalSetu : Add New User';

            $this->loadViews("addNew", $this->global, $data, NULL);
        }
    }

    function addMember()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->model('user_model');
            $data['roles'] = $this->user_model->getUserRoles();
            
            $this->global['pageTitle'] = 'MangalSetu : Add New Member';

            $this->loadViews("addMember", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to check whether email already exist or not
     */
    function checkEmailExists()
    {
        $userId = $this->input->post("userId");
        $email = $this->input->post("email");

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ echo("true"); }
        else { echo("false"); }
    }
    
    /**
     * This function is used to add new user to the system
     */
    function addNewUser()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','required|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','trim|required|matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->addNew();
            }
            else
            {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                
                $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId, 'name'=> $name,
                                    'mobile'=>$mobile, 'createdBy'=>$this->vendorId, 'createdDtm'=>date('Y-m-d H:i:s'));
                
                $this->load->model('user_model');
                $result = $this->user_model->addNewUser($userInfo);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('success', 'New User created successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User creation failed');
                }
                
                redirect('addNew');
            }
        }
    }

    function addNewMember()
    {
        $this->load->library('form_validation');
    
        $this->form_validation->set_rules('firstname','FirstName','trim|required|max_length[128]');
        $this->form_validation->set_rules('lastname','LastName','trim|required|max_length[128]');
        $this->form_validation->set_rules('gender','Gender','trim|required');
        $this->form_validation->set_rules('dob','DOB','trim|required');
        $this->form_validation->set_rules('state','State','trim|required');
        $this->form_validation->set_rules('city','City','trim|required');
        $this->form_validation->set_rules('phone','Phone','trim|required|is_unique[tbl_member.phone]');
        $this->form_validation->set_rules('intrested_in','Intrested In','trim|required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->index();
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
            $data['refrenceid']     = $this->session->userdata('userId');
            $data['email']          = strtolower($this->input->post('email'));
            $data['roleid']         = "4";
            $data['email_verify']   = md5(rand());
            $data['phone_verify']   = mt_rand(1000, 9999);
            $data['created_on']     = date('Y-m-d H:i:s');
            
            if($this->user_model->creat_new_member($data))
            {
                if($data['email'] != ""){
                    $data1["email"] = $data['email'];
                    $data1["passcode"] = $data['email_verify'];

                    $welcomeEmail = welcomeEmail($data1); 
                    $verifyEmail = verifyEmail($data1);
                } 

                $this->session->set_flashdata('success', 'New User created successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'User creation failed');
            }
            
            redirect('dashboard');
        }
    }

    public function is_email_unique($email){
        if($this->user_model->is_email_unique($email)){
            $this->form_validation->set_message('is_email_unique', 'The {field} already exist!');
            return false;
        }else{
            return true;
        }
    }

    public function get_MemberId(){
        $last_id = $this->user_model->lastId();
        $last_id++;
        $new_id = "MSM-".str_pad($last_id, 4, "0", STR_PAD_LEFT);
        return $new_id;
    }

    function MemberAction($id="",$status = ""){
        if(!empty($id)){
            $data = array();
            if($status == 1){
                $data['payment_status'] = 1;
                $data['isPrime'] = 1;
                $this->session->set_flashdata('success', 'Member Is Paied and Activated!');
            }else{
                $data['payment_status'] = 0;
                $data['isPrime'] = 0;
                $this->session->set_flashdata('error', 'Member Is Deactivate!');
            }
            $result = $this->user_model->Action_on_Member($id,$data);
        }
        redirect('memberListing');
    }
    
    /**
     * This function is used load user edit information
     * @param number $userId : Optional : This is user id
     */
    function editOld($userId = NULL)
    {
        if($this->isAdmin() == TRUE || $userId == 1)
        {
            $this->loadThis();
        }
        else
        {
            if($userId == null)
            {
                redirect('userListing');
            }
            
            $data['roles'] = $this->user_model->getUserRoles();
            $data['userInfo'] = $this->user_model->getUserInfo($userId);
            
            $this->global['pageTitle'] = 'MangalSetu : Edit User';
            
            $this->loadViews("editOld", $this->global, $data, NULL);
        }
    }

    function editOldMember($memberId = NULL)
    {
        if($memberId == null)
        {
            redirect('memberListing');
        }
        if($this->role == 3 && $this->user_model->isRefrenceExist($this->vendorId,$memberId)){
            $data['memberInfo'] = $this->user_model->getMemberInfo($memberId);
            $data['states'] = $this->get_states();
            $data['citydetail']   = $this->user_model->getMembercity($memberId);
            
            $this->global['pageTitle'] = 'MangalSetu : Edit Member';
            
            $this->loadViews("editOldMember", $this->global, $data, NULL);
        }elseif($this->role == ROLE_ADMIN){
            $data['memberInfo'] = $this->user_model->getMemberInfo($memberId);
            $data['states'] = $this->get_states();
            $data['citydetail']   = $this->user_model->getMembercity($memberId);
            
            $this->global['pageTitle'] = 'MangalSetu : Edit Member';
            
            $this->loadViews("editOldMember", $this->global, $data, NULL);
        }else{
            $this->loadThis();
        }
    }    
    
    /**
     * This function is used to edit the user information
     */
    function editUser()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $this->load->library('form_validation');
            
            $userId = $this->input->post('userId');
            
            $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]');
            $this->form_validation->set_rules('password','Password','matches[cpassword]|max_length[20]');
            $this->form_validation->set_rules('cpassword','Confirm Password','matches[password]|max_length[20]');
            $this->form_validation->set_rules('role','Role','trim|required|numeric');
            $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
            
            if($this->form_validation->run() == FALSE)
            {
                $this->editOld($userId);
            }
            else
            {
                $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
                $email = strtolower($this->security->xss_clean($this->input->post('email')));
                $password = $this->input->post('password');
                $roleId = $this->input->post('role');
                $mobile = $this->security->xss_clean($this->input->post('mobile'));
                
                $userInfo = array();
                
                if(empty($password))
                {
                    $userInfo = array('email'=>$email, 'roleId'=>$roleId, 'name'=>$name,
                                    'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                else
                {
                    $userInfo = array('email'=>$email, 'password'=>getHashedPassword($password), 'roleId'=>$roleId,
                        'name'=>ucwords($name), 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 
                        'updatedDtm'=>date('Y-m-d H:i:s'));
                }
                
                $result = $this->user_model->editUser($userInfo, $userId);
                
                if($result == true)
                {
                    $this->session->set_flashdata('success', 'User updated successfully');
                }
                else
                {
                    $this->session->set_flashdata('error', 'User updation failed');
                }
                
                redirect('userListing');
            }
        }
    }

    function editMember()
    { 
        $this->load->library('form_validation');
            
        $memberId = $this->input->post('memberId');
        
        $this->form_validation->set_rules('firstname','FirstName','trim|required|max_length[128]');
        $this->form_validation->set_rules('lastname','LastName','trim|required|max_length[128]');
        $this->form_validation->set_rules('gender','Gender','trim|required');
        $this->form_validation->set_rules('dob','DOB','trim|required');
        $this->form_validation->set_rules('state','State','trim|required');
        $this->form_validation->set_rules('city','City','trim|required');
        $this->form_validation->set_rules('phone','Phone','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email');
        $this->form_validation->set_rules('intrested_in','Intrested In','trim|required');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->editOldMember($memberId);
        }
        else
        {
            $data['firstname']      = $this->input->post('firstname');
            $data['lastname']       = $this->input->post('lastname');
            $data['phone']          = $this->input->post('phone');
            $data['dob']            = $this->input->post('dob');
            $data['gender']         = $this->input->post('gender');
            $data['state']          = $this->input->post('state');
            $data['city']           = $this->input->post('city');
            $data['intrested_in']   = $this->input->post('intrested_in');
            $data['email']          = $this->input->post('email');
            $data['updated_on']     = date('Y-m-d H:i:s');
            
            $result = $this->user_model->editMember($data, $memberId);
            
            if($result == true)
            {
                $this->session->set_flashdata('success', 'Member updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Member updation failed');
            }
            
            redirect('editOldMember/'.$memberId);
        }
    }

    function memberListing()
    {
        if($this->role == 3){
            redirect('myMembers');
        }
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $emp_id = $this->input->post('emp_id');
            
            $data['searchText'] = $searchText;
            $data['emp_id'] = $emp_id;
            $data['emp_lists'] = $this->user_model->get_emp_list();
            
            $this->load->library('pagination');
             
            $count = $this->user_model->memberListingCount($searchText,$emp_id);

			$returns = $this->paginationCompress ( "memberListing/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->memberListing($searchText,$emp_id,$returns["page"], $returns["segment"]);
            //echo "<pre>"; print_r($data['userRecords']);die;
            $this->global['pageTitle'] = 'MangalSetu : Member Listing';
            
            $this->loadViews("members_listing", $this->global, $data, NULL);
        }
    }

    function myMembers()
    {  
        if($this->role != 3)
        {
            $this->loadThis();
        }
        else
        {        
            
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $emp_id = $this->vendorId;
            
            $data['searchText'] = $searchText;
            $data['emp_id'] = $emp_id;
            $data['emp_lists'] = $this->user_model->get_emp_list();
            
            $this->load->library('pagination');
             
            $count = $this->user_model->memberListingCount($searchText,$emp_id);

			$returns = $this->paginationCompress ( "memberListing/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->memberListing($searchText,$emp_id,$returns["page"], $returns["segment"]);
            //echo "<pre>"; print_r($data['userRecords']);die;
            $this->global['pageTitle'] = 'MangalSetu : Member Listing';
            
            $this->loadViews("members_listing", $this->global, $data, NULL);
        }
    }

    function reports()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {        
            $searchText = $this->security->xss_clean($this->input->post('searchText'));
            $data['searchText'] = $searchText;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->userListingCount($searchText);

			$returns = $this->paginationCompress ( "userListing/", $count, 10 );
            
            $data['userRecords'] = $this->user_model->userListing($searchText, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'MangalSetu : User Listing';
            
            $this->loadViews("reports", $this->global, $data, NULL);
        }
    }

    /**
     * This function is used to delete the user using userId
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $userId = $this->input->post('userId');
            $userInfo = array('isDeleted'=>1,'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteUser($userId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

    function deleteMember()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $memberId = $this->input->post('memberId');
            $userInfo = array('isDeleted'=>1,'updated_on'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->deleteMember($memberId, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

    function deactiveAll()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            
            $result = $this->user_model->deactiveAll();
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

    function activeAnnouncement()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
            
            $result = $this->user_model->activeAnnouncement($id);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }

    function deleteAnnouncement()
    {
        if($this->isAdmin() == TRUE)
        {
            echo(json_encode(array('status'=>'access')));
        }
        else
        {
            $id = $this->input->post('id');
            $userInfo = array('isDeleted'=>1);
            
            $result = $this->user_model->deleteAnnouncement($id, $userInfo);
            
            if ($result > 0) { echo(json_encode(array('status'=>TRUE))); }
            else { echo(json_encode(array('status'=>FALSE))); }
        }
    }
    
    /**
     * Page not found : error 404
     */
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'MangalSetu : 404 - Page Not Found';
        
        $this->loadViews("404", $this->global, NULL, NULL);
    }

    /**
     * This function used to show login history
     * @param number $userId : This is user id
     */
    function loginHistoy($userId = NULL)
    {   
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {
            $userId = ($userId == NULL ? 0 : $userId);

            $searchText = $this->input->post('searchText');
            $fromDate = $this->input->post('fromDate');
            $toDate = $this->input->post('toDate');

            $data["userInfo"] = $this->user_model->getUserInfoById($userId);

            $data['searchText'] = $searchText;
            $data['fromDate'] = $fromDate;
            $data['toDate'] = $toDate;
            
            $this->load->library('pagination');
            
            $count = $this->user_model->loginHistoryCount($userId, $searchText, $fromDate, $toDate);

            $returns = $this->paginationCompress ( "login-history/".$userId."/", $count, 10, 3);

            $data['userRecords'] = $this->user_model->loginHistory($userId, $searchText, $fromDate, $toDate, $returns["page"], $returns["segment"]);
            
            $this->global['pageTitle'] = 'MangalSetu : User Login History';
            
            $this->loadViews("loginHistory", $this->global, $data, NULL);
        }        
    }

    /**
     * This function is used to show users profile
     */
    function profile($active = "details")
    {
        $data["userInfo"] = $this->user_model->getUserInfoWithRole($this->vendorId);
        $data["active"] = $active;
        
        $this->global['pageTitle'] = $active == "details" ? 'MangalSetu : My Profile' : 'MangalSetu : Change Password';
        $this->loadViews("profile", $this->global, $data, NULL);
    }

    /**
     * This function is used to update the user details
     * @param text $active : This is flag to set the active tab
     */
    function profileUpdate($active = "details")
    {
        $this->load->library('form_validation');
            
        $this->form_validation->set_rules('fname','Full Name','trim|required|max_length[128]');
        $this->form_validation->set_rules('mobile','Mobile Number','required|min_length[10]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|max_length[128]|callback_emailExists');        
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $name = ucwords(strtolower($this->security->xss_clean($this->input->post('fname'))));
            $mobile = $this->security->xss_clean($this->input->post('mobile'));
            $email = strtolower($this->security->xss_clean($this->input->post('email')));
            
            $userInfo = array('name'=>$name, 'email'=>$email, 'mobile'=>$mobile, 'updatedBy'=>$this->vendorId, 'updatedDtm'=>date('Y-m-d H:i:s'));
            
            $result = $this->user_model->editUser($userInfo, $this->vendorId);
            
            if($result == true)
            {
                $this->session->set_userdata('name', $name);
                $this->session->set_flashdata('success', 'Profile updated successfully');
            }
            else
            {
                $this->session->set_flashdata('error', 'Profile updation failed');
            }

            redirect('profile/'.$active);
        }
    }

    /**
     * This function is used to change the password of the user
     * @param text $active : This is flag to set the active tab
     */
    function changePassword($active = "changepass")
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->profile($active);
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password is not correct');
                redirect('profile/'.$active);
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('profile/'.$active);
            }
        }
    }

    /**
     * This function is used to check whether email already exist or not
     * @param {string} $email : This is users email
     */
    function emailExists($email)
    {
        $userId = $this->vendorId;
        $return = false;

        if(empty($userId)){
            $result = $this->user_model->checkEmailExists($email);
        } else {
            $result = $this->user_model->checkEmailExists($email, $userId);
        }

        if(empty($result)){ $return = true; }
        else {
            $this->form_validation->set_message('emailExists', 'The {field} already taken');
            $return = false;
        }

        return $return;
    }
}

?>