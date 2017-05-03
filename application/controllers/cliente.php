<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //cliente model
        $this->load->model('cliente_model', 'cli');

        //carrega helper CPF
        $this->load->helper('cpf_helper');

        //carrega helper tratamento array
        $this->load->helper('array_helper');

        //carrega helper status
        $this->load->helper('status_helper');
    }

    public function index() {
        //verifica autenticação
        $this->auth->checkAuth('cliente');

        //verifica acesso
        $this->auth->checkAccess(3);

        //array de parâmetros
        $toView = [];

        try {
            $this->load->model('usuario_model');
            $this->load->view('inc/header_view');
            $this->load->view('cliente/cliente_view', $toView);
            $this->load->view('inc/footer_view');
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            redirect(site_url());
        }
    }

    public function insert() {

        try {
            //verifica autenticação
            $this->auth->checkAuth('cliente');

            //verifica acesso
            $this->auth->checkAccess(3);


            if (!$this->input->post('cpfcnpj')) {
                throw new Exception('Campo obrigatório não preenchido.[CPF]');
            }
            $cpfcnpj = $this->input->post('cpfcnpj');

            if (!$this->input->post('nome')) {
                throw new Exception('Campo obrigatório não preenchido.[Nome]');
            }
            $nome = $this->input->post('nome');

            if ($this->input->post('id') != NULL) {
                $id = $this->input->post('id');
            }

            $tipo = $this->input->post('tipo');

            $status = $this->input->post('status');
            if ($tipo == 1) {
                if (!valida_cpf($cpfcnpj)) {
                    throw new Exception("CPF inválido.");
                }
            } else {
                if (!valida_cnpj($cpfcnpj)) {
                    throw new Exception('CNPJ inválido.');
                }
            }



            $data = [];

            if (isset($id)) {
                $data = array(
                    'id' => $id,
                    'nome' => $nome,
                    'cpfcnpj' => $cpfcnpj,
                    'status' => $status
                );

                if ($this->cli->update($data)) {
                    $this->msg->sucesso('Cadastro atualizado com sucesso.');
                    redirect(site_url('cliente'));
                } else {
                    $this->msg->erro('Erro ao atualizar o cadastro.');
                    redirect(site_url('cliente'));
                }
            } else {
                if ($this->cli->exists($cpfcnpj)) {
                    throw new Exception('CPF/CNPJ já cadastrado.');
                }
                $data = array(
                    'nome' => $nome,
                    'cpfcnpj' => $cpfcnpj,
                    'status' => $status
                );
                if ($this->cli->insert($data)) {
                    $this->msg->sucesso('Cadastrado com sucesso.');
                    redirect(site_url('cliente'));
                } else {
                    $this->msg->erro('Erro ao cadastrar.');
                    redirect(site_url('cliente'));
                }
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            redirect(site_url('cliente'));
        }
    }

    public function delete() {
        //verifica autenticação
        $this->auth->checkAuth('cliente');

        //verifica acesso
        $this->auth->checkAccess(3);

        //carrega helper tratamento array
        $this->load->helper('array_helper');
        try {
            $id = $this->input->post('id');

            if ($id == null || $id == '') {
                throw new Exception('Identificador inválido');
            }
            if ($this->cli->delete($id)) {
                $this->msg->sucesso('Cliente excluído.');
                redirect(site_url('cliente'));
            } else {
                $this->msg->erro('Erro ao excluir cliente.');
                redirect(site_url('cliente'));
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            redirect(site_url('cliente'));
        }
    }

}
