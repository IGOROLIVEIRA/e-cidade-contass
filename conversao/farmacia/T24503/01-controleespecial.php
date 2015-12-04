<?
set_time_limit(0);
// Esse � o padr�o para conexao
include("../../../libs/db_conn.php");


/*NAO H� NECESSIDADE DE VARI�VEIS LOCAIS PARA CONEXAO.
CLARO QUE SE EM TEMPO DE DESENVOLVIMENTO VCS NAO QUISEREM
FICAR ALTERANDO O db_conn.php PELO MENOS UTILIZEM AS VARIAVEIS
COM O MESMO NOME DA CONFIGURACAO E DEPOIS SOH COMENTEM

$DB_SERVIDOR = "172.30.6.6";
$DB_BASE     = "bage";
$DB_USUARIO  = "postgres";
$DB_SENHA    = "";
$DB_PORTA    = "5432";*/



// Fazendo dessa forma teremos a conexao padronizacao e sem necessidade de alteracoes externas
if(!($conn = pg_connect('host='.$DB_SERVIDOR.' dbname='.$DB_BASE.' user='.$DB_USUARIO.' password='.$DB_SENHA.' port='.$DB_PORTA))) {
 echo "Erro ao conectar...\n\n";
 exit;
}
 
echo "conectado...\n\n";
// Logo ap�s o pg_connect rodar o fc_startsession
pg_query($conn, "SELECT fc_startsession()");
pg_query("delete from far_classeterapeuticamed");
pg_query("delete from far_classeterapeutica");
pg_query("delete from far_concentracaomed");
pg_query("delete from far_concentracao");
pg_query("delete from far_formafarmaceuticamed");
pg_query("delete from far_formafarmaceutica");
pg_query("delete from far_laboratoriomed");
pg_query("delete from far_laboratorio");
pg_query("delete from far_listacontroladomed");
pg_query("delete from far_listacontrolado");
pg_query("delete from far_medreferenciamed");
pg_query("delete from far_listaprescricao");
pg_query("delete from far_medreferencia");
pg_query("delete from far_prescricaomed");
pg_query("delete from far_prescricaomedica");
pg_query("delete from far_medanvisa");

function maiusculo(&$string){
 $string = strtoupper($string);
 $string = str_replace("á","�",$string);
 $string = str_replace("é","�",$string);
 $string = str_replace("í","�",$string);
 $string = str_replace("ó","�",$string);
 $string = str_replace("ú","�",$string);
 $string = str_replace("â","�",$string);
 $string = str_replace("ê","�",$string);
 $string = str_replace("ô","�",$string);
 $string = str_replace("î","�",$string);
 $string = str_replace("û","�",$string);
 $string = str_replace("ã","�",$string);
 $string = str_replace("õ","�",$string);
 $string = str_replace("ç","�",$string);
 $string = str_replace("à","�",$string);
 $string = str_replace("è","�",$string);
 return $string;
}

function TiraAcento($string){
 set_time_limit(240);
 $acentos = '�������������������������������Ǫ���\'';
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
 if($titulo!=" PROGRESS�O TOTAL DA TAREFA"){
  echo " ---> ".trim($dado1)." -- ".trim($dado2)."\n";
 }
}
echo " ->Iniciando processo...";
sleep(1);
system("clear");
pg_exec("begin");
//////////medanvisa
echo"\n Tabela far_medanvisa.";
$ponteiro = fopen("controleespecial.txt","r");
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,360);
 $array_linha = explode("|",$linha);
 $array_linha[0] = trim(strtoupper(maiusculo(TiraAcento($array_linha[0]))));
 $sql2  ="select fa14_c_medanvisa from far_medanvisa where fa14_c_medanvisa='".$array_linha[0]."'";
 $result2 = pg_query($sql2) or die("erro");
 $linhas=pg_num_rows($result2);
 if($array_linha[0]!=""){
   if($linhas==0){     
      $sql4 = "INSERT INTO far_medanvisa (fa14_i_codigo,fa14_c_medanvisa)
            VALUES(nextval('far_medanvisa_fa14_codigo_seq'),'$array_linha[0]')
           ";
      echo(".");
      $result4 = pg_query($sql4) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
   }
 }
}



