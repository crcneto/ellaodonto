<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paciente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('paciente_model');
    }

    public function index() {
        //verifica autenticação
        $this->auth->checkAuth('paciente');

        //verifica acesso
        $this->auth->checkAccess(3);

        //array de parâmetros
        $toView = [];

        try {
            //carrega pacientes
            $pacientes = $this->paciente_model->getAllById();
            $toView['pacientes'] = $pacientes;

            //carrega usuarios
            $this->load->model('usuario_model');
            $usuarios = $this->usuario_model->getAllById();
            $toView['usuarios'] = $usuarios;



            if ($this->input->post('id')) {
                $id = $this->input->post('id');
                $paciente = $this->paciente_model->getById($id);
                $toView['paciente'] = $paciente;
            }


            $this->load->view('inc/header_view');
            $this->load->view('paciente/paciente_view', $toView);
            $this->load->view('inc/footer_view');
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            redirect(site_url());
        }
    }

    public function insert() {
        //verifica autenticação
        $this->auth->checkAuth('paciente');

        //verifica acesso
        $this->auth->checkAccess(3);

        //array de parâmetros
        $toView = [];

        try {
            
            $data = array();
            
            if ($this->input->post('id')) {
                $id = $this->input->post('id');
                if (!$this->paciente_model->exists($id)) {
                    throw new Exception('Paciente não localizado');
                }
                $data = $this->paciente_model->getById($id);
                $toView['paciente'] = $data;
            }
            
            if (!$this->input->post('responsavel')) {
                throw new Exception("Responsável não identificado");
            }
            
            $this->load->model('usuario_model');
            $usuario = $this->input->post('responsavel');
            
            if (!$this->usuario_model->existsId($usuario)) {
                throw new Exception('Responsável não encontrado');
            }
            if (!$this->input->post('nome')) {
                throw new Exception('É necessário informar o nome do paciente');
            }
            $nome = $this->input->post('nome');

            if (!$this->input->post('sexo')) {
                throw new Exception("É necessário informar o sexo do paciente");
            }
            $sexo = $this->input->post('sexo');


            $data = [
                'usuario' => $usuario,
                'nome' => $nome,
                'sexo' => $sexo,
                'operador' => $this->session->userdata('operador')
            ];
            
            if($this->input->post('dn')){
                $dn = inverte_data_w_exception($this->input->post('dn'));
                $data['dn'] = $dn;
            }

            if (!isset($id)) {
                if ($this->paciente_model->insert($data)) {
                    $this->msg->sucesso("Cadastrado com sucesso");
                    redirect(site_url('paciente'));
                } else {
                    throw new Exception('Erro ao cadastrar paciente');
                }
            } else {
                if ($this->paciente_model->update($data)) {
                    $this->msg->sucesso("Cadastro de paciente alterado com sucesso");
                    redirect(site_url('paciente'));
                }else{
                    throw new Exception("Erro ao alterar o cadastro do paciente");
                }
            }
        } catch (Exception $ex) {
            if(isset($data)){
                $toView['paciente'] = $data;
            }
            $this->msg->erro($ex->getMessage());
            redirect(site_url('paciente'));
        }
    }

}
