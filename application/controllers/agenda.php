<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agenda extends CI_Controller {

    public function index() {

        $toView = [];

        $this->auth->checkAuth('agenda');

        try {

            $date = $this->input->post("date");
            if (!$date || $date == '') {
                if ($this->session->flashdata("ds")) {
                    $ds = $this->session->flashdata("ds");
                } else {
                    $ds = date("Y-m-d");
                }
            }else{
                $date = inverte_data_w_exception($date);
            }
            






            if ($this->session->flashdata("data_selecionada")) {
                $this->session->keep_flashdata("data_selecionada");
            } else {
                $this->session->set_flashdata("ds", $ds);
            }

            $toView['ds'] = $ds;
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
            if ($this->session->flashdata("data_selecionada")) {
                $this->session->keep_flashdata("data_selecionada");
            }
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('agenda/agenda_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }

}
