<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model
{
    function getAnnouncement(){
        $this->db->select("*");
        $this->db->from('tbl_announcement');
        $this->db->where('active',1);
        $querry = $this->db->get();
        $data = $querry->row();

        if(!empty($data)){
            return $data;
        }else{
            return array();
        }
    }

    function getRecentMembers(){
        $this->db->select("a.firstname,a.lastname,c.city,b.image_1");
        $this->db->from('tbl_member as a');
        $this->db->JOIN('tbl_member_profile as b','a.member_id = b.member_id');
        $this->db->JOIN('tbl_cities as c','a.city = c.id');
        $this->db->order_by('a.id', 'DESC');
        $this->db->limit('10');
        $querry = $this->db->get();
        $data = $querry->result_array();

        if(!empty($data)){
            return $data;
        }else{
            return array();
        }
    }
}