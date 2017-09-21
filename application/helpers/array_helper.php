<?php
/**
 * It iterates on the array unsetting the empty indexes
 * @param array list where the loop goes run
 * @return array Returns the same array without the empty keys
 */
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
