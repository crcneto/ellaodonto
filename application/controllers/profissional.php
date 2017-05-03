<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profissional extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('profissional_model', 'pro');
        $this->load->model('usuario_model');
    }

    public function index() {
        //verifica autenticação
        $this->auth->checkAuth('profissional');

        //verifica acesso
        $this->auth->checkAccess(3);

        //array de parâmetros
        $toView = [];

        try {
            $profissionais = $this->pro->getAllById();
            $toView['profissionais'] = $profissionais;
            
            $usuarios = $this->usuario_model->getAllById();
            $toView['usuarios'] = $usuarios;

            $id = $this->input->post('id');

            if ($id!=null && $id!='') {
                $pro = $this->pro->getById($id);
                $toView['pro'] = $pro;
            }


            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('profissional/profissional_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }
    
    public function insert(){
        //verifica autenticação
        $this->auth->checkAuth('profissional');

        //verifica acesso
        $this->auth->checkAccess(3);
        
        //carrega helper tratamento array
        $this->load->helper('array_helper');
        try{
            $id = $this->input->post('id');
            $nome = $this->input->post('nome');
            $apelido = $this->input->post('apelido');
            $orgao = $this->input->post('orgao');
            $registro = $this->input->post('nro_registro');
            $sexo = $this->input->post('sexo');
            $operador = $this->session->userdata('operador');
            $status = $this->input->post('status');
            
            $data = [];
            
            if($id){
                $data = array(
                    'id'=>$id,
                    'nome'=>$nome,
                    'apelido'=>$apelido,
                    'orgao'=>$orgao,
                    'nro_registro'=>$registro,
                    'sexo'=>$sexo,
                    'operador'=>$operador,
                    'status'=>$status
                );
                if(!$nome || $nome==''){
                    throw new Exception('Campos obrigatórios não preenchidos.');
                }
                $data = limpaArray($data);
                if($this->pro->update($data)){
                    $this->msg->sucesso('Cadastro atualizado com sucesso.');
                    redirect(site_url('profissional'));
                }else{
                    $this->msg->erro('Erro ao atualizar o cadastro.');
                    redirect(site_url('profissional'));
                }
            }else{
                $data = array(
                    'nome'=>$nome,
                    'apelido'=>$apelido,
                    'orgao'=>$orgao,
                    'nro_registro'=>$registro,
                    'sexo'=>$sexo,
                    'operador'=>$operador,
                    'status'=>$status
                );
                if(!$nome || $nome==''){
                    throw new Exception('Campos obrigatórios não preenchidos.');
                }
                $data = limpaArray($data);
                if($this->pro->insert($data)){
                    $this->msg->sucesso('Cadastrado com sucesso.');
                    redirect(site_url('profissional'));
                }else{
                    $this->msg->erro('Erro ao cadastrar.');
                    redirect(site_url('profissional'));
                }
            }
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            redirect(site_url('profissional'));
        }
    }
    public function delete(){
        //verifica autenticação
        $this->auth->checkAuth('profissional');

        //verifica acesso
        $this->auth->checkAccess(3);
        
        //carrega helper tratamento array
        $this->load->helper('array_helper');
        try{
            $id = $this->input->post('id');
            
            if($id==null || $id==''){
                throw new Exception('Identificador inválido');
            }
            if($this->pro->delete($id)){
                $this->msg->sucesso('Profissional excluído.');
                redirect(site_url('profissional'));
            }else{
                $this->msg->erro('Erro ao excluir profissional.');
                redirect(site_url('profissional'));
            }
            
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            redirect(site_url('profissional'));
        }
    }

}
