<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site extends MY_Controller {
  private $messages = array();

  public function index($site_id = 0,$active = 'homescreen'){ //Lets assume pabe by default
		$this->load->model('Section_model','sections');
		$this->load->model('Homepage_model','homepage');
		$site_info = $this->sections->get_all_with_site_info($site_id);
		$message = array_shift($this->messages);
		if($message != null){
			$this->twiggy->set('important_message',$message);
		}
		$this->twiggy->set('site_info',$site_info);
    $this->twiggy->set('active',$active);
    $this->twiggy->set('homepage',$this->homepage->get_by('site_id',$site_id));
		$this->twiggy->template('site/index')->display();
	}

  public function saveHomepageData($site_id){
    $homepageData = array();
    if($this->input->post('description')){
      $homepageData['caption'] =  $this->input->post('description');
    }
    $background = $this->do_image_upload('homescreen_background_image',sprintf('site_%s_homepageBG'));
    $logo = $this->do_image_upload('homescreen_logo_image',sprintf('site_%s_logoImg'));
    if($background != null && $background  != 'no_changes')
      $homepageData['background'] = $background;

    if($logo != null && $logo != 'no_changes')
        $homepageData['logo'] = $logo;

    $this->load->model('Homepage_model','homepage');
    $this->homepage->update_by(sprintf('site_id = %s',$site_id),$homepageData);
    // print_r($_FILES);
    redirect(sprintf('site/%s/homescreen',$site_id));
  }

}

?>
