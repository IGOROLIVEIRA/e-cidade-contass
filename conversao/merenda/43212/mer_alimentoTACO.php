<?
set_time_limit(0);
//include(__DIR__ . "/../../../libs/db_conn.php");
$DB_SERVIDOR = "localhost";
$DB_BASE     = "cmmirabela";
$DB_USUARIO  = "dbportal";
$DB_SENHA    = "";
$DB_PORTA    = "5432";

if (!($conn = pg_connect('host='.$DB_SERVIDOR.' dbname='.$DB_BASE.' user='.$DB_USUARIO.' password='.$DB_SENHA.' port='.$DB_PORTA))) {

 echo "Erro ao conectar...\n\n";
 exit;

}
 
echo "conectado...\n\n";
pg_query($conn, "SELECT fc_startsession()");

function maiusculo(&$string) {

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

function TiraAcento($string) {

  set_time_limit(240);
  $acentos      = 'áéíóúÁÉÍÓÚàÀÂâÊêôÔüÜïÏöÖñÑãÃõÕçÇªºäÄ\'';
  $letras       = 'AEIOUAEIOUAAAAEEOOUUIIOONNAAOOCCAOAA ';
  $new_string = '';
  for ($x = 0;  $x < strlen($string); $x++) { 

    $let = substr($string, $x, 1);
    for ($y = 0; $y < strlen($acentos); $y++) {

       if ($let == substr($acentos, $y, 1)) {

         $let=substr($letras, $y, 1);
         break;

       }

    }
    $new_string = $new_string . $let;

 }
 return $new_string;
}

function Progresso($linha,$total,$dado1,$dado2,$titulo) {

  $linha++;
  $percent = ($linha/$total)*100;
  $percorrido = floor($percent);
  $restante = 100-$percorrido;
  $tracos = "";
  for ($t = 0; $t < $percorrido; $t++) {
    $tracos .= "#";
  }
  $brancos = "";
  for ($t = 0; $t < $restante; $t++) {
    $brancos .= ".";
  }
  echo " $titulo";
  echo " $linha de $total registros.\n";
  echo " [".$tracos.$brancos."] ".number_format($percent,2,".",".")."%\n";
  if ($titulo != " PROGRESSÃO TOTAL DA TAREFA") {
    echo " ---> ".trim($dado1)." -- ".trim($dado2)."\n";
  }

}

echo " ->Iniciando processo...";
sleep(1);
system("clear");
pg_exec("begin");

$cont = 0;
$erro = false;
$ponteiro = fopen("foods.txt","r");
while (!feof($ponteiro)) {

  $linha = fgets($ponteiro,190);
  if (trim($linha)!="") {

    $array_linha    = explode("|",$linha);
    $array_linha[0] = trim(strtoupper(maiusculo(TiraAcento($array_linha[0]))));
    $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
    $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
    $array_linha[3] = trim(strtoupper(maiusculo(TiraAcento($array_linha[3]))));
    $array_linha[1] = str_replace("'","",$array_linha[1]);
    $array_linha[1] = str_replace("*","",$array_linha[1]);
    $array_linha[2] = str_replace("'","",$array_linha[2]);
    $array_linha[2] = str_replace("*","",$array_linha[2]);
    $array_linha[3] = str_replace("'","",$array_linha[3]);
    $array_linha[3] = str_replace("*","",$array_linha[3]);
    $array_linha[2] = $array_linha[2]=="NULL"?"":$array_linha[2];
    $sql2           = "select me30_i_codigo from mer_grupoalimento where me30_c_descricao = '".$array_linha[3]."'";
    $result2        = pg_query($sql2);
    $linhas2         = pg_num_rows($result2);
    if ($linhas2==0) {
     
      $rsGrupo = pg_query("SELECT nextval('mer_grupoalimento_me30_codigo_seq')");
      $me30_i_codigo = pg_result($rsGrupo,0,0);
      $sql3 = "INSERT INTO mer_grupoalimento(me30_i_codigo,me30_c_descricao)
               VALUES($me30_i_codigo,'$array_linha[3]')
              ";
      $result3 = pg_query($sql3);

    } else {
      $me30_i_codigo = pg_result($result2,0,0);
    }
    $sql4    = "select me35_i_codigo from mer_alimento where me35_c_nomealimento='".$array_linha[1]."'";
    $result4 = pg_query($sql4);
    $linhas4 = pg_num_rows($result4);
    if ($linhas4==0) {

      $sql5      = "select m61_codmatunid,m61_descr from matunid where m61_descr = 'GRAMA' OR m61_descr = 'GRAMAS'";
      $result5   =  pg_query($sql5);
      $linhas5   = pg_num_rows($result5);
      if ($linhas5==0) {

        $rsUnidade = pg_query("SELECT nextval('matunid_m61_codmatunid_seq')");
        $m61_codmatunid = pg_result($rsUnidade,0,0);
        $sql6 = "INSERT INTO matunid (m61_codmatunid,m61_descr,m61_usaquant,m61_abrev,m61_usadec)
                 VALUES($m61_codmatunid,'GRAMA','f','G','t')";
        $result6 = pg_query($sql6);

      } else {
        $m61_codmatunid = pg_result($result5,0,0);
      }
      $sql7 = "INSERT INTO mer_alimento(me35_i_codigo,me35_c_nomealimento,me35_c_nomecientifico,me35_i_grupoalimentar,me35_c_fonteinformacao,me35_i_id,me35_i_unidade,me35_c_quant)
               VALUES(nextval('mer_alimento_me35_i_codigo_seq'),'$array_linha[1]','$array_linha[2]',$me30_i_codigo, 'Tabela Brasileira de Composição de Alimentos - TACO',$array_linha[0],$m61_codmatunid,100)
              ";
      $result7 = pg_query($sql7);
      if ($result7==false) {

        echo "ERRO: ".$sql7;
        $erro = true;
        break;

      }

    }

  }
  system("clear");
  echo Progresso($cont,495,$array_linha[0],$array_linha[1]," PROGRESSÃO MER_ALIMENTO:");
  $cont++;

}
fclose($ponteiro);

if($erro==false){

  $cont1 = 0;
  $erro1 = false;
  $ponteiro = fopen("nutrientes.txt","r");
  while (!feof($ponteiro)) {

    $linha = fgets($ponteiro,90);
    if (trim($linha)!="") {

      $array_linha    =  explode("|",$linha);
      $array_linha[0] =  trim(strtoupper(maiusculo(TiraAcento($array_linha[0]))));
      $array_linha[1] =  trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
      $array_linha[2] =  trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
      $array_linha[2] = str_replace("_","",$array_linha[2]);
      $sql1           = "select me09_i_codigo from mer_nutriente where me09_c_descr='".$array_linha[1]."'";
      $result1        =  pg_query($sql1);
      $linhas1        = pg_num_rows($result1);
      if ($linhas1==0) {

        $aUnidades = array("G"=>"GRAMA","KCAL"=>"KILOCALORIA","MG"=>"MILIGRAMA","KJ"=>"KILOJOULE","MCG"=>"MICROGRAMA","IU"=>"IU","MCGRAE"=>"MICROGRAMA RAE","MCGDFE"=>"MICROGRAMA DFE",);
        $descrunidade = trim($aUnidades[$array_linha[2]]);
        $abrevunidade = trim($array_linha[2]);
        $sql2      = "select m61_codmatunid,m61_descr from matunid where m61_descr = '$descrunidade'";
        $result2   =  pg_query($sql2);
        $linhas2   = pg_num_rows($result2);
        if ($linhas2==0) {

          $rsUnidade = pg_query("SELECT nextval('matunid_m61_codmatunid_seq')");
          $m61_codmatunid = pg_result($rsUnidade,0,0);
          $sql3 = "INSERT INTO matunid (m61_codmatunid,m61_descr,m61_usaquant,m61_abrev,m61_usadec)
                   VALUES($m61_codmatunid,'$descrunidade','f','$abrevunidade','t')";
          $result3 = pg_query($sql3);

        } else {
          $m61_codmatunid = pg_result($result2,0,0);
        }
        $sql4 = "INSERT INTO mer_nutriente (me09_i_codigo,me09_c_descr,me09_i_unidade,me09_i_id)
                 VALUES(nextval('mernutriente_me09_codigo_seq'),'$array_linha[1]',$m61_codmatunid,$array_linha[0])";
        $result4 = pg_query($sql4) or die($sql4);
        if ($result4==false) {

          $erro1 = true;
          break;

        }

      }

    }
    system("clear");
    echo Progresso($cont1,99,$array_linha[0],$array_linha[1]," PROGRESSÃO MER_NUTRIENTE:");
    $cont1++;

  }
  fclose($ponteiro);

}

if($erro==false && $erro1==false){

  $cont2 = 0;
  $erro2 = false;
  $ponteiro = fopen("foods_components.txt","r");
  while (!feof($ponteiro)) {

    $linha = fgets($ponteiro,18);
    if (trim($linha)!="") {

      $array_linha    = explode("|",$linha);
      $array_linha[0] = trim(strtoupper(maiusculo(TiraAcento($array_linha[0]))));
      $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
      $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
      $sql1           = "select me35_i_codigo from mer_alimento where me35_i_id='".$array_linha[0]."'";
      $result1        =  pg_query($sql1);
      $linhas1        = pg_num_rows($result1);
      if ($linhas1 > 0) {

        $cod_alimento = pg_result($result1,0,0);
        $sql2         = "select me09_i_codigo from mer_nutriente where me09_i_id='".$array_linha[1]."'";
        $result2      =  pg_query($sql2);
        $linhas2      = pg_num_rows($result2);
        if ($linhas2 > 0) {

          $cod_nutriente = pg_result($result2,0,0);
          $sql3 = "INSERT INTO mer_infnutricional (me08_i_codigo,me08_f_quant,me08_i_nutriente,me08_i_alimento)
                   VALUES(nextval('merinfnutricional_me08_codigo_seq'),$array_linha[2],$cod_nutriente,$cod_alimento)";
          $result3 = pg_query($sql3);
          if ($result3==false) {

            $erro = true;
            break;

          }

        }

      }

    }
    system("clear");
    echo Progresso($cont2,15193,$array_linha[0],$array_linha[1]," PROGRESSÃO MER_INFNUTRICIONAL:");
    $cont2++;

  }
  fclose($ponteiro);

}
$result01 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 139   WHERE me07_i_codigo =29;");
$result02 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 399   WHERE me07_i_codigo =12;");
$result03 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 95    WHERE me07_i_codigo =31;");
$result04 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 133   WHERE me07_i_codigo =33;");
$result05 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 399   WHERE me07_i_codigo =34;");
$result06 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 399   WHERE me07_i_codigo =6;");
$result07 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 33    WHERE me07_i_codigo =7;");
$result08 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 158   WHERE me07_i_codigo =8;");
$result09 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 428   WHERE me07_i_codigo =9;");
$result10 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 442   WHERE me07_i_codigo =10;");
$result11 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 426   WHERE me07_i_codigo =11;");
$result12 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 427   WHERE me07_i_codigo =13;");
$result13 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 8     WHERE me07_i_codigo =14;");
$result14 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 440   WHERE me07_i_codigo =2;");
$result15 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 428   WHERE me07_i_codigo =4;");
$result16 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 399   WHERE me07_i_codigo =3;");
$result17 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 13    WHERE me07_i_codigo =5;");
$result18 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 205   WHERE me07_i_codigo =15;");
$result19 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 139   WHERE me07_i_codigo =16;");
$result20 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 95    WHERE me07_i_codigo =17;");
$result21 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 138   WHERE me07_i_codigo =18;");
$result22 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 352   WHERE me07_i_codigo =19;");
$result23 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 87    WHERE me07_i_codigo =20;");
$result24 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 4     WHERE me07_i_codigo =21;");
$result25 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 471   WHERE me07_i_codigo =22;");
$result26 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 98    WHERE me07_i_codigo =23;");
$result27 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 40    WHERE me07_i_codigo =24;");
$result28 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 427   WHERE me07_i_codigo =25;");
$result29 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 399   WHERE me07_i_codigo =26;");
$result30 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 198   WHERE me07_i_codigo =27;");
$result31 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 31    WHERE me07_i_codigo =28;");
$result32 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 138   WHERE me07_i_codigo =30;");
$result33 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 280   WHERE me07_i_codigo =32;");
$result34 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 444   WHERE me07_i_codigo =35;");
$result35 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 8     WHERE me07_i_codigo =36;");
$result36 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 389   WHERE me07_i_codigo =37;");
$result37 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 8     WHERE me07_i_codigo =38;");
$result38 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 4     WHERE me07_i_codigo =39;");
$result39 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 95    WHERE me07_i_codigo =40;");
$result40 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 138   WHERE me07_i_codigo =41;");
$result41 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 352   WHERE me07_i_codigo =42;");
$result42 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 134   WHERE me07_i_codigo =43;");
$result43 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 101   WHERE me07_i_codigo =44;");
$result44 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 399   WHERE me07_i_codigo =45;");
$result45 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 158   WHERE me07_i_codigo =46;");
$result46 = pg_query("UPDATE mer_cardapioitem SET me07_i_alimento = 8     WHERE me07_i_codigo =47;");

$result47 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),82,139);");
$result48 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),5966,399);");
$result49 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),74,95);");
$result50 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),76,133);");
$result51 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),1578,33);");
$result52 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),71,158);");
$result53 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),93,428);");
$result54 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),145,442);");
$result55 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),77,426);");
$result56 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),24,8);");
$result57 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),202,440);");
$result58 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),2686,13);");
$result59 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),205,205);");
$result60 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),72,138);");
$result61 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),68,352);");
$result62 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),78,87);");
$result63 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),179,4);");
$result64 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),88,471);");
$result65 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),70,98);");
$result66 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),86,40);");
$result67 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),97,427);");
$result68 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),191,198);");
$result69 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),81,31);");
$result70 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),147,280);");
$result71 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),2617,444);");
$result72 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),90,8);");
$result73 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),8906,389);");
$result74 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),8890,8);");
$result75 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),102,134);");
$result76 = pg_query("INSERT INTO mer_alimentomatmater VALUES(nextval('mer_alimentomatmater_me36_i_codigo_seq'),101,101);");

if($erro==true || $erro1==true || $erro2==true){

  pg_exec("rollback");
        
}else{

  echo"\n\n Processo concluido com sucesso! \n";
  pg_exec("commit");

}
?>
