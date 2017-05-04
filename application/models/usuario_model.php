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
        $sql = "select id, nome, email, apelido, sexo, datanasc, ts, secretaria, profissional, sysadmin, status from usuario order by nome";
        $q = $this->db->query($sql);
        return $q->result_array();
    }

    public function get($id) {
        $sql = "select * from usuario where id=? limit 1";
        $q = $this->db->query($sql, [$id]);
        if ($q->num_rows < 1) {
            throw new Exception("Usuário não encontrado.");
        }
        $u = $q->row_array();
        unset($u['senha']);
        return $u;
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
        $sql = "select id, nome, email, apelido, sexo, datanasc, ts, secretaria, profissional, sysadmin, status from usuario where email=? limit 1";
        $r = $this->db->query($sql, [$email]);
        $u = $r->result_array();
        return $u[0];
    }

    public function exists($login) {
        $sql = "select * from usuario where email=?";
        $r = $this->db->query($sql, [$login]);
        if ($r->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function existsId($id) {
        $sql = "select * from usuario where id=?";
        $r = $this->db->query($sql, [$id]);
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
        $sql = "select * from usuario where email=? and senha=?";
        $q = $this->db->query($sql, [$login, md5($senha)]);
        if ($q->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ativa($id) {
        $sql = "update usuario set status=2 where id=?";
        $this->db->query($sql, [$id]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function desativa($id) {
        $sql = "update usuario set status=0 where id=?";
        $this->db->query($sql, [$id]);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

}
