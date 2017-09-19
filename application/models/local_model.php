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
        $this->db->order_by(['nome', 'ASC']);
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
    
}

