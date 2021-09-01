<?php
/*
 * Verifica se já possui registros na tabela processoforo
 * flag para não deixar rodar o script mais de 1x na mesma base, caso ja exista passar valor da variavel $lVerificar = false
 */
$lVerificar = true;

/*
 * Flag para usar o arquivo de configuracao db_conn.php
 */
$lConn      = true;
if ($lConn) {
  require_once(__DIR__ . "/../../libs/db_conn.php");	
} else {
	
  $DB_USUARIO         = "postgres";
  $DB_SENHA           = "";
  $DB_SERVIDOR        = ""; 
  $DB_BASE            = "";
  $DB_PORTA           = "5432";
}

require_once(__DIR__ . "/../../libs/db_utils.php");
require_once(__DIR__ . "/../../libs/db_libconsole.php");

echo "inicio da migracao: ".date("d/m/Y - h:i:s", time())."\n";
echo "Conectando...\n";

$sConexao = "host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA";

if(!($conn1 = pg_connect($sConexao))){
  echo "Erro ao Conectar...\n";
  exit;
}

echo "Processando...\n";

$aDadosDefinidos          = array();
$aDadosIndefinidos        = array();
$lErro                    = true;
$sArquivo                 = "log/log_migracao_processoforo_".date("YmdHis").".txt";

