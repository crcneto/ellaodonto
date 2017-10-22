<?php

class Autenticacao extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
    }

    public function index() {
        if ($this->session->userdata('usuario')) {
            redirect(site_url());
        }
        $this->load->view('inc/header_view');
        $this->load->view('login/formlogin_view');
        $this->load->view('inc/footer_view');
    }

    public function login() {
        if ($this->session->userdata('usuario')) {
            redirect(site_url());
        }

        try {
            //recebe post
            $login = $this->input->post('login');
            $senha = $this->input->post('senha');
            
            //verifica campos nulos
            if ($login == null || $login == "" || $senha == null || $senha == "") {

                throw new Exception("Campos obrigatórios não preenchidos.");
            }

            //confere login
            if (!$this->usuario_model->login($login, $senha)) {
                throw new Exception("Combinação de usuário e senha incorreta.");
            }
            
            //carrega usuario
            $user = $this->usuario_model->getByEmail($login);
            
            //se usuário não está ativo, não loga
            if ($user['status'] != '2') {
                throw new Exception("Usuário bloqueado. Por gentileza, entre em contato com a secretaria.");
            }
            
            
            //carrega usuário na sessão
            $this->session->set_userdata('usuario', $user);
            
            //carrega id do usuário como Operador
            $this->session->set_userdata('operador', $user['id']);
            
            //set profissional
            if($user['profissional']>0){
                $this->session->set_userdata("profissional", $user["profissional"]);
            }
            
            //carrega mensagem de boas vindas
            $this->session->set_userdata("sucesso_mensagem", "Bem-vindo, " . $user['nome'] . "!");
            
            //carrega último login
            $ll = $this->usuario_model->getLastLogin($user['id']);
            
            //carrega mensagem com o último login e adiciona a mensagem de sucesso
            $this->session->set_userdata("sucesso_mensagem", $this->session->userdata("sucesso_mensagem") . " Seu último acesso foi em: " . $ll);

            // atualiza último login
            $this->usuario_model->registralogin(['usuario' => $user['id']]);
            
            //se estava em alguma página, carregue-a novamente
            if ($this->session->userdata('pagina')) {
                $pagina = $this->session->userdata('pagina');
                $this->session->unset_userdata('pagina');
                redirect(site_url($pagina));
            } else {
                redirect(site_url());
            }
        } catch (Exception $ex) {
            $this->session->set_userdata('erro_mensagem', $ex->getMessage());
            redirect(site_url('autenticacao'));
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(site_url());
    }

}
