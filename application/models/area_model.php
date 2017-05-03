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
        $sql = "select * from area where upper(nome) = upper(?);";
        $r = $this->db->query($sql, [$nome]);
        if ($r->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function exists($id) {
        $sql = "select * from area where id=?";
        $r = $this->db->query($sql, [$id]);
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
        $res = $this->db->get('area');
        return $res->result_array();
    }

    public function getAllById() {
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

}
