<?php

/**
 * Controller responsável por manipular os locais de atendimento 
 * @author Cláudio Neto <claudiorcneto@gmail.com>
 * @package ellaodonto
 * @subpackage controllers
 */
class Local extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('local_model');
    }

    /**
     * Controller da página inicial do cadastro dos "Meus Locais de Atendimento". Controla a relação do usuário com o local de atendimento...
     *  
     */
    public function index() {
        $toView = [];

        $this->auth->checkAuth('local');

        try {
            $toView["tipos"] = tipos_logradouro();

            if ($this->session->flashdata("lo")) {
                $toView['lo'] = $this->session->flashdata("lo");
            }

            $toView['locais'] = $this->local_model->getAllById();
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            if ($this->session->flashdata("lo")) {
                $toView['lo'] = $this->session->flashdata("lo");
            }
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('local/local_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }

    public function insert() {
        $this->auth->checkAuth('local');

        try {
            $data = [];

            if ($this->input->post('id')) {
                $data['id'] = $this->input->post('id');
            }


            $data['nome'] = $this->input->post('nome');
            $data['tp_log'] = $this->input->post('tp_log');
            $data['logradouro'] = $this->input->post('logradouro');
            $data['nro'] = $this->input->post('nro');
            $data['bairro'] = $this->input->post('bairro');
            $data['cidade'] = $this->input->post('cidade');
            $data['uf'] = $this->input->post('uf');
            $data['cep'] = $this->input->post('cep');
            $data['complemento'] = $this->input->post('complemento');
            $data['tel'] = $this->input->post('tel');
            $data['cel'] = $this->input->post('cel');

            //$data = limpaArray($data);

            if (isset($data['id'])) {
                if ($this->local_model->update($data)) {
                    $this->msg->sucesso("Alterado com sucesso");
                } else {
                    throw new Exception("Erro ao alterar o registro do local de atendimento");
                }
            } else {
                if ($this->local_model->insert($data)) {
                    $this->msg->sucesso("Cadastrado com sucesso");
                } else {
                    throw new Exception("Erro ao cadastrar o local de atendimento");
                }
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            $this->session->set_flashdata('lo', $this->input->post());
        } finally {
            redirect(site_url('local'));
        }
    }

    public function desativar() {
        $this->auth->checkAuth('local');

        try {
            $data = [];

            if ($this->input->post('id')) {
                $data['id'] = $this->input->post('id');
            }
            if (!$this->local_model->exists($data['id'])) {
                throw new Exception("Erro ao carregar o local");
            }

            $data['status'] = 0;

            if ($this->local_model->update($data)) {
                $this->msg->sucesso("Local desativado");
            } else {
                throw new Exception("Erro ao desativar o local de atendimento");
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('local'));
        }
    }

    public function ativar() {
        $this->auth->checkAuth('local');

        try {
            $data = [];

            if ($this->input->post('id')) {
                $data['id'] = $this->input->post('id');
            }
            if (!$this->local_model->exists($data['id'])) {
                throw new Exception("Erro ao carregar o local");
            }

            $data['status'] = 2;

            if ($this->local_model->update($data)) {
                $this->msg->sucesso("Local ativado");
            } else {
                throw new Exception("Erro ao ativar o local de atendimento");
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('local'));
        }
    }

    public function edit() {
        $this->auth->checkAuth('local');

        try {
            $data = [];

            if ($this->input->post('id')) {
                $data['id'] = $this->input->post('id');
            }
            if (!$this->local_model->exists($data['id'])) {
                throw new Exception("Erro ao carregar o local");
            }

            $lo = $this->local_model->getById($data['id']);

            $this->session->set_flashdata("lo", $lo);
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('local'));
        }
    }

    public function meus_locais() {
        $this->auth->checkAuth('local');


        $toView = [];
        try {
            $operador = $this->session->userdata("operador");
            $toView['locais'] = $this->local_model->getAllById();

            $toView['locaiss'] = $this->local_model->get();
            $toView['mlocais'] = $this->local_model->meus_locais($operador);
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            if ($this->session->flashdata("lo")) {
                $toView['lo'] = $this->session->flashdata("lo");
            }
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('local/meus_locais_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }

    public function add_meu_local() {

        try {
            $local = $this->input->post('id');
            $usuario = $this->session->userdata("operador");
            if ($local == NULL || $usuario == NULL) {
                throw new Exception("Não foi possível determinar o usuário ou o local");
            }
            $data = ['usuario' => $usuario, 'local' => $local];

            if (!$this->local_model->existe_meu_local($data)) {

                if (!$this->local_model->add_meu_local($data)) {
                    throw new Exception("Erro ao adicionar 'Meu Local'");
                } else {
                    $this->msg->sucesso("Local adicionado");
                }
            } else {
                $this->msg->sucesso("Local adicionado");
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex);
        } finally {
            redirect(site_url('local/meus_locais'));
        }
    }

    public function delete_meu_local() {

        try {

            $local = $this->input->post('id');
            $usuario = $this->session->userdata("operador");
            if ($local == NULL || $usuario == NULL) {
                throw new Exception("Não foi possível determinar o usuário ou o local");
            }
            $data = ['usuario' => $usuario, 'local' => $local];

            if (!$this->local_model->delete_meu_local($data)) {
                throw new Exception("Erro ao excluir 'Meu Local'");
            } else {
                $this->msg->sucesso("Local excluído");
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex);
        } finally {
            redirect(site_url('local/meus_locais'));
        }
    }

    public function delete() {

        try {
            $id = $this->input->post('id');
            
            if(!$id || $id=='' || !is_numeric($id)){
                throw new Exception("Identificador inválido");
            }
            
            if(!$this->local_model->exists($id)){
                throw new Exception("Identificador não localizado");
            }
            
            if($this->local_model->delete($id)){
                $this->msg->sucesso("Local excluído");
            }else{
                throw new Exception("Erro ao excluir o local");
            }
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('local'));
        }
    }

}

/*
    id serial unique not null primary key,
    nome varchar(255),
    tp_log integer default 1,
    logradouro varchar(255),
    nro varchar(20),
    bairro varchar(120),
    cidade varchar(120),
    uf varchar(2),
    cep varchar(9),
    complemento varchar(120),
    tel varchar(40),
    cel varchar(40),
    status integer not null default 2
 */