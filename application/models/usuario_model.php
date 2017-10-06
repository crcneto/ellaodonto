<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario_model extends CI_Model {
    
    /*
     * id serial unique not null,
    nome varchar(120) not null,
    email varchar(120) not null unique,
    apelido varchar(120),
    sexo integer not null default 1,
    senha varchar not null,
    datanasc date, 
    ts timestamp default now(),
    secretaria integer,
    profissional integer,
    sysadmin integer,
    status integer default 1
     */

    public function getAll() {
        $this->db->select('id, nome, email, apelido, sexo, datanasc, ts, secretaria, profissional, sysadmin, status');
        $this->db->order_by('nome', 'ASC');
        $q = $this->db->get('usuario');
        
        return $q->result_array();
    }

    public function get($id) {
        $this->db->from('usuario');
        $this->db->where('id', $id);
        $this->db->limit('1');
        
        $q = $this->db->get();
        if ($q->num_rows < 1) {
            throw new Exception("Usuário não encontrado.");
        }
        $u = $q->row_array();
        unset($u['senha']);
        return $u;
    }
    
    public function todos_ativos(){
        $this->db->from('usuario');
        $this->db->where('status', 2);
        $this->db->order_by('nome','ASC');
        $q = $this->db->get();
        $res = $q->result_array();
        $r = [];
        foreach ($res as $v) {
            $r[$v['id']] = $v;
        }
        return $r;
    }

    /**
     * @return array Retorna um array com o ID do usuário como índice e array com a tupla
     * 
     */
    public function getAllById() {
        $this->db->order_by('nome', 'ASC');
        $r = $this->db->get('usuario');
        $a = $r->result_array();
        $md = array();
        foreach ($a as $key => $value) {
            unset($value['senha']);
            $md[$value['id']] = $value;
        }
        return $md;
    }

    public function getByEmail($email) {
        if (!$this->exists($email)) {
            throw new Exception("Usuário não encontrado.");
        }
        $this->db->select('id, nome, email, apelido, sexo, datanasc, ts, secretaria, profissional, sysadmin, status');
        $this->db->where('email', $email);
        $this->db->limit('1');
        $r = $this->db->get('usuario');
        $u = $r->result_array();
        return $u[0];
    }

    public function exists($login) {
        $this->db->where('email', $login);
        $r = $this->db->get('usuario');
        if ($r->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function existe_id($id){
        $this->db->where("id", $id);
        $q = $this->db->get('usuario');
        if($q->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function existe_outro_cpf($id, $cpf){
        $this->db->from('usuario');
        $this->db->where('id !=', $id);
        $this->db->where('cpfcnpj =', $cpf);
        $res = $this->db->get();
        if($res->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function existe_cpf($cpf){
        $this->db->from("usuario");
        $this->db->where("cpfcnpj",$cpf);
        $res = $this->db->get();
        if($res->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function existe_outro_email($id, $email){
        $this->db->from('usuario');
        $this->db->where('id !=', $id);
        $this->db->where('email =', $email);
        $res = $this->db->get();
        if($res->num_rows()>0){
            return true;
        }else{
            return false;
        }
    }
    
    public function get_id_by_email($email){
        $this->db->from('usuario');
        $this->db->selet('id');
        $this->db->where('email', $email);
        $res = $this->db->get();
        if($res->num_rows()>0){
            return $res->row_array();
        }else{
            return null;
        }
    }

    public function existsId($id) {
        $this->db->from('usuario');
        $this->db->where("id", $id);
        $r = $this->db->get();
        if ($r->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function insert($data) {
        $this->db->insert('usuario', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @usage 
     */
    public function update($data) {
        $this->db->where(['id' => $data['id']]);
        $this->db->update('usuario', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function registralogin($data) {
        if ($this->db->insert('ultimoacesso', $data) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getLastLogin($id) {
        $sql = "select extract(day from (select max(login) from ultimoacesso where usuario=?)) as dia , extract(month from (select max(login) from ultimoacesso where usuario=?)) as mes, extract(year from (select max(login) from ultimoacesso where usuario=?)) as ano";
        $r = $this->db->query($sql, array($id, $id, $id));
        $res = $r->result_array();
        if (count($res) > 0) {
            $d = $res[0];
            $ret = $d['dia'] . '/' . $d['mes'] . '/' . $d['ano'];
            return $ret;
        } else {
            return null;
        }
    }

    public function delete($id) {
        $this->db->delete('usuario', ['id' => $id]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function login($login, $senha) {
        $this->db->where('email', $login);
        $this->db->where('senha', md5($senha));
        $q = $this->db->get('usuario');
        if ($q->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ativa($id) {
        $this->db->where('id', $id);
        $this->db->set('status', '2');
        $this->db->update('usuario');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function desativa($id) {
        $this->db->where('id', $id);
        $this->db->set('status', '0');
        $this->db->update('usuario');
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}
