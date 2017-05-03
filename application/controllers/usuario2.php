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
        
        //checa a autenticação/redireciona
        $this->auth->checkAuth('usuario');
        
        //checar o acesso
        //***************
        
        $toView = array();

        if ($this->input->post('id') != null && $this->input->post('id') != '') {
            $this->session->set_userdata('user', $this->usuario_model->get($this->input->post('id')));
        }

        $usuarios = $this->usuario_model->getAll();
        $toView['usuarios'] = $usuarios;

        $status = array(
            '0' => 'Desativado',
            '1' => 'Cadastro Pendente',
            '2' => 'Ativo'
        );
        $toView['status'] = $status;

        $acessos = array(
            '1' => 'Cliente/Paciente',
            '3' => 'Secretaria',
            '5' => 'Profissional',
            '7' => 'Administrador',
            '9' => 'WebMaster'
        );
        $toView['acessos'] = $acessos;

        $this->load->view('inc/header_view');
        $this->load->view('usuario/usuario_view', $toView);
        $this->load->view('inc/footer_view');
    }

    public function edit() {
        $this->load->library('form_validation');

        if ($this->session->userdata('autenticado') == null) {
            $this->session->set_userdata('erro_mensagem', 'É necessário estar logado para acessar esta página.');
            redirect(site_url('home'));
        }
        if ($this->session->userdata('acesso') < 5) {
            $this->session->set_userdata('erro_mensagem', 'Desculpe, você não possui acesso a esta página.');
            redirect(site_url('home'));
        }
        $id = $this->input->post('id');
        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        $acesso = $this->input->post('acesso');

        $this->load->helper('data_helper');

        $usuario = [
            "id" => $id,
            "nome" => $nome,
            "email" => $email,
            "acesso" => $acesso
        ];

        try {
            if (!$this->form_validation->required($id)) {
                throw new Exception("Campo obrigatório não preenchido [ID].");
            }
            if (!$this->form_validation->required($nome)) {
                throw new Exception("Campo obrigatório não preenchido [Nome].");
            }
            if (!$this->form_validation->required($email)) {
                throw new Exception("Campo obrigatório não preenchido [Email].");
            }
            if (!$this->form_validation->valid_email($email)) {
                throw new Exception("E-mail inválido.");
            }
            if (!$this->form_validation->required($acesso)) {
                throw new Exception("Campo obrigatório não preenchido [Acesso].");
            }
            
            if (!$this->usuario_model->exists($usuario['email'])) {
                throw new Exception("Usuário não encontrado.");
            }

            if ($this->usuario_model->update($usuario)) {
                $this->session->set_userdata('sucesso_mensagem', "Alteração de usuário realizada com sucesso.");
                redirect(site_url('usuario'));
            } else {
                throw new Exception("Erro ao editar usuário.");
            }
        } catch (Exception $ex) {

            $this->session->set_userdata('erro_mensagem', $ex->getMessage());
            redirect(site_url('usuario'));
        }
    }

    public function insert() {
        $this->load->library('form_validation');

        if ($this->session->userdata('autenticado') == null) {
            $this->session->set_userdata('erro_mensagem', 'É necessário estar logado para acessar esta página.');
            redirect(site_url('home'));
        }
        if ($this->session->userdata('acesso') < 5) {
            $this->session->set_userdata('erro_mensagem', 'Desculpe, você não possui acesso a esta página.');
            redirect(site_url('home'));
        }

        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        $acesso = $this->input->post('acesso');

        $this->load->helper('data_helper');

        $usuario = [
            "nome" => $nome,
            "email" => $email,
            "acesso" => $acesso
        ];

        $this->session->set_userdata('user', $usuario);

        try {
            if (!$this->form_validation->required($nome)) {
                throw new Exception("Campo obrigatório não preenchido [Nome].");
            }
            if (!$this->form_validation->required($email)) {
                throw new Exception("Campo obrigatório não preenchido [Email].");
            }
            if (!$this->form_validation->valid_email($email)) {
                throw new Exception("E-mail inválido.");
            }
            if (!$this->form_validation->required($acesso)) {
                throw new Exception("Campo obrigatório não preenchido [Acesso].");
            }
            
            if ($this->usuario_model->exists($usuario['email'])) {
                throw new Exception("E-mail já cadastrado.");
            }

            $senha = substr(md5($email . rand()), 0, 10);

            $usuario['senha'] = md5($senha);

            if ($this->usuario_model->insert($usuario)) {
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'vistoriasneto',
                    'smtp_pass' => 'meupau01',
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1'
                );
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");

                $this->email->from('vistoriasneto@gmail.com', 'EllaOdonto');
                $list = array($usuario['email']);
                $this->email->to($list);
                $this->email->reply_to('vistoriasneto@gmail.com', 'EllaOdonto');
                $this->email->subject('Seja Bem-vindo ao EllaOdonto!');
                $this->email->message('Olá, ' . $usuario['nome'] . '\n Seja bem-vindo ao EllaOdonto. \n Sua nova senha é ' . $senha);
                $this->email->send();

                $this->session->set_userdata('sucesso_mensagem', "Usuário cadastrado com sucesso.");
                redirect(site_url('usuario'));
            }
        } catch (Exception $ex) {
            $this->session->set_userdata('erro_mensagem', $ex->getMessage());
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
            $this->session->set_userdata('erro_mensagem', $ex->getMessage());
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

            if ($this->usuario_model->ativa($id)) {
                $this->session->set_userdata('sucesso_mensagem', "Usuário ativado.");
            } else {
                throw new Exception('Erro ao ativar usuário.');
            }
            redirect(site_url('usuario'));
        } catch (Exception $ex) {
            $this->session->set_userdata('erro_mensagem', $ex->getMessage());
            redirect(site_url('usuario'));
        }
    }

    public function reset() {

        $this->load->library('form_validation');

        if ($this->session->userdata('autenticado') == null) {
            $this->session->set_userdata('erro_mensagem', 'É necessário estar logado para acessar esta página.');
            redirect(site_url('home'));
        }
        if ($this->session->userdata('acesso') < 5) {
            $this->session->set_userdata('erro_mensagem', 'Desculpe, você não possui acesso a esta página.');
            redirect(site_url('home'));
        }

        $id = $this->input->post('id');

        $this->load->helper('data_helper');

        try {
            if (!$this->form_validation->required($id)) {
                throw new Exception("Usuário não identificado.");
            }
            $usuario = $this->usuario_model->get($id);

            $senha = substr(md5(rand() . $usuario['email']), 0, 10);

            $usuario['senha'] = md5($senha);


            if ($this->usuario_model->update($usuario)) {
                //retirar
                $usuario['email'] = 'claudiorcneto@yahoo.com.br';

                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'vistoriasneto',
                    'smtp_pass' => 'meupau01',
                    'mailtype' => 'html',
                    'charset' => 'utf-8'
                );
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");

                $this->email->from('vistoriasneto@gmail.com', 'EllaOdonto');
                $list = array($usuario['email']);
                $this->email->to($list);
                $this->email->reply_to('vistoriasneto@gmail.com', 'EllaOdonto');
                $this->email->subject('Seja Bem-vindo ao EllaOdonto!');
                $this->email->message('Olá, ' . $usuario['nome'] . '<br> Seja bem-vindo ao EllaOdonto. <br> Sua nova senha é ' . $senha);
                $this->email->send();

                $this->session->set_userdata('sucesso_mensagem', "Senha alterada com sucesso. Confira seu e-mail.");
                redirect(site_url('usuario'));
            }
        } catch (Exception $ex) {
            $this->session->set_userdata('erro_mensagem', $ex->getMessage());
            redirect(site_url('usuario'));
        }
    }

    public function changepass() {
        $this->load->library('form_validation');

        if ($this->session->userdata('autenticado') == null) {
            $this->session->set_userdata('erro_mensagem', 'É necessário estar logado para acessar esta página.');
            redirect(site_url('home'));
        }
        $login = $this->session->userdata('email');
        $usuario = $this->usuario_model->getByEmail($login);

        $this->load->helper('data_helper');
        
        $senha = $this->input->post('senha');
        $senha2 = $this->input->post('senha2');
        $senha3 = $this->input->post('senha3');

        try {
            if (!$this->form_validation->required($senha)) {
                throw new Exception("Senha inválida.");
            }
            if (!$this->form_validation->required($senha2)) {
                throw new Exception("Nova senha inválida.");
            }
            if (!$this->form_validation->required($senha3)) {
                throw new Exception("Confirmação de senha inválida.");
            }
            if ($senha2!=$senha3) {
                throw new Exception("Confirmação de senha inválida.");
            }
            if(!$this->usuario_model->login($login, $senha)){
                throw new Exception("Combinação Usuário/Senha (atual) inválida.");
            }

            $usuario['senha'] = md5($senha2);


            if ($this->usuario_model->update($usuario)) {
                
                $this->session->set_userdata('sucesso_mensagem', "Senha alterada com sucesso.");
                redirect(site_url('home'));
            }else{
                $this->session->set_userdata('erro_mensagem', "Erro ao alterar a senha.");
                redirect(site_url('usuario/editform'));
            }
        } catch (Exception $ex) {
            $this->session->set_userdata('erro_mensagem', $ex->getMessage());
            redirect(site_url('usuario/editform'));
        }
    }

}
