<?
global $data_ini,$data_fim,$cnpj;
$data_ini='2005-01-01';
$data_fim='2005-02-28';
$cnpj="00112244552211"; 


function espaco($tamanho='',$conteudo=' '){
  $tm='';
  for($x=0;$x < $tamanho;$x++){
    $tm = $tm .$conteudo;
  }  
  return $tm;
}
// tipo ='C'-> caracter, alinhado a esquerda e espaco em branco a direita
//    'N' => alinha a direta com zeros a esquerda e sem caracteres especiais
//    'V'  => valor,   $R250,00 =  25000
//    'D' => 8 digitos,  16/10/2005 =  16102005
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
     } 	
     $field = str_replace('.','',$field);
     $field = espaco($size-(strlen($field)),'0').$field;
  } else if ($tipo =="d"){  
     $dt= explode("-",$field);
     $field = "$dt[2]$dt[1]$dt[0]";
  }
  
  return $field;
}  

function imprime_header($arq){
  // $cnpj="00112244552211"; 
  global $cnpj;
  $data_ini="03042005";
  $data_fim="03052005";
  $data_geracao="03022005";
  $nome_setor="governo do estado";
  $nome_setor = $nome_setor .espaco(80-(strlen($nome_setor))); // espaco de 80
 //-- 
  $line =$cnpj.$data_ini.$data_fim.$data_geracao.$nome_setor; 
  fputs($arq,$line);
  fputs($arq,"\n");
}




?>