//////////classe terapeutica
echo"\n Tabela far_classeterapeutica.";
$ponteiro = fopen("controleespecial.txt","r");
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[7] = trim(strtoupper(maiusculo(TiraAcento($array_linha[7]))));
 $sql2  ="select fa18_c_classetera from far_classeterapeutica where fa18_c_classetera='".$array_linha[7]."'";
 $result2 = pg_query($sql2) or die("erro");
 $linhas=pg_num_rows($result2);
 if($array_linha[7]!=""){
  if($linhas==0){   
     $sql4 = "INSERT INTO far_classeterapeutica (fa18_i_codigo,fa18_c_classetera)
           VALUES(nextval('far_classeterapeutica_fa18_codigo_seq'),'$array_linha[7]')
          ";
     echo".";
     $result4 = pg_query($sql4) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
  }
 }
}

echo"\n Tabela far_classeterapeuticamed.";
$ponteiro = fopen("controleespecial.txt","r");

while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[0] = trim(strtoupper(maiusculo(TiraAcento($array_linha[0]))));
 $array_linha[7] = trim(strtoupper(maiusculo(TiraAcento($array_linha[7]))));

 $sql7  ="select fa14_i_codigo from far_medanvisa where fa14_c_medanvisa='".$array_linha[0]."'";
 $result7 = pg_query($sql7) or die("erro");
 $linhas7=pg_num_rows($result7);
 @$med= pg_result($result7,0,0);

 $sql9  ="select fa18_i_codigo from far_classeterapeutica where fa18_c_classetera='".$array_linha[7]."'";
 $result9 = pg_query($sql9) or die("erro");
 $linhas9=pg_num_rows($result9);
 @$for= pg_result($result9,0,0);

  if(trim($linha)!=""){
   $sql15  ="select fa36_i_medanvisa,fa36_i_classeterapeutica from far_classeterapeuticamed where  fa36_i_medanvisa=$med and fa36_i_classeterapeutica=$for";
   $result15 = pg_query($sql15) or die("erro");
   $linhas15=pg_num_rows($result15);
    if($linhas15==0) {
      $sql11 = "INSERT INTO far_classeterapeuticamed (fa36_i_codigo,fa36_i_medanvisa,fa36_i_classeterapeutica)
              VALUES(nextval('far_classeterapeuticamed_fa36_codigo_seq'),$med,$for)";
      echo(".");
      $result11 = pg_query($sql11) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
    }
  }
}



//////////concentracao
echo"\n Tabela far_concentracao";
$ponteiro = fopen("controleespecial.txt","r");
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[3] = trim(strtoupper(maiusculo(TiraAcento($array_linha[3]))));
 $sql2  ="select fa30_c_concentracao from far_concentracao where fa30_c_concentracao='".$array_linha[3]."'";
 $result2 = pg_query($sql2) or die("erro");
 $linhas=pg_num_rows($result2);
 if($array_linha[3]!=""){
  if($linhas==0){   
     $sql4 = "INSERT INTO far_concentracao (fa30_i_codigo,fa30_c_concentracao)
           VALUES(nextval('far_concentracao_fa30_codigo_seq'),'$array_linha[3]')
          ";
     echo".";
     $result4 = pg_query($sql4) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
  }
 }
}


echo"\n Tabela far_concentracaomed.";
$ponteiro = fopen("controleespecial.txt","r");

while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[0] = trim(strtoupper(maiusculo(TiraAcento($array_linha[0]))));
 $array_linha[3] = trim(strtoupper(maiusculo(TiraAcento($array_linha[3]))));

 $sql7  ="select fa14_i_codigo from far_medanvisa where fa14_c_medanvisa='".$array_linha[0]."'";
 $result7 = pg_query($sql7) or die("erro");
 $linhas7=pg_num_rows($result7);
 @$med= pg_result($result7,0,0);

 $sql9  ="select fa30_i_codigo from far_concentracao where fa30_c_concentracao='".$array_linha[3]."'";
 $result9 = pg_query($sql9) or die("erro");
 $linhas9=pg_num_rows($result9);
 @$for= pg_result($result9,0,0);

  if(trim($linha)!=""){
   $sql15  ="select fa37_i_medanvisa,fa37_i_concentracao from far_concentracaomed where  fa37_i_medanvisa=$med and fa37_i_concentracao=$for";
   $result15 = pg_query($sql15) or die("erro");
   $linhas15=pg_num_rows($result15);
    if($linhas15==0) {
       $sql11 = "INSERT INTO far_concentracaomed (fa37_i_codigo,fa37_i_medanvisa,fa37_i_concentracao)
              VALUES(nextval('far_concentracaomed_fa37_codigo_seq'),$med,$for)";
       echo".";
       $result11 = pg_query($sql11) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
    }
  }
}


