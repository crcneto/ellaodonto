<?php

class Home extends CI_Controller {

    public function index() {
        $toView = [];

        try {

            $user = $this->session->userdata("usuario");
            
            if($user['profissional']>0){
                $toView['profissional'] = $user['profissional'];

                if($this->input->post('anomes')){
                    $anomes = $this->input->post('anomes');
                    $am = explode("/", $anomes);
                    $mes = $am[1];
                    $ano = $am[0];
                }else{
                    $mes = date('m');
                    $ano = date('Y');
                }
                
                
                $data = [
                    3=> 3,
                    4=> 3,
                    12=> 3
                ];
                
                $this->load->library('calendar', $this->calendar_prefs());
                $calendar = $this->calendar->generate($ano, $mes, $data);
                $toView['calendar'] = $calendar;
            }


            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('home/home_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }

    public function erro() {
        $this->load->view('inc/header_view');

        $this->load->view('erro/e404_view');

        $this->load->view('inc/footer_view');
    }

    public function erroautenticacao() {
        $this->load->view('inc/header_view');
        $this->load->view('erro/eauth_view');
        $this->load->view('inc/footer_view');
    }

    public function acessonegado() {
        $this->load->view('inc/header_view');
        $this->load->view('erro/eacesso_view');
        $this->load->view('inc/footer_view');
    }

    public function calendar_prefs() {
        $prefs['template'] = '

        {table_open}<table class="table table-bordered table-hover col-md-8">{/table_open}

        {heading_row_start}<thead><tr class="text-center alert alert-info" style="font-weight: bold; /*background-color: #3232CD; color: white;*/">{/heading_row_start}

        {heading_previous_cell}<th><form action="'. site_url('home').'" method="post"><input type="hidden" name="anomes" value="{previous_url}" /><button type="submit" class="btn btn-link"><i class="glyphicon glyphicon-menu-left"></i></button></form></th>{/heading_previous_cell}
        {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
        {heading_next_cell}<th><form action="'. site_url('home').'" method="post"><input type="hidden" name="anomes" value="{next_url}" /><button type="submit" class="btn btn-link"><i class="glyphicon glyphicon-menu-right"></i></button></form></th>{/heading_next_cell}

        {heading_row_end}</tr>{/heading_row_end}

        {week_row_start}<tr>{/week_row_start}
        {week_day_cell}<td class="text-center" style="font-weight: bold;">{week_day}</td>{/week_day_cell}
        {week_row_end}</tr>{/week_row_end}

        {cal_row_start}<tr class="alert alert-warning">{/cal_row_start}
        {cal_cell_start}<td class="text-center">{/cal_cell_start}
        {cal_cell_start_today}<td style="text-align: center; font-weight: bold;">{/cal_cell_start_today}
        {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}

        {cal_cell_content}<form action="'. site_url('agenda/seleciona').'" method="post" ><input type="hidden" name="dia" value="{day}"/><input type="hidden" name="mes" value=""/><button type="submit" class="btn btn-link">{day}</button></form>{/cal_cell_content}
        
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
        $prefs['show_next_prev'] = true;
        return $prefs;
    }

}
