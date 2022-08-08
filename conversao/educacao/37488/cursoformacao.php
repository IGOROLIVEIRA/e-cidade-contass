<?
set_time_limit(0);
//$host="";
//$base="";
//$user="";
//$pass="";
//$port="5432";
include(__DIR__ . "/../../../libs/db_conn.php");
if(!($conn = pg_connect("host='$DB_SERVIDOR' dbname='$DB_BASE' user='$DB_USUARIO' password='$DB_SENHA' port='$DB_PORTA'"))) {
 echo "Erro ao conectar...\n\n";
 exit;
}else{
 echo "conectado...\n\n";
}
pg_query($conn, "SELECT fc_startsession()");
function maiusculo(&$string){
 $string = strtoupper($string);
 $string = str_replace("Ã¡","Ã",$string);
 $string = str_replace("Ã©","Ã",$string);
 $string = str_replace("Ã­","Ã",$string);
 $string = str_replace("Ã³","Ã",$string);
 $string = str_replace("Ãº","Ã",$string);
 $string = str_replace("Ã¢","Ã",$string);
 $string = str_replace("Ãª","Ã",$string);
 $string = str_replace("Ã´","Ã",$string);
 $string = str_replace("Ã®","Ã",$string);
 $string = str_replace("Ã»","Ã",$string);
 $string = str_replace("Ã£","Ã",$string);
 $string = str_replace("Ãµ","Ã",$string);
 $string = str_replace("Ã§","Ã",$string);
 $string = str_replace("Ã ","Ã",$string);
 $string = str_replace("Ã¨","Ã",$string);
 return $string;
}

function TiraAcento($string){
 set_time_limit(240);
 $acentos = 'áéíóúÁÉÍÓÚàÀÂâÊêôÔüÜïÏöÖñÑãÃõÕçÇªºäÄ\'';
 $letras  = 'AEIOUAEIOUAAAAEEOOUUIIOONNAAOOCCAOAA ';
 $new_string = '';
 for($x=0; $x<strlen($string); $x++){
  $let = substr($string, $x, 1);
  for($y=0; $y<strlen($acentos); $y++){
   if($let==substr($acentos, $y, 1)){
    $let=substr($letras, $y, 1);
    break;
   }
  }
  $new_string = $new_string . $let;
 }
 return $new_string;
}
function Progresso($linha,$total,$dado1,$dado2,$titulo){
 $linha++;
 $percent = ($linha/$total)*100;
 $percorrido = floor($percent);
 $restante = 100-$percorrido;
 $tracos = "";
 for($t=0;$t<$percorrido;$t++){
  $tracos .= "#";
 }
 $brancos = "";
 for($t=0;$t<$restante;$t++){
  $brancos .= ".";
 }
 echo " $titulo";
 echo " $linha de $total registros.\n";
 echo " [".$tracos.$brancos."] ".number_format($percent,2,".",".")."%\n";
 if($titulo!=" PROGRESSÃO TOTAL DA TAREFA"){
  echo " ---> ".trim($dado1)." -- ".trim($dado2)."\n";
 }
}


//////////CURSOFORMACAO-NOVA
$ponteiro = fopen("tabela_cursoformacao.txt","r");
$erro = false;
$x = 0;
$total=1224;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = str_replace(chr(39),"",$array_linha[1]);
 $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
 $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
 $array_linha[3] = str_replace(chr(39),"",$array_linha[3]);
 $array_linha[3] = trim(strtoupper(maiusculo(TiraAcento($array_linha[3]))));

  $sql4 = "INSERT INTO cursoformacao
            (ed94_i_codigo,
             ed94_i_codclasse,
             ed94_c_descrclasse,
             ed94_c_codigocenso,
             ed94_c_descr)
           VALUES
            (nextval('cursoformacao_ed94_i_codigo_seq'),
             $array_linha[0],
             '$array_linha[1]',
             '$array_linha[2]',
             '$array_linha[3]')
          ";
  $result4 = pg_query($sql4);
 if($result4==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,1224,"( ".$array_linha[0]." ) ".$array_linha[2],$array_linha[3]," PROGRESSÃO: TABELA CURSOFORMACAO");  
 }
 $x++;
 $t++;
}
 
 
if($erro==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n\n";
 pg_exec("rollback");
 exit;
}else{
 echo "  \nConcluída CURSOFORMACAO\n\n";
 sleep(1);
}
system("clear");
echo Progresso($total-1,$total,$array_linha[2],$array_linha[3]," PROGRESSÃO TOTAL DA TAREFA");
echo " \n->Terminado processo...\n\n";
if($erro==false){
 pg_exec("commit");
}
?>
