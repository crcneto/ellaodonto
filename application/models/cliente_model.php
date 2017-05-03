<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getById($id) {
        $this->db->where('id', $id);
        $r = $this->db->get('cliente');
        $ra = $r->result_array();
        return $ra[0];
    }

    public function nomeExists($nome) {
        $sql = "select * from cliente where upper(nome) = upper(?);";
        $r = $this->db->query($sql, [$nome]);
        if ($r->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function exists($cpfcnpj) {
        $sql = "select * from cliente where cpfcnpj=?";
        $r = $this->db->query($sql, [$cpfcnpj]);
        if ($r->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('cliente');
    }

    public function get() {
        $this->db->where('status', 2);
        $res = $this->db->get('cliente');
        return $res->result_array();
    }
    
    public function getAllById() {
        $this->db->order_by('nome');
        $res = $this->db->get('cliente');
        $r = $res->result_array();
        $rr = [];
        foreach ($r as $v) {
            $rr[$v['id']] = $v;
        }
        return $rr;
    }

    public function insert($data) {
        $this->db->insert('cliente', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data) {
        $id = $data['id'];
        $this->db->where('id', $id);
        $this->db->update('cliente', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}
