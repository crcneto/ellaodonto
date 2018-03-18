<?php

class Profissional extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model("usuario_model");
        $this->load->model("administrador_model");
        $this->load->model("profissional_model");
    }

    public function index() {

        $this->auth->checkAuth('profissional');

        $toview = [];

        try {
            

            $operador = $this->session->userdata("operador");

            if (!$this->administrador_model->check_admin($operador)) {
                $this->msg->erro("Desculpe, acesso não autorizado.");
                redirect(site_url('home'));
            }
            $toview['operador'] = $operador;
            $toview['usuarios'] = $this->usuario_model->todos_ativos();
            $toview['profs'] = $this->profissional_model->get_all_by_id();
        } catch (Exception $ex) {
            
        } finally {
            $this->load->view("inc/header_view");
            $this->load->view("profissional/profissional_view", $toview);
            $this->load->view("inc/footer_view");
        }
    }

    public function set_prof() {

        $this->auth->checkAuth('profissional');
        try {
            
            $operador = $this->session->userdata("operador");
            
            if(!$this->administrador_model->check_admin($operador)){
                throw new Exception("Você deve ser um administrador para alterar os demais usuários");
            }
            
            $user = $this->input->post('id');
            
            if(!$user || $user=="" || !is_numeric($user)){
                throw new Exception("Identificador de usuário inválido");
            }
            
            if(!$this->usuario_model->existe_id($user)){
                throw new Exception("Usuário inexistente.");
            }
            
            if($operador==$user){
                throw new Exception("Você não pode alterar seu próprio cadastro");
            }
            
            if($this->profissional_model->set_prof($user)){
                $this->msg->sucesso("Profissional definido");
            }else{
                throw new Exception("Erro ao definir o usuário como profissional");
            }
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('profissional'));
        }
    }

    public function unset_prof() {
        $this->auth->checkAuth('profissional');
        try {
            
            $operador = $this->session->userdata("operador");
            
            if(!$this->administrador_model->check_admin($operador)){
                throw new Exception("Você deve ser um administrador para alterar os demais usuários");
            }
            
            $user = $this->input->post('id');
            
            if(!$user || $user=="" || !is_numeric($user)){
                throw new Exception("Identificador de usuário inválido");
            }
            
            if(!$this->usuario_model->existe_id($user)){
                throw new Exception("Usuário inexistente.");
            }
            
            if($operador==$user){
                throw new Exception("Você não pode alterar seu próprio cadastro");
            }
            
            if($this->profissional_model->unset_prof($user)){
                $this->msg->sucesso("Definição de profissional cancelada");
            }else{
                throw new Exception("Erro ao excluir os privilégios");
            }
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('profissional'));
        }
    }

}
