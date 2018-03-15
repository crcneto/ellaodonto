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
    
    public function eh_assistente($id_usuario){
        $this->db->where("assistente", $id_usuario);
        $q = $this->db->get("assistente");
        if($q->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * Retorna os profissionais os quais o usuário é assistente e ele mesmo
     * @param int $id_assistente
     * @return array de profissionais ou false
     */
    public function profissionais_do_assistente($id_assistente){
        $this->db->from("usuario as u");
        $this->db->join("assistente as a", "a.profissional = u.id");
        $this->db->where("a.assistente", $id_assistente);
        $this->db->select("u.*");
        $this->db->group_by("u.id, u.nome, u.cpfcnpj, u.email, u.tel, u.apelido, u.sexo, u.senha, u.datanasc, u.ts, u.secretaria, u.profissional, u.sysadmin, u.status");
        $this->db->order_by("u.nome");
        $q = $this->db->get();
        
        if($q->num_rows()>0){
            return $q->result_array();
        }else{
            return false;
        }
    }
    
}