//////////forma farmaceutica
echo"\n Tabela far_formafarmaceutica.";
$ponteiro = fopen("controleespecial.txt","r");
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[4] = trim(strtoupper(maiusculo(TiraAcento($array_linha[4]))));
 $sql2  ="select fa29_c_forma from far_formafarmaceutica where fa29_c_forma='".$array_linha[4]."'";
 $result2 = pg_query($sql2) or die("erro");
 $linhas=pg_num_rows($result2);
 if($array_linha[4]!=""){
  if($linhas==0){   
     $sql4 = "INSERT INTO far_formafarmaceutica (fa29_i_codigo,fa29_c_forma)
           VALUES(nextval('far_formafarmaceutica_fa29_codigo_seq'),'$array_linha[4]')
          ";
     echo".";
     $result4 = pg_query($sql4) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
  }
 }
}


echo"\n Tabela far_formafarmaceuticamed.";
$ponteiro = fopen("controleespecial.txt","r");

while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[0] = trim(strtoupper(maiusculo(TiraAcento($array_linha[0]))));
 $array_linha[4] = trim(strtoupper(maiusculo(TiraAcento($array_linha[4]))));

 $sql7  ="select fa14_i_codigo from far_medanvisa where fa14_c_medanvisa='".$array_linha[0]."'";
 $result7 = pg_query($sql7) or die("erro");
 $linhas7=pg_num_rows($result7);
 @$med= pg_result($result7,0,0);

 $sql9  ="select fa29_i_codigo from far_formafarmaceutica where fa29_c_forma='".$array_linha[4]."'";
 $result9 = pg_query($sql9) or die("erro");
 $linhas9=pg_num_rows($result9);
 @$for= pg_result($result9,0,0);

  if(trim($linha)!=""){
   $sql15  ="select fa33_i_medanvisa,fa33_i_formafarmaceutica from far_formafarmaceuticamed where  fa33_i_medanvisa=$med and fa33_i_formafarmaceutica=$for";
   $result15 = pg_query($sql15) or die("erro");
   $linhas15=pg_num_rows($result15);
    if($linhas15==0) {
     $sql11 = "INSERT INTO far_formafarmaceuticamed (fa33_i_codigo,fa33_i_medanvisa,fa33_i_formafarmaceutica)
              VALUES(nextval('far_formafarmaceuticamed_fa33_codigo_seq'),$med,$for)";
     echo".";
     $result11 = pg_query($sql11) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
    }
  }
}

//////////laboratorio
echo"\n Tabela far_laboratorio.";
$ponteiro = fopen("controleespecial.txt","r");
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
 $sql2  ="select fa24_c_laboratorio from far_laboratorio where fa24_c_laboratorio='".$array_linha[1]."'";
 $result2 = pg_query($sql2) or die("erro");
 $linhas=pg_num_rows($result2);
 if($array_linha[1]!=""){
  if($linhas==0){   
     $sql4 = "INSERT INTO far_laboratorio (fa24_i_codigo,fa24_c_laboratorio)
           VALUES(nextval('far_laboratorio_fa24_codigo_seq'),'$array_linha[1]')
          ";
     echo".";
     $result4 = pg_query($sql4) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
  }
 }
}

echo"\n Tabela far_laboratoriomed.";
$ponteiro = fopen("controleespecial.txt","r");

