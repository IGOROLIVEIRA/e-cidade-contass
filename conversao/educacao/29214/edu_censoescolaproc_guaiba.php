<?
set_time_limit(0);
/*$host="172.30.6.5";
$base="bage";
$user="postgres";
$pass="";
$port="5432";*/
include(__DIR__ . "/../../../libs/db_conn.php");
if(!($conn = pg_connect('host='.$DB_SERVIDOR.' dbname='.$DB_BASE.' user='.$DB_USUARIO.' password='.$DB_SENHA.' port='.$DB_PORTA))) {
 echo "Erro ao conectar...\n\n";
 exit;
}else{
 echo "conectado...\n\n";
}
function TiraCaracteres(&$string){
 $string = str_replace("/","",$string);
 $string = str_replace(chr(92),"",$string);// contrabarra -> \
 $string = str_replace(";","",$string);
 $string = str_replace(":","",$string);
 $string = str_replace("?","",$string);
 $string = str_replace(",","",$string);
 $string = str_replace(".","",$string);
 $string = str_replace("'","",$string);
 $string = str_replace(chr(34),"",$string);// aspas dupla -> "
 $string = str_replace("!","",$string);
 $string = str_replace("@","",$string);
 $string = str_replace("#","",$string);
 $string = str_replace("$","",$string);
 $string = str_replace("%","",$string);
 $string = str_replace("&","",$string);
 $string = str_replace("*","",$string);
 $string = str_replace("(","",$string);
 $string = str_replace(")","",$string);
 $string = str_replace("_","",$string);
 $string = str_replace("+","",$string);
 $string = str_replace("=","",$string);
 $string = str_replace("{","",$string);
 $string = str_replace("}","",$string);
 $string = str_replace("[","",$string);
 $string = str_replace("]","",$string);
 $string = str_replace("<","",$string);
 $string = str_replace(">","",$string);
 $string = str_replace("|","",$string);
 $string = str_replace("ß","",$string);
 $string = str_replace("∞","",$string);
 $string = str_replace("π","",$string);
 $string = str_replace("≤","",$string);
 $string = str_replace("≥","",$string);
 $string = str_replace("£","",$string);
 $string = str_replace("¢","",$string);
 $string = str_replace("¨","",$string);

 return $string;
}

function maiusculo(&$string){
 $string = strtoupper($string);
 $string = str_replace("√°","√",$string);
 $string = str_replace("√©","√",$string);
 $string = str_replace("√≠","√",$string);
 $string = str_replace("√≥","√",$string);
 $string = str_replace("√∫","√",$string);
 $string = str_replace("√¢","√",$string);
 $string = str_replace("√™","√",$string);
 $string = str_replace("√¥","√",$string);
 $string = str_replace("√Æ","√",$string);
 $string = str_replace("√ª","√",$string);
 $string = str_replace("√£","√",$string);
 $string = str_replace("√µ","√",$string);
 $string = str_replace("√ß","√",$string);
 $string = str_replace("√†","√",$string);
 $string = str_replace("√®","√",$string);
 return $string;
}

function TiraAcento($string){
 set_time_limit(240);
 $acentos = '·ÈÌÛ˙¡…Õ”⁄‡¿¬‚ ÍÙ‘¸‹Ôœˆ÷Ò—„√ı’Á«™∫‰ƒ\'';
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
 if($titulo!=" PROGRESS√O TOTAL DA TAREFA"){
  echo " ---> ".trim($dado1)." -- ".trim($dado2)."\n";
 }
}
echo " ->Iniciando processo...\n\n";
sleep(1);
system("clear");
pg_exec("begin");
//$sqlproc11 =  pg_query("alter table escolaproc drop ed82_i_censouf;");
//$sqlproc33 =  pg_query("alter table escolaproc drop ed82_i_censomunic;");
//$sqlproc44 =  pg_query("alter table escolaproc drop ed82_i_censodistrito;");
$sqlproc1 =  pg_query(" alter table escolaproc add ed82_i_censouf integer;");
$sqlproc3 =  pg_query("	alter table escolaproc add ed82_i_censomunic integer;");
$sqlproc4 =  pg_query("	alter table escolaproc add ed82_i_censodistrito integer;");
$sqlproc5 =  pg_query("	ALTER TABLE escolaproc ADD CONSTRAINT escolaproc_censomunic_fk FOREIGN KEY (ed82_i_censomunic) REFERENCES censomunic;");
$sqlproc6 =  pg_query("	ALTER TABLE escolaproc ADD CONSTRAINT escolaproc_censouf_fk FOREIGN KEY (ed82_i_censouf) REFERENCES censouf;");
$sqlproc7 =  pg_query("	ALTER TABLE escolaproc ADD CONSTRAINT escolaproc_censodistrito_fk FOREIGN KEY (ed82_i_censodistrito) REFERENCES censodistrito;");
$sqlproc8 =  pg_query("	CREATE  INDEX escolaproc_censouf_in ON escolaproc(ed82_i_censouf);");
$sqlproc9 =  pg_query("	CREATE  INDEX escolaproc_censomunic_in ON escolaproc(ed82_i_censomunic);");
$sqlproc10 = pg_query("	CREATE  INDEX escolaproc_censodistrito_in ON escolaproc(ed82_i_censodistrito);");                                                        

