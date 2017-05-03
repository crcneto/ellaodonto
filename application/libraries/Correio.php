<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Correio {

    private $CI;
    
    public function __construct() {
        $this->CI = & get_instance();
    }
    
    public function config(){
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'vistoriasneto',
            'smtp_pass' => 'meupau01',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );
        return $config;
    }
    
    public function sendMail($to, $title, $message){
        $this->CI->load->library('email', $this->config());
        $this->CI->email->set_newline("\r\n");

        $this->CI->email->from('vistoriasneto@gmail.com', 'EllaOdonto');
        $this->CI->email->to($to);
        $this->CI->email->reply_to('vistoriasneto@gmail.com', 'EllaOdonto');
        $this->CI->email->subject($title);
        $this->CI->email->message($message);
        $this->CI->email->send();
    }
}