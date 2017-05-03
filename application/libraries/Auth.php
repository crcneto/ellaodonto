<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth {

    private $CI;


    public function __construct() {
        $this->CI = & get_instance();
    }

    public function checkAuth($pagina) {
        
        if (!$this->CI->session->userdata('usuario')) {
            $this->CI->session->set_userdata('pagina', $pagina);
            $this->CI->session->set_userdata('erro_mensagem', 'É necessário ter sido autenticado pelo sistema para ter acesso a esta página.');
            redirect(site_url('autenticacao'));
        }
    }
    
    public function checkAccess($acesso){
        if($this->CI->session->userdata('acesso')<$acesso){
            $this->CI->session->set_userdata('erro_mensagem', 'Desculpe, você não possui acesso a esta página.');
            redirect(site_url());
        }
    }

}
