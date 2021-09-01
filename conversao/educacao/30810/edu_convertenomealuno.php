<?
set_time_limit(0);
/*
$DB_SERVIDOR="172.30.6.4";
$DB_BASE="bage";
$DB_USUARIO="postgres";
$DB_SENHA="";
$DB_PORTA="5432";
*/
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
function RetiraAcento($string){
 set_time_limit(240);
 $acentos = 'áéíóúÁÉÍÓÚàÀÂâÊêôÔüÜïÏöÖñÑãÃõÕçÇäÄ\'';
 $letras  = 'AEIOUAEIOUAAAAEEOOUUIIOONNAAOOCCAA ';
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
function TiraEspacoNome($nome){
 $nome_partes = explode(" ",$nome);
 $novonome = "";
 $espaco = "";
 for($e=0;$e<count($nome_partes);$e++){
  if(trim($nome_partes[$e])!=""){
   $novonome .= $espaco.trim($nome_partes[$e]);
   $espaco = " ";
  }
 } 
 return $novonome;	
}
function TiraCaracteres(&$string,$tipo){
 // $string = string a ser retirados os caracteres
 // $tipo = tipo de validação: 1, 2, 3 e 4
 //
 // 1 - Somente Letras e espaço
 // 2 - Somente Números, Letras, espaço, ª, º e traço
 // 3 - Somente Números, Letras, espaço, ª, º , ponto, virgula, barra e traço
 // 4 - Somente Números, Letras, arroba, ponto, sublinha e traço (email)
 $string = str_replace(chr(92),"",$string);// contrabarra -> \
 $string = str_replace(";","",$string);
 $string = str_replace(":","",$string);
 $string = str_replace("?","",$string);
 $string = str_replace("'","",$string);
 $string = str_replace(chr(34),"",$string);// aspas dupla -> "
 $string = str_replace("!","",$string);
 $string = str_replace("#","",$string);
 $string = str_replace("$","",$string);
 $string = str_replace("%","",$string);
 $string = str_replace("&","",$string);
 $string = str_replace("*","",$string);
 $string = str_replace("(","",$string);
 $string = str_replace(")","",$string);
 $string = str_replace("+","",$string);
 $string = str_replace("=","",$string);
 $string = str_replace("{","",$string);
 $string = str_replace("}","",$string);
 $string = str_replace("[","",$string);
 $string = str_replace("]","",$string);
 $string = str_replace("<","",$string);
 $string = str_replace(">","",$string);
 $string = str_replace("|","",$string);
 $string = str_replace("§","",$string);
 $string = str_replace("°","",$string);
 $string = str_replace("¹","",$string);
 $string = str_replace("²","",$string);
 $string = str_replace("³","",$string);
 $string = str_replace("£","",$string);
 $string = str_replace("¢","",$string);
 $string = str_replace("¬","",$string);
 $string = str_replace("~","",$string);
 $string = str_replace("^","",$string);
 $string = str_replace("´","",$string);
 $string = str_replace("`","",$string);
 $string = str_replace("¨","",$string);
 if($tipo==1){
  $string = str_replace("/","",$string);
  $string = str_replace("@","",$string);
  $string = str_replace(".","",$string);
  $string = str_replace(",","",$string);
  $string = str_replace("ª","",$string);
  $string = str_replace("º","",$string);
  $string = str_replace("-","",$string);
  $string = str_replace("_","",$string);
  $string = str_replace("0","",$string);
  $string = str_replace("1","",$string);
  $string = str_replace("2","",$string);
  $string = str_replace("3","",$string);
  $string = str_replace("4","",$string);
  $string = str_replace("5","",$string);
  $string = str_replace("6","",$string);
  $string = str_replace("7","",$string);
  $string = str_replace("8","",$string);
  $string = str_replace("9","",$string);
 }
 if($tipo==2){
  $string = str_replace("/","",$string);
  $string = str_replace("@","",$string);
  $string = str_replace(".","",$string);
  $string = str_replace(",","",$string);
  $string = str_replace("_","",$string);
 }
 if($tipo==3){
  $string = str_replace("@","",$string);
  $string = str_replace("_","",$string);
 }
 if($tipo==4){
  $string = str_replace("/","",$string);
  $string = str_replace(",","",$string);
  $string = str_replace("ª","",$string);
  $string = str_replace("º","",$string);
  $string = str_replace(" ","",$string);
 }
 $string = maiusculo(RetiraAcento(TiraEspacoNome($string)));
 return $string;
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
echo " ->Iniciando processo...\n\n";
sleep(1);
system("clear");
pg_exec("begin");
$sql = "SELECT ed47_i_codigo,trim(ed47_v_nome),trim(ed47_v_mae),trim(ed47_v_pai) FROM aluno ORDER BY ed47_v_nome";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
 $codaluno  = trim(pg_result($result,$x,0));
 $nomealuno = TiraCaracteres(pg_result($result,$x,1),1);
 $nomemae   = TiraCaracteres(pg_result($result,$x,2),1);
 $nomepai   = TiraCaracteres(pg_result($result,$x,3),1);  
 $sql2 = "UPDATE ALUNO SET 
           ed47_v_nome = '$nomealuno',
           ed47_v_mae  = '$nomemae',
           ed47_v_pai  = '$nomepai'                       
          WHERE ed47_i_codigo = $codaluno";
 $result2 = pg_query($sql2);
 if($result2==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$codaluno,$nomealuno," PROGRESSÃO: ALUNO");
 }
}
if($erro==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n SQL: ".$sql2."\n\n";
 pg_exec("rollback");
 exit;
}else{
 echo "  \nProcesso Concluído\n";
 pg_exec("commit");
}
?>                                                           