try {

	$lErro                    = false;
	
	db_query($conn1, "BEGIN");
	
	$sSqlStartSession          = " select fc_startsession(); ";
	$rsStartSession            = db_query($conn1, $sSqlStartSession);
	
	if ($lVerificar) {
		
	  $sSqlVerificaProcessoForo     = " select * from processoforo; ";
	  $rsSqlVerificaProcessoForo    = db_query($conn1, $sSqlVerificaProcessoForo);
	  $iNumRowsVerificaProcessoForo = pg_num_rows($rsSqlVerificaProcessoForo);
	  /*
	   * Verifica se possui registros na tabela processoforo, o script de migração será rodado apenas 1x a tabela processoforo
	   * será vazia pois essa tabela é nova
	   */
	  if ($iNumRowsVerificaProcessoForo > 0) {
	  	throw new Exception("Erro programa de migracao ja foi rodado na base. Verificar tabela processoforo!");
	  }
	}
	
	/*
	 * Migrando registros da tabela inicialcodforo para as novas tabelas processoforo e processoforoinicial apenas registros
	 * onde os dados da inicialcodforo que nao são indefinidos ou que possuem v55_codforo preenchido
	 */
  db_log('Migrando registros(Definidos).',                                                                $sArquivo ,2);	
	
	/*
	 * Pesquisa dados da inicialcodforo que nao são indefinidos ou que possuem v55_codforo preenchido.
	 */	
	$sSqlDadosDefinidos      = " select distinct v55_codforo        "; 
	$sSqlDadosDefinidos     .= "   from inicialcodforo              ";
	$sSqlDadosDefinidos     .= "  where v55_codforo <> 'INDEFINIDO' "; 
	$sSqlDadosDefinidos     .= "    and v55_codforo <> ''           "; 
	$sSqlDadosDefinidos     .= "    and v55_codforo is not null;    ";
//	die($sSqlDadosDefinidos);
	$rsDadosDefinidos        = db_query($conn1, $sSqlDadosDefinidos);
	
  if (!$rsDadosDefinidos) {
    throw new Exception("Erro na Pesquisa Dados da inicialcodforo. Dados Definidos!");
  }
  
	$iNumRowsDadosDefinidos  = pg_num_rows($rsDadosDefinidos);

  db_log("Registros encontrados: (Definidos)                                        ",$sArquivo,2);
  db_log("-------------+-----------------+------------+--------------+------------- ",$sArquivo,2);
  db_log(" v55_inicial |   v55_codforo   |  v55_data  | v55_id_login | v55_codvara  ",$sArquivo,2);
  db_log("-------------+-----------------+------------+--------------+------------- ",$sArquivo,2);
	
	/*
	 * Migração de registros definidos na tabela inicialforo para as tabelas processoforo e processoforoinicial
	 * Pesquisa apenas registos que sao v55_codforo <> 'INDEFINIDO' e v55_codforo <> '' e que sao v55_codforo is not null
	 */
	for ($iInd = 0; $iInd < $iNumRowsDadosDefinidos; $iInd++) {
	    
	  $oInicialCodForo    = db_utils::fieldsMemory($rsDadosDefinidos, $iInd);

    /*
     * Pesquisando na inicialcodforo distinct onde v55_codforo  = '<v55_codforo>'
     * e v55_data = ultima data (max(v55_data)) da tabela inicialcodforo para o codigo existente (inicialcodforo.v55_codforo)
     */
	  $sSqlInicialCodForo  = " select distinct v55_inicial,                                                                               ";
	  $sSqlInicialCodForo .= "        trim(replace(v55_codforo,'\x09','')) as v55_codforo,                                                ";
    $sSqlInicialCodForo .= "        v55_data,                                                                                           ";
    $sSqlInicialCodForo .= "        v55_id_login,                                                                                       ";
    $sSqlInicialCodForo .= "        v55_codvara                                                                                         ";
    $sSqlInicialCodForo .= "   from inicialcodforo                                                                                      ";
    $sSqlInicialCodForo .= "  where trim(replace(v55_codforo,'\x09','')) = trim(replace('".$oInicialCodForo->v55_codforo."','\x09','')) ";  
    $sSqlInicialCodForo .= "    and v55_data = ( select max(v55_data)                                                                   ";
    $sSqlInicialCodForo .= "                       from inicialcodforo x                                                                ";  
    $sSqlInicialCodForo .= "                      where x.v55_codforo = inicialcodforo.v55_codforo );                                   ";
    $rsInicialCodForo       = db_query($conn1, $sSqlInicialCodForo);                                          
    $iNumRowsInicialCodForo = pg_num_rows($rsInicialCodForo);
    
    if (!$rsInicialCodForo) {
      throw new Exception("Erro na Pesquisa Dados da inicialcodforo por v55_codforo!");
    }
    
    if ($iNumRowsInicialCodForo > 0) {
      
      $oInicialCodForoDados  = db_utils::fieldsMemory($rsInicialCodForo, 0);
      
	    $sDadosDefinidosLog    = " {$oInicialCodForoDados->v55_inicial} |  ";
	    $sDadosDefinidosLog   .= " {$oInicialCodForoDados->v55_codforo} |  "; 
	    $sDadosDefinidosLog   .= " {$oInicialCodForoDados->v55_data} |     ";
	    $sDadosDefinidosLog   .= " {$oInicialCodForoDados->v55_id_login} | ";
	    $sDadosDefinidosLog   .= " {$oInicialCodForoDados->v55_codvara}    ";
	    db_log($sDadosDefinidosLog,                      $sArquivo, 2);
      
	    $sSqlVara     = "select * from vara where v53_codvara = {$oInicialCodForoDados->v55_codvara}";
	    $rsSqlVara    = db_query($conn1, $sSqlVara);
	    $iNumRowsVara = pg_num_rows($rsSqlVara);
	    if ($iNumRowsVara == 0) {
	    	
	    	$sSqlVara  = "insert into vara( v53_codvara, 
	    	                                v53_descr ) 
	    	                               values ( {$oInicialCodForoDados->v55_codvara}, 
	    	                                        'VARA MIGRAÇÃO' )";
	    	$rsSqlVara = db_query($conn1, $sSqlVara);
	      if (!$rsSqlVara) {
          throw new Exception("Erro ao incluir registros na vara!");
        }
	    }
	    
    	/*
    	 * Verifica se o valar do campo v55_data esta vazio, ai acrecenta uma data fixa, essa data corresponde a um dia 
    	 * em que nao foi processado nada para nao haver registros existentes com a mesma data. 
    	 */
      if ($oInicialCodForoDados->v55_data == '') {
        $v70_data = '2010-09-26';
      } else {
        $v70_data = $oInicialCodForoDados->v55_data;
      }
      
      $rsNextVal       = db_query($conn1, "select nextval('processoforo_v70_sequencial_seq') as v70_sequencial;");
      $iNumRowsNextVal = pg_num_rows($rsNextVal);
      if ($iNumRowsNextVal > 0) {
        
        $oProcessoForo  = db_utils::fieldsMemory($rsNextVal, 0);
        $v70_sequencial = $oProcessoForo->v70_sequencial; 
      }
      
      /*
       * Inclui registros na tabela processoforo pesquisando na inicialcodforo distinct onde v55_codforo  = '<v55_codforo>'
       * e v55_data = ultima data (max(v55_data)) da tabela inicialcodforo para o codigo existente (inicialcodforo.v55_codforo)
       */
      $sSqlProcessoForo  = " insert into processoforo ( v70_sequencial,                                                    ";
      $sSqlProcessoForo .= "                            v70_codforo,                                                       ";
      $sSqlProcessoForo .= "                            v70_processoforomov,                                               ";
      $sSqlProcessoForo .= "                            v70_id_usuario,                                                    ";
      $sSqlProcessoForo .= "                            v70_vara,                                                          ";
      $sSqlProcessoForo .= "                            v70_data,                                                          ";
      $sSqlProcessoForo .= "                            v70_valorinicial,                                                  ";
      $sSqlProcessoForo .= "                            v70_observacao,                                                    ";
      $sSqlProcessoForo .= "                            v70_anulado                                                        ";
      $sSqlProcessoForo .= "                          )                                                                    ";
      $sSqlProcessoForo .= "                          values ( {$v70_sequencial},                                          ";
      $sSqlProcessoForo .= "                                   '{$oInicialCodForoDados->v55_codforo}',                     ";
      $sSqlProcessoForo .= "                                   null,                                                       ";
      $sSqlProcessoForo .= "                                   {$oInicialCodForoDados->v55_id_login},                      ";
      $sSqlProcessoForo .= "                                   {$oInicialCodForoDados->v55_codvara},                       ";
      $sSqlProcessoForo .= "                                   '{$v70_data}',                                              ";
      $sSqlProcessoForo .= "                                   0,                                                          ";
      $sSqlProcessoForo .= "                                   '',                                                         ";
      $sSqlProcessoForo .= "                                   'false'                                                     ";
      $sSqlProcessoForo .= "                          );                                                                   ";
      
      $rsProcessoForo    = db_query($conn1, $sSqlProcessoForo);
       
      if (!$rsProcessoForo) {
        throw new Exception("Erro ao incluir registros na processoforo!");
      }
       
      $sSqlInicialCodForo     = " select *                                                                                 ";
      $sSqlInicialCodForo    .= "   from inicialcodforo                                                                    ";
      $sSqlInicialCodForo    .= "  where trim(replace(v55_codforo,'\x09',''))  = '{$oInicialCodForoDados->v55_codforo}';   ";
      $rsSqlInicialCodForo    = db_query($conn1, $sSqlInicialCodForo);
      
      $iNumRowsCodForoInicial = pg_num_rows($rsSqlInicialCodForo);
      
      if (!$rsSqlInicialCodForo) {
        throw new Exception("Erro ao pesquisar iniciais na inicialcodforo!");
      }
      
      for ($xInd = 0; $xInd < $iNumRowsCodForoInicial; $xInd++) {
      	
      	$oCodForoInicial = db_utils::fieldsMemory($rsSqlInicialCodForo, $xInd);
      	
        if ($oCodForoInicial->v55_data == '') {
          $v71_data = '2010-09-26';
        } else {
          $v71_data = $oCodForoInicial->v55_data;
        }
      	
      	/*
      	 * Inclui registros na tabela processoforoinicial pesquisando da inicialcodforo onde v55_codforo  = '<v55_codforo>'
      	 */
	      $sSqlProcessoForoInicial  = " insert into processoforoinicial ( v71_sequencial,                                             ";
	      $sSqlProcessoForoInicial .= "                                   v71_id_usuario,                                             ";
	      $sSqlProcessoForoInicial .= "                                   v71_inicial,                                                ";
	      $sSqlProcessoForoInicial .= "                                   v71_processoforo,                                           ";
	      $sSqlProcessoForoInicial .= "                                   v71_data,                                                   ";
	      $sSqlProcessoForoInicial .= "                                   v71_anulado                                                 ";
	      $sSqlProcessoForoInicial .= "                                 ) values ( nextval('processoforoinicial_v71_sequencial_seq'), ";
	      $sSqlProcessoForoInicial .= "                                            {$oCodForoInicial->v55_id_login},                  ";
	      $sSqlProcessoForoInicial .= "                                            {$oCodForoInicial->v55_inicial},                   ";
	      $sSqlProcessoForoInicial .= "                                            {$v70_sequencial},                                 ";
	      $sSqlProcessoForoInicial .= "                                            '{$v71_data}',                                     ";
	      $sSqlProcessoForoInicial .= "                                            'false'                                            "; 
	      $sSqlProcessoForoInicial .= "                                 );                                                            ";
	      
	      $rsSqlCodForoIni          = db_query($conn1, $sSqlProcessoForoInicial);
	      
	      if (!$rsSqlCodForoIni) {
	        throw new Exception("Erro ao incluir iniciais na processoforoinicial!");
	      }
      }
         
      logProcessamento($iInd, $iNumRowsDadosDefinidos, 0);
    } else {
    	echo " Erro no sql: \n ".$sSqlInicialCodForo." \n ";
    	throw new Exception("Erro na Pesquisa Dados da inicialcodforo por v55_codforo. Registro na v55_codforo possui caracter invalido!");
    }
	}
	
	db_log("Total de registros encontados: ".$iNumRowsDadosDefinidos,                                       $sArquivo, 2);
	db_log("",                                                                                              $sArquivo, 2);
	
	db_log('Migracao registros(Definidos) concluida com sucesso.',                                          $sArquivo ,0);
  db_log('',                                                                                              $sArquivo ,0);
  
	/*
	 * Migrando registros da tabela inicialcodforo para as novas tabelas processoforo e processoforoinicial apenas registros
	 * onde os dados da inicialcodforo que são indefinidos ou que possuem v55_codforo vazio ou nulo será gerado uma inicial 
	 * para ca registro
	 */
  db_log('Migrando registros(Indefinidos, vazio ou nulos).',                                              $sArquivo ,2);  
  
  /*
   * Pesquisar dados da inicialcodforo que estao como indefinidos ou que o v55_codforo é vazio ou nulo.
   */ 
  $sSqlDadosIndefinidos    = " select *                                 "; 
  $sSqlDadosIndefinidos   .= "   from inicialcodforo                    ";
  $sSqlDadosIndefinidos   .= "  where trim(v55_codforo) = 'INDEFINIDO'  "; 
  $sSqlDadosIndefinidos   .= "     or trim(v55_codforo) = ''            "; 
  $sSqlDadosIndefinidos   .= "     or v55_codforo is null;              ";
  $rsDadosIndefinidos      = db_query($conn1, $sSqlDadosIndefinidos);

  if (!$rsDadosIndefinidos) {
    throw new Exception("Erro na Pesquisa Dados da inicialcodforo. Dados Indefinidos!");
  }
	
  $iNumRowsDadosIndefinidos  = pg_num_rows($rsDadosIndefinidos);
  
  db_log("Registros encontrados: (Indefinidos, Vazio ou Nulos)                      ",$sArquivo,2);
  db_log("-------------+-----------------+------------+--------------+------------- ",$sArquivo,2);
  db_log(" v55_inicial |   v55_codforo   |  v55_data  | v55_id_login | v55_codvara  ",$sArquivo,2);
  db_log("-------------+-----------------+------------+--------------+------------- ",$sArquivo,2);
  
  /*
   * Migração de registros indefinidos, vazios ou nulos na tabela inicialforo para as tabelas processoforo e processoforoinicial
   */
  for ($iInd = 0; $iInd < $iNumRowsDadosIndefinidos; $iInd++) { 
  	
    $oInicialCodForo       = db_utils::fieldsMemory($rsDadosIndefinidos, $iInd);
    
    $sDadosIndefinidosLog  = " {$oInicialCodForo->v55_inicial} |  ";
    $sDadosIndefinidosLog .= " {$oInicialCodForo->v55_codforo} |  ";
    $sDadosIndefinidosLog .= " {$oInicialCodForo->v55_data} |     ";
    $sDadosIndefinidosLog .= " {$oInicialCodForo->v55_id_login} | ";
    $sDadosIndefinidosLog .= " {$oInicialCodForo->v55_codvara}    ";
    db_log($sDadosIndefinidosLog,                     $sArquivo, 2);

    $sSqlVara     = "select * from vara where v53_codvara = {$oInicialCodForoDados->v55_codvara}";
    $rsSqlVara    = db_query($conn1, $sSqlVara);
    $iNumRowsVara = pg_num_rows($rsSqlVara);
    if ($iNumRowsVara == 0) {
        
      $sSqlVara  = "insert into vara( v53_codvara, 
                                      v53_descr ) 
                                     values ( {$oInicialCodForoDados->v55_codvara}, 
                                              'VARA MIGRAÇÃO' )";
      $rsSqlVara = db_query($conn1, $sSqlVara);
      if (!$rsSqlVara) {
        throw new Exception("Erro ao incluir registros na vara!");
      }
    }
    
    /*
     * Verifica se o valar do campo v55_data esta vazio, ai acrecenta uma data fixa, essa data corresponde a um dia 
     * em que nao foi processado nada para nao haver registros existentes com a mesma data. 
     */
    if ($oInicialCodForo->v55_data == '') {
      $v70_data = '2010-09-26';
    } else {
      $v70_data = $oInicialCodForo->v55_data;
    }
      
    $rsNextVal       = db_query($conn1, "select nextval('processoforo_v70_sequencial_seq') as v70_sequencial;");
    $iNumRowsNextVal = pg_num_rows($rsNextVal);
    if ($iNumRowsNextVal > 0) {
        
      $oProcessoForo  = db_utils::fieldsMemory($rsNextVal, 0);
      $v70_sequencial = $oProcessoForo->v70_sequencial; 
    }
      
    /*
     * Inclui registros na tabela processoforo pesquisando na inicialcodforo 
     */
    $sSqlProcessoForo  = " insert into processoforo ( v70_sequencial,                                  ";
    $sSqlProcessoForo .= "                            v70_codforo,                                     ";
    $sSqlProcessoForo .= "                            v70_processoforomov,                             ";
    $sSqlProcessoForo .= "                            v70_id_usuario,                                  ";
    $sSqlProcessoForo .= "                            v70_vara,                                        ";
    $sSqlProcessoForo .= "                            v70_data,                                        ";  
    $sSqlProcessoForo .= "                            v70_valorinicial,                                ";
    $sSqlProcessoForo .= "                            v70_observacao,                                  ";
    $sSqlProcessoForo .= "                            v70_anulado                                      ";
    $sSqlProcessoForo .= "                          )                                                  ";
    $sSqlProcessoForo .= "                          values ( {$v70_sequencial},                        ";
    $sSqlProcessoForo .= "                                   '{$oInicialCodForo->v55_codforo}',        ";
    $sSqlProcessoForo .= "                                   null,                                     ";
    $sSqlProcessoForo .= "                                   {$oInicialCodForo->v55_id_login},         ";
    $sSqlProcessoForo .= "                                   {$oInicialCodForo->v55_codvara},          ";
    $sSqlProcessoForo .= "                                   '{$v70_data}',                            ";
    $sSqlProcessoForo .= "                                   0,                                        ";
    $sSqlProcessoForo .= "                                   '',                                       ";
    $sSqlProcessoForo .= "                                   'false'                                   ";
    $sSqlProcessoForo .= "                          );                                                 ";
    $rsProcessoForo    = db_query($conn1, $sSqlProcessoForo);
       
    if (!$rsProcessoForo) {
      throw new Exception("Erro ao incluir registros na processoforo!");
    }
       
    if ($oInicialCodForo->v55_data == '') {
      $v71_data = '2010-09-26';
    } else {
      $v71_data = $oInicialCodForo->v55_data;
    }
        
    /*
     * Inclui registros na tabela processoforoinicial pesquisando da inicialcodforo
     */
    $sSqlProcessoForoInicial  = " insert into processoforoinicial ( v71_sequencial,                                             ";
    $sSqlProcessoForoInicial .= "                                   v71_id_usuario,                                             ";
    $sSqlProcessoForoInicial .= "                                   v71_inicial,                                                ";
    $sSqlProcessoForoInicial .= "                                   v71_processoforo,                                           ";
    $sSqlProcessoForoInicial .= "                                   v71_data,                                                   ";
    $sSqlProcessoForoInicial .= "                                   v71_anulado                                                 ";
    $sSqlProcessoForoInicial .= "                                 ) values ( nextval('processoforoinicial_v71_sequencial_seq'), ";
    $sSqlProcessoForoInicial .= "                                            {$oInicialCodForo->v55_id_login},                  ";
    $sSqlProcessoForoInicial .= "                                            {$oInicialCodForo->v55_inicial},                   ";
    $sSqlProcessoForoInicial .= "                                            {$v70_sequencial},                                 ";
    $sSqlProcessoForoInicial .= "                                            '{$v71_data}',                                     ";
    $sSqlProcessoForoInicial .= "                                            'false'                                            "; 
    $sSqlProcessoForoInicial .= "                                 );                                                            ";
        
    $rsSqlCodForoIni          = db_query($conn1, $sSqlProcessoForoInicial);
        
    if (!$rsSqlCodForoIni) {
      throw new Exception("Erro ao incluir iniciais na processoforoinicial!");
    }
         
    logProcessamento($iInd, $iNumRowsDadosIndefinidos, 0);
  }
  
  db_log("Total de registros encontados: ".$iNumRowsDadosIndefinidos,                                     $sArquivo, 2);
  db_log("",                                                                                              $sArquivo, 2);
  
  db_log('Migracao registros(Indefinidos, Vazio ou Nulos) concluida com sucesso.',                        $sArquivo ,0);
  db_log('',                                                                                              $sArquivo ,0);
  
	db_query($conn1, "COMMIT");
} catch ( Exception $eException ) {
  
  $lErro = true;
  db_query($conn1, "ROLLBACK");
  db_log($eException->getMessage(),                                                                       $sArquivo ,0);
}

db_log('OBS: Favor verificar os logs gerados no diretorio ./log.',                                        $sArquivo ,0);
db_log('OBS: Cuidado script deve ser executado apenas 1x, para nao duplicar os registros.',               $sArquivo ,0);
db_log('',                                                                                                $sArquivo ,0);

/**
 * Função que exibe na tela a quantidade de registros processados 
 * e a quandidade de memória utilizada
 *
 * @param integer $iInd      Indice da linha que está sendo processada
 * @param integer $iTotalLinhas  Total de linhas a processar
 * @param integer $iParamLog     Caso seja passado true é exibido na tela 
 */
function logProcessamento($iInd,$iTotalLinhas,$iParamLog) {
  
  $nPercentual = round((($iInd + 1) / $iTotalLinhas) * 100, 2);
  $nMemScript  = (float)round( (memory_get_usage()/1024 ) / 1024,2);
  $sMemScript  = $nMemScript ." Mb";
  $sMsg        = " ".($iInd+1)." de {$iTotalLinhas} Processando {$nPercentual} %"." Total de memoria utilizada : {$sMemScript} ";
  $sMsg        = str_pad($sMsg,100," ",STR_PAD_RIGHT);
  db_log($sMsg."\r",null,$iParamLog,true,false);  

}
?>