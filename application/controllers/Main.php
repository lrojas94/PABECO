<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    public function index()
    {
        $this->load->view("main_views/main.php");
    }

    public function mail(){
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
        $this->email->to('lrojas94@gmail.com');
        $this->email->subject("Mensaje desde ");
        $message = <<<BODY
        <div style="border: 1px solid #795B43;border-top: 20px solid #795B43;padding: 20px;font-size: 16px;
        font-family: 'Avant Garde', Avantgarde, 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;">
            <div style="text-align: justify;">
                <p>
                    {$body}
                </p>
                <p style="text-align: right;">
                    - {$name}
                </p>
            </div>
            <div>
                <p>
                    <h4 style="color: #795B43;margin-bottom: 5px;">Contacto</h4>
                    Correo Electronico: {$from}
                </p>
            </div>
        </div>
BODY;


        $this->email->message($message);
        $result = array();
        
        if($this->email->send()){
            $result['status'] = 'success';
            return json_encode($result);
        }
        else {

            $result['status'] = 'error';
            $result['error_msg'] = $this->mail->print_debugger();
            return json_encode($result);
        }

    }
}
