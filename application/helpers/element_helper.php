<?php


function btn($texto, $tipo=null, $tamanho=null, $titulo=null, $placement=null){
    $btn = "<button type='submit'";
    $tip = "";
    if($texto==null || $texto==''){
        $texto = "???";
    }
    
    if($tipo==null || $tipo==''){
        $tip .= "btn";
    }else{
        $tip .= "btn btn-$tipo";
        if($tamanho!=null && $tamanho!=''){
            $tip.=" btn-$tamanho";
        } 
    }
    if($titulo==null && $titulo==''){
        $title = "";
    }else{
        $title = " title='$titulo' data-toggle='tooltip'";
        if($placement!=null && $placement!=''){
            $title.=" data-placement='$placement'";
        }
    }
    
    $btn .= "class='$tip' $title>$texto</button>";
    
    return $btn;
}

function gly($icone, $titulo=null, $posicao=null){
    $gly = "<i ";
    if($titulo!=null && $titulo!=''){
        $title = " title='$titulo' data-toggle='tooltip' ";
        if($posicao!=null){
            $title.="data-placement='$posicao'";
        }
    }else{
        $title = "";
    }
    
    $gly .= "class='glyphicon glyphicon-$icone' $title></i>";
    return $gly;
}