while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[0] = trim(strtoupper(maiusculo(TiraAcento($array_linha[0]))));
 $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));

 $sql7  ="select fa14_i_codigo from far_medanvisa where fa14_c_medanvisa='".$array_linha[0]."'";
 $result7 = pg_query($sql7) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql7);
 $linhas7=pg_num_rows($result7);
 @$med= pg_result($result7,0,0);

 $sql9  ="select fa24_i_codigo from far_laboratorio where fa24_c_laboratorio='".$array_linha[1]."'";
 $result9 = pg_query($sql9) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql9);
 $linhas9=pg_num_rows($result9);
 @$for= pg_result($result9,0,0);

  if(trim($linha)!=""){
   $sql15  ="select fa32_i_medanvisa,fa32_i_laboratorio from far_laboratoriomed where  fa32_i_medanvisa=$med and fa32_i_laboratorio=$for";
   $result15 = pg_query($sql15) or die("erro");
   $linhas15=pg_num_rows($result15);
    if($linhas15==0) {
     $sql11 = "INSERT INTO far_laboratoriomed (fa32_i_codigo,fa32_i_medanvisa,fa32_i_laboratorio)
              VALUES(nextval('far_laboratoriomed_fa32_codigo_seq'),$med,$for)";
     echo".";
     $result11 = pg_query($sql11) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql11);
    }
  }
}


//////////medreferencia
echo"\n Tabela far_medreferencia.";
$ponteiro = fopen("controleespecial.txt","r");
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
 $sql2  ="select fa19_c_medreferencia from far_medreferencia where fa19_c_medreferencia='".$array_linha[2]."'";
 $result2 = pg_query($sql2) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql2);
 $linhas=pg_num_rows($result2);
 if($array_linha[2]!=""){
  if($linhas==0){   
     $sql4 = "INSERT INTO far_medreferencia (fa19_i_codigo,fa19_c_medreferencia)
           VALUES(nextval('far_medreferencia_fa19_codigo_seq'),'$array_linha[2]')
          ";
     echo".";
     $result4 = pg_query($sql4) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
  }
 }
}

echo"\n Tabela far_medreferenciamed.";
$ponteiro = fopen("controleespecial.txt","r");

while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[0] = trim(strtoupper(maiusculo(TiraAcento($array_linha[0]))));
 $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));

 $sql7  ="select fa14_i_codigo from far_medanvisa where fa14_c_medanvisa='".$array_linha[0]."'";
 $result7 = pg_query($sql7) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
 $linhas7=pg_num_rows($result7);
 @$med= pg_result($result7,0,0);

 $sql9  ="select fa19_i_codigo from far_medreferencia where fa19_c_medreferencia='".$array_linha[2]."'";
 $result9 = pg_query($sql9) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql9);
 $linhas9=pg_num_rows($result9);
 @$for= pg_result($result9,0,0);

  if(trim($linha)!=""){
   $sql15  ="select fa34_i_medanvisa,fa34_i_medreferencia from far_medreferenciamed where  fa34_i_medanvisa=$med and fa34_i_medreferencia=$for";
   $result15 = pg_query($sql15) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql15);
   $linhas15=pg_num_rows($result15);
    if($linhas15==0) {
      $sql11 = "INSERT INTO far_medreferenciamed (fa34_i_codigo,fa34_i_medanvisa,fa34_i_medreferencia)
              VALUES(nextval('far_medreferenciamed_fa34_codigo_seq'),$med,$for)";
      echo".";
      $result11 = pg_query($sql11) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql1);
    }
  }
}


//////////prescricao
echo"\n Tabela far_prescricaomedica.";
$ponteiro = fopen("controleespecial.txt","r");
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[5] = trim(strtoupper(maiusculo(TiraAcento($array_linha[5]))));
 $sql2  ="select fa20_c_prescricao from far_prescricaomedica where fa20_c_prescricao='".$array_linha[5]."'";
 $result2 = pg_query($sql2) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql2);
 $linhas=pg_num_rows($result2);
 if($array_linha[5]!=""){
  if($linhas==0){   
     $sql4 = "INSERT INTO far_prescricaomedica (fa20_i_codigo,fa20_c_prescricao)
           VALUES(nextval('far_prescricaomedica_fa20_codigo_seq'),'$array_linha[5]')                           
           ";
     echo".";
     $result4 = pg_query($sql4) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
  }
 }
}

