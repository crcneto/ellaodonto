<?php

/**
 * Retorna uma string com a data invertida (troca '/' por '-'). Ex: inverte_data('2016/10/01') -> 01-10-2016
 * @param string $date
 * @return string
 */
function inverte_data($date) {
    if($date==null || $date==''){
        return null;
    }
    $date2 = str_replace('/', '-', $date);
    $d = explode('-', $date2);
    if(checkdate($d[1], $d[2], $d[0]) || checkdate($d[1], $d[0], $d[2])){
        return $d[2] . '-' . $d[1] . '-' . $d[0];
    }else{
        return null;
    }   
}

/**
 * Retorna o array com a data. Formato aaaa/mm/dia ou aaaa-mm-dd
 * @param String $data
 * @return Array
 */
function dateToArray($data){
    $data = str_replace('/', '-', $data);
    $d = explode('-', $data);
    if(checkdate($d[1], $d[2], $d[0]) || checkdate($d[1], $d[0], $d[2])){
        return $d;
    }else{
        return array();
    } 
}

function idade($data){
    $date = new DateTime($data);
    $now = new DateTime();
    $interval = $now->diff($date);
    return $interval->y;
}

function inverte_data_w_exception($date) {
    $date2 = str_replace('/', '-', $date);
    $d = explode('-', $date2);
    if(count($d)<3){
        throw new Exception("Data inválida.");
    }
    if (checkdate($d[1], $d[2], $d[0]) || checkdate($d[1], $d[0], $d[2])) {
        return $d[2] . '-' . $d[1] . '-' . $d[0];
    } else {
        throw new Exception("Data inválida.");
    }
}

/**
 * Retorna o mês por extenso
 * @param Int $mes
 * @return string
 */
function getMes($mes=01){
    $m = [
        '01'=>'Janeiro',
        '02'=>'Fevereiro',
        '03'=>'Março',
        '04'=>'Abril',
        '05'=>'Maio',
        '06'=>'Junho',
        '07'=>'Julho',
        '08'=>'Agosto',
        '09'=>'Setembro',
        '10'=>'Outubro',
        '11'=>'Novembro',
        '12'=>'Dezembro'
    ];
    return $m[$mes];
}

function getDataPorExtenso($data){
    $d = dateToArray($data);
    return $d[0] . " de " . getMes($d[1]) . " de " . $d[2] . ".";
}

function get_months(){
        $m = [
            1=>"Janeiro",
            2=>"Fevereiro",
            3=>"Março",
            4=>"Abril",
            5=>"Maio",
            6=>"Junho",
            7=>"Julho",
            8=>"Agosto",
            9=>"Setembro",
            10=>"Outubro",
            11=>"Novembro",
            12=>"Dezembro",
        ];
        
        return $m;
    }
    
    function month_name($num_month){
        $ms = get_months();
        return $ms[$num_month];
    }
    
    function month_min($num_month){
        $ms = get_months_min();
        return $ms[$num_month];
    }


    function get_months_min(){
        $m = [
            1=>"Jan",
            2=>"Fev",
            3=>"Mar",
            4=>"Abr",
            5=>"Mai",
            6=>"Jun",
            7=>"Jul",
            8=>"Ago",
            9=>"Set",
            10=>"Out",
            11=>"Nov",
            12=>"Dez",
        ];
        
        return $m;
    }
    
    /**
     * Retorna o ano atual (4 dígitos)
     * @return string/integer 4 dígitos
     */
    function current_year(){
        return date("Y");
    }
    
    /**
     * Retorna o mês atual (2 dígitos)
     * @return string/integer
     */
    function current_month(){
        return date("m");
    }
    
    /**
     * Retorna o dia atual (2 dígitos)
     * @return string/integer
     */
    function current_day(){
        return date("d");
    }
    
    /**
     * Retorna um array com os  horários de 00:00 a 23:59 de 15 em 15 minutos. Ex.: [00:00, 00:15, 00:30....]
     * @return array 
     */
    function quarter_hours(){
        $hs = [];
        
        for($h = 0; $h<=23; $h++){
            for($m = 0; $m<=45;($m=$m+15)){
                
                if($h<10){
                    $hp = "0".$h;
                }else{
                    $hp = $h;
                }
                if($m<10){
                    $mp = "0".$m;
                }else{
                    $mp = $m;
                }
                $hs[]=$hp.":".$mp;
            }
        }
        return $hs;
    }
    
    /**
     * Verifica se o formato do horário está correto hh:mm
     * @throws Exception
     * @param string $hr
     * @return boolean Resultado da verificação
     */
    function check_hour_exception($hr){
        if(strlen($hr)!=5){
            throw new Exception("Formato de hora inválido. Tente hh:mm.");
        }
        $h = explode(":", $hr);
        $hh = $h[0];
        $mm = $h[1];
        
        if($hh<0 || $hh>23){
            throw new Exception("Hora inválida");
        }
        
        if($mm<0 || $mm>59){
            throw new Exception("Minuto inválido");
        }
        
        return true;
    }
    
    /**
     * Verifica se o formato do horário está correto hh:mm
     * @param string $hr
     * @return boolean Resultado da verificação
     */
    function check_hour($hr){
        if($hr==null){
            return false;
        }
        
        if ($hr==""){
            return false;
        }
        
        if(strlen($hr)!=5){
            return false;
        }
        $h = explode(":", $hr);
        $hh = $h[0];
        $mm = $h[1];
        
        if($hh<0 || $hh>23){
            return false;
        }
        
        if($mm<0 || $mm>59){
            return false;
        }
        
        return true;
    }
    
    /**
     * Verifica se a data1 é maior que a data2
     * @param date $data1 Data 1 no formato aaaa/mm/dd
     */
    function compara_datas($data1, $data2){
        
    }
    
?>