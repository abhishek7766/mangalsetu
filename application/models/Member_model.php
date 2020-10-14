<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Member_model extends CI_Model
{
    /**
     * This function used to insert reset password data
     * @param {array} $data : This is reset password data
     * @return {boolean} $result : TRUE/FALSE
     */
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

    function is_user_exist($phone){
        $this->db->select('phone');
        $this->db->from('tbl_member');
        $this->db->where('roleid','4');
        $this->db->where('phone', $phone);   
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        
        $user = $query->row();
        
        if(!empty($user)){
            return true;
        } else {
            return false;
        }
    }

    function generate_otp($phone){
        $data['phone_verify']   = mt_rand(1000, 9999);
        $data['updated_on']     = date('Y-m-d H:i:s');

        $this->db->where('phone',$phone);
        $this->db->update('tbl_member',$data);
        return $data['phone_verify'];
    }
    
    function member_login($phone,$otp)
    {
        $this->db->select('id,member_id,firstname,lastname,email,password,phone,dob,gender,roleid,refrenceid,intrested_in,isPrime');
        $this->db->from('tbl_member');
        $this->db->where('roleid','4');
        $this->db->where('phone', $phone);
        $this->db->where('phone_verify', $otp);   
        $this->db->where('isDeleted', 0);
        $query = $this->db->get();
        
        $user = $query->row();
        
        if(!empty($user)){
            return $user;
        } else {
            return array();
        }
    }

    function lastLogin($loginInfo)
    {
        $this->db->trans_start();
        $this->db->insert('tbl_member_last_login', $loginInfo);
        $this->db->trans_complete();
    }

    /**
     * This function is used to get last login info by user id
     * @param number $userId : This is user id
     * @return number $result : This is query result
     */
    function lastLoginInfo($userId)
    {
        $this->db->select('BaseTbl.createdDtm');
        $this->db->where('BaseTbl.member_id', $userId);
        $this->db->order_by('BaseTbl.id', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_member_last_login as BaseTbl');
        
        return $query->row();
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

    function fetch_refrenceid(){
        $this->db->select('userid,name');
        $this->db->where('roleid','3');
        $query = $this->db->get('tbl_users');
        $data = $query->result_array();
        
        if(!empty($data)){
            return $data;
        } else {
            return "0";
        }
    }

    function get_member_profile($member_id){
        $this->db->select('b.*,a.id,a.firstname,a.lastname,a.phone,a.dob,a.isPrime,a.is_email_verified,a.payment_status,
        a.email,a.gender,a.gender,a.state,a.city');
        $this->db->from('tbl_member as a');
        $this->db->join('tbl_member_profile as b','b.member_id = a.member_id','left');
        $this->db->where('a.member_id',$member_id);
        $this->db->where('a.isDeleted',0);
        $query = $this->db->get();
        $data = $query->row();
        
        if(!empty($data)){
            return $data;
        } else {
            return "0";
        }
    }

    function get_listing($intrested_in){
        $this->db->select('b.short_bio,b.age,b.image_1,a.id,a.firstname,a.lastname,a.email,a.gender,c.state,d.city');
        $this->db->from('tbl_member as a');
        $this->db->join('tbl_member_profile as b','b.member_id = a.member_id','left');
        $this->db->join('tbl_states as c','c.id = a.state');
        $this->db->join('tbl_cities as d','d.id = a.city');
        $this->db->where('gender',$intrested_in);
        $query = $this->db->get();
        $data = $query->result_array();
        
        if(!empty($data)){
            return $data;
        } else {
            return "0";
        }
    }

    function fetch_member_profile($id){
        $this->db->select('a.*');
        $this->db->from('tbl_member_profile as a');
        $this->db->where('member_id',$id);
        $query = $this->db->get();
        $data = $query->result_array();
        
        if(!empty($data)){
            return $data;
        } else {
            return array();
        }
    }

    function update_member_profile($data,$id){
        
        $data['updated_on']     = date('Y-m-d H:i:s');

        $this->db->where('member_id',$id);
        $this->db->update('tbl_member_profile',$data);
        
        if ($this->db->affected_rows() > 0)
        {
            return True;
        }
        else
        {
        return FALSE;
        }
    }

    function matchOldPhone($userId, $oldPhone)
    {
        $this->db->select('member_id, phone');
        $this->db->where('member_id', $userId);
        $this->db->where('phone', $oldPhone);  
        $query = $this->db->get('tbl_member');

        $user = $query->result();

        if(!empty($user)){
            return $user;
        } else {
            return array();
        }
    }

    function matchOtp($userId,$oldPhone)
    {
        $this->db->select('member_id, phone');
        $this->db->where('member_id', $userId);
        $this->db->where('phone_verify', $oldPhone);  
        $query = $this->db->get('tbl_member');

        $user = $query->result();

        if(!empty($user)){
            return $user;
        } else {
            return array();
        }
    }
    
    function creatOtp($id){
        $data['phone_verify']   = mt_rand(1000, 9999);
        $data['updated_on']     = date('Y-m-d H:i:s');

        $this->db->where('member_id',$id);
        $this->db->update('tbl_member',$data);
        
        if ($this->db->affected_rows() > 0)
        {
            return $data['phone_verify'];
        }
        else
        {
        return FALSE;
        }
    }

    function updatePhone($id,$newPhone){
        $data['phone']      = $newPhone;
        $data['updated_on'] = date('Y-m-d H:i:s');
        $this->db->where('member_id',$id);
        $this->db->update('tbl_member',$data);
        
        if ($this->db->affected_rows() > 0)
        {
        return TRUE;
        }
        else
        {
        return FALSE;
        }
    }

    function PhoneVerified($id){
        $data['phone_verify']       = " ";
        $data['is_phone_verified']  = 1;
        $data['updated_on'] = date('Y-m-d H:i:s');
        $this->db->where('member_id',$id);
        $this->db->update('tbl_member',$data);
        
        if ($this->db->affected_rows() > 0)
        {
        return TRUE;
        }
        else
        {
        return FALSE;
        }
    }

    function check_profile_per($id){
        $this->db->select('profile_percent');
        $this->db->where('member_id', $id);
        $this->db->where('profile_percent >', 80);  
        $query = $this->db->get('tbl_member_profile');
        
        $user = $query->result();

        if(!empty($user)){
            return true;
        } else {
            return false;
        }
    }
     function save_upload($data,$id){

        $data['updated_on'] = date('Y-m-d H:i:s');
        $this->db->where('member_id',$id);
        $this->db->update('tbl_member_profile',$data);
        
        if ($this->db->affected_rows() > 0)
        {
        return TRUE;
        }
        else
        {
        return FALSE;
        }
     }

     function VerifyEmail($code){
        
        $data['email_verify'] = " ";
        $data['is_email_verified'] = 1;
        $data['updated_on'] = date('Y-m-d H:i:s');
        // /print_r($data);die;
        $this->db->where('email_verify',$code);
        $this->db->update('tbl_member',$data);
       
        if ($this->db->affected_rows() > 0)
        {
        return TRUE;
        }
        else
        {
        return FALSE;
        }

     }
}

?>