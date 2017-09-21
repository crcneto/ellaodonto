<?php

/**
 * Conjunto de persistência dos locais de atendimento dos profissionais. Cada usuário pode possuir vários locais de atendimento.
 * @author Cláudio Neto <claudiorcneto@gmail.com>
 * @package ellaodonto
 * @subpackage models
 * @since 1.0
 */

class Local_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    

    public function getById($id) {
        $this->db->where('id', $id);
        $r = $this->db->get('local');
        $ra = $r->result_array();
        return $ra[0];
    }

    public function nomeExists($nome) {
        $sql = "select * from local where upper(nome) = upper(?);";
        $r = $this->db->query($sql, [$nome]);
        if ($r->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function exists($id) {
        $sql = "select * from local where id=?";
        $r = $this->db->query($sql, [$id]);
        if ($r->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('local');
    }

    public function get() {
        $this->db->where('status', 2);
        $this->db->order_by('nome ASC');
        $res = $this->db->get('local');
        return $res->result_array();
    }
    
    public function getAllById() {
        $this->db->order_by('nome');
        $res = $this->db->get('local');
        $r = $res->result_array();
        $rr = [];
        foreach ($r as $v) {
            $rr[$v['id']] = $v;
        }
        return $rr;
    }

    public function insert($data) {
        $this->db->insert('local', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data) {
        $id = $data['id'];
        $this->db->where('id', $id);
        $this->db->update('local', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function desativa($id){
        $this->db->where('id', $id);
        $this->db->set('status', '0');
        $this->db->update('local');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function ativa($id){
        $this->db->where('id', $id);
        $this->db->set('status', '2');
        $this->db->update('local');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Retorna um array com os locais relacionados ao usuário passado por parâmetro
     * @param type $usuario Identificador (id) do usuário
     * @return array Lista de array dos locais vinculados ao usuário informado
     */
    public function meus_locais($usuario){
        $this->db->where('usuario', $usuario);
        $res = $this->db->get('meu_local');
        $r = $res->result_array();
        $a = [];
        foreach ($r as $k=>$v){
            $a[$v['local']] = $v;
        }
        return $a;
    }
    
    /**
     * 
     * @param array $data Array contendo usuário e local
     * @return boolean Retorna verdadeiro se as informações foram gravadas no banco
     */
    public function add_meu_local($data){
        $this->db->insert('meu_local', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 
     * @param type $data Array contendo local e usuário
     * @return boolean Retorna TRUE se não houver erros
     */
    public function delete_meu_local($data){
        $this->db->where($data);
        $this->db->delete('meu_local', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Verifica se já existem registros do local e usuário informados na tabela 'meu local'
     * @param array $data Array com 2 campos [usuario, local] 
     * @return boolean Retorna TRUE se já houver algum registro do local e usuário informado no banco de dados
     */
    public function existe_meu_local($data){
        $this->db->where($data);
        $res = $this->db->get('meu_local');
        if($res->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
}

