<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function index()
    {
        $this->load->view("main_views/main.php");
    }

    public function mail(){
        print_r($this->input->post());
    }
}
