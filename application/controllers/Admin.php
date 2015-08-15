<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	private function _setSessionData($username){
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

	public function index()
	{
		$this->load->library('session');
		if($this->input->cookie('UserInfo')){
			//Check if the cookie is untouched:
			$userInfo = json_decode(stripslashes($this->input->cookie('UserInfo')));
			if($userInfo->username == $this->encrypt->decode($userInfo->hash)){
					//Set session data:
					$this->_setSessionData($userInfo->username);
			}
		}

		if($this->session->userdata('logged_in')){
			//Do something :)
		}
		else{
			return redirect('admin/login');
		}
	}

	public function login(){
		//redirect('admin/','refresh');
		$this->load->library('session');
		$this->session->unset_userdata('logged_in');
		if(!$this->input->post('username')){
			return $this->twiggy->template('admin/login')->display();
		}
		else{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$this->load->model('User_model','users');
			$data = $this->users->get(trim($username));
			if(!$data){
				$this->twiggy->set('error_message','Usuario o Contrasena Incorrecta.');
				return $this->twiggy->template('admin/login')->display();
			}
			else{
				$check_password = do_hash($password,'md5') == $data['password'];
				if(password_verify($password,$data['password'])){ //NOTE: BCrypt used here.
					//Passwords did match ^^
					//Store session:
					$this->_setSessionData($username);
					if($this->input->post('remember_me')){
						//Set a cookie.
						$this->load->helper('cookie');
						$cookieData = array(
							'username' => $username,
							'hash' => $this->encrypt->encode($username)
						);
						$cookie = array(
						  'name'   => 'UserInfo',
					    'value'  => json_encode($cookieData),
					    'expire' => 186500,
					    'path'   => '/'
						);
						$this->input->set_cookie($cookie);
					}
					return redirect('admin/');
				}
				else{
					$this->twiggy->set('error_message','Usuario o Contrasena Incorrecta.');
					return $this->twiggy->template('admin/login')->display();
				}
			}
		}

	}
}
