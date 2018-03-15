<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agenda extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("agenda_model", "am");
    }

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

            $this->load->model("local_model", "lm");
            $lcs = $this->lm->getAllById();
            $toView['lcs'] = $lcs;

            $mlocais = $this->lm->meus_locais($this->session->userdata("operador"));
            $toView['mlocais'] = $mlocais;

            $toView["dias_marcados"] = $this->am->dias_marcados($this->session->userdata("operador"));


            if ($this->session->flashdata("post")) {
                $post = $this->session->flashdata("post");
                $toView['post'] = $post;
            } else {
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

    public function set_dates() {


        $this->auth->checkAuth('agenda');

        try {
            $dts = $this->input->post('dts');
            $ti1 = $this->input->post('turnoinicio1');
            $tf1 = $this->input->post('turnofim1');
            $ti2 = $this->input->post('turnoinicio2');
            $tf2 = $this->input->post('turnofim2');
            $local = $this->input->post('local');

            if (!$dts || $dts == "" || count($dts) <= 0) {
                throw new Exception("Datas inválidas");
            }

            $datas = explode(",", $dts);
            $dates = [];

            check_hour_exception($ti1);
            check_hour_exception($tf1);
            check_hour_exception($ti2);
            check_hour_exception($tf2);

            $usuario = $this->session->userdata("operador");
            $count = 0;

            foreach ($datas as $k => $v) {
                $dates[$k]['usuario'] = $usuario;
                $dates[$k]['data'] = inverte_data_w_exception($v);
                $dates[$k]['ti1'] = $ti1;
                $dates[$k]['tf1'] = $tf1;
                $dates[$k]['ti2'] = $ti2;
                $dates[$k]['tf2'] = $tf2;
                $dates[$k]['local'] = $local;

                if ($ti2 == $tf2) {
                    unset($dates[$k]['ti2']);
                    unset($dates[$k]['tf2']);
                }

                if ($this->am->eh_dia_marcado($dates[$k])) {
                    $this->am->exclui_horarios($dates[$k]);
                }
                $res = $this->am->grava_horario($dates[$k]);
                if (!$res) {
                    throw new Exception("Erro ao definir as datas/horários de atendimento");
                }
                $count++;
            }
            $this->msg->sucesso("$count Datas definidas com sucesso.");
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect(site_url('agenda/dias_atendimento'));
        }
    }

    public function excluir_horario() {
        $this->auth->checkAuth('agenda/dias_atendimento');

        try {
            $id = $this->input->post('id');

            if (!$id || $id == '' || !is_numeric($id)) {
                throw new Exception("Horário não identificado");
            }

            if ($this->am->exclui_linha($id)) {
                $this->msg->sucesso("Horário excluído");
            } else {
                throw new Exception("Erro ao excluir o horário");
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            redirect('agenda/dias_atendimento');
        }
    }

    public function profissional() {
        $this->auth->checkAuth('agenda/profissional');

        $toView = [];
        try {
            $usuario = $this->session->userdata("usuario");
            if ($usuario['profissional'] < 1) {
                throw new Exception("Acesso exclusivo aos profissionais");
            }

            if ($this->input->post("data")) {
                $data = $this->input->post("data");
                $toView['data'] = $data;
                $this->session->set_flashdata("data", $data);
            } elseif ($this->session->flashdata("data")) {
                $this->session->keep_flashdata("data");
            }

            if ($this->session->flashdata("data")) {
                $toView['data'] = $this->session->flashdata("data");
            }
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('agenda/profissional_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }

    public function seleciona() {

        $this->auth->checkAuth('agenda');
        
        $toview = [];
        
        try {
            $toview['teste'] = $this->input->post();
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('agenda/profissional_view', $toview);
            $this->load->view('inc/footer_view');
        }
    }

}
