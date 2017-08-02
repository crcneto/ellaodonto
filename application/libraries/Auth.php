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

    public function sec_pro() {
        $us = $this->CI->session->userdata("usuario");
        if (!$us['secretaria'] && !$us['profissional'] && !$us['sysadmin']) {
            $this->CI->msg->erro("Desculpe, área não autorizada para o usuário atual");
            redirect(site_url());
        }
    }
    public function sec() {
        $us = $this->CI->session->userdata("usuario");
        if (!$us['secretaria'] && !$us['sysadmin']) {
            $this->CI->msg->erro("Desculpe, área não autorizada para o usuário atual");
            redirect(site_url());
        }
    }
    public function pro() {
        $us = $this->CI->session->userdata("usuario");
        if (!$us['profissional'] && !$us['sysadmin']) {
            $this->CI->msg->erro("Desculpe, área não autorizada para o usuário atual");
            redirect(site_url());
        }
    }
    public function sysadmin() {
        $us = $this->CI->session->userdata("usuario");
        if (!$us['sysadmin']) {
            $this->CI->msg->erro("Desculpe, área não autorizada para o usuário atual");
            redirect(site_url());
        }
    }
    
    public function administrador(){
        $us = $this->CI->session->userdata("usuario");
        if (!$us['sysadmin']) {
            return false;
        }else{
            return true;
        }
    }


    public function sec_pro_menu() {
        $us = $this->CI->session->userdata("usuario");
        if (!$us['secretaria'] && !$us['profissional'] && !$us['sysadmin']) {
            return false;
        }else{
            return true;
        }
    }
    
    

}
