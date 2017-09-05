<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agenda extends CI_Controller {

    public function dias_atendimento() {

        $toView = [];

        $this->auth->checkAuth('agenda');

        try {

            if ($this->input->post("mes")) {
                $mes = $this->input->post("mes");
                $toView["mes"] = $mes;
            } else {
                if ($this->session->flashdata("mes")) {
                    $mes = $this->session->flashdata("mes");
                } else {
                    $mes = date("m");
                }
            }
            $toView["mes"] = $mes;

            if ($this->input->post("ano")) {
                $ano = $this->input->post("ano");
                $toView["ano"] = $ano;
            } else {
                if ($this->session->flashdata("ano")) {
                    $ano = $this->session->flashdata("ano");
                } else {
                    $ano = date("Y");
                }
            }
            $toView["ano"] = $ano;

            $horarios = quarter_hours();
            $toView["horarios"] = $horarios;
            
            if($this->session->flashdata("post")){
                $post = $this->session->flashdata("post");
                $toView['post'] = $post;
            }else{
                $toView['post'] = null;
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('agenda/dias_atendimento_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }
    
    public function set_dates(){
        
        
        $toView = [];

        $this->auth->checkAuth('agenda');

        try {
            
            $dts = $this->input->post('dts');
            $ti1 = $this->input->post('turnoinicio1');
            $tf1 = $this->input->post('turnofim1');
            $ti2 = $this->input->post('turnoinicio2');
            $tf2 = $this->input->post('turnofim2');
            
            if(!$dts || $dts=="" || count($dts)<=0){
                throw new Exception("Datas inválidas");
            }
            
            $datas = explode(",", $dts);
            $dates = [];
            
            check_hour_exception($ti1);
            check_hour_exception($tf1);
            check_hour_exception($ti2);
            check_hour_exception($tf2);
            
            $usuario = $this->session->userdata("operador");
            
            foreach ($datas as $k => $v) {
                $dates[$k]['usuario'] = $usuario;
                $dates[$k]['data'] = inverte_data_w_exception($v);
                $dates[$k]['ti1'] = $ti1;
                $dates[$k]['tf1'] = $tf1;
                $dates[$k]['ti2'] = $ti2;
                $dates[$k]['tf2'] = $tf2;
            }
            
            
            
            $this->session->set_flashdata('post', $dates);
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('agenda/dias_atendimento'));
        }
        
        
    }

}
