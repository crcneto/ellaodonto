<?php

function limpaArray(Array $array){
    if(!is_array($array)){
        return null;
    }
    foreach ($array as $key => $value) {
        if($value==NULL || $value==''){
            unset($array[$key]);
        }
    }
    return $array;
}
