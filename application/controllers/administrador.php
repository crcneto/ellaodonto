<?php

class Administrador extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model("usuario_model");
        $this->load->model("administrador_model");
    }

    public function index() {

        $this->auth->checkAuth('administrador');

        $toview = [];

        try {
            

            $operador = $this->session->userdata("operador");

            if (!$this->administrador_model->check_admin($operador)) {
                $this->msg->erro("Desculpe, acesso não autorizado.");
                redirect(site_url('home'));
            }
            $toview['operador'] = $operador;
            $toview['usuarios'] = $this->usuario_model->todos_ativos();
            $toview['admins'] = $this->administrador_model->get_all_by_id();
        } catch (Exception $ex) {
            
        } finally {
            $this->load->view("inc/header_view");
            $this->load->view("administrador/administrador_view", $toview);
            $this->load->view("inc/footer_view");
        }
    }

    public function set_admin() {

        $this->auth->checkAuth('administrador');
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
            
            if($this->administrador_model->set_admin($user)){
                $this->msg->sucesso("Administrador incluído");
            }else{
                throw new Exception("Erro ao tornar o usuário administrador");
            }
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('administrador'));
        }
    }

    public function unset_admin() {
        $this->auth->checkAuth('administrador');
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
            
            if($this->administrador_model->unset_admin($user)){
                $this->msg->sucesso("Administrador removido");
            }else{
                throw new Exception("Erro ao excluir os privilégios");
            }
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('administrador'));
        }
    }

}
