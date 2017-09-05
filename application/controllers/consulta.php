<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Consulta extends CI_Controller {
    
    
    public function nova(){
        
        $this->auth->checkAuth('consulta');
        
        $toView = [];
        try{
            
        } catch (Exception $ex) {
            $this->msg->erro($ex->getMessage());
        } finally {
            $this->load->view('inc/header_view');
            $this->load->view('consulta/nova_view', $toView);
            $this->load->view('inc/footer_view');
        }
    }
}