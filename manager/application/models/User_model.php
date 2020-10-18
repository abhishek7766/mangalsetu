<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    function fetch_states(){
        $this->db->select('id,state');
        $query = $this->db->get('tbl_states');
        $data = $query->result_array();
        
        if(!empty($data)){
            return $data;
        } else {
            return "0";
        }
    }

    function fetch_city($state_id){
        $this->db->select('id,city');
        $this->db->where('state_id',$state_id);
        $query = $this->db->get('tbl_cities');
        
        $output = '<option value="">Select City</option>';
        foreach($query->result() as $row)
        {
         $output .= '<option value="'.$row->id.'">'.$row->city.'</option>';
        }
        return $output;
    }

    function getMemberCity($memberId){
        $this->db->select('b.id,b.city');
        $this->db->where('member_id',$memberId);
        $this->db->JOIN('tbl_cities as b','b.id = a.city');
        $query = $this->db->get('tbl_member as a');
        
        $data = $query->row();
        
        if(!empty($data)){
            return $data;
        } else {
            return "0";
        }
    }

    function creat_new_member($data)
    {
        $result = $this->db->insert('tbl_member', $data);
        
        if($result) {
            $profile_data['member_id'] = $data['member_id'];
            $dateOfBirth = $this->input->post('dob');
            $today = date("Y-m-d");
            $diff = date_diff(date_create($dateOfBirth), date_create($today));
            $age = $diff->format('%y');
            $profile_data['age'] = $age;
            $profile = $this->db->insert('tbl_member_profile',$profile_data);
            if($profile) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function lastId(){
        $this->db->select('id');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_member');
        
        $data = $query->row();
        if(!empty($data)){
            return $data->id;
        } else {
            return "0";
        }
    }

    function Action_on_Member($id,$data){
        $data['updated_on']     = date('Y-m-d H:i:s');

        $this->db->where('member_id',$id);
        $this->db->update('tbl_member',$data);
        
        if ($this->db->affected_rows() > 0)
        {
            return True;
        }
        else
        {
        return FALSE;
        }
    }

    function isRefrenceExist($vendorId,$memberId){
        $this->db->select('member_id');
        $this->db->where('member_id',$memberId);
        $this->db->where('refrenceid',$vendorId);
        $query = $this->db->get('tbl_member');

        $user = $query->result();

        if(!empty($user)){
            return true;
        } else {
            return false;
        }
    }
    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @return number $count : This is row count
     */
    function userListingCount($searchText = '')
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.createdDtm, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 1);
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    /**
     * This function is used to get the user listing count
     * @param string $searchText : This is optional search text
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function userListing($searchText = '', $page, $segment)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.createdDtm, Role.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Role', 'Role.roleId = BaseTbl.roleId','left');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.name  LIKE '%".$searchText."%'
                            OR  BaseTbl.mobile  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->where('BaseTbl.roleId !=', 1);
        $this->db->order_by('BaseTbl.userId', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }
    
    function memberListingCount($searchText = '',$emp_id = '')
    {
        $this->db->select('BaseTbl.member_id, BaseTbl.email, BaseTbl.firstname,BaseTbl.lastname, BaseTbl.phone,BaseTbl.payment_status, BaseTbl.created_on, Users.name');
        $this->db->from('tbl_member as BaseTbl');
        $this->db->join('tbl_users as Users', 'Users.userId = BaseTbl.refrenceid','left');
        if(!empty($emp_id)){
            $this->db->where('refrenceid',$emp_id);
        }
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.phone  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();

        return $query->num_rows();
    }

    function memberListing($searchText = '',$emp_id = '', $page, $segment)
    {
        $this->db->select('BaseTbl.member_id, BaseTbl.email, BaseTbl.firstname,BaseTbl.lastname, BaseTbl.phone,BaseTbl.payment_status, BaseTbl.created_on,Users.name');
        $this->db->from('tbl_member as BaseTbl');
        $this->db->join('tbl_users as Users', 'Users.userId = BaseTbl.refrenceid','left');
        if(!empty($emp_id)){
            $this->db->where('refrenceid',$emp_id);
        }
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.email  LIKE '%".$searchText."%'
                            OR  BaseTbl.phone  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        $this->db->where('BaseTbl.isDeleted', 0);
        $this->db->order_by('BaseTbl.member_Id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    /**
     * This function is used to get the user roles information
     * @return array $result : This is result of the query
     */
    function getUserRoles()
    {
        $this->db->select('roleId, role');
        $this->db->from('tbl_roles');
        $this->db->where('roleId !=', 1);
        $query = $this->db->get();
        
        return $query->result();
    }

    /**
     * This function is used to check whether email id is already exist or not
     * @param {string} $email : This is email id
     * @param {number} $userId : This is user id
     * @return {mixed} $result : This is searched result
     */
    function checkEmailExists($email, $userId = 0)
    {
        $this->db->select("email");
        $this->db->from("tbl_users");
        $this->db->where("email", $email);   
        $this->db->where("isDeleted", 0);
        if($userId != 0){
            $this->db->where("userId !=", $userId);
        }
        $query = $this->db->get();

        return $query->result();
    }
    
    
    /**
     * This function is used to add new user to system
     * @return number $insert_id : This is last inserted id
     */
    function addNewUser($userInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_users', $userInfo);
        
        $insert_id = $this->db->insert_id();
        
        $this->db->trans_complete();
        
        return $insert_id;
    }
    
    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfo($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
		$this->db->where('roleId !=', 1);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    function getMemberInfo($memberId)
    {
        $this->db->select('*');
        $this->db->from('tbl_member');
        $this->db->where('isDeleted', 0);
        $this->db->where('member_Id', $memberId);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    /**
     * This function is used to update the user information
     * @param array $userInfo : This is users updated information
     * @param number $userId : This is user id
     */
    function editUser($userInfo, $userId)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return TRUE;
    }
    
    function editMember($data, $memberId)
    {
        $this->db->where('member_id', $memberId);
        $this->db->update('tbl_member', $data);
        
        return TRUE;
    }
    
    /**
     * This function is used to delete the user information
     * @param number $userId : This is user id
     * @return boolean $result : TRUE / FALSE
     */
    function deleteUser($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }

    function deleteMember($memberId, $userInfo)
    {
        $this->db->where('member_id ', $memberId);
        $this->db->update('tbl_member', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to match users password for change password
     * @param number $userId : This is user id
     */
    function matchOldPassword($userId, $oldPassword)
    {
        $this->db->select('userId, password');
        $this->db->where('userId', $userId);        
        $this->db->where('isDeleted', 0);
        $query = $this->db->get('tbl_users');
        
        $user = $query->result();

        if(!empty($user)){
            if(verifyHashedPassword($oldPassword, $user[0]->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }
    
    /**
     * This function is used to change users password
     * @param number $userId : This is user id
     * @param array $userInfo : This is user updation info
     */
    function changePassword($userId, $userInfo)
    {
        $this->db->where('userId', $userId);
        $this->db->where('isDeleted', 0);
        $this->db->update('tbl_users', $userInfo);
        
        return $this->db->affected_rows();
    }


    /**
     * This function is used to get user login history
     * @param number $userId : This is user id
     */
    function loginHistoryCount($userId, $searchText, $fromDate, $toDate)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->from('tbl_last_login as BaseTbl');
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    /**
     * This function is used to get user login history
     * @param number $userId : This is user id
     * @param number $page : This is pagination offset
     * @param number $segment : This is pagination limit
     * @return array $result : This is result
     */
    function loginHistory($userId, $searchText, $fromDate, $toDate, $page, $segment)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.sessionData, BaseTbl.machineIp, BaseTbl.userAgent, BaseTbl.agentString, BaseTbl.platform, BaseTbl.createdDtm');
        $this->db->from('tbl_last_login as BaseTbl');
        if(!empty($searchText)) {
            $likeCriteria = "(BaseTbl.sessionData  LIKE '%".$searchText."%')";
            $this->db->where($likeCriteria);
        }
        if(!empty($fromDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) >= '".date('Y-m-d', strtotime($fromDate))."'";
            $this->db->where($likeCriteria);
        }
        if(!empty($toDate)) {
            $likeCriteria = "DATE_FORMAT(BaseTbl.createdDtm, '%Y-%m-%d' ) <= '".date('Y-m-d', strtotime($toDate))."'";
            $this->db->where($likeCriteria);
        }
        if($userId >= 1){
            $this->db->where('BaseTbl.userId', $userId);
        }
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit($page, $segment);
        $query = $this->db->get();
        
        $result = $query->result();        
        return $result;
    }

    /**
     * This function used to get user information by id
     * @param number $userId : This is user id
     * @return array $result : This is user information
     */
    function getUserInfoById($userId)
    {
        $this->db->select('userId, name, email, mobile, roleId');
        $this->db->from('tbl_users');
        $this->db->where('isDeleted', 0);
        $this->db->where('userId', $userId);
        $query = $this->db->get();
        
        return $query->row();
    }

    /**
     * This function used to get user information by id with role
     * @param number $userId : This is user id
     * @return aray $result : This is user information
     */
    function getUserInfoWithRole($userId)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.email, BaseTbl.name, BaseTbl.mobile, BaseTbl.roleId, Roles.role');
        $this->db->from('tbl_users as BaseTbl');
        $this->db->join('tbl_roles as Roles','Roles.roleId = BaseTbl.roleId');
        $this->db->where('BaseTbl.userId', $userId);
        $this->db->where('BaseTbl.isDeleted', 0);
        $query = $this->db->get();
        
        return $query->row();
    }

    function getNoOfMembers(){
        $this->db->select('id');
        $this->db->from('tbl_member');
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function noOfEmployees(){
        $this->db->select('userId');
        $this->db->from('tbl_users');
        $this->db->where('roleid >=',2);
        $this->db->where('roleid <=',3);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
        
        return $query->num_rows();
    }

    function get_emp_list(){
        $this->db->select('userId,name');
        $this->db->where('roleId',3);
        $query = $this->db->get('tbl_users');
        $data = $query->result_array();
        
        if(!empty($data)){
            return $data;
        } else {
            return "0";
        }
    }

    function noOfPMember(){
        $this->db->select('id');
        $this->db->from('tbl_member');
        $this->db->where('payment_status !=',0);
        $this->db->where('isPrime',1);
        $this->db->where('isDeleted',0);
        $query = $this->db->get();
        
        return $query->num_rows();
    }

}

  