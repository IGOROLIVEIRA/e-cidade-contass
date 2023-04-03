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
  db_log("Escolas 51,52,53,54,55,56,57,58,59 devem estar previamente cadastradas no sistema para proseeguir a migração dos dados. Migração abortada!", $sArquivoLog, 0, true, true);
  db_log("\n ", $sArquivoLog, 0, true, true);
  pg_query("rollback");
  exit;

}

$dir = "Historicos1/";
db_log("Iniciando inclusao de historicos!", $sArquivoLog, 0, true, true);
// Abre um diretorio conhecido, e faz a leitura de seu conteudo
if(is_dir($dir)){
  if($dh = opendir($dir)){

    while((($file = readdir($dh)) !== false)){

      $extension = explode( ".", $file );
      if($file != "." && $file != ".." && @$extension[1] == "txt" ){

        $filename = $dir.$file;
        registro_historico( $filename, $sArquivoLog );

      }

    }
    closedir($dh);
  }

}else{

  echo "\n\n  DiretÃ³rio invÃ¡lido \n\n ";
  exit;

}

function CodigoAlunoDbportal($id_infotec,$cod_arquivo){

  $sql = "SELECT id_dbportal FROM tmp_aluno WHERE id_infotec = $id_infotec AND codarquivo = $cod_arquivo";
  $result = pg_query($sql);
  if(!$result){
   die($sql);
  }
  return pg_result($result,0,0);

}

function CodigoCursoDbportal($codserie){

  $sql = "SELECT ed11_i_ensino FROM serie WHERE ed11_i_codigo = $codserie";
  $result = pg_query($sql);
  if(!$result){
   die($sql);
  }
  return pg_result($result,0,0);

}

function CodigoSerieDbportal($id_infotec){

  $sql = "SELECT id_dbportal FROM tmp_serie WHERE id_infotec = $id_infotec";
  $result = pg_query($sql);
  if(!$result){
   die($sql);
  }
  return pg_result($result,0,0);

}

function EscolaDbportal($id_infotec,$cod_arquivo){

  $sql = "SELECT id_dbportal,tipo FROM tmp_escola WHERE id_infotec = $id_infotec AND escola = $cod_arquivo";
  $result = pg_query($sql);
  if(!$result){
   die($sql);
  }
  $retorno["codescola"] = pg_result($result,0,0);
  $retorno["tipo"] = pg_result($result,0,1);
  return $retorno;

}

function CodigoDisciplinaDbportal($id_infotec,$cod_arquivo,$curso){

  $sql = "SELECT id_dbportal FROM tmp_disciplina WHERE id_infotec = $id_infotec AND escola = $cod_arquivo";
  $result = pg_query($sql);
  if(!$result){
   die($sql);
  }
  $id_dbportal = pg_result($result,0,0);
  $sql1 = "SELECT ed12_i_codigo FROM disciplina WHERE ed12_i_caddisciplina = $id_dbportal AND ed12_i_ensino = $curso";
  $result1 = pg_query($sql1);
  if(!$result1){
   die($sql1);
  }
  return pg_result($result1,0,0);

}

function InsereTabHistorico($cod_arquivo,$CodigoAlunoDbportal,$CodigoCursoDbportal){

  $sql_insert = "INSERT INTO historico
                  (ed61_i_codigo
                  ,ed61_i_escola
                  ,ed61_i_aluno
                  ,ed61_i_curso
                  ,ed61_t_obs
                  ,ed61_i_anoconc
                  ,ed61_i_periodoconc)
                 VALUES
                  (nextval('historico_ed61_i_codigo_seq')
                  ,$cod_arquivo
                  ,$CodigoAlunoDbportal
                  ,$CodigoCursoDbportal
                  ,''
                  ,null
                  ,null)
                ";
  return $sql_insert;

}

