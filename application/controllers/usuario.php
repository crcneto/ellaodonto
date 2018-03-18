<?php

class Usuario extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
        $this->load->model('paciente_model');
    }

    public function index() {

        //checa a autenticação
        $this->auth->checkAuth('usuario');
        
        //checa o acesso
        $this->auth->sec_pro();

        $req = array();
        $toView = array();

        $toView['st'] = [
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

            $usuarios = $this->usuario_model->getAllById();
            $toView['usuarios'] = $usuarios;

            $usuario = $this->session->userdata('usuario');
            $toView['usuario'] = $usuario;
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('usuario/usuario_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }

    public function insert() {
        
        //Autenticação
        $this->auth->checkAuth('usuario');
        
        //Permissão
        $this->auth->sec_pro();
        
        
        $user = array();

        try {

            $id = $this->input->post('id');
            if ($id != null && $id != '' && is_numeric($id)) {
                $user['id'] = $id;
                if (!$this->usuario_model->existsId($id)) {
                    throw new Exception('Usuário não localizado');
                }
                $user = $this->usuario_model->get($id);
            }


            // CPF / CNPJ
            $tipo = $this->input->post('tipo');
            $cpfcnpj = $this->input->post('cpfcnpj');

            if ($cpfcnpj == null || $cpfcnpj == '' || !is_numeric($cpfcnpj)) {
                throw new Exception("CPF inválido. Preencha apenas com números");
            } else {
                $cpfcnpj = preg_replace('/[^0-9]/is', '', $cpfcnpj);
                //$cpfcnpj = (int) $cpfcnpj;

                if ($tipo == 1) {
                    if (!valida_cpf($cpfcnpj)) {
                        throw new Exception('CPF inválido.');
                    }
                } else {
                    if (!valida_cnpj($cpfcnpj)) {
                        throw new Exception('CNPJ inválido.');
                    }
                }
            }
            if (isset($user['id'])) {
                if ($this->usuario_model->existe_outro_cpf($id, $cpfcnpj)) {
                    throw new Exception("Este CPF/CNPJ já está em uso por outro usuário");
                }
            }else{
                if($this->usuario_model->existe_cpf($cpfcnpj)){
                    throw new Exception("Este CPF/CNPJ já foi cadastrado com outro usuário");
                }
            }
            $user['cpfcnpj'] = $cpfcnpj;



            //nome
            $nome = $this->input->post('nome');

            if (!$nome || strlen($nome) < 3) {
                throw new Exception('Nome inválido. Mínimo 3 caracteres');
            } else {
                $user['nome'] = $nome;
            }

            //apelido
            $apelido = $this->input->post('apelido');

            if ($apelido != null && $apelido != '' && strlen($apelido) < 90) {
                $user['apelido'] = $apelido;
            }

            //E-mail
            $email = $this->input->post('email');
            $this->load->helper('email_helper');
            if (!valid_email($email)) {
                throw new Exception("E-mail inválido.");
            }
            if (isset($user['id'])) {
                if ($this->usuario_model->existe_outro_email($id, $email)) {
                    throw new Exception("Este endereço de e-mail já está em uso por outro usuário");
                }
            }
            $user['email'] = $email;

            //TELEFONE PRINCIPAL
            $tel = $this->input->post('tel');
            if ($tel != null && $tel != '' && strlen($tel) < 30) {
                $user['tel'] = $tel;
            }

            //SEXO
            $sexo = $this->input->post('sexo');
            if ($sexo != null && $sexo != '' && is_numeric($sexo) && $sexo == 1) {
                $user['sexo'] = 1;
            } else {
                $user['sexo'] = 2;
            }

            //DATA NASCIMENTO
            $dnasc = $this->input->post('dn');
            if ($dnasc != null && $dnasc != '') {
                $dn = inverte_data_w_exception($dnasc);
                $user['datanasc'] = $dn;
            }

            //STATUS
            $status = $this->input->post('status');
            if ($status != null && $status != '' && is_numeric($status)) {
                $user['status'] = $status;
            }

            
            //SECRETARIA
            $sec = $this->input->post('secretaria');
            if ($sec != null && $sec != '' && is_numeric($sec)) {
                $user['secretaria'] = $sec;
            }else{
                $user['secretaria']=null;
            }

            //PROFISSIONAL
            $pro = $this->input->post('profissional');
            if ($pro != null && $pro != '' && is_numeric($pro)) {
                $user['profissional'] = $pro;
            }else{
                $user['profissional']=null;
            }

            //SYSADMIN
            $adm = $this->input->post('sysadmin');
            if ($adm != null && $adm != '' && is_numeric($adm)) {
                $user['sysadmin'] = $adm;
            }else{
                $user['sysadmin']=null;
            }
            //teste($user);
            
            $gerar = $this->input->post('gerar');

            if ($gerar == 1) {
                $senhagerada = substr(md5($email . rand()), 0, 10);
                $senha = md5($senhagerada);
                $user['senha'] = $senha;
                
                $message = "<h2>EllaOdonto</h2><p>Seja bem-vindo ao sistema EllaOdonto.<br>Seu cadastro foi realizado com sucesso.<br>A senha de acesso gerada pelo sistema foi: $senhagerada <br>Agradecemos a prefer&ecirc;ncia!";
                $this->correio->sendMail($user['email'], "Bem-vindo ao Sistema EllaOdonto!", $message);
            }
            if (isset($user['id'])) {
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

                if (!isset($user['senha'])) {
                    $senhagerada = substr(md5($email . rand()), 0, 10);
                    $senha = md5($senhagerada);
                    $user['senha'] = $senha;
                }

                if ($this->usuario_model->insert($user)) {
                    $uu = $this->usuario_model->get_id_by_email($user['email']);
                    $pac = [
                        'usuario'=>$uu['id'],
                        'nome'=>$user['nome'],
                        'dn'=>$user['datanasc'],
                        'sexo'=>$user['sexo'],
                        'operador'=> $this->session->userdata('operador')
                    ];
                    if(!$this->paciente_model->insert($pac)){
                        throw new Exception("Usuário cadastrado com sucesso, porém houve um erro ao criar o paciente");
                    }
                    
                    $this->msg->sucesso('Usuário cadastrado com sucesso.');
                    
                } else {
                    throw new Exception('Erro ao cadastrar.');
                }
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            $this->session->set_flashdata('req', $this->input->post());
        } finally {
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
            $id = $this->input->post('id');
            
            if(!$id || $id=="" || !is_numeric($id)){
                throw new Exception("Identificador de usuário inválido");
            }
            
            if(!$this->usuario_model->existe_id($id)){
                throw new Exception("Usuário não localizado");
            }
            
            $user = $this->usuario_model->get($id);
            
            $email = $user['email'];
            
            $senhagerada = substr(md5($email . rand()), 0, 10);
            $senha = md5($senhagerada);
            
            $user['senha'] = $senha;
            
            $message = "<h2>EllaOdonto</h2><p>Seja bem-vindo ao sistema EllaOdonto.<br>Sua senha foi reconfigurada.<br>A senha de acesso gerada pelo sistema foi: $senhagerada <br>Agradecemos a prefer&ecirc;ncia!";
            $this->correio->sendMail($user['email'], "Bem-vindo ao Sistema EllaOdonto!", $message);
            
            if($this->usuario_model->update($user)){
                $this->msg->sucesso("Senha gerada e enviada para o e-mail cadastrado");
            }else{
                throw new Exception("Erro ao gera a senha");
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('usuario'));
        }
    }

    public function changepass() {

        try {
            
            $usuario = $this->session->userdata('usuario');
            $senha = $this->input->post("senha");
            $senha2 = $this->input->post("senha2");
            $senha3 = $this->input->post("senha3");
            
            if(!$senha || !$senha2 || !$senha3){
                throw new Exception("Preencha todos os campos");
            }
            
            if(strlen($senha)<4 || strlen($senha2)<4 || strlen($senha3)<4){
                throw new Exception("A senha deverá possuir no mínimo 4 caracteres");
            }
            
            if($senha2!==$senha3){
                throw new Exception("Confirmação de senha inválida");
            }
            
            if(!$this->usuario_model->login($usuario['email'], $senha)){
                throw new Exception("Senha incorreta");
            }
            
            $usuario['senha'] = md5($senha2);
            
            if($this->usuario_model->update($usuario)){
                $this->msg->sucesso("Senha alterada com sucesso");
            }else{
                throw new Exception("Erro ao atualizar a senha");
            }
            
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('usuario/alterarsenha'));
        }
    }

    public function alterarsenha() {
        //checa a autenticação
        $this->auth->checkAuth('usuario');

        $toView = array();

        $this->load->view('inc/header_view');
        $this->load->view('usuario/alterarsenha_view', $toView);
        $this->load->view('inc/footer_view');
    }
    
    public function esqueci_minha_senha(){
        
        $toView = [];
        
        try{
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('usuario/esqueci_minha_senha_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }
    
    public function redefinir_senha(){
        
        try{
            
            $email = $this->input->post("email");
            $dn = $this->input->post("dn");
            
            $this->load->helper("email");
            if(!valid_email($email)){
                throw new Exception("E-mail inválido");
            }
            
            if(!$this->usuario_model->exists($email)){
                throw new Exception("E-mail não encontrado em nossa base de dados");
            }
            
            $user = $this->usuario_model->getByEmail($email);
            
            
            if($user['datanasc'] != inverte_data_w_exception($dn)){
                throw new Exception("As informações não correspondem ao cadastro");
            }
            
            $login = $user['email'];
            
            $senhagerada = substr(md5($login . rand()), 0, 10);
            $senha = md5($senhagerada);
            
            $user['senha'] = $senha;
            
            $message = "<h2>EllaOdonto</h2><p>Seja bem-vindo ao sistema EllaOdonto.<br>Sua senha foi redefinida.<br>A senha de acesso gerada pelo sistema foi: $senhagerada <br>Agradecemos a prefer&ecirc;ncia!";
            $this->correio->sendMail($user['email'], "Sistema EllaOdonto!", $message);
            
            if($this->usuario_model->update($user)){
                $this->msg->sucesso("Senha gerada e enviada para o e-mail cadastrado");
            }else{
                throw new Exception("Erro ao gera a senha");
            }
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('usuario/esqueci_minha_senha'));
        }
    }

}
