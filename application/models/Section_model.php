<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section_model extends MY_Model {
    protected $return_type = 'array';

    function __construct(){
        parent::__construct();
    }

    function get_all_with_info($site_id){
      $this->load->model('Blocksection_model','BlockSection');
      $this->load->model('Textimagesection_model','TextImageSection');
      $this->load->model('Imagesection_model','ImageSection');
      $this->load->model('Fulltextsection_model','FullTextSection');
      $this->db->order_by('position','asc');
      $sections = $this->get_many_by('id_site',$site_id);
      foreach($sections as &$section) {
        switch ($section['section_type']) {
          case 'block':
            $query = $this->BlockSection->get_many_by('section_id',$section['id']);
            $section['blocks'] = $query;
            break;
          case 'text_image':
            $query = $this->TextImageSection->get_by('section_id',$section['id']);
            $section['data'] = $query; //ONLY SUPPOSED TO RETURN 1
            break;
          case 'image':
            $query = $this->ImageSection->get_many_by('section_id',$section['id']);
            $section['images'] = $query;
            break;
          case 'full_text':
            $query = $this->FullTextSection->get_by('section_id',$section['id']);
            $section['data'] = $query; //ONLY SUPPOSED TO RETURN 1
            break;
          default:
            # code...
            break;
        }
      }

      return $sections;
    }

    function get_all_with_site_info($site_id){
      $this->load->model('Site_model',"sites");
      $site = $this->sites->get($site_id);
      $this->db->order_by('position','asc');
      $sections  = $this->get_many_by('id_site',$site_id);
      $site['sections'] = $sections;
      return $site;
    }
}

?>
