<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profissional_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    public function check_prof($id_usuario){
        $this->db->from("profissional");
        $this->db->where("usuario", $id_usuario);
        $q = $this->db->get();
        $res = $q->result_array();
        if(count($res)>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function get_all_by_id(){
        
        $this->db->from('usuario as u');
        $this->db->join('profissional as p', 'u.id = p.usuario');
        $this->db->select('u.*, p.usuario');
        $this->db->order_by('u.nome');
        $q = $this->db->get();
        
        $r = $q->result_array();
        
        $ret = [];
        foreach ($r as $v) {
            $ret[$v['id']] = $v;
        }
        return $ret;
    }
    
    public function set_prof($id_usuario){
        
        $user = ["usuario"=>$id_usuario];
        $this->db->insert('profissional', $user);
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
        
    }
    
    public function unset_prof($id_usuario){
        $this->db->from('profissional');
        $this->db->where('usuario', $id_usuario);
        $this->db->delete();
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
}