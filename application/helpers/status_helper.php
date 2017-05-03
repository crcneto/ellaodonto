<?php

function cliente_status() {
    $status = array(
        '2' => 'Ativo',
        '1' => 'Pendente',
        '3' => 'Bloqueado',
        '0' => 'Desativado',
    );
    return $status;
}

function usuario_status() {
    $ar = array(
        '0' => 'Desativado',
        '1' => 'Cadastro Pendente',
        '2' => 'Ativo'
    );
    return $ar;
}

function acessos() {
    $acessos = array(
        '1' => 'Cliente/Paciente',
        '3' => 'Secretaria',
        '5' => 'Profissional',
        '7' => 'Administrador',
        '9' => 'WebMaster'
    );
    return $acessos;
}

?>