$ed82_c_censomunic_banco = array(   
									"ARAMBAR…"=>"4300851";                                                                 
 									"BENTO GON«ALVES"=>"4302105";                                                                
 									"CAMAQU√"=>"4303509";                                                                  
 									"CANGU«U"=>"4304507";                                                                                                             
 									"GRAVATAÕ"=>"4309209";                                                                            
 									"GUAÕBA"=>"4309308";                                                                                                               
 								    "S√O BORJA"=>"4318002";                                      
 									"S√O GABRIEL"=>"4318309";                                      
 								    "SAO LEOPOLDO"=>"4318705";                             
 									"S√O LEOPOLDO"=>"4318705";                             
 									"SA’ LEOPOLDO"=>"4318705";                             
 									"S√O LOURENCO DO SUL"=>"4318804";                                                             
 									"SERRARI - S√O JOS…"=>"4216602";                           
 									"SERT√O SANTANA"=>"4320552";                                                                                                              
 								    "TR S CACHOEIRAS"=>"4321667";                             
 									"TR S DE MAIO"=>"4321808";
								);

$sql = "SELECT ed82_i_codigo,
               ed82_c_cidade,
               ed82_c_estado               
        FROM escolaproc
       ";
$result = pg_query($sql);
$linhas = pg_num_rows($result);
$erro = false;
for($x=0;$x<$linhas;$x++){
 $ed82_i_codigo          = trim(pg_result($result,$x,0));
 $ed82_c_cidade          = trim(pg_result($result,$x,1));
  if($ed82_c_cidade!=""){
  $sql1 = "SELECT ed261_i_codigo,ed261_i_censouf FROM censomunic WHERE ed261_c_nome = '$ed82_c_cidade'";
  $result1 = pg_query($sql1);
  if(pg_num_rows($result1)>0){
   $ed82_i_censomunic = pg_result($result1,0,0);
   $ed82_i_censouf    = pg_result($result1,0,1);
  }else{
   $ed82_i_censomunic = "null";
   $ed82_i_censouf   = "null";
  }
 }else{
  $ed82_i_censomunic = "null";
  $ed82_i_censouf = "null";
 }
 if($ed82_c_cidade!=""){
  $naotem = false;
  reset($ed82_c_censomunic_banco);
  for($t=0;$t<count($ed82_c_censomunic_banco);$t++){
   if($ed82_c_cidade==key($ed82_c_censomunic_banco)){
    $ed82_c_cidade = $ed82_c_censomunic_banco[key($ed82_c_censomunic_banco)];
    $naotem = true;
    break;
   }
   next($ed82_c_censomunic_banco);
  }
  if($naotem==false){
    $sql1 = "SELECT ed261_i_codigo,ed261_i_censouf FROM censomunic WHERE ed261_c_nome = '$ed82_c_cidade'";
   $result1 = pg_query($sql1);
   if(pg_num_rows($result1)>0){
    $ed82_c_cidade = pg_result($result1,0,0);
    $ed82_c_estado    = pg_result($result1,0,1);
   }else{
    $ed82_c_cidade = "null";
    $ed82_c_estado    = "null";
   }
  }else{
   if($ed82_c_cidade!=""){
     $sql1 = "SELECT ed261_i_censouf FROM censomunic WHERE ed261_i_codigo = $ed82_c_cidade";
    $result1 = pg_query($sql1);
    $ed82_c_estado = pg_result($result1,0,0);
   }else{
    $ed82_c_cidade = "null";
    $ed82_c_estado    = "null";
   }
  }
 }else{
  $ed82_c_cidade = "null";
  $ed82_c_estado    = "null";
 }
  $sql2 = "UPDATE escolaproc SET
           ed82_i_censomunic = $ed82_c_cidade,
           ed82_i_censouf = $ed82_c_estado       
          WHERE ed82_i_codigo = $ed82_i_codigo";
 $result2 = pg_query($sql2);
 if($result2==false){
  $erro = true;
  break;
 }else{
  system("clear");
  echo Progresso($x,$linhas,$ed82_i_codigo,$ed82_c_estado," PROGRESS√O:");
 }
}

if($erro==true){
 echo "\n\n ERRO: ".pg_errormessage()."\n SQL: ".$sql2."\n\n";
 pg_exec("rollback");
 exit;
}else{
 echo "  \nProcesso ConcluÌdo\n\n";
 pg_exec("commit");
}
?>
