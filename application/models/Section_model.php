<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section_model extends MY_Model {
    protected $return_type = 'array';
    
    function __construct(){
        parent::__construct();
    }

    function get_all_with_info(){
      $this->load->model('BlockSection_model','BlockSection');
      $this->load->model('TextImageSection_model','TextImageSection');
      $this->load->model('ImageSection_model','ImageSection');
      $this->load->model('FullTextSection_model','FullTextSection');

      $query = $this->db->from('Sections')
               ->order_by('position','asc')
               ->get();
      $sections = $query->result_array();
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
}

?>
