<?
 function espaco($tamanho='',$conteudo=' '){
     $tm='';
     for($x=0;$x < $tamanho;$x++){
       $tm = $tm .$conteudo;
     }  
     return $tm;
 }
 /**
   prototipo =
   $numero = formatar($numero,10,'n');
   10 = tamanho
   n  = tipo  que pode ser (n,v,c,d)
   tipo  n= numero, alinhado a direta c/ zeros a esquerda
         v= valor, alinha  a direita c/ zero a esqueda e adiciona cadas decimais quando não tem
 	 c= caracter, alinha a esquerda e coloca espaço a direita
 	 c= data, recebe do banco e faz 16/08/2005 = 16082005
  */
 function formatar($field,$size,$tipo=""){
    $field = trim($field);
    if ((strlen($field) > $size ) && $tipo !='d' ){
       $field = substr($field,0,$size);
    }   
    if ($tipo=="c"){
       $field = $field.espaco($size-(strlen($field)));   
       
    } else if ($tipo=="n"){
       $field = str_replace('.','',$field);
       $field = espaco($size-(strlen($field)),'0').$field;
       
    } else if ($tipo=="v"){ 
       $pos = strpos($field,'.');
       if ($pos ==''){
          $field = $field.".00";
       }else{
          if (strlen($field)==$pos+2){
	     $field = $field."0";
	  } 
       }	 
       $field = str_replace('.','',$field);
       $field = espaco($size-(strlen($field)),'0').$field;

    } else if ($tipo =="d"){  
       $dt= split("-",$field);
       $field = "$dt[2]$dt[1]$dt[0]";
    }  
    return $field;
}
?>
