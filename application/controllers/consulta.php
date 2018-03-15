<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Consulta extends CI_Controller {

    public function nova() {

        $this->auth->checkAuth('consulta');

        $toView = [];
        try {
            //carrega models
            $this->load->model("assistente_model");
            $this->load->model("paciente_model");

            //carrega usuário
            $operador = $this->session->userdata("operador");
            $profs = $this->assistente_model->profissionais_do_assistente($operador);
            $usuario = $this->session->userdata("usuario");
            
            //se usuário for profissional, inclui na lista
            if ($usuario['profissional'] > 0) {
                $profs[] = $usuario;
            }
            
            //carrega pacientes
            $pacs = $this->paciente_model->getAllById();
            
            $data = date("d-m-Y");
            $horarios = quarter_hours();
            

            //carrega p/ view
            $toView['profs'] = $profs;
            $toView['pacs'] = $pacs;
            $toView["data"] = $data;
            $toView["horarios"] = $horarios;
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('consulta/nova_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }

    public function profissional() {

        teste("descontinuado");
    }

}
