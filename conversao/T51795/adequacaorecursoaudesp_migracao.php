<?php
/*
 * Flag para usar o arquivo de configuracao db_conn.php.
 */
$lConn = true;

define("CAMINHO_LIBS_PADRAO", "../../");
define("CAMINHO_LOGS_PADRAO", "./logs");

if ($lConn) {
  require_once(CAMINHO_LIBS_PADRAO."libs/db_conn.php");	
} else {
	
  $DB_USUARIO  = "postgres";
  $DB_SENHA    = "";
  $DB_SERVIDOR = ""; 
  $DB_BASE     = "";
  $DB_PORTA    = "5432";
}

require_once(CAMINHO_LIBS_PADRAO."libs/db_utils.php");
require_once(CAMINHO_LIBS_PADRAO."libs/db_libconsole.php");

$sArquivo = "./logs/log_migracao_adequacaorecursoaudesp_".date("YmdHis").".txt";

if (!file_exists(CAMINHO_LOGS_PADRAO)) {
    
  if (!$pDirLog = mkdir(CAMINHO_LOGS_PADRAO, 0777)) {
    
    echo "Erro ao criar diretorio ".CAMINHO_LOGS_PADRAO." padrao...\n";
    exit;
  }
} else {
	
	/**
	 * Log de verificação se o script já foi executado.
	 */
  db_log("",                                                                            $sArquivo, 0);
  db_log("Script PHP já foi executado (".date("d/m/Y - h:i:s", time()).")! Verifique.", $sArquivo, 0);
  db_log("",                                                                            $sArquivo, 0);
  db_log("\n",                                                                          $sArquivo, 0);
  exit;
}

db_log("",                                                                              $sArquivo, 0);
db_log("Inicio da migracao (adequacao recurso audesp): ".date("d/m/Y - h:i:s", time()), $sArquivo, 0);
db_log("",                                                                              $sArquivo, 0);

db_log("Conectando...",                                                                 $sArquivo, 0);
db_log("",                                                                              $sArquivo, 0);

/**
 * String de conexão com o banco de dados.
 */
$sConexao = "host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA";

if (!$conn1 = pg_connect($sConexao)) {
  
	db_log("Erro ao conectar...", $sArquivo, 0);
	db_log("",                    $sArquivo, 0);
  exit;
}

db_log("Processando...", $sArquivo, 0);
db_log("",               $sArquivo, 0);

