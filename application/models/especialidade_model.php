<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Especialidade_model extends CI_Model{
    public function __construct() {
        parent::__construct();
    }

    public function getById($id) {
        $sql = "select * from especialidade where id=?";
        $r = $this->db->query($sql, [$id]);
        $ra = $r->result_array();
        return $ra[0];
    }

    public function nomeExists($nome) {
        $sql = "select * from especialidade where upper(nome) = upper(?);";
        $r = $this->db->query($sql, [$nome]);
        if ($r->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function exists($id) {
        $sql = "select * from especialidade where id=?";
        $r = $this->db->query($sql, [$id]);
        if ($r->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete('especialidade');
    }

    public function get() {
        $this->db->where('status', 2);
        $res = $this->db->get('especialidade');
        return $res->result_array();
    }

    public function getAllById() {
        $sql = "select e.id, e.nome, e.obs, e.area, e.status from especialidade as e, area as a where e.area=a.id order by a.nome asc, e.nome asc;";
        $res = $this->db->query($sql);
        $r = $res->result_array();
        $rr = [];
        foreach ($r as $v) {
            $rr[$v['id']] = $v;
        }
        return $rr;
    }
    public function getAllAtivosById() {
        $this->db->where('status', 2);
        $res = $this->db->get('especialidade');
        $r = $res->result_array();
        $rr = [];
        foreach ($r as $v) {
            $rr[$v['id']] = $v;
        }
        return $rr;
    }

    public function insert($data) {
        $this->db->insert('especialidade', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data) {
        $id = $data['id'];
        $this->db->where('id', $id);
        $this->db->update('especialidade', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}