function InsereTabHistoricomps($codigohistorico,$codigoescola,$codigoserie,$turma,$ano,$dias){

  $sql_insert = "INSERT INTO historicomps
                  (ed62_i_codigo
                  ,ed62_i_historico
                  ,ed62_i_escola
                  ,ed62_i_serie
                  ,ed62_i_turma
                  ,ed62_i_justificativa
                  ,ed62_i_anoref
                  ,ed62_i_periodoref
                  ,ed62_c_resultadofinal
                  ,ed62_c_situacao
                  ,ed62_i_qtdch
                  ,ed62_i_diasletivos
                  ,ed62_c_minimo)
                 VALUES
                  (nextval('historicomps_ed62_i_codigo_seq')
                  ,$codigohistorico
                  ,$codigoescola
                  ,$codigoserie
                  ,'$turma'
                  ,null
                  ,$ano
                  ,0
                  ,''
                  ,'CONCLUÍDO'
                  ,null
                  ,$dias
                  ,'60')
                ";
  return $sql_insert;

}

function InsereTabHistoricompsfora($codigohistorico,$codigoescola,$codigoserie,$turma,$ano,$dias){

  $sql_insert = "INSERT INTO historicompsfora
                  (ed99_i_codigo
                  ,ed99_i_historico
                  ,ed99_i_escolaproc
                  ,ed99_i_serie
                  ,ed99_c_turma
                  ,ed99_i_justificativa
                  ,ed99_i_anoref
                  ,ed99_i_periodoref
                  ,ed99_c_resultadofinal
                  ,ed99_c_situacao
                  ,ed99_i_qtdch
                  ,ed99_i_diasletivos
                  ,ed99_c_minimo)
                 VALUES
                  (nextval('historicompsfora_ed99_i_codigo_seq')
                  ,$codigohistorico
                  ,$codigoescola
                  ,$codigoserie
                  ,'$turma'
                  ,null
                  ,$ano
                  ,0
                  ,''
                  ,'CONCLUÍDO'
                  ,null
                  ,$dias
                  ,'60')
                ";
  return $sql_insert;

}

function InsereTabHistmpsdisc($codigoserie,$codigodisciplina,$linha_ch,$linha_rf,$linha_nota){

  $sql_insert = "INSERT INTO histmpsdisc
                  (ed65_i_codigo
                  ,ed65_i_historicomps
                  ,ed65_i_disciplina
                  ,ed65_i_justificativa
                  ,ed65_i_qtdch
                  ,ed65_c_resultadofinal
                  ,ed65_t_resultobtido
                  ,ed65_c_situacao
                  ,ed65_c_tiporesultado
                  ,ed65_i_ordenacao)
                 VALUES
                  (nextval('histmpsdisc_ed65_i_codigo_seq')
                  ,$codigoserie
                  ,$codigodisciplina
                  ,null
                  ,$linha_ch
                  ,'$linha_rf'
                  ,'$linha_nota'
                  ,'CONCLUÍDO'
                  ,'N'
                  ,0)
                ";
  return $sql_insert;

}

function InsereTabHistmpsdiscfora($codigoserie,$codigodisciplina,$linha_ch,$linha_rf,$linha_nota){

  $sql_insert = "INSERT INTO histmpsdisc
                  (ed100_i_codigo
                  ,ed100_i_historicompsfora
                  ,ed100_i_disciplina
                  ,ed100_i_justificativa
                  ,ed100_i_qtdch
                  ,ed100_c_resultadofinal
                  ,ed100_t_resultobtido
                  ,ed100_c_situacao
                  ,ed100_c_tiporesultado
                  ,ed100_i_ordenacao)
                 VALUES
                  (nextval('histmpsdisc_ed65_i_codigo_seq')
                  ,$codigoserie
                  ,$codigodisciplina
                  ,null
                  ,$linha_ch
                  ,'$linha_rf'
                  ,'$linha_nota'
                  ,'CONCLUÍDO'
                  ,'N'
                  ,0)
                ";
  return $sql_insert;

}