echo"\n Tabela far_prescricaomed.";
$ponteiro = fopen("controleespecial.txt","r");

while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[0] = trim(strtoupper(maiusculo(TiraAcento($array_linha[0]))));
 $array_linha[5] = trim(strtoupper(maiusculo(TiraAcento($array_linha[5]))));

 $sql7  ="select fa14_i_codigo from far_medanvisa where fa14_c_medanvisa='".$array_linha[0]."'";
 $result7 = pg_query($sql7) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql7);
 $linhas7=pg_num_rows($result7);
 @$med= pg_result($result7,0,0);

 $sql9  ="select fa20_i_codigo from far_prescricaomedica where fa20_c_prescricao='".$array_linha[5]."'";
 $result9 = pg_query($sql9) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql9);
 $linhas9=pg_num_rows($result9);
 @$for= pg_result($result9,0,0);

  if(trim($linha)!=""){
   $sql15  ="select fa31_i_medanvisa,fa31_i_prescricao from far_prescricaomed where  fa31_i_medanvisa=$med and fa31_i_prescricao=$for";
   $result15 = pg_query($sql15) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql15);
   $linhas15=pg_num_rows($result15);
    if($linhas15==0) {
     $sql11 = "INSERT INTO far_prescricaomed (fa31_i_codigo,fa31_i_medanvisa,fa31_i_prescricao)
              VALUES(nextval('far_prescricaomed_fa31_codigo_seq'),$med,$for)";
      echo".";
      $result11 = pg_query($sql11) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql11);
    }
  }
}

//////////listacontrolado
echo"\n Tabela far_listacontrolado.";
$ponteiro = fopen("controleespecial.txt","r");
while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[6] = trim(strtoupper(maiusculo(TiraAcento($array_linha[6]))));
 $sql2  ="select fa15_c_listacontrolado from far_listacontrolado where fa15_c_listacontrolado='".$array_linha[6]."'";
 $result2 = pg_query($sql2) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql2);
 $linhas=pg_num_rows($result2);
 if($array_linha[6]!=""){
  if($linhas==0){   
     $sql4 = "INSERT INTO far_listacontrolado (fa15_i_codigo,fa15_c_listacontrolado)
           VALUES(nextval('far_listacontrolado_fa15_codigo_seq'),'$array_linha[6]')
          ";
     echo".";
     $result4 = pg_query($sql4) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
  }
 }
}

echo"\n Tabela far_listacontroladomed.";
$ponteiro = fopen("controleespecial.txt","r");

while (!feof($ponteiro)){
 $linha = fgets($ponteiro,370);
 $array_linha = explode("|",$linha);
 $array_linha[0] = trim(strtoupper(maiusculo(TiraAcento($array_linha[0]))));
 $array_linha[6] = trim(strtoupper(maiusculo(TiraAcento($array_linha[6]))));

 $sql7  ="select fa14_i_codigo from far_medanvisa where fa14_c_medanvisa='".$array_linha[0]."'";
 $result7 = pg_query($sql7) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql7);
 $linhas7=pg_num_rows($result7);
 @$med= pg_result($result7,0,0);

 $sql9  ="select fa15_i_codigo from far_listacontrolado where fa15_c_listacontrolado='".$array_linha[6]."'";
 $result9 = pg_query($sql9) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql9);
 $linhas9=pg_num_rows($result9);
 @$for= pg_result($result9,0,0);

  if(trim($linha)!=""){
   $sql15  ="select fa35_i_medanvisa,fa35_i_listacontrolado from far_listacontroladomed where fa35_i_listacontrolado=$for and fa35_i_medanvisa=$med";
   $result15 = pg_query($sql15) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql15);
   $linhas15=pg_num_rows($result15);
    if($linhas15==0) {
    $sql11 = "INSERT INTO far_listacontroladomed (fa35_i_codigo,fa35_i_listacontrolado,fa35_i_medanvisa)
              VALUES(nextval('far_listacontroladomed_fa35_codigo_seq'),$for,$med)";
     echo(".");
     $result11 = pg_query($sql11) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql11);
    }
  }
}
echo"\n\n Processo concluido com sucesso! \n";
pg_exec("commit");
?>
