<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function index(){
        $this->load->model('Section_model','Section');
        $data = $this->Section->get_all_with_info();
        $this->twiggy->set('sections',$data);
        $this->twiggy->template('main/index')->display();
    }

    public function mail() {
        $this->load->library('email');

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.googlemail.com',
            'smtp_port' => 587,
            'smtp_crypto' => 'tls',
            'smtp_user' => 'lrojas94@gmail.com',
            'smtp_pass' => 'lrojas#2894',
            'mailtype'  => 'html',
            'charset'   => 'iso-8859-1'
        );

        $this->email->initialize($config);
        $this->email->set_newline("\r\n");
        //print_r($this->input->post());
        $from = $this->input->post('mail');
        $name = $this->input->post('name');
        $body = $this->input->post('msg');

        $this->email->from($from,$name);

        $this->email->to('serviciocliente@pabe.com.do');
        // $this->email->to('lrojas94@gmail.com');
        $this->email->subject("Feedback PABE. (Pagina Web)");
        $this->twiggy->set(array(
          'body' => $body,
          'name' => $name,
          'from' => $from
        ));

        $message = $this->twiggy->template('email')->render();


        $this->email->message($message);
        $result = array();

        if($this->email->send()){
            $result['status'] = 'success';
            echo json_encode($result);
        }
        else {

            $result['status'] = 'error';
            $result['error_msg'] = $this->mail->print_debugger();
            return json_encode($result);
        }

    }
}
