<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Assistente_model extends CI_Model{
    
    
    public function assistentes($id_do_usuario){
        $this->db->where("profissional", $id_do_usuario);
        $q = $this->db->get('assistente');
        return $q->result_array();
    }
    
    /**
     * Vincula um usuário como assistente de outro.
     * @param array $data Array no formato ['profissional'=>'id_operador', 'assistente'=>'id_usuario_selecionado]
     * @return boolean Se o assistente e o usuário foram persistidos, retorna TRUE
     */
    public function add($data){
        $this->db->insert("assistente", $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function delete($data){
        $this->db->where("profissional", $data['profissional']);
        $this->db->where("assistente", $data['assistente']);
        $this->db->delete("assistente");
        if($this->db->affected_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function ja_existe($data){
        $this->db->where("profissional", $data['profissional']);
        $this->db->where("assistente", $data['assistente']);
        $q = $this->db->get("assistente");
        $count = count($q->result_array());
        if($count>0){
            return true;
        }else{
            return false;
        }
    }
    
}
