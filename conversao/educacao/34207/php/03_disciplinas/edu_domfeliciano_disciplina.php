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

$dir = "Disciplinas/";
db_log("Iniciando inclusao de caddisciplinas.", $sArquivoLog, 0, true, true);

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
db_log("Processo inclusao de caddisciplinas encerrado.", $sArquivoLog, 0, true, true);

db_log("Iniciando inclusao de disciplinas.", $sArquivoLog, 0, true, true);
$contt = 1;
for($tt=1;$tt<=4;$tt++){

  for($dd=1;$dd<=35;$dd++){

    $sql_disciplina = "INSERT INTO disciplina VALUES ($contt,$tt,$dd)";
    $insert_disciplina = pg_query($sql_disciplina);
    if(!$insert_disciplina){

      $var_erro = true;
      break;

    }
    if($var_erro==true){

      break;

    }
    $contt++;

  }

}
$alter_disciplina = pg_query("ALTER SEQUENCE caddisciplina_ed232_i_codigo_seq START 141");
if(!$alter_disciplina){
 $var_erro = true;
}
db_log("Processo inclusao de disciplinas encerrado.", $sArquivoLog, 0, true, true);

db_log("Criaчуo de tabela temporсria tmp_disciplina.", $sArquivoLog, 0, true, true);
$tmp_disciplina = pg_query("CREATE TABLE tmp_disciplina (id_infotec integer,id_dbportal integer,escola integer)");
$ponteiro = fopen($dir."migra_disciplina.txt","r");
while (!feof($ponteiro)){

  $linha = fgets($ponteiro,47);
  if(trim($linha)!=""){

    $array_linha = explode("|",$linha);
    $array_linha[0] = trim($array_linha[0]);
    $array_linha[4] = trim($array_linha[4]);
    $array_linha[5] = trim($array_linha[5]);
    $sql1 = "INSERT INTO tmp_disciplina VALUES ($array_linha[0],$array_linha[4],$array_linha[5])";
    $insert_tmp_disciplina = pg_query($sql1);
    if(!$insert_tmp_disciplina){

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