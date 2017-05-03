<?php


class Home extends CI_Controller{
    
    
    public function index(){
        $this->load->view('inc/header_view');
        $this->load->view('home/home_view');
        $this->load->view('inc/footer_view');
    }
    
    public function erro(){
        $this->load->view('inc/header_view');

        $this->load->view('erro/e404_view');

        $this->load->view('inc/footer_view');
    }
    
    public function erroautenticacao(){
        $this->load->view('inc/header_view');
        $this->load->view('erro/eauth_view');
        $this->load->view('inc/footer_view');
    }
    
    public function acessonegado(){
        $this->load->view('inc/header_view');
        $this->load->view('erro/eacesso_view');
        $this->load->view('inc/footer_view');
    }
}