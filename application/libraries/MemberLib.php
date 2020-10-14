<?php defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' ); 

class MemberLib extends CI_Controller {
	protected $id = '';
	protected $email = '';
	protected $name = '';
	protected $global = array ();
	protected $lastLogin = '';
	protected $refrenceId = '';
	protected $roleid = '';
	protected $intrested_in = '';
	
	/**
	 * Takes mixed data and optionally a status code, then creates the response
	 *
	 * @access public
	 * @param array|NULL $data
	 *        	Data to output to the user
	 *        	running the script; otherwise, exit
	 */
	public function response($data = NULL) {
		$this->output->set_status_header ( 200 )->set_content_type ( 'application/json', 'utf-8' )->set_output ( json_encode ( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) )->_display ();
		exit ();
	}
	
	/**
	 * This function used to check the user is logged in or not
	 */
	function isLoggedIn() {
		
		$member_data = $this->session->userdata ( 'member');
		$isLoggedIn	= $member_data['isLoggedIn'];
		$roleid		= $member_data['roleid'];
		
		if (!isset ( $isLoggedIn ) || $isLoggedIn != TRUE || $roleid != 4) {
			$this->session->sess_destroy('member');
			redirect ( 'login' );
		} else {
			
			$this->email 		= $member_data['email'];
			$this->refrenceid 	= $member_data['refrenceid'];
			$this->id 			= $member_data['id'];
			$this->roleid 		= $member_data['roleid'];
			$this->phone 		= $member_data['phone'];
			$this->intrested_in = $member_data['intrested_in'];
			$this->name 		= $member_data['name'];
			$this->gender 		= $member_data['gender'];
			$this->lastLogin 	= $member_data['lastLogin'];

			$this->global ['name'] 			= $member_data['name'];
			$this->global ['roleid']		= $member_data['roleid'];
			$this->global ['email'] 		= $member_data['email'];
			$this->global ['phone']			= $member_data['phone'];
			$this->global ['refrenceid']	= $member_data['refrenceid'];
			$this->global ['id'] 			= $member_data['id'];
			$this->global ['gender']		= $member_data['gender'];
			$this->global ['intrested_in'] 	= $member_data['intrested_in'];
			$this->global ['last_login'] 	= $member_data['lastLogin'];
		}
	}
	/**
     * This function used to load views
     * @param {string} $viewName : This is view name
     * @param {mixed} $headerInfo : This is array of header information
     * @param {mixed} $pageInfo : This is array of page information
     * @param {mixed} $footerInfo : This is array of footer information
     * @return {null} $result : null
     */
    function loadViews($viewName = "", $headerInfo = NULL, $pageInfo = NULL, $footerInfo = NULL){

        $this->load->view('front/header', $headerInfo);
        $this->load->view('page/'.$viewName, $pageInfo);
        $this->load->view('front/footer', $footerInfo);
	}
	
	function generateOTP(){
		
	}
	/**
	 * This function is used to logged out user from system
	 */
	function logout() {
		$this->session->sess_destroy ('member');
		redirect ( 'login' );
    }
}