function registro_historico( $filename, $sArquivoLog ){

  $cod_arquivo = substr($filename,12,2);
  $ponteiro = fopen($filename,"r");
  while (!feof($ponteiro)){

    $linha = fgets($ponteiro,100);
    if($linha == "" ){

       continue;

    }
    $array_linha = explode("|",$linha);
    $linha_escola      = trim($array_linha[0]);    //Escola
    $linha_ano         = trim($array_linha[1]);    //Ano Letivo
    $linha_dias        = trim($array_linha[2]);    //Dias Letivos
    $linha_serie       = trim($array_linha[3]);    //Série
    $linha_turma       = trim($array_linha[4]);    //Turma
    $linha_disciplina  = trim($array_linha[5]);    //Disciplina
    $linha_nota        = trim($array_linha[6]);    //Nota
    $linha_rf          = trim($array_linha[7]);    //Resultado Final
    $linha_ch          = trim($array_linha[8]);    //Carga Horária
    $linha_matricula   = trim($array_linha[9]);    //Matrícula
    $linha_conceito    = trim($array_linha[10]);   //Conceito - DESCARTADO
    $linha_escolaatual = trim($array_linha[11]);   //Escola_Atual - DESCARTADO
    $linha_grau        = trim($array_linha[12]);   //Grau - DESCARTADO
    $CodigoAlunoDbportal = CodigoAlunoDbportal($linha_matricula,$cod_arquivo);
    $CodigoSerieDbportal = CodigoSerieDbportal($linha_serie);
    $CodigoCursoDbportal = CodigoCursoDbportal($CodigoSerieDbportal);
    $EscolaDbportal = EscolaDbportal($linha_escola,$cod_arquivo);


    ///////////////TAB HISTORICO
    $sql_historico = "SELECT ed61_i_codigo
                      FROM historico
                      WHERE ed61_i_aluno = $CodigoAlunoDbportal
                      AND ed61_i_curso = $CodigoCursoDbportal";
    $result_historico = pg_query($sql_historico);
    if(pg_num_rows($result_historico)==0){

      $res_insert = pg_query(InsereTabHistorico($cod_arquivo,$CodigoAlunoDbportal,$CodigoCursoDbportal));
      if(!$res_insert){

        db_log("ERRO: $cod_arquivo - $linha_matricula", $sArquivoLog, 0, true, true);

      }else{

        $res_ultimo = pg_query("SELECT last_value FROM historico_ed61_i_codigo_seq");
        $CodigoHistorico = pg_result($res_ultimo,0,0);

      }
      db_log("INSERIDO historico $CodigoHistorico - Escola $cod_arquivo", $sArquivoLog, 0, true, true);

    }else{

     $CodigoHistorico = pg_result($result_historico,0,0);

    }



    ///////////////TABS HISTORICOMPS e HISTORICOMPSFORA
    if($EscolaDbportal["tipo"]=="R"){
      ///////////////TABS HISTORICOMPS
      $sql_historicomps = "SELECT ed62_i_codigo
                           FROM historicomps
                            inner join historico on ed61_i_codigo = ed62_i_historico
                           WHERE ed61_i_aluno = $CodigoAlunoDbportal
                           AND ed61_i_curso = $CodigoCursoDbportal
                           AND ed62_i_serie = $CodigoSerieDbportal
                           AND ed62_i_anoref = $linha_ano";
      $result_historicomps = pg_query($sql_historicomps);
      if(pg_num_rows($result_historicomps)==0){

	$res_insert = pg_query(InsereTabHistoricomps($CodigoHistorico,$EscolaDbportal["codescola"],$CodigoSerieDbportal,$linha_turma,$linha_ano,$linha_dias));
	if(!$res_insert){

	  db_log("ERRO: $cod_arquivo - $linha_matricula", $sArquivoLog, 0, true, true);

	}else{

	  $res_ultimo = pg_query("SELECT last_value FROM historicomps_ed62_i_codigo_seq");
	  $CodigoHistoricoSerie = pg_result($res_ultimo,0,0);

	}

      }else{

	$CodigoHistoricoSerie = pg_result($result_historicomps,0,0);

      }

    }else{
      ///////////////TABS HISTORICOMPSFORA
      $sql_historicompsfora = "SELECT ed99_i_codigo
                               FROM historicompsfora
                                inner join historico on ed61_i_codigo = ed99_i_historico
                               WHERE ed61_i_aluno = $CodigoAlunoDbportal
                               AND ed61_i_curso = $CodigoCursoDbportal
                               AND ed99_i_serie = $CodigoSerieDbportal
                               AND ed99_i_anoref = $linha_ano";
      $result_historicompsfora = pg_query($sql_historicompsfora);
      if(pg_num_rows($result_historicompsfora)==0){

	$res_insert = pg_query(InsereTabHistoricompsfora($CodigoHistorico,$EscolaDbportal["codescola"],$CodigoSerieDbportal,$linha_turma,$linha_ano,$linha_dias));
	if(!$res_insert){

	  db_log("ERRO: $cod_arquivo - $linha_matricula", $sArquivoLog, 0, true, true);

	}else{

	  $res_ultimo = pg_query("SELECT last_value FROM historicompsfora_ed99_i_codigo_seq");
	  $CodigoHistoricoSerie = pg_result($res_ultimo,0,0);

	}

      }else{

	$CodigoHistoricoSerie = pg_result($result_historicompsfora,0,0);

      }

    }

    ///////////////TABS HISTMPSDISC e HISTMPSDISCFORA
    $CodigoDisciplinaDbportal = CodigoDisciplinaDbportal($linha_disciplina,$cod_arquivo,$CodigoCursoDbportal);
    if($EscolaDbportal["tipo"]=="R"){
      ///////////////TABS HISTMPSDISC
      $sql_histmpsdisc = "SELECT ed65_i_codigo
                          FROM histmpsdisc
                           inner join historicomps on ed62_i_codigo = ed65_i_historicomps
                           inner join historico on ed61_i_codigo = ed62_i_historico
                          WHERE ed61_i_aluno = $CodigoAlunoDbportal
                          AND ed61_i_curso = $CodigoCursoDbportal
                          AND ed62_i_serie = $CodigoSerieDbportal
                          AND ed62_i_anoref = $linha_ano
                          AND ed65_i_disciplina = $CodigoDisciplinaDbportal";
      $result_histmpsdisc = pg_query($sql_histmpsdisc);
      if(pg_num_rows($result_histmpsdisc)==0){

	$res_insert = pg_query(InsereTabHistmpsdisc($CodigoHistoricoSerie,$CodigoDisciplinaDbportal,$linha_ch,$linha_rf,$linha_nota));
	if(!$res_insert){

	  db_log("ERRO: $cod_arquivo - $linha_matricula", $sArquivoLog, 0, true, true);

	}

      }

    }else{

      ///////////////TABS HISTMPSDISCFORA
      $sql_histmpsdiscfora = "SELECT ed100_i_codigo
                              FROM histmpsdiscfora
                               inner join historicompsfora on ed99_i_codigo = ed100_i_historicompsfora
                               inner join historico on ed61_i_codigo = ed99_i_historico
                              WHERE ed61_i_aluno = $CodigoAlunoDbportal
                              AND ed61_i_curso = $CodigoCursoDbportal
                              AND ed99_i_serie = $CodigoSerieDbportal
                              AND ed99_i_anoref = $linha_ano
                              AND ed100_i_disciplina = $CodigoDisciplinaDbportal";
      $result_histmpsdiscfora = pg_query($sql_histmpsdiscfora);
      if(pg_num_rows($result_histmpsdiscfora)==0){

	$res_insert = pg_query(InsereTabHistmpsdisc($CodigoHistoricoSerie,$CodigoDisciplinaDbportal,$linha_ch,$linha_rf,$linha_nota));
	if(!$res_insert){

	  db_log("ERRO: $cod_arquivo - $linha_matricula", $sArquivoLog, 0, true, true);

	}

      }

    }
  }
  db_log("ESCOLA $cod_arquivo encerrada", $sArquivoLog, 0, true, true);
  fclose($ponteiro);

}

pg_exec("commit");

// Final do Script
db_log("Processo inclusao de historicos encerrado", $sArquivoLog, 0, true, true);
db_log("\n ", $sArquivoLog, 0, true, true);
include(__DIR__ . "/../../libs/db_final_script.php");
?>