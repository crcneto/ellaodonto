<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Especialidade extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('especialidade_model','esp');
        $this->load->model('area_model');
    }


    public function index(){
        //verifica autenticação
        $this->auth->checkAuth('especialidade');

        //verifica acesso
        $this->auth->checkAccess(3);

        //array de parâmetros
        $toView = [];
        try {
            
            $especialidades = $this->esp->getAllById();
            $toView['especialidades'] = $especialidades;
            
            $areas = $this->area_model->getAllById();
            $toView['areas'] = $areas;

            $id = $this->input->post('id');

            if ($id!=null && $id!='') {
                $especialidade = $this->esp->getById($id);
                $toView['esp'] = $especialidade;
            }
            
            $this->load->view('inc/header_view');
            $this->load->view('especialidade/especialidade_view', $toView);
            $this->load->view('inc/footer_view');
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            redirect(site_url());
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
            $area = $this->input->post('area');
            $obs = $this->input->post('obs');
            $status = $this->input->post('status');
            
            $data = [];
            
            if($id){
                $data = array(
                    'id'=>$id,
                    'nome'=>$nome,
                    'area'=>$area,
                    'obs'=>$obs,
                    'status'=>$status
                );
                if(!$nome || $nome=='' || $area==null || $area==''){
                    throw new Exception('Campos obrigatórios não preenchidos.');
                }
                $data = limpaArray($data);
                if($this->esp->update($data)){
                    $this->msg->sucesso('Cadastro atualizado com sucesso.');
                    redirect(site_url('especialidade'));
                }else{
                    $this->msg->erro('Erro ao atualizar o cadastro.');
                    redirect(site_url('especialidade'));
                }
            }else{
                $data = array(
                    'nome'=>$nome,
                    'area'=>$area,
                    'obs'=>$obs,
                    'status'=>$status
                );
                if(!$nome || $nome=='' || $area==null || $area==''){
                    throw new Exception('Campos obrigatórios não preenchidos.');
                }
                $data = limpaArray($data);
                if($this->esp->insert($data)){
                    $this->msg->sucesso('Cadastrado com sucesso.');
                    redirect(site_url('especialidade'));
                }else{
                    $this->msg->erro('Erro ao cadastrar.');
                    redirect(site_url('especialidade'));
                }
            }
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            redirect(site_url('especialidade'));
        }
    }
}