try {

	db_query($conn1, "BEGIN");
	
	$sSqlStartSession = " select fc_startsession(); ";
  $rsStartSession   = db_query($conn1, $sSqlStartSession);
  
  /**
   * Armazena o sequencial da nova estrutura em uma variavel.
   */
  $sSqlNextValDbEstrutura  = "select nextval('rhestrutura_r77_codestrut_seq') as db77_codestrut";
  $rsSqlNextValDbEstrutura = db_query($conn1, $sSqlNextValDbEstrutura);
  $iNextValDbEstrutura     = db_utils::fieldsMemory($rsSqlNextValDbEstrutura, 0)->db77_codestrut;
  
  /**
   * Inclui um estrutural novo.
   */
  $sSqlInsertDbEstrutura   = "INSERT INTO db_estrutura ( db77_codestrut,         ";
  $sSqlInsertDbEstrutura  .= "                           db77_estrut,            ";
  $sSqlInsertDbEstrutura  .= "                           db77_descr,             ";
  $sSqlInsertDbEstrutura  .= "                           db77_permitesintetico   ";
  $sSqlInsertDbEstrutura  .= "                         )                         ";
  $sSqlInsertDbEstrutura  .= "                  VALUES ( {$iNextValDbEstrutura}, "; 
  $sSqlInsertDbEstrutura  .= "                           '0000',                 ";
  $sSqlInsertDbEstrutura  .= "                           'Estrutura Recurso',    "; 
  $sSqlInsertDbEstrutura  .= "                           false)                  ";
  $rsSqlInsertDbEstrutura  = db_query($conn1, $sSqlInsertDbEstrutura);
  if (!$rsSqlInsertDbEstrutura) {
    throw new Exception("Erro ao incluir registros na tabela(db_estrutura)! Verifique.");
  }
  
  db_log("Registros incluidos na tabela (db_estrutura): \n", $sArquivo, 2);
  db_log("db77_codestrut  |       db77_estrut        |            db77_descr             | db77_permitesintetico \n", $sArquivo, 2);
  db_log("----------------+--------------------------+-----------------------------------+-----------------------\n", $sArquivo, 2);
  db_log("            {$iNextValDbEstrutura} | 0000                     | Estrutura Recurso                 | f  \n", $sArquivo, 2);
  db_log("----------------+--------------------------+-----------------------------------+-----------------------\n\n", $sArquivo, 2);
  
  /**
   * Inclui o nivel do novo estrutural. 
   */
  $sSqlInsertDbEstruturaNivel   = "INSERT INTO db_estruturanivel ( db78_codestrut,         ";
  $sSqlInsertDbEstruturaNivel  .= "                                db78_nivel,             ";
  $sSqlInsertDbEstruturaNivel  .= "                                db78_descr,             ";
  $sSqlInsertDbEstruturaNivel  .= "                                db78_tamanho,           ";
  $sSqlInsertDbEstruturaNivel  .= "                                db78_inicio             ";
  $sSqlInsertDbEstruturaNivel  .= "                              )                         ";
  $sSqlInsertDbEstruturaNivel  .= "                       VALUES ( {$iNextValDbEstrutura}, ";
  $sSqlInsertDbEstruturaNivel  .= "                                0,                      ";
  $sSqlInsertDbEstruturaNivel  .= "                                'NÍVEL 1',              ";
  $sSqlInsertDbEstruturaNivel  .= "                                4,                      ";
  $sSqlInsertDbEstruturaNivel  .= "                                0)                      ";
  $rsSqlInsertDbEstruturaNivel  = db_query($conn1, $sSqlInsertDbEstruturaNivel);
  if (!$rsSqlInsertDbEstruturaNivel) {
    throw new Exception("Erro ao incluir registros na tabela(db_estruturanivel)! Verifique.");
  }
  
  db_log("Registros incluidos na tabela (db_estruturanivel): \n", $sArquivo, 2);
  db_log(" db78_codestrut | db78_nivel |  db78_descr   | db78_tamanho | db78_inicio                    \n", $sArquivo, 2);
  db_log("----------------+------------+---------------+--------------+-------------                   \n", $sArquivo, 2);
  db_log("            {$iNextValDbEstrutura} |          0 | NÍVEL 1       |            4 |           0 \n", $sArquivo, 2);
  db_log("----------------+------------+---------------+--------------+-------------                   \n\n", $sArquivo, 2);
  
  /**
   * Atualiza a nova estrutura do recurso na orcparametro.
   */
  $sSqlUpdateOrcParametro  = "UPDATE orcparametro SET o50_estruturarecurso = {$iNextValDbEstrutura}";
  $rsSqlUpdateOrcParametro = db_query($conn1, $sSqlUpdateOrcParametro);
  if (!$rsSqlUpdateOrcParametro) {
    throw new Exception("Erro ao alterar registros na tabela(orcparametro)! Verifique.");
  }
  
  db_log("Registros alterados na tabela (orcparametro) campo (o50_estruturarecurso): {$iNextValDbEstrutura} \n", $sArquivo, 2);

  db_log("Registros incluidos na tabela (db_estruturavalor): \n", $sArquivo, 2);
  db_log(" db121_sequencial | db121_db_estrutura | db121_estrutural |   db121_descricao   | db121_estruturavalorpai | db121_nivel | db121_tipoconta \n", $sArquivo, 2);
  db_log("------------------+--------------------+------------------+---------------------+-------------------------+-------------+-----------------\n", $sArquivo, 2); 
  
  /**
   * Busca todos os recursos disponiveis.
   */
  $sSqlSelectOrcTipoRec   = "select * from orctiporec";
  $rsSqlSelectOrcTipoRec  = db_query($conn1, $sSqlSelectOrcTipoRec);
  $iRowsSelectOrcTipoRec  = pg_num_rows($rsSqlSelectOrcTipoRec);
  for ($iInd = 0; $iInd < $iRowsSelectOrcTipoRec; $iInd++) {
  	
  	$oOrcTipoRec                  = db_utils::fieldsMemory($rsSqlSelectOrcTipoRec, $iInd);
  	
  	/**
  	 * Armazena o sequencial da estrutura valor em uma variavel.
  	 */
	  $sSqlNextValDbEstruturaValor  = "select nextval('db_estruturavalor_db121_sequencial_seq') as db121_sequencial";
	  $rsSqlNextValDbEstruturaValor = db_query($conn1, $sSqlNextValDbEstruturaValor);
	  $iNextValDbEstruturaValor     = db_utils::fieldsMemory($rsSqlNextValDbEstruturaValor, 0)->db121_sequencial;
  	
	  $icodtri = trim($oOrcTipoRec->o15_codigo);
	  if (empty($icodtri)) {
	  	$icodtri = 0;
	  }
	  
	  $iEstrutural                  = str_pad($icodtri, 4, "0", STR_PAD_LEFT);
	  
	  /**
	   * Inclui uma nova estrutura valor para cada recurso encontrado.
	   */
  	$sSqlInsertDbEstruturaValor   = "INSERT INTO db_estruturavalor ( db121_sequencial,             ";
    $sSqlInsertDbEstruturaValor  .= "                                db121_db_estrutura,           ";
    $sSqlInsertDbEstruturaValor  .= "                                db121_estrutural,             ";
    $sSqlInsertDbEstruturaValor  .= "                                db121_descricao,              ";
    $sSqlInsertDbEstruturaValor  .= "                                db121_estruturavalorpai,      ";
    $sSqlInsertDbEstruturaValor  .= "                                db121_nivel,                  ";
    $sSqlInsertDbEstruturaValor  .= "                                db121_tipoconta               ";
    $sSqlInsertDbEstruturaValor  .= "                              )                               ";
    $sSqlInsertDbEstruturaValor  .= "                       VALUES ( {$iNextValDbEstruturaValor},  ";
    $sSqlInsertDbEstruturaValor  .= "                                {$iNextValDbEstrutura},       ";
    $sSqlInsertDbEstruturaValor  .= "                                '{$iEstrutural}',             ";
    $sSqlInsertDbEstruturaValor  .= "                                '{$oOrcTipoRec->o15_descr}',  ";
    $sSqlInsertDbEstruturaValor  .= "                                null,                         ";
    $sSqlInsertDbEstruturaValor  .= "                                1,                            ";
    $sSqlInsertDbEstruturaValor  .= "                                2)                            ";
    $rsSqlInsertDbEstruturaValor  = db_query($conn1, $sSqlInsertDbEstruturaValor);
	  if (!$rsSqlInsertDbEstruturaValor) {
	    throw new Exception("Erro ao incluir registros na tabela(db_estruturavalor)! Verifique.");
	  }
	  
	  db_log("                {$iNextValDbEstruturaValor} |                 {$iNextValDbEstrutura} | {$iEstrutural}            | {$oOrcTipoRec->o15_descr}               |                       null |           1 |               2 \n", $sArquivo, 2);
	  
	  /**
	   * Altera o estrutura valor da orctiporec para o novo estrutura valor criado.
	   */
	  $sSqlUpdateOrcTipoRec  = "UPDATE orctiporec SET o15_db_estruturavalor = {$iNextValDbEstruturaValor} "; 
	  $sSqlUpdateOrcTipoRec .= " WHERE o15_codigo = {$oOrcTipoRec->o15_codigo}                            ";
    $rsSqlUpdateOrcTipoRec = db_query($conn1, $sSqlUpdateOrcTipoRec);
    if (!$rsSqlUpdateOrcTipoRec) {
      throw new Exception("Erro ao alterar registros na tabela(orctiporec)! Verifique.");
    }
	  
	  logProcessamento($iInd, $iRowsSelectOrcTipoRec, 1);
  }

  $sSqlSetNotNulOrcTipoRec  = "ALTER TABLE orctiporec ALTER o15_db_estruturavalor SET NOT null";
  $rsSqlSetNotNulOrcTipoRec = db_query($conn1, $sSqlSetNotNulOrcTipoRec);
  if (!$rsSqlSetNotNulOrcTipoRec) {
    throw new Exception("Erro ao alterar a tabela(orctiporec) set not null no campo o15_db_estruturavalor! Verifique.");
  }
  
  db_log("({$iRowsSelectOrcTipoRec} registros)                                                                                                      \n", $sArquivo, 2);
  db_log("------------------+--------------------+------------------+---------------------+-------------------------+-------------+-----------------\n", $sArquivo, 2);
  
  db_log('Migracao registros concluida com sucesso.', $sArquivo, 0);
  db_log('',                                          $sArquivo, 0);
  
  db_query($conn1, "COMMIT");
} catch ( Exception $eException ) {
  
  db_query($conn1, "ROLLBACK");
  db_log($eException->getMessage(), $sArquivo ,0);
}

