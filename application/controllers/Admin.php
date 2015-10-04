<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

	function __construct(){
		parent::__construct();
	}

	public function index()
	{
		redirect('site/0/section/'); //Should be to a sites controller which wont be used in right  now.
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
}?>