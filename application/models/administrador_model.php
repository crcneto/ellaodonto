<?php


class Administrador_model extends CI_Model{
    
    public function get_all_by_id(){
        
        $this->db->from('usuario as u');
        $this->db->join('administrador as a', 'u.id = a.usuario');
        $this->db->select('u.*, a.usuario');
        $this->db->order_by('u.nome');
        $q = $this->db->get();
        
        $r = $q->result_array();
        
        $ret = [];
        foreach ($r as $v) {
            $ret[$v['id']] = $v;
        }
        return $ret;
    }
    
    public function check_admin($id_usuario){
        $this->db->from("administrador");
        $this->db->where("usuario", $id_usuario);
        $q = $this->db->get();
        $res = $q->result_array();
        if(count($res)>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function set_admin($id_usuario){
        if($this->check_admin($id_usuario)){
            return true;
        }else{
            $user = ["usuario"=>$id_usuario];
            $this->db->insert('administrador', $user);
            if($this->db->affected_rows()>0){
                return true;
            }else{
                return false;
            }
        }
    }
    
    public function unset_admin($id_usuario){
        $this->db->from('administrador');
        $this->db->where('usuario', $id_usuario);
        $this->db->delete();
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    
}