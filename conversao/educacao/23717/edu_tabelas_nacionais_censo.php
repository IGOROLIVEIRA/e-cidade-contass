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
$t = 0;
$total = 16546;
//////////CENSOUF
$ponteiro = fopen("tabela_censouf.txt","r");
$erro = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = trim(str_replace(chr(39),"",$array_linha[1]));
 $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
 $sql4 = "INSERT INTO censouf
          VALUES($array_linha[0],'$array_linha[1]','$array_linha[2]')
         ";
 $result4 = pg_query($sql4);
 if($result4==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,27,$array_linha[1],$array_linha[2]," PROGRESSÃO: TABELA CENSOUF");
  echo Progresso($t,$total,$array_linha[1],$array_linha[2]," PROGRESSÃO TOTAL DA TAREFA");
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
 echo "  \nConcluída CENSOUF\n\n";
 sleep(1);
}

//////////CENSOMUNIC
$ponteiro = fopen("tabela_censomunic.txt","r");
$erro = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = (int)str_replace(chr(39),"",$array_linha[1]);
 $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
 $sql4 = "INSERT INTO censomunic
          VALUES($array_linha[1],$array_linha[0],'$array_linha[2]')
         ";
 $result4 = pg_query($sql4);
 if($result4==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,5564,$array_linha[1],$array_linha[2]," PROGRESSÃO: TABELA CENSOMUNIC");
  echo Progresso($t,$total,$array_linha[1],$array_linha[2]," PROGRESSÃO TOTAL DA TAREFA");
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
 echo "  \nConcluída CENSOMUNIC\n\n";
 sleep(1);
}

//////////CENSODISTRITO
$ponteiro = fopen("tabela_censodistrito.txt","r");
$erro = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = (int)str_replace(chr(39),"",$array_linha[1]);
 $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
 $sql4 = "INSERT INTO censodistrito
          VALUES(nextval('censodistrito_ed262_i_codigo_seq'),$array_linha[0],$array_linha[1],'$array_linha[2]')
         ";
 $result4 = pg_query($sql4);
 if($result4==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,9463,$array_linha[1],$array_linha[2]," PROGRESSÃO: TABELA CENSODISTRITO");
  echo Progresso($t,$total,$array_linha[1],$array_linha[2]," PROGRESSÃO TOTAL DA TAREFA");
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
 echo "  \nConcluída CENSODISTRITO\n\n";
 sleep(1);
}

//////////CENSOORGREG
$ponteiro = fopen("tabela_censoorgreg.txt","r");
$erro = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = (int)str_replace(chr(39),"",$array_linha[1]);
 $array_linha[2] = str_replace(chr(39),"",$array_linha[2]);
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
 $sql4 = "INSERT INTO censoorgreg
          VALUES(nextval('censoorgreg_ed263_i_codigo_seq'),$array_linha[1],$array_linha[0],'$array_linha[2]')
         ";
 $result4 = pg_query($sql4);
 if($result4==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,800,$array_linha[0],$array_linha[2]," PROGRESSÃO: TABELA CENSOORGREG");
  echo Progresso($t,$total,$array_linha[0],$array_linha[2]," PROGRESSÃO TOTAL DA TAREFA");
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
 echo "  \nConcluída CENSOORGREG\n\n";
 sleep(1);
}

//////////CENSOLINGUAINDIG
$ponteiro = fopen("tabela_censolinguaindig.txt","r");
$erro = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = str_replace(chr(39),"",$array_linha[1]);
 $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
 $sql4 = "INSERT INTO censolinguaindig
          VALUES($array_linha[0],'$array_linha[1]')
         ";
 $result4 = pg_query($sql4);
 if($result4==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,207,$array_linha[0],$array_linha[1]," PROGRESSÃO: TABELA CENSOLINGUAINDIG");
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
 echo "  \nConcluída CENSOLINGUAINDIG\n\n";
 sleep(1);
}

//////////CENSOATIVCOMPL
$ponteiro = fopen("tabela_censoativcompl.txt","r");
$erro = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = str_replace(chr(39),"",$array_linha[1]);
 $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
 $array_linha[2] = (int)str_replace(chr(39),"",$array_linha[2]);
 $sql4 = "INSERT INTO censoativcompl
          VALUES($array_linha[0],$array_linha[2],'$array_linha[1]')
         ";
 $result4 = pg_query($sql4);
 if($result4==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,48,$array_linha[0],$array_linha[1]," PROGRESSÃO: TABELA CENSOATIVCOMPL");
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
 echo "  \nConcluída CENSOATIVCOMPL\n\n";
 sleep(1);
}

//////////CENSOCURSOPROFISS
$ponteiro = fopen("tabela_censocursoprofiss.txt","r");
$erro = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = str_replace(chr(39),"",$array_linha[1]);
 $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
 $array_linha[2] = (int)str_replace(chr(39),"",$array_linha[2]);
 $sql4 = "INSERT INTO censocursoprofiss
          VALUES($array_linha[0],'$array_linha[1]',$array_linha[2])
         ";
 $result4 = pg_query($sql4);
 if($result4==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,408,$array_linha[0],$array_linha[1]," PROGRESSÃO: TABELA CENSOCURSOPROFISS");
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
 echo "  \nConcluída CENSOCURSOPROFISS\n\n";
 sleep(1);
}

//////////CENSOORGEMISSRG
$ponteiro = fopen("tabela_censoorgemissrg.txt","r");
$erro = false;
$x = 0;
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,200);
 $array_linha = explode("|",$linha);
 $array_linha[0] = (int)str_replace(chr(39),"",$array_linha[0]);
 $array_linha[1] = str_replace(chr(39),"",$array_linha[1]);
 $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
 $sql4 = "INSERT INTO censoorgemissrg
          VALUES($array_linha[0],'$array_linha[1]')
         ";
 $result4 = pg_query($sql4);
 if($result4==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,29,$array_linha[0],$array_linha[1]," PROGRESSÃO: TABELA CENSOORGEMISSRG");
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
 echo "  \nConcluída CENSOORGEMISSRG\n\n";
 sleep(1);
}

system("clear");
echo Progresso($total-1,$total,$array_linha[0],$array_linha[1]," PROGRESSÃO TOTAL DA TAREFA");
echo " \n->Terminado processo...\n\n";
if($erro==false){
 pg_exec("commit");
}
?>
