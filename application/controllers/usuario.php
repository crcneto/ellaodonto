<?php

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
    }

    public function editform() {
        //checa a autenticação
        $this->auth->checkAuth('usuario');

        $toView = array();

        $this->load->view('inc/header_view');
        $this->load->view('usuario/alterarsenha_view', $toView);
        $this->load->view('inc/footer_view');
    }

    public function index() {

        //checa a autenticação
        $this->auth->checkAuth('usuario');

        $req = array();
        $toView = array();

        $toView['acessos'] = [
            '1' => 'usuario',
            '3' => 'secretaria',
            '5' => 'profissional',
            '9' => 'webmaster'
        ];

        $toView['status'] = [
            '0' => 'Desativado',
            '1' => 'Pendente',
            '2' => 'Ativo',
            '3' => 'Bloqueado'
        ];
        
        try {
            if ($this->input->post('id')) {
                $id = $this->input->post('id');
                $user = $this->usuario_model->get($id);
                $req = $user;
            } else {
                if ($this->session->flashdata('req')) {
                    $req = $this->session->flashdata('req');
                }
            }

            $toView['req'] = $req;
            
            $usuarios = $this->usuario_model->getAll();
            $toView['usuarios'] = $usuarios;
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        }

        $this->load->view('inc/header_view');
        $this->load->view('usuario/usuario_view', $toView);
        $this->load->view('inc/footer_view');
    }

    public function insert() {
        $req = array();
        try {

            $update = false;

            if ($this->input->post('id')) {
                $update = true;
            }

            $nome = $this->input->post('nome');
            $email = $this->input->post('email');
            $cpfcnpj = $this->input->post('cpfcnpj');
            $tipo = $this->input->post('tipo');
            $gerar = $this->input->post('gerar');
            $celular = $this->input->post('celular');
            $fixo = $this->input->post('fixo');
            $obs = $this->input->post('obs');
            $status = $this->input->post('status');
            
            $cpfcnpj = preg_replace( '/[^0-9]/is', '', $cpfcnpj );
            $req = [
                'nome' => $nome,
                'email' => $email,
                'cpfcnpj' => (int)$cpfcnpj,
                'tipo' => $tipo,
                'gerar' => $gerar,
                'celular' => $celular,
                'fixo' => $fixo,
                'obs' => $obs,
                'status' => $status
            ];

            $this->load->helper('email_helper');

            if (!$nome || strlen($nome) < 3) {
                throw new Exception('Nome inválido.');
            }
            if (!valid_email($email)) {
                throw new Exception("E-mail inválido.");
            }
            if ($tipo == 1) {
                if (!valida_cpf($cpfcnpj)) {
                    throw new Exception('CPF inválido.');
                }
            } else {
                if (!valida_cnpj($cpfcnpj)) {
                    throw new Exception('CNPJ inválido.');
                }
            }

            $user = [
                'nome' => $nome,
                'email' => $email,
                'cpfcnpj' => $cpfcnpj,
                'celular' => $celular,
                'fixo' => $fixo,
                'obs' => $obs,
                'status' => $status
            ];

            if ($gerar == 1) {
                $senhagerada = substr(md5($email . rand()), 0, 10);
                $senha = md5($senhagerada);
                $user['senha'] = $senha;
            }
            if ($update) {
                $id = $this->input->post('id');
                $u = $this->usuario_model->getByEmail($email);
                if ($u['id'] != $id) {
                    throw new Exception('E-mail já cadastrado para outro usuário.');
                }
                $user['id'] = $id;

                if ($this->usuario_model->update($user)) {
                    $this->msg->sucesso('Usuário alterado com sucesso.');
                    redirect(site_url('usuario'));
                } else {
                    throw new Exception('Erro ao alterar usuário.');
                }
            } else {
                if ($this->usuario_model->exists($email)) {
                    throw new Exception("E-mail já cadastrado.");
                }

                $senhagerada = substr(md5($email . rand()), 0, 10);
                $senha = md5($senhagerada);
                $user['senha'] = $senha;

                if ($this->usuario_model->insert($user)) {
                    $this->msg->sucesso('Usuário cadastrado com sucesso.');
                    redirect(site_url('usuario'));
                } else {
                    throw new Exception('Erro ao cadastrar.');
                }
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            $this->session->set_flashdata('req', $req);
            redirect(site_url('usuario'));
        }
    }

    public function desativa() {
        try {
            if ($this->input->post('id') == null || $this->input->post('id') == '') {
                throw new Exception('Usuário não encontrado.');
            }
            if (!$this->usuario_model->existsId($this->input->post('id'))) {
                throw new Exception('Usuário não encontrado.');
            }
            $id = $this->input->post('id');

            if ($this->usuario_model->desativa($id) > 0) {
                $this->session->set_userdata('sucesso_mensagem', "Usuário desativado.");
            } else {
                throw new Exception('Erro ao desativar usuário.');
            }
            redirect(site_url('usuario'));
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            redirect(site_url('usuario'));
        }
    }

    public function ativa() {
        try {
            if ($this->input->post('id') == null || $this->input->post('id') == '') {
                throw new Exception('Usuário não encontrado.');
            }
            if (!$this->usuario_model->existsId($this->input->post('id'))) {
                throw new Exception('Usuário não encontrado.');
            }
            $id = $this->input->post('id');

            if ($this->usuario_model->ativa($id) > 0) {
                $this->msg->sucesso("Usuário ativado.");
                redirect(site_url('usuario'));
            } else {
                throw new Exception('Erro ao desativar usuário.');
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            redirect(site_url('usuario'));
        }
    }

    public function reset() {

        try {
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            redirect(site_url('usuario'));
        }
    }

    public function changepass() {

        try {
            $
                    $usuario = $this->session->userdata('usuario');
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            redirect(site_url('usuario/editform'));
        }
    }

}
