<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('common_model');
    }
	public function index()
	{
		$data['announcement'] = $this->common_model->getAnnouncement();
		$data['new_members'] = $this->common_model->getRecentMembers();
		//echo "<pre>";print_r($data['new_members']);die;
		$this->load->view('page/home',$data);
	}

	public function about(){
		$this->load->view('page/about');
	}
}
