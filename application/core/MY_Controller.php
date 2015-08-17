<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

  function __construct(){
    parent::__construct();

    if($this->uri->segment(1) == 'admin' && $this->uri->segment(2) == 'login'){
      return; // NO LOGIN REQUIRED.
    }


		$this->load->library('session');
		if($this->input->cookie('UserInfo')){
			//Check if the cookie is untouched:
			$userInfo = json_decode(stripslashes($this->input->cookie('UserInfo')));
			if($userInfo->username == $this->encrypt->decode($userInfo->hash)){
					//Set session data:
					$this->_setSessionData($userInfo->username);
			}
		}

		if(!$this->session->userdata('logged_in')){
				return redirect('admin/login');
		}
  }

  protected function _setSessionData($username){
		$this->load->model('User_model','users');
		$data = $this->users->get($username);
		$sessionData = array(
			'username' => $data['username'],
			'name' => $data['name'],
			'email' => $data['email'],
			'logged_in' => true
		);
		$this->session->set_userdata($sessionData);

	}


}
?>
