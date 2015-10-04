<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section extends MY_Controller {

	private $messages = array();

	public function index($site_id = 0){ //Lets assume pabe by default
		redirect('site/'.$site_id.'/section');
		}

	public function move_up($section_id){

	}

	public function move_down($section_id){

	}

	public function delete($site_id,$section_id){
		$this->load->model('Section_model','sections');
		$this->sections->delete($section_id);
		redirect('site/'.$site_id.'/section');
	}

	public function edit($site_id,$section_id){
		$this->load->model("Section_model",'sections');
		$site_info =  $this->sections->get_all_with_site_info($site_id);

		if(!$site_info)
			redirect('site/'.$site_id.'/section');

		$this->twiggy->set('site_info',$site_info);
		$section = $this->sections->get($section_id);
		switch ($section['section_type']) {
			case 'block':
				$this->load->model('Blocksection_model','blocks');
				$blocks = $this->blocks->get_many_by('section_id',$section['id']);
				$section['blocks'] = $blocks;
				break;
			case 'full_text':
				$this->load->model('Fulltextsection_model','fulltext');
				$section['data'] = $this->fulltext->get_by('section_id',$section['id']);
				break;
			case 'text_image':
				$this->load->model('Textimagesection_model','textimage');
				$section['data'] = $this->textimage->get_by('section_id',$section['id']);
				break;
			case 'image':
				$this->load->model('Imagesection_model','images');
				$section['data'] = $this->images->get_many_by('section_id',$section['id']);
				break;
			default:
				# code...
				break;
		}
		$this->twiggy->set('section',$section);
		$this->twiggy->set('is_edit',true);
		$this->twiggy->template('section/add')->display();

	}



	private function add_update_block_data($section_id){
		$block_count =  count($this->input->post('block-title'));
		$post = $this->input->post();
		$this->load->model('Blocksection_model','blocks');
		for($i = 0; $i < $block_count;$i++){
			$block_data = array(
				'block_title' => $post['block-title'][$i],
				'block_color' => $post['block-color'][$i],
				'block_text' => $post['block-content'][$i],
				'block_position' => $i,
				'section_id' => $section_id
			);
			if($post['block-id'][$i] == 'undefined')
				$this->blocks->insert($block_data);
			else
				$this->blocks->update($post['block-id'][$i],$block_data);
		}
	}

	private function add_update_fulltext_data($section_id){
		$this->load->model('Fulltextsection_model','fulltext');
		$post = $this->input->post();
		$data = array(
			'title' => $post['text-title'],
			'text' => $post['content'],
			'section_id' => $section_id
		);
		if($this->input->post('fulltext_id'))
			$this->fulltext->update($post['fulltext_id'],$data);
		else {
			$this->fulltext->insert($data);
		}
	}

	private function add_update_textimage_data($section_id){
		$this->load->model('Textimagesection_model','textimage');
		$post = $this->input->post();
		$data = array(
			'title' => $post['text-title'],
			'text' => $post['text-content'],
			'section_id'=>$section_id
		);

		if(isset($_FILES['text-image']) && $_FILES['text-image']['error'] == 0){
			$filepath = $this->do_image_upload('text-image');
			if($filepath == null){
				return 'image_upload_error';
			}
			else if($filepath != 'no_changes'){
				$data['img_url'] = $filepath;
			}
		}

		if($this->input->post('text_image_id')){
			$this->textimage->update($post['text_image_id'],$data);
		}
		else{
			$this->textimage->insert($data);
		}
	}

	private function add_update_image_data($section_id){
		$this->load->model('Imagesection_model','images');
		$images = $this->images->get_many_by('section_id',null);
		foreach ($images as $img) {
			$new_data = array('section_id' => $section_id);
			$this->images->update($img['id'],$new_data);
		}
		$images = $this->images->get_many_by('section_id',$section_id);

		for ($i=0; $i < 	count($images); $i++) {
			$this->images->update($images[$i]['id'],array('position'=> $i));
		}
	}

	private function fix_section_numbers($site_id){
		$this->load->model('Section_model','sections');
		$this->db->order_by('position','asc');
		$this->db->order_by('section_title','desc');
		$sections = $this->sections->get_many_by('id_site',$site_id);
		$prev_pos = 0;
		for ($i=0; $i < count($sections); $i++) {
			$pos = $i;
			if($sections[$i]['section_title'] == ''){
				$pos = $prev_pos;
			}
			$this->sections->update($sections[$i]['id'],array('position' => $pos));
			$prev_pos = $pos;
		}
	}

	private function read_section_info($site_id){
		$this->load->model('Section_model','sections');
		$this->db->order_by('position','asc');
		$sections = $this->sections->get_many_by('id_site',$site_id);
		$section_data = array(
			'section_title' => $this->input->post('title'),
			'section_type' => $this->input->post('section_type'),
			'id_site' => $site_id,
		);
		if(isset($_FILES['section-image_upload']) && $_FILES['section-image_upload']['error'] == 0){
			//We have an image to upload.
			$this->load->library('upload');

			$filename = $this->input->post('title') ? $this->input->post('title') :
																								"section_".$this->input->post('section_type').
																								"_".($this->db->count_all('sections'))."-".
																								($this->db->insert_id())."_image";

			$filename.= '.'.pathinfo($_FILES['section-image_upload']['name'],PATHINFO_EXTENSION);
			$this->upload->initialize($this->image_upload_config($filename));
			if(!$this->upload->do_upload('section-image_upload'))
			{
					 $this->twiggy->set('error_msg','Hubo problemas al subir su archivo. Es muy probable que el tamaño de este sea muy grande.');
					 $site_info = $this->sections->get_all_with_site_info($section_data['id_site']);
					 $this->twiggy->set('site_info',$site_info);
					 return $this->twiggy->template('section/add')->display();

			}
			else{
				$section_data['background'] = 'assets/img/'.$this->upload->data()['file_name'];
			}
		}
		else{
			if($this->input->post('section-color_picker') != '#000000')
				$section_data['background'] = $this->input->post('section-color_picker');
		}

		$section_count = count($sections);
		$should_add = false;
		$section_id = $this->input->post('insert_after');
		$section_position = 0;

		if($section_id == -1){
			$should_add = true;
			$section_position = -1;
			$section_data['position'] = 1;
		}
		else if($section_data['section_title'] == ''){
			$parent_section = $this->sections->get($section_id);
			$section_data['position'] = $parent_section['position'];
		}

		if($should_add){
			for($i = 0; $i < $section_count;$i++){
				if($section_id == $sections[$i]['id']){
					$should_add = true;
					$section_position = $sections[$i]['position'];
					$section_data['position'] = $section_position + 1;
				}

				if($should_add && $section_position != $sections[$i]['position']){
					$new_pos = array('position' => $sections[$i]['position'] + 1);
					$this->sections->update($sections[$i]['id'],$new_pos);
				}
			}
		}
		return $section_data;
	}



	public function add_update($site_id){

		if($this->input->method() == 'post'){
			$this->load->model('Section_model','sections');
			$section_data = $this->read_section_info($site_id);

			if($this->input->post('is_edit')){
				$this->sections->update($this->input->post('is_edit'),$section_data);
			}
			else{
				$this->sections->insert($section_data);
			}

			$section_id = $this->input->post('is_edit') ? $this->input->post('is_edit') : $this->db->insert_id();
			switch ($section_data['section_type']) {
				case 'block':
					$this->add_update_block_data($section_id);
					break;
				case 'full_text':
					$this->add_update_fulltext_data($section_id);
					break;
				case 'text_image':
					$result = $this->add_update_textimage_data($section_id);
					if($result == 'image_upload_error'){
						 $this->twiggy->set('error_msg','Hubo problemas al subir su archivo. Es muy probable que el tamaño de este sea muy grande.');
	 					 $site_info = $this->sections->get_all_with_site_info($section_data['id_site']);
						 $this->twiggy->set('site_info',$site_info);
	 					 return $this->twiggy->template('section/add')->display();
					}
					break;
				case 'image':
					$this->add_update_image_data($section_id);
					break;
				default:
					break;
			}
			$this->fix_section_numbers($site_id);

		}
		redirect('site/'.$site_id.'/section'); //Can't access this site another way.
	}

	public function add($site_id){
		//If site_id == null, it should redirect to sites... meanwhile:
		$this->load->model("Section_model",'sections');
		$site_info =  $this->sections->get_all_with_site_info($site_id);
		if(!$site_info)
			redirect('site/'.$site_id.'/section');

		$this->twiggy->set('site_info',$site_info);
		$this->twiggy->template('section/add')->display();

	}

	public function ajax_image_upload(){
		// $this->output->set_output(json_encode(array('a' => 'b')));
		if($this->input->is_ajax_request())
		{
			$path = $this->do_image_upload('file');
			$data = array();
			if($path == null){
				$data['status'] = 'Image Upload Error';
			}
			else {
				$data['status'] = 'success';
				$img_data = array(
					'image_url' => $path
				);
				$this->load->model("Imagesection_model",'images');
				$this->images->insert($img_data);
				$data['id'] = $this->db->insert_id();
			}
			$this->output->set_output(json_encode($data));
		}
		return;
	}

	public function ajax_delete_image($site_id,$img_id){
		if($this->input->is_ajax_request()){
			$this->load->model('Imagesection_model','images');
			$data = $this->images->get($img_id);
			if(unlink($data['image_url'])){
				$this->images->delete($img_id);
				echo json_encode(array('status'=>'success'));
			}
			else{
				echo json_encode(array('status'=>'error'));
			}
		}
	}

	public function ajax_section_type($section_type,$section_id = ''){
		if($this->input->is_ajax_request()){
			$this->load->model("Section_model",'sections');
			switch ($section_type) {
				case 'block':
					if($section_id != ''){
						//Load data C:
						$section = $this->sections->get($section_id);
						$this->load->model('Blocksection_model','blocks');
						$section['blocks'] = $this->blocks->get_many_by('section_id',$section_id);
						$this->twiggy->set('section',$section);
					}
					$output = $this->twiggy->render('section/add_block_section');
					$this->output->set_output($output);
					return;
				case 'full_text':
					if($section_id != ''){
						//Load data C:
						$section = $this->sections->get($section_id);
						$this->load->model('Fulltextsection_model','fulltext');
						$section['data'] = $this->fulltext->get_by('section_id',$section_id);
						$this->twiggy->set('section',$section);
					}
					$output = $this->twiggy->render('section/add_fulltext_section');
					$this->output->set_output($output);
					return;
				case 'text_image':
					if($section_id != ''){
						//Load data C:
						$section = $this->sections->get($section_id);
						$this->load->model('Textimagesection_model','textimage');
						$section['data'] = $this->textimage->get_by('section_id',$section_id);
						$this->twiggy->set('section',$section);
					}
					$output = $this->twiggy->render('section/add_text_image_section');
					$this->output->set_output($output);
					return;
				case 'image':
					if($section_id != ''){
						//Load data C:
						$section = $this->sections->get($section_id);
						$this->load->model('Imagesection_model','images');
						$section['data'] = $this->images->get_many_by('section_id',$section_id);
						$this->twiggy->set('section',$section);
					}
					$output = $this->twiggy->render('section/add_image_section');
					$this->output->set_output($output);
					return;
				default:
					break;
			}
		}
	}
}