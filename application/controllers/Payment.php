<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/MemberLib.php';

class Payment extends MemberLib {

    public function __construct()
    {
		parent::__construct();
		$this->load->model('member_model');
        $this->isLoggedIn();
    }

	public function index()
	{	 
		$this->global['title'] = "MangalSetu : Payment";
        $this->loadViews("payment", $this->global, NULL , NULL);
    }

}
