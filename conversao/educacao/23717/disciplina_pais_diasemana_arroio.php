<?
set_time_limit(0);
$host="";
$base="";
$user="";
$pass="";
$port="5432";
if(!($conn = pg_connect("host=$host dbname=$base port=$port user=$user password=$pass"))) {
 echo "Erro ao conectar...\n\n";
 exit;
}else{
 echo "conectado...\n\n";
}

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
echo " ->Iniciando processo...";
sleep(1);
system("clear");
pg_exec("begin");
$sql0 = "ALTER SEQUENCE caddisciplina_ed232_i_codigo_seq START 1";
$result0 = pg_query($sql0);
$sql0 = "ALTER SEQUENCE pais_ed228_i_codigo_seq START 1";
$result0 = pg_query($sql0);
$sql0 = "ALTER SEQUENCE diasemana_ed32_i_codigo_seq START 1";
$result0 = pg_query($sql0);
$t = 0;
$total = 363;

//////////CADDISCIPLINA
$ponteiro = fopen("tabela_disciplina.txt","r");
$erro = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = str_replace(chr(39),"",$array_linha[1]);
 $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
 $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
 $sql4 = "INSERT INTO caddisciplina
          VALUES($array_linha[0],'$array_linha[1]','$array_linha[2]')
         ";
 $result4 = pg_query($sql4);
 if($result4==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,24,$array_linha[0],$array_linha[1]," PROGRESSÃO: TABELA CADDISCIPLINA");
  echo Progresso($t,$total,$array_linha[0],$array_linha[1]," PROGRESSÃO TOTAL DA TAREFA");
 }
 $x++;
 $t++;
}
fclose($ponteiro);
if($erro==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n\n";
 pg_exec("rollback");
 exit;
}else{
 echo "  \nConcluída CADDISCIPLINA\n\n";
 sleep(1);
}

//////////PAIS
$ponteiro = fopen("tabela_paises.txt","r");
$erro = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = str_replace(chr(39),"",$array_linha[1]);
 $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
 $sql4 = "INSERT INTO pais
          VALUES($array_linha[0],'$array_linha[1]')
         ";
 $result4 = pg_query($sql4);
 if($result4==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,332,$array_linha[0],$array_linha[1]," PROGRESSÃO: TABELA PAIS");
  echo Progresso($t,$total,$array_linha[0],$array_linha[1]," PROGRESSÃO TOTAL DA TAREFA");
 }
 $x++;
 $t++;
}
fclose($ponteiro);
if($erro==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n\n";
 pg_exec("rollback");
 exit;
}else{
 echo "  \nConcluída PAIS\n\n";
 sleep(1);
}

//////////CADDISCIPLINA
$ponteiro = fopen("tabela_diasemana.txt","r");
$erro = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = str_replace(chr(39),"",$array_linha[1]);
 $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
 $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
 $sql4 = "INSERT INTO diasemana
          VALUES($array_linha[0],'$array_linha[1]','$array_linha[2]')
         ";
 $result4 = pg_query($sql4);
 if($result4==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,7,$array_linha[0],$array_linha[1]," PROGRESSÃO: TABELA DIASEMANA");
  echo Progresso($t,$total,$array_linha[0],$array_linha[1]," PROGRESSÃO TOTAL DA TAREFA");
 }
 $x++;
 $t++;
}
fclose($ponteiro);
if($erro==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n\n";
 pg_exec("rollback");
 exit;
}else{
 echo "  \nConcluída DIASEMANA\n\n";
 sleep(1);
}

$sql0 = "ALTER SEQUENCE caddisciplina_ed232_i_codigo_seq START 25";
$result0 = pg_query($sql0);
$sql0 = "ALTER SEQUENCE pais_ed228_i_codigo_seq START 333";
$result0 = pg_query($sql0);
$sql0 = "ALTER SEQUENCE diasemana_ed32_i_codigo_seq START 8";
$result0 = pg_query($sql0);

system("clear");
echo Progresso($total-1,$total,$array_linha[0],$array_linha[1]," PROGRESSÃO TOTAL DA TAREFA");
echo " \n->Terminado processo...\n\n";
if($erro==false){
 pg_exec("commit");
}
?>
