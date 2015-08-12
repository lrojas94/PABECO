<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

    function get_all_sections(){
      $query = $this->db->get('Sections');
      $sections = $query->result_array();
      foreach($sections as &$section) {
        switch ($section['section_type']) {
          case 'block':
            $query = $this->db->from('BlockSections')
                     ->where('section_id',$section['id'])
                     ->get();
            $section['blocks'] = $query->result_array();
            break;
          case 'text_image':
            $query = $this->db->from('TextImageSections')
                      ->where('section_id',$section['id'])
                      ->get();
            $section['data'] = $query->result_array()[0]; //ONLY SUPPOSED TO RETURN 1
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
