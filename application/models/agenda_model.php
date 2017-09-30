<?php

/**
 * Classe de persistência dos métodos relacionados à agenda, aos horários de atendimento...
 */

class Agenda_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }
    
    public function grava_horario($data){
        $this->db->insert('horario_atendimento', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function exclui_horarios($data){
        $this->db->from('horario_atendimento');
        $this->db->where('usuario', $data['usuario']);
        $this->db->where('data', $data['data']);
        $this->db->where('local', $data['local']);
        $q = $this->db->get();
        $res = $q->result_array();
        foreach ($res as $k=>$v){
            $this->exclui_linha($v['id']);
        }
    }
    
    public function exclui_linha($id){
        $this->db->from('horario_atendimento');
        $this->db->where('id', $id);
        $this->db->delete();
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    
    public function eh_dia_marcado($data){
        $this->db->from('horario_atendimento');
        $this->db->where('usuario', $data['usuario']);
        $this->db->where('data', $data['data']);
        $this->db->where('local', $data['local']);
        $q = $this->db->get();
        $res = $q->result_array();
        if(count($res)>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function dias_marcados($usuario){
        $this->db->from('horario_atendimento');
        $this->db->where('usuario', $usuario);
        $this->db->order_by("data ASC");
        $q = $this->db->get();
        $res = $q->result_array();
        return $res;
    }
}

/**
 * id serial unique not null primary key,
    usuario integer references usuario(id) not null,
    data date not null,
    ti1 time,
    tf1 time,
    ti2 time,
    tf2 time,
    local integer references local(id)
 */