db_log('OBS: Favor verificar os logs gerados no arquivo ./log_*',                               $sArquivo ,0);
db_log('OBS: Cuidado script deve ser executado apenas 1x, para nao duplicar os registros.',     $sArquivo ,0);
db_log('',                                                                                      $sArquivo ,0);
db_log("\n",                                                                                    $sArquivo, 0);

/**
 * Função que exibe na tela a quantidade de registros processados 
 * e a quandidade de memória utilizada
 *
 * @param integer $iInd      Indice da linha que está sendo processada
 * @param integer $iTotalLinhas  Total de linhas a processar
 * @param integer $iParamLog     Caso seja passado true é exibido na tela 
 */
function logProcessamento($iInd, $iTotalLinhas, $iParamLog) {
  
  $nPercentual = round((($iInd + 1) / $iTotalLinhas) * 100, 2);
  $nMemScript  = (float)round( (memory_get_usage()/1024 ) / 1024,2);
  $sMemScript  = $nMemScript ." Mb";
  $sMsg        = " ".($iInd+1)." de {$iTotalLinhas} Processando {$nPercentual} %"." Total de memoria utilizada : {$sMemScript} ";
  $sMsg        = str_pad($sMsg,100," ",STR_PAD_RIGHT);
  
  db_log($sMsg."\r",null,$iParamLog,true,false);
}
?>