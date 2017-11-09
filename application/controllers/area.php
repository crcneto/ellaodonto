<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Area extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('area_model', 'am');
    }

    public function index() {
        try {
            //check auth
            $this->auth->checkAuth('area');

            //check access
            $usuario = $this->session->userdata("usuario");
            if($usuario['sysadmin']<1){
                $this->msg->erro("É necessário ser administrador para acessar o cadastro de áreas");
                redirect(site_url());
            }

            $toView = array();

            $this->load->model("area_model", "area");
            $areas = $this->area->getAllById();
            $toView['areas'] = $areas;

            $id = $this->input->post('id');

            if ($id) {
                $area = $this->area_model->getById($id);
                $toView['area'] = $area;
            }
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('area/area_view', $toView);
            $this->load->view('inc/footer_view');
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
                if ($nome == null || $nome == '') {
                    throw new Exception('Campos obrigatórios não preenchidos.');
                }
                if ($this->area_model->ja_existe_nome($nome, $id)) {
                    throw new Exception("Esta definição de área já foi utilizada");
                }
                if ($this->area_model->update($data)) {
                    $this->session->set_userdata('sucesso_mensagem', 'Atualizado com sucesso.');
                    redirect(site_url('area'));
                } else {
                    throw new Exception('Erro ao alterar o cadastro.');
                }
            } else {
                if ($nome == null || $nome == '') {
                    throw new Exception('Campos obrigatórios não preenchidos');
                }
                if ($this->area_model->nomeExists($nome)) {
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

    public function delete() {
        $id = $this->input->post('id');
        try {
            if (!$id) {
                throw new Exception('Registro não identificado.');
            }
            if (!$this->area_model->exists($id)) {
                throw new Exception('Registro não encontrado.');
            }
            if ($this->area_model->delete($id)) {
                $this->session->set_userdata('sucesso_mensagem', 'Excluído com sucesso.');
                redirect(site_url('area'));
            } else {
                throw new Exception('Erro ao excluir o registro.');
            }
        } catch (Exception $ex) {
            $this->session->set_userdata('erro_mensagem', $ex->getMessage());
            redirect(site_url('area'));
        }
    }

    public function definir_area() {
        $toView = [];
        try {
            
            $areas = $this->am->getAllById();
            $toView["areas"] = $areas;

            $operador = $this->session->userdata("operador");
            $definidas = $this->am->get_definidas($operador);
            $toView['definidas'] = $definidas;
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('area/definir_area_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }

    public function vincular() {

        try {
            $operador = $this->session->userdata("operador");
            $area = $this->input->post("area");
            
            if(!$area || $area=='' || !is_numeric($area)){
                throw new Exception("Erro ao definir a área de atuação");
            }
            
            if(!$this->am->vinculada($operador, $area)){
                if($this->am->vincular($operador, $area)){
                    $this->msg->sucesso("Área definida");
                }else{
                    throw new Exception("Erro ao definir a área");
                }
            }else{
                $this->msg->sucesso("Área vinculada"); 
            }
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('area/definir_area'));
        }
    }
    
    public function desvincular() {

        try {
            $operador = $this->session->userdata("operador");
            $area = $this->input->post("area");
            
            if(!$area || $area=='' || !is_numeric($area)){
                throw new Exception("Erro ao definir a área de atuação");
            }
            
            if($this->am->vinculada($operador, $area)){
                if($this->am->desvincular($operador, $area)){
                    $this->msg->sucesso("Área excluída");
                }else{
                    throw new Exception("Erro ao excluir a área");
                }
            }else{
                $this->msg->sucesso("Área excluída"); 
            }
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('area/definir_area'));
        }
    }

}
