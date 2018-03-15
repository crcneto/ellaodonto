<?php

function status_cliente() {
    $status = array(
        '2' => 'Ativo',
        '1' => 'Pendente',
        '3' => 'Bloqueado',
        '0' => 'Desativado',
    );
    return $status;
}

function status_usuario() {
    $ar = array(
        '0' => 'Desativado',
        '1' => 'Cadastro Pendente',
        '2' => 'Ativo'
    );
    return $ar;
}

function status_acesso() {
    $acessos = array(
        '1' => 'Cliente/Paciente',
        '3' => 'Secretaria',
        '5' => 'Profissional',
        '7' => 'Administrador',
        '9' => 'WebMaster'
    );
    return $acessos;
}

function status_consulta(){
    $status = [
        '0'=>'Excluida',
        '1'=>'Pendente',
        '2'=>'Cancelada pelo profissional',
        '3'=>'Cancelada pelo cliente',
        '4'=>'Atendida parcial',
        '5'=>'Atendida c/ pendências',
        '6'=>'Atendida/Concluida'
    ];
    return $status;
}

function status_pagamento(){
    $status = [
        '0'=>'Cancelado',
        '1'=>'Pendente',
        '2'=>'Pago parcial',
        '3'=>'Pago total'
    ];
    return $status;
}

?>
