<?php

/*
 * Helper de utilidades gerais
 */

function tipos_logradouro() {
    $tipos = [
        "1" => "Rua",
        "2" => "Avenida",
        "3" => "Rodovia",
        "4" => "Estrada",
        "5" => "Servidão",
        "6" => "Beco",
        "7" => "Outros",
    ];
    return $tipos;
}

function get_tipo_logradouro($id){
    $tps = tipos_logradouro();
    if(isset($tps[$id])){
        return $tps[$id];
    }else{
        return "";
    }
    
}

?>