<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Area_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getById($id) {
        $this->db->where('id', $id);
        $r = $this->db->get('area');
        $ra = $r->result_array();
        return $ra[0];
    }

    public function nomeExists($nome) {
        $this->db->where("upper(nome)", "upper('$nome')", false);
        $r = $this->db->get('area');
        if ($r->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function ja_existe_nome($nome, $id){
        $this->db->where('upper(nome)', "upper('$nome')", false);
        $this->db->where('id !=', $id, false);
        $q = $this->db->get('area');
        if($q->num_rows()>0){
            return true;
        } else {
            return false;
        }
    }

    public function exists($id) {
        $this->db->where('id', $id);
        $r = $this->db->get('area');
        //$sql = "select * from area where id=?";
        //$r = $this->db->query($sql, [$id]);
        if ($r->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('area');
    }

    public function get() {
        $this->db->where('status', 2);
        $this->db->order_by('nome ASC');
        $res = $this->db->get('area');
        return $res->result_array();
    }

    public function getAllById() {
        $this->db->order_by('nome ASC');
        $res = $this->db->get('area');
        $r = $res->result_array();
        $rr = [];
        foreach ($r as $v) {
            $rr[$v['id']] = $v;
        }
        return $rr;
    }
    
    public function getAllAtivosById() {
        $this->db->where('status', 2);
        $this->db->order_by('nome ASC');
        $res = $this->db->get('area');
        $r = $res->result_array();
        $rr = [];
        foreach ($r as $v) {
            $rr[$v['id']] = $v;
        }
        return $rr;
    }

    public function insert($data) {
        $this->db->insert('area', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data) {
        $id = $data['id'];
        $this->db->where('id', $id);
        $this->db->update('area', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function get_definidas($usuario){
        $this->db->where('profissional', $usuario);
        $q = $this->db->get('area_profissional');
        return $q->result_array();
        
    }
    
    public function vincular($profisisonal, $area){
        $data = [
            "profissional"=>$profisisonal,
            "area"=>$area
        ];
        $this->db->insert("area_profissional", $data);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function desvincular($profisisonal, $area){
        $this->db->where("profissional", $profisisonal);
        $this->db->where("area", $area);
        $this->db->delete("area_profissional");
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function vinculada($profisisonal, $area){
        $this->db->where("profissional", $profisisonal);
        $this->db->where("area", $area);
        $q = $this->db->get("area_profissional");
        if($q->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }

}
