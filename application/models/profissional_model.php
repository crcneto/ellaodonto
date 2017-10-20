<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profissional_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getById($id){
        $this->db->where('id', $id);
        $r = $this->db->get('profissional');
        if($r->num_rows()>0){
            return $r->row_array();
        }else{
            return false;
        }
    }
    
    public function nomeExists($nome){
        $this->db->where('upper(nome)', "upper('$nome')", FALSE);
        $r = $this->db->get('profissional');
        //$sql = "select * from area where upper(nome) = upper(?);";
        //$r = $this->db->query($sql, [$nome]);
        if($r->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function exists($id){
        $this->db->where('id', $id);
        $r = $this->db->get('profissional');
        //$sql = "select * from profissional where id=?";
        //$r = $this->db->query($sql, [$id]);
        if($r->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function delete($id){
        $this->db->where('id', $id);
        return $this->db->delete('profissional');
    }

        public function get(){
        $this->db->where('status', 2);
        $res = $this->db->get('profissional');
        return $res->result_array();
    }
    
    
    public function getAllById(){
        $res = $this->db->get('profissional');
        $r = $res->result_array();
        $rr = [];
        foreach ($r as $v) {
            $rr[$v['id']] = $v;
        }
        return $rr;
    }
    
    public function insert($data){
        $this->db->insert('profissional', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function update($data){
        $id = $data['id'];
        $this->db->where('id', $id);
        $this->db->update('profissional', $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
}