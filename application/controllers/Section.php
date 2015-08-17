<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section extends MY_Controller {

	private $messages = array();

	public function index($site_id = 0){ //Lets assume pabe by default
		$this->load->model('Section_model','sections');
		$site_info = $this->sections->get_all_with_site_info($site_id);
		$message = array_shift($this->messages);
		if($message != null){
			$this->twiggy->set('important_message',$message);
		}
		$this->twiggy->set('site_info',$site_info);
		$this->twiggy->template('section/index')->display();
	}

	public function move_up($section_id){

	}

	public function move_down($section_id){

	}

	public function delete($section_id){

	}

	public function edit($section_id){

	}

	public function add($site_id){
		//If site_id == null, it should redirect to sites... meanwhile:
		$this->load->model('Site_model',"sites");
		$site_info =  $this->sites->get($site_id);
		if(!$site_info)
			redirect('/site/0/section');


	}
}
