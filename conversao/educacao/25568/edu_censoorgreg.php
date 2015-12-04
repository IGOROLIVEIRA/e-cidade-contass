<?
set_time_limit(0);
$host="127.0.0.1";
$base="guaiba";
$user="postgres";
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
$t = 0;
$total = 800;
//////////CENSOORGREG
$ponteiro = fopen("tabela_censoorgreg.txt","r");
$erro = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = (int)str_replace(chr(39),"",$array_linha[1]);
 $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
 $sql3 = "SELECT ed263_i_codigo FROM censoorgreg
          WHERE ed263_i_censouf = $array_linha[1]
          AND ed263_c_nome = '$array_linha[2]'
         ";
 $result3 = pg_query($sql3);
 if(pg_num_rows($result3)>0){
  $ed263_i_codigo = pg_result($result3,0,0);
  $sql4 = "UPDATE censoorgreg SET ed263_i_codigocenso = '$array_linha[0]' WHERE ed263_i_codigo = $ed263_i_codigo";
  $result4 = pg_query($sql4);
  if($result4==false){
   $erro = true;
   break;
  }else{
   system("clear");
   echo Progresso($x,800,$array_linha[0],$array_linha[2]," PROGRESSÃO: TABELA CENSOORGREG");
  }
  $x++;
  $t++;
 }
}
fclose($ponteiro);
if($erro==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n\n";
 pg_exec("rollback");
 exit;
}else{
 echo "  \nConcluída CENSOORGREG\n\n";
 sleep(1);
}

system("clear");
echo Progresso($total-1,$total,$array_linha[0],$array_linha[1]," PROGRESSÃO TOTAL DA TAREFA");
echo " \n->Terminado processo...\n\n";
if($erro==false){
 pg_exec("commit");
}
?>
