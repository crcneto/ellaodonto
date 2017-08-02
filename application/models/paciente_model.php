<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paciente_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getById($id){
        $this->db->where('id', $id);
        $r = $this->db->get('paciente');
        return $r->row_array();
    }
    
    public function nomeExists($nome){
        $sql = "select * from area where upper(nome) = upper(?);";
        $r = $this->db->query($sql, [$nome]);
        if($r->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function exists($id){
        $sql = "select * from paciente where id=?";
        $r = $this->db->query($sql, [$id]);
        if($r->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function delete($id){
        $this->db->where('id', $id);
        return $this->db->delete('paciente');
    }

        public function get(){
        $this->db->where('status', 2);
        $this->db->order_by('nome', 'ASC');
        $res = $this->db->get('paciente');
        return $res->result_array();
    }
    
    
    public function getAllById(){
        $this->db->order_by('nome', 'ASC');
        $res = $this->db->get('paciente');
        $r = $res->result_array();
        $rr = [];
        foreach ($r as $v) {
            $rr[$v['id']] = $v;
        }
        return $rr;
    }
    
    public function insert($data){
        $this->db->insert('paciente', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function update($data){
        $id = $data['id'];
        $this->db->where('id', $id);
        $this->db->update('paciente', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function desativar($id){
        $this->db->from("paciente");
        $this->db->set(['status'=>0]);
        $this->db->where(['id'=>$id]);
        $this->db->update();
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    public function ativar($id){
        $this->db->from("paciente");
        $this->db->set(['status'=>2]);
        $this->db->where(['id'=>$id]);
        $this->db->update();
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
}
