<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends MY_Model {

  public $primary_key = 'username';
  protected $return_type = 'array';
  function __construct(){
      parent::__construct();
  }

}

?>
