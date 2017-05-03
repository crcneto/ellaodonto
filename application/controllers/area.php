<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Area extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('area_model');
    }

    public function index() {
        try {
            //check auth
            $this->auth->checkAuth('area');

            //check access
            $this->auth->checkAccess(5);

            $toView = array();

            $areas = $this->area_model->getAllById();
            $toView['areas'] = $areas;
            
            $id = $this->input->post('id');
            
            if($id){
                $area = $this->area_model->getById($id);
                $toView['area'] = $area;
            }

            $this->load->view('inc/header_view');
            $this->load->view('area/area_view', $toView);
            $this->load->view('inc/footer_view');
        } catch (Exception $ex) {
            $this->session->set_userdata('erro_mensagem', $ex->getMessage());
            redirect(site_url('area'));
        }
    }

    public function insert() {
        $id = $this->input->post('id');
        $nome = $this->input->post('nome');
        $status = $this->input->post('status');

        try {
            $data = [];
            
            $data['nome'] = $nome;
            $data['status'] = $status;
                
            if ($id) {
                $data['id'] = $id;
                if($nome==null || $nome==''){
                    throw new Exception('Campos obrigatórios não preenchidos.');
                }
                if($this->area_model->update($data)){
                    $this->session->set_userdata('sucesso_mensagem', 'Atualizado com sucesso.');
                    redirect(site_url('area'));
                }else{
                    throw new Exception('Erro ao alterar o cadastro.');
                }
            } else {
                if($nome==null || $nome==''){
                    throw new Exception('Campos obrigatórios não preenchidos');
                }
                if($this->area_model->nomeExists($nome)){
                    throw new Exception('Já existe um registro com esse nome.');
                }
                if ($this->area_model->insert($data)) {
                    $this->session->set_userdata('sucesso_mensagem', 'Cadastrado com sucesso.');
                    redirect(site_url('area'));
                } else {
                    throw new Exception('Erro ao cadastrar');
                }
            }
        } catch (Exception $ex) {
            $this->session->set_userdata('erro_mensagem', $ex->getMessage());
            redirect(site_url('area'));
        }
    }
    
    public function delete(){
        $id = $this->input->post('id');
        try{
            if(!$id){
                throw new Exception('Registro não identificado.');
            }
            if(!$this->area_model->exists($id)){
                throw new Exception('Registro não encontrado.');
            }
            if($this->area_model->delete($id)){
                $this->session->set_userdata('sucesso_mensagem', 'Excluído com sucesso.');
                redirect(site_url('area'));
            }else{
                throw new Exception('Erro ao excluir o registro.');
            }
            
        } catch (Exception $ex) {
            $this->session->set_userdata('erro_mensagem', $ex->getMessage());
            redirect(site_url('area'));
        }
        
    }

}
