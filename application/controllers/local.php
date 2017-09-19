<?php

/** 
 * Controller responsável por manipular os locais de atendimento de cada profissional
 * @author Cláudio Neto <claudiorcneto@gmail.com>
 * @package ellaodonto
 * @subpackage controllers
 */

class Local extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model('usuario_model');
        $this->load->model('local_model');
    }
    
    public function index(){
        $toView = [];

        $this->auth->checkAuth('local');

        try {
            
            throw new Exception("Teste index");
        
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            if($this->session->flashdata("lo")){
                $toView['lo'] = $this->input->post();
            }else{
                $toView['lo'] = $this->input->post();
            }
            
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('local/local_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }
    
    public function insert(){
        $this->auth->checkAuth('local');

        try {
            
            throw new Exception("Teste insert");
        
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            $this->session->set_flashdata('lo', $this->input->post());
        } finally {
            redirect(site_url('local'));
        }
    }
}
