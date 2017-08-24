<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agenda extends CI_Controller {

    public function index() {

        $toView = [];

        $this->auth->checkAuth('agenda');

        try {
            
            if ($this->input->post("mes")) {
                $mes = $this->input->post("mes");
                $toView["mes"] = $mes;
            } else {
                if ($this->session->flashdata("mes")) {
                    $mes = $this->session->flashdata("mes");
                    
                }else{
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
                    
                }else{
                    $ano = date("Y");
                }
            }
            $toView["ano"] = $ano;
            
            //Carrega Calendario
            $prefs['template'] = '

        {table_open}<table class="table table-bordered table-hover">{/table_open}

        {heading_row_start}<tr>{/heading_row_start}

        {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr style="font-weight: bold;">{/week_row_start}
        {week_day_cell}<td>{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr>{/cal_row_start}
        {cal_cell_start}<td>{/cal_cell_start}
        {cal_cell_start_today}<td>{/cal_cell_start_today}
        {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}

        {cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
        {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

        {cal_cell_no_content}{day}{/cal_cell_no_content}
        {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

        {cal_cell_blank}&nbsp;{/cal_cell_blank}

        {cal_cell_other}{day}{/cal_cel_other}

        {cal_cell_end}</td>{/cal_cell_end}
        {cal_cell_end_today}</td>{/cal_cell_end_today}
        {cal_cell_end_other}</td>{/cal_cell_end_other}
        {cal_row_end}</tr>{/cal_row_end}

        {table_close}</table>{/table_close}
';

            $this->load->library('calendar', $prefs);

            $total_dias = $this->calendar->get_total_days($mes, $ano);
            $toView["tds"] = $total_dias;
            
            $data = array(
                4 => 'http://example.com/news/article/2006/06/03/',
                6 => 'http://example.com/news/article/2006/06/07/',
                13 => 'http://example.com/news/article/2006/06/13/',
                26 => 'http://example.com/news/article/2006/06/26/'
            );
            

            if ($mes && $ano) {
                $cal = $this->calendar->generate($ano, $mes, $data);
                $toView["cal"] = $cal;
            }


            $post = $this->input->post();
            $toView["post"] = $post;


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
