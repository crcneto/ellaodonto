<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assistente extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        //verifica autenticação
        $this->auth->checkAuth('assistente');

        $toView = [];

        try {
            $operador = $this->session->userdata("operador");

            $this->load->model("usuario_model", "um");
            $usuarios = $this->um->todos_ativos();
            unset($usuarios[$operador]);
            $toView["usuarios"] = $usuarios;

            $users = $this->um->getAllById();
            $toView['users'] = $users;

            $this->load->model("assistente_model", "am");
            $assistentes = $this->am->assistentes($operador);
            $toView['assistentes'] = $assistentes;
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            $this->load->view("inc/header_view");
            $this->load->view("assistente/assistente_view", $toView);
            $this->load->view("inc/footer_view");
        }
    }

    public function add() {

        try {

            //verifica autenticação
            $this->auth->checkAuth('assistente');

            //define operador
            $operador = $this->session->userdata("operador");

            //recebe POST / define assistente
            $assist = $this->input->post('assistente');

            //carrega model Usuario
            $this->load->model("usuario_model", "um");

            //verifica a existência do usuário
            if (!$this->um->existe_id($assist)) {
                throw new Exception("Assitente não identificado.");
            }

            //carrega model Assistente
            $this->load->model("assistente_model", "am");

            //define array Assistente
            $data = [
                "profissional" => $operador,
                "assistente" => $assist
            ];
            
            if (!$this->am->ja_existe($data)) {
                if ($this->am->add($data)) {
                    $this->msg->sucesso("Cadastrado com sucesso");
                } else {
                    throw new Exception("Erro ao cadastrar");
                }
            }else{
                $this->msg->sucesso("Cadastrado com sucesso");
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('assistente'));
        }
    }

    public function delete() {

        try {

            //verifica autenticação
            $this->auth->checkAuth('assistente');

            //define operador
            $operador = $this->session->userdata("operador");

            //recebe POST / define assistente
            $assist = $this->input->post('assistente');

            //carrega model Assistente
            $this->load->model("assistente_model", "am");

            //define array Assistente
            $data = [
                "profissional" => $operador,
                "assistente" => $assist
            ];

            if ($this->am->delete($data)) {
                $this->msg->sucesso("Assistente removido");
            } else {
                throw new Exception("Erro ao remover assistente");
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('assistente'));
        }
    }

}
