<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Msg {

    private $CI;


    public function __construct() {
        $this->CI = & get_instance();
    }
    
    public function erro($mensagem){
        $this->CI->session->set_userdata('erro_mensagem', $mensagem);
    }
    
    public function sucesso($mensagem){
        $this->CI->session->set_userdata('sucesso_mensagem', $mensagem);
    }
    
}