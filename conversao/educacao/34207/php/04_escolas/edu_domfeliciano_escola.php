<?

// Seta Nome do Script
$sNomeScript = basename(__FILE__);

require (__DIR__ . "/../../libs/db_conecta.php");

db_log("\n ", $sArquivoLog, 0, true, true);
db_log("Conectando", $sArquivoLog, 0, true, true);
db_log("\n ", $sArquivoLog, 0, true, true);
pg_query($pConexaoDestino1,"select fc_startsession()");
pg_query($pConexaoDestino1,"begin");
system("clear");
set_time_limit(0);

$naotem = false;
for($dd=51;$dd<=59;$dd++){

  $verif_escola = pg_query("SELECT ed18_i_codigo from escola WHERE ed18_i_codigo = $dd");
  if(pg_num_rows($verif_escola)==0){

    $naotem = true;
    break;

  }

}
if($naotem==true){

  db_log("\n ", $sArquivoLog, 0, true, true);
  db_log("Escolas 51,52,53,54,55,56,57,58,59 devem estar previamente cadastradas no sistema para proseeguir a migraчуo dos dados. Migraчуo abortada.", $sArquivoLog, 0, true, true);
  db_log("\n ", $sArquivoLog, 0, true, true);
  pg_exec("rollback");
  exit;

}

$var_erro = false;

$dir = "Escolas/";
db_log("Iniciando inclusao de escolaproc.", $sArquivoLog, 0, true, true);

$ponteiro = fopen($dir."dados_iniciais.txt","r");
while (!feof($ponteiro)){

  $linha = fgets($ponteiro,200);
  if(trim($linha)!=""){

    $insert_registros = pg_query(trim($linha));
    if(!$insert_registros){

      $var_erro = true;
      break;

    }

  }

}
db_log("Processo inclusao de escolaproc encerrado.", $sArquivoLog, 0, true, true);

db_log("Criaчуo de tabela temporсria tmp_escola.", $sArquivoLog, 0, true, true);
$tmp_escola = pg_query("CREATE TABLE tmp_escola (id_infotec integer,id_dbportal integer,tipo char(1),escola integer)");
$ponteiro = fopen($dir."migra_escola.txt","r");
while (!feof($ponteiro)){

  $linha = fgets($ponteiro,600);
  if(trim($linha)!=""){

    $array_linha = explode("|",$linha);
    $array_linha[0] = trim($array_linha[0]);//id_dbportal
    $array_linha[5] = trim($array_linha[1]);//tipo
    $array_linha[5] = trim($array_linha[2]);//escola
    $array_linha[5] = trim($array_linha[4]);//id_infotec
    $sql1 = "INSERT INTO tmp_escola VALUES ($array_linha[4],$array_linha[0],'$array_linha[1]',$array_linha[2])";
    $insert_tmp_escola = pg_query($sql1);
    if(!$insert_tmp_escola){

      $var_erro = true;
      break;

    }

  }

}
fclose($ponteiro);

if($var_erro == true){

  pg_exec("rollback");
  db_log("Processo abortado por erro.", $sArquivoLog, 0, true, true);

}else{

  pg_exec("commit");
  db_log("Processo encerrado.", $sArquivoLog, 0, true, true);

}

// Final do Script
db_log("\n ", $sArquivoLog, 0, true, true);
include(__DIR__ . "/../../libs/db_final_script.php");
?>