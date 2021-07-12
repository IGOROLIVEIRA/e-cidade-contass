<?
$DB_SERVIDOR     = '192.168.0.24';
$DB_BASE         = 'osorio_contrib';
$DB_PORTA        = '5432';
$DB_USER         = 'postgres';
$DB_SENHA        = ''; 

/**
 *  A variável iParamLog define o tipo de log que deve ser gerado :
 *  0 - Imprime log na tela e no arquivo  
 *  1 - Imprime log somente da tela  
 *  2 - Imprime log somente no arquivo
 */
$iParamLog = 2;
if ( $iParamLog == 1 ) {
	
  $sArquivoLog        = null;
  $sArquivoMatricErro = null;
} else {
	
  $sArquivoLog        = "importacao_t43042_".date("Ymd_His").".log";
  $sArquivoMatricErro = "importacao_t43042_matricula_nao_existe_".date("Ymd_His").".log";
}

$dtDataHoje      = date("Y-m-d");
$sNomeArquivoCSV = "csv/planilha_importacao_t43042.csv";

require_once('libs/db_conecta.php');
require_once("libs/db_utils.php");

if ( !$lErro ) {
	
	try {
	  
	  if ( !file_exists(".importacao_ja_executada") ) {

	    pg_query("drop table w_conversao_t43042");	  	
		  pg_query("begin");
	    pg_query("select fc_startsession()");
	    
	    $fd = fopen('.importacao_ja_executada', "a+");
	    if ($fd) {
	        
	      fwrite($fd, 'ALERTA: O SCRIPT DE IMPORTACÃO SÓ DEVERÁ SER EXECUTADO UM VEZ NO CLIENTE!');
	      fclose($fd);
	    }
	    
	    /*
	     * Dados referentes da planilha arquivo T43042.csv
	     */
	    $sSqlTabelaTemporaria  = "create table w_conversao_t43042( ";
	    $sSqlTabelaTemporaria .= "    A int4,                      ";
	    $sSqlTabelaTemporaria .= "    B int4,                      ";
	    $sSqlTabelaTemporaria .= "    C int4,                      ";
	    $sSqlTabelaTemporaria .= "    D numeric,                   ";
	    $sSqlTabelaTemporaria .= "    E numeric,                   ";
	    $sSqlTabelaTemporaria .= "    F numeric,                   ";
	    $sSqlTabelaTemporaria .= "    G numeric,                   ";
	    $sSqlTabelaTemporaria .= "    H numeric,                   ";
	    $sSqlTabelaTemporaria .= "    I numeric,                   ";
	    $sSqlTabelaTemporaria .= "    J numeric,                   ";
	    $sSqlTabelaTemporaria .= "    K numeric,                   ";
	    $sSqlTabelaTemporaria .= "    L text,                      ";
	    $sSqlTabelaTemporaria .= "    M int4,                      ";
	    $sSqlTabelaTemporaria .= "    N int4,                      ";
	    $sSqlTabelaTemporaria .= "    O int4,                      ";
	    $sSqlTabelaTemporaria .= "    P int4,                      ";
	    $sSqlTabelaTemporaria .= "    Q numeric,                   ";
	    $sSqlTabelaTemporaria .= "    R numeric,                   ";
	    $sSqlTabelaTemporaria .= "    S numeric,                   ";
	    $sSqlTabelaTemporaria .= "    T text )                     ";
	    $rsTabelaTemporaria    = pg_query($sSqlTabelaTemporaria);
	    
	    if ( !$rsTabelaTemporaria ) {
	      throw new Exception("ERRO AO CRIAR TABELA TEMPORARIA w_conversao_t43042!");
	    }
	    
	    if ( !file_exists("{$sNomeArquivoCSV}") ) {
	      throw new Exception("ARQUIVO {$sNomeArquivoCSV} NAO EXISTE!");
	    }
	    
	    $aLinhasCSV = file("{$sNomeArquivoCSV}");  
	    $iCountCSV  = count($aLinhasCSV);
	    foreach ( $aLinhasCSV as $iInd => $sLinha ) {
	      
	      logProcessamento($iInd, $iCountCSV, 1);
	      
	      $sLinha  = str_replace(',', ".", $sLinha);
	      $sLinha  = str_replace('|', ", ", $sLinha);
	      
	      $sQuery  = "insert into w_conversao_t43042( A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T )";
	      $sQuery .= " values ( {$sLinha} )";
	      
	      db_log('\n'.$sQuery.'\n', 'migracao.sql', $iParamLog);
	      
	      $rsQuery = pg_query($sQuery);
	      if ( !$rsTabelaTemporaria ) {
	        throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA w_conversao_t43042!");
	      }
	    }
	    
	    /**
	     * Primeira parte 
	     * 
	     * projmelhorias
	     * projmelhoriasmatric
	     * projmelhoriasresp
	     */
      $sCampos                       = "distinct a, c, l, round((n::numeric/2), 1) as valor";
      $rsSqlConsultaProjMelhorias    = sqlRecordTabelaTemp($sCampos, null, 'a');
	    $iNumRowsConsultaProjMelhorias = pg_num_rows($rsSqlConsultaProjMelhorias);
	    
	    for ($aInd = 0; $aInd < $iNumRowsConsultaProjMelhorias; $aInd++) {
	      
	      logProcessamento($aInd, $iNumRowsConsultaProjMelhorias, 1);
	      
	      $oConsultaProjMelhoria = db_utils::fieldsMemory($rsSqlConsultaProjMelhorias, $aInd);
	      
	      $sSqlNextValProjMelhoria  = "select nextval('projmelhorias_d40_codigo_seq') as codigo";
	      $rsSqlNextValProjMelhoria = pg_query($sSqlNextValProjMelhoria);
	      
	      $oNextValProjMelhoria     = db_utils::fieldsMemory($rsSqlNextValProjMelhoria, 0);
	      
	      $sSqlProjMelhoria  = "insert into projmelhorias( d40_codigo,                              ";
	      $sSqlProjMelhoria .= "                           d40_data,                                ";
	      $sSqlProjMelhoria .= "                           d40_login,                               ";
	      $sSqlProjMelhoria .= "                           d40_codlog,                              ";
	      $sSqlProjMelhoria .= "                           d40_trecho,                              ";
	      $sSqlProjMelhoria .= "                           d40_profun )                             ";
	      $sSqlProjMelhoria .= "                  values ( {$oNextValProjMelhoria->codigo},         "; 
	      $sSqlProjMelhoria .= "                           '{$dtDataHoje}',                         ";
	      $sSqlProjMelhoria .= "                           1,                                       ";
	      $sSqlProjMelhoria .= "                           {$oConsultaProjMelhoria->c},             "; 
	      $sSqlProjMelhoria .= "                           '{$oConsultaProjMelhoria->l}',           "; 
	      $sSqlProjMelhoria .= "                           {$oConsultaProjMelhoria->valor} )        ";
	      
	      db_log($sSqlProjMelhoria, $sArquivoLog, $iParamLog);
	      
	      $rsSqlProjMelhoria = pg_query($sSqlProjMelhoria);
	      if ( !$rsSqlProjMelhoria ) {
	        throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA projmelhorias!");
	      }
	      
        $sSqlTabelaTemporaria  = "update w_conversao_t43042                  ";
        $sSqlTabelaTemporaria .= "   set a = {$oNextValProjMelhoria->codigo} ";
        $sSqlTabelaTemporaria .= " where a = {$oConsultaProjMelhoria->a}     ";
        
        db_log($sSqlTabelaTemporaria, $sArquivoLog, $iParamLog);
        db_log(' ', $sArquivoLog, $iParamLog);
        
        $rsSqlTabelaTemporaria = pg_query($sSqlTabelaTemporaria);
	      if ( !$rsSqlTabelaTemporaria ) {
          throw new Exception("ERRO AO ATUALIZAR REGISTROS NA TABELA w_conversao_t43042!");
        }
        
        $sSqlDbConfig  = "select numcgm from db_config where prefeitura is true";
        $rsSqlDbConfig = pg_query($sSqlDbConfig);
        
        $oDbConfig     = db_utils::fieldsMemory($rsSqlDbConfig, 0);
        
        $sSqlProjMelhoriasResp  = "insert into projmelhoriasresp( d42_codigo,                      ";
        $sSqlProjMelhoriasResp .= "                               d42_numcgm )                     ";
        $sSqlProjMelhoriasResp .= "                      values ( {$oNextValProjMelhoria->codigo}, ";
        $sSqlProjMelhoriasResp .= "                               {$oDbConfig->numcgm} )           ";
        
        db_log($sSqlProjMelhoriasResp, $sArquivoLog, $iParamLog);
        db_log(' ', $sArquivoLog, $iParamLog);
        
        $rsSqlProjMelhoriasResp = pg_query($sSqlProjMelhoriasResp);
	      if ( !$rsSqlProjMelhoriasResp ) {
          throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA projmelhoriasresp!");
        }
	    }

      $sCampos                       = "a, b, d";
      $rsSqlConsultaProjMelhorias    = sqlRecordTabelaTemp($sCampos, null, 'a');	    
      $iNumRowsConsultaProjMelhorias = pg_num_rows($rsSqlConsultaProjMelhorias);
      
      for ($bInd = 0; $bInd < $iNumRowsConsultaProjMelhorias; $bInd++) {
      	
        logProcessamento($bInd, $iNumRowsConsultaProjMelhorias, 1);
	    
      	$oConsultaProjMelhoria = db_utils::fieldsMemory($rsSqlConsultaProjMelhorias, $bInd);
      	
      	$sSqlIptuBase     = "select * from iptubase where j01_matric = {$oConsultaProjMelhoria->b}";
      	$rsSqlIptuBase    = pg_query($sSqlIptuBase);
        $iNumRowsIptuBase = pg_num_rows($rsSqlIptuBase);
      	
        if ( $iNumRowsIptuBase > 0 ) {
        	
	        $sSqlProjMelhoriasMatric  = "insert into projmelhoriasmatric( d41_codigo,                  "; 
	        $sSqlProjMelhoriasMatric .= "                                 d41_matric,                  ";
	        $sSqlProjMelhoriasMatric .= "                                 d41_testada,                 ";
	        $sSqlProjMelhoriasMatric .= "                                 d41_eixo,                    ";
	        $sSqlProjMelhoriasMatric .= "                                 d41_obs,                     ";
	        $sSqlProjMelhoriasMatric .= "                                 d41_auto,                    ";
	        $sSqlProjMelhoriasMatric .= "                                 d41_pgtopref )               "; 
	        $sSqlProjMelhoriasMatric .= "                        values ( {$oConsultaProjMelhoria->a}, ";
	        $sSqlProjMelhoriasMatric .= "                                 {$oConsultaProjMelhoria->b}, ";
	        $sSqlProjMelhoriasMatric .= "                                 {$oConsultaProjMelhoria->d}, ";
	        $sSqlProjMelhoriasMatric .= "                                 0,                           ";
	        $sSqlProjMelhoriasMatric .= "                                 '',                          ";
	        $sSqlProjMelhoriasMatric .= "                                 true,                        ";
	        $sSqlProjMelhoriasMatric .= "                                 true )                       ";
	        
	        db_log($sSqlProjMelhoriasMatric, $sArquivoLog, $iParamLog);
	        db_log(' ', $sArquivoLog, $iParamLog);
	
	        $rsSqlProjMelhoriasMatric = pg_query($sSqlProjMelhoriasMatric);
	        if ( !$rsSqlProjMelhoriasMatric ) {
	          throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA projmelhoriasmatric!");
	        }
        } else {
        	
        	$sMensagem = "ERRO MATRICULA {$oConsultaProjMelhoria->b} NAO EXISTE! \n";
        	db_log($sMensagem, $sArquivoMatricErro, $iParamLog);
        }
      }
      
      /**
       * Segunda parte
       * 
       * edital
       * editaldoc
       * editalproj
       */
	    $sCampos = "distinct t, q";
	    $rsSqlConsultaProjMelhorias    = sqlRecordTabelaTemp($sCampos, null, 't, q');
      $iNumRowsConsultaProjMelhorias = pg_num_rows($rsSqlConsultaProjMelhorias);
      
      for ($cInd = 0; $cInd < $iNumRowsConsultaProjMelhorias; $cInd++) {
      	
        logProcessamento($cInd, $iNumRowsConsultaProjMelhorias, 1);
      
        $oConsultaProjMelhoria = db_utils::fieldsMemory($rsSqlConsultaProjMelhorias, $cInd);	
        
        $sSqlNextValEdital  = "select nextval('edital_d01_codedi_seq') as codigo";
        $rsSqlNextValEdital = pg_query($sSqlNextValEdital);
        
        $oNextValEdital     = db_utils::fieldsMemory($rsSqlNextValEdital, 0);
        
        $iPercentual  = (100 - $oConsultaProjMelhoria->q);
        
        $sSqlEdital   = "insert into edital( d01_codedi,                    "; 
        $sSqlEdital  .= "                    d01_numero,                    ";
        $sSqlEdital  .= "                    d01_descr,                     ";
        $sSqlEdital  .= "                    d01_idlog,                     ";
        $sSqlEdital  .= "                    d01_data,                      ";
        $sSqlEdital  .= "                    d01_perc,                      ";
        $sSqlEdital  .= "                    d01_receit,                    ";
        $sSqlEdital  .= "                    d01_numtot,                    ";
        $sSqlEdital  .= "                    d01_privenc,                   ";
        $sSqlEdital  .= "                    d01_perunica )                 ";
        $sSqlEdital  .= "            values( {$oNextValEdital->codigo},     ";
        $sSqlEdital  .= "                    '{$oConsultaProjMelhoria->t}', ";
        $sSqlEdital  .= "                    '{$oConsultaProjMelhoria->t}', ";
        $sSqlEdital  .= "                    1,                             ";
        $sSqlEdital  .= "                    '{$dtDataHoje}',               ";
        $sSqlEdital  .= "                    {$iPercentual},                ";
        $sSqlEdital  .= "                    11,                            ";
        $sSqlEdital  .= "                    1,                             ";
        $sSqlEdital  .= "                    '2011-12-31',                  ";
        $sSqlEdital  .= "                    10 )                           ";

        db_log($sSqlEdital, $sArquivoLog, $iParamLog);
        db_log(' ', $sArquivoLog, $iParamLog);
  
        $rsSqlEdital = pg_query($sSqlEdital);
        if ( !$rsSqlEdital ) {
          throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA edital!");
        }
        
        $sSqlEditalDoc  = "insert into editaldoc( d13_sequencial,                          ";
        $sSqlEditalDoc .= "                       d13_db_documento,                        ";
        $sSqlEditalDoc .= "                       d13_edital )                             ";
        $sSqlEditalDoc .= "              values ( nextval('editaldoc_d13_sequencial_seq'), ";
        $sSqlEditalDoc .= "                       122,                                     ";
        $sSqlEditalDoc .= "                       {$oNextValEdital->codigo} )              ";
        
        db_log($sSqlEditalDoc, $sArquivoLog, $iParamLog);
        db_log(' ', $sArquivoLog, $iParamLog);
        
        $rsSqlEditalDoc = pg_query($sSqlEditalDoc);
        if ( !$rsSqlEditalDoc ) {
          throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA editaldoc!");
        }
        
	      $sCampos            = "distinct a, t";
	      $sWhere             = "t = '{$oConsultaProjMelhoria->t}'";
	      $rsSqlTabelaTemp    = sqlRecordTabelaTemp($sCampos, $sWhere, 'a, t');
	      $iNumRowsTabelaTemp = pg_num_rows($rsSqlTabelaTemp);
	      
	      for ($xInd = 0; $xInd < $iNumRowsTabelaTemp; $xInd++) {
	      	
	      	logProcessamento($xInd, $iNumRowsTabelaTemp, 1);
          
          $oTabelaTemp = db_utils::fieldsMemory($rsSqlTabelaTemp, $xInd); 

          $sSqlEditalProj  = "insert into editalproj( d10_codedi,                "; 
          $sSqlEditalProj .= "                        d10_codigo )               ";
          $sSqlEditalProj .= "               values ( {$oNextValEdital->codigo}, ";
          $sSqlEditalProj .= "                        {$oTabelaTemp->a} )        ";
          
	        db_log($sSqlEditalProj, $sArquivoLog, $iParamLog);
	        db_log(' ', $sArquivoLog, $iParamLog);

          $rsSqlEditalProj = pg_query($sSqlEditalProj);
	        if ( !$rsSqlEditalProj ) {
            throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA editalproj!");
          }
	      }
	      
        $sSqlTabelaTemporaria  = "update w_conversao_t43042                ";
        $sSqlTabelaTemporaria .= "   set t = {$oNextValEdital->codigo}     ";
        $sSqlTabelaTemporaria .= " where t = '{$oConsultaProjMelhoria->t}' ";
        
        db_log($sSqlTabelaTemporaria, $sArquivoLog, $iParamLog);
        db_log(' ', $sArquivoLog, $iParamLog);
        
        $rsSqlTabelaTemporaria = pg_query($sSqlTabelaTemporaria);
        if ( !$rsSqlTabelaTemporaria ) {
          throw new Exception("ERRO AO ATUALIZAR REGISTROS NA TABELA w_conversao_t43042!");
        }
      }
	    
      /**
       * Terceira parte
       * 
       * editalrua
       * editalserv
       * 
       * contlot
       * contlotv
       * 
       * editalruaproj
       */
      $sCampos = "distinct a, t, c, round((n::numeric/2), 1) as valor";
      $rsSqlConsultaProjMelhorias    = sqlRecordTabelaTemp($sCampos, null, 'a, t, c');
      $iNumRowsConsultaProjMelhorias = pg_num_rows($rsSqlConsultaProjMelhorias);
      
      for ($dInd = 0; $dInd < $iNumRowsConsultaProjMelhorias; $dInd++) {
        
        logProcessamento($dInd, $iNumRowsConsultaProjMelhorias, 1);
      
        $oConsultaProjMelhoria = db_utils::fieldsMemory($rsSqlConsultaProjMelhorias, $dInd);
        
        $sSqlNextValEditalRua  = "select nextval('editalrua_d02_contri_seq') as codigo";
        $rsSqlNextValEditalRua = pg_query($sSqlNextValEditalRua);
        
        $oNextValEditalRua     = db_utils::fieldsMemory($rsSqlNextValEditalRua, 0);
        
        $sSqlEditalRua  = "insert into editalrua( d02_contri,                      ";
        $sSqlEditalRua .= "                       d02_codedi,                      ";
        $sSqlEditalRua .= "                       d02_codigo,                      ";
        $sSqlEditalRua .= "                       d02_dtauto,                      ";
        $sSqlEditalRua .= "                       d02_autori,                      ";
        $sSqlEditalRua .= "                       d02_idlog,                       ";
        $sSqlEditalRua .= "                       d02_data,                        ";
        $sSqlEditalRua .= "                       d02_profun,                      ";
        $sSqlEditalRua .= "                       d02_valorizacao )                "; 
        $sSqlEditalRua .= "              values ( {$oNextValEditalRua->codigo},    ";
        $sSqlEditalRua .= "                       {$oConsultaProjMelhoria->t},     ";
        $sSqlEditalRua .= "                       {$oConsultaProjMelhoria->c},     ";
        $sSqlEditalRua .= "                       '{$dtDataHoje}',                 ";
        $sSqlEditalRua .= "                       true,                            ";
        $sSqlEditalRua .= "                       1,                               ";
        $sSqlEditalRua .= "                       '{$dtDataHoje}',                 ";
        $sSqlEditalRua .= "                       {$oConsultaProjMelhoria->valor}, ";
        $sSqlEditalRua .= "                       1 )                              ";
      
        db_log($sSqlEditalRua, $sArquivoLog, $iParamLog);
        db_log(' ', $sArquivoLog, $iParamLog);
  
        $rsSqlEditalRua = pg_query($sSqlEditalRua);
        if ( !$rsSqlEditalRua ) {
          throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA editalrua!");
        }
        
        $sCamposEdital = "distinct s";
        $sWhereEdital  = "a = '{$oConsultaProjMelhoria->a}'";
        $rsSqlEditalS  = sqlRecordTabelaTemp($sCamposEdital, $sWhereEdital, 's');
        
        $oEditalS      = db_utils::fieldsMemory($rsSqlEditalS, 0);
        
        $sSqlEditalServ  = "insert into editalserv( d04_contri,                   "; 
        $sSqlEditalServ .= "                        d04_tipos,                    ";
        $sSqlEditalServ .= "                        d04_quant,                    ";
        $sSqlEditalServ .= "                        d04_vlrcal,                   ";
        $sSqlEditalServ .= "                        d04_vlrval,                   ";
        $sSqlEditalServ .= "                        d04_mult,                     ";
        $sSqlEditalServ .= "                        d04_forma,                    ";
        $sSqlEditalServ .= "                        d04_vlrobra )                 ";
        $sSqlEditalServ .= "               values ( {$oNextValEditalRua->codigo}, ";
        $sSqlEditalServ .= "                        1,                            ";
        $sSqlEditalServ .= "                        1,                            ";
        $sSqlEditalServ .= "                        0,                            ";
        $sSqlEditalServ .= "                        {$oEditalS->s},               ";
        $sSqlEditalServ .= "                        1,                            ";
        $sSqlEditalServ .= "                        3,                            ";
        $sSqlEditalServ .= "                        0 )                           ";
        
        db_log($sSqlEditalServ, $sArquivoLog, $iParamLog);
        db_log(' ', $sArquivoLog, $iParamLog);
        
        $rsSqlEditalServ = pg_query($sSqlEditalServ);
        if ( !$rsSqlEditalServ ) {
          throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA editalserv!");
        }
      }

      $sCampos = "a, b, c, d, j";
      $rsSqlConsultaProjMelhorias    = sqlRecordTabelaTemp($sCampos, null, 'b');
      $iNumRowsConsultaProjMelhorias = pg_num_rows($rsSqlConsultaProjMelhorias);
      
      for ($eInd = 0; $eInd < $iNumRowsConsultaProjMelhorias; $eInd++) {
        
        logProcessamento($eInd, $iNumRowsConsultaProjMelhorias, 1);
      
        $oConsultaProjMelhoria = db_utils::fieldsMemory($rsSqlConsultaProjMelhorias, $eInd);

        $sSqlIptuBase     = "select * from iptubase                                                  ";
        $sSqlIptuBase    .= " where j01_matric = {$oConsultaProjMelhoria->b}                         ";
     //   $sSqlIptuBase    .= "   and not exists ( select 1 from contlot where d05_idbql = j01_idbql ) ";
        $rsSqlIptuBase    = pg_query($sSqlIptuBase);
        $iNumRowsIptuBase = pg_num_rows($rsSqlIptuBase);
        
        db_log($sSqlIptuBase, $sArquivoLog, $iParamLog);
        db_log(' ', $sArquivoLog, $iParamLog);
        
        if ( $iNumRowsIptuBase > 0 ) {
        	
        	$oIptuBase = db_utils::fieldsMemory($rsSqlIptuBase, 0);
        	
        	$sSqlBuscaContrib  = " select d02_contri as contribuicao                       ";
					$sSqlBuscaContrib .= "   from projmelhorias                                    ";
					$sSqlBuscaContrib .= "        inner join editalproj on d10_codigo = d40_codigo ";
					$sSqlBuscaContrib .= "        inner join editalrua  on d02_codedi = d10_codedi ";
					$sSqlBuscaContrib .= "                             and d02_codigo = d40_codlog "; 
          $sSqlBuscaContrib .= "        inner join projmelhoriasmatric on projmelhoriasmatric.d41_codigo = d40_codigo and d41_matric = {$oConsultaProjMelhoria->b}";
					$sSqlBuscaContrib .= " where d40_codlog = {$oConsultaProjMelhoria->c}         ";
					$sSqlBuscaContrib .= "   and d40_data = current_date ";

//          $sSqlBuscaContrib .= "    and d40_codigo = {$oConsultaProjMelhoria->a}         ";

if ($oIptuBase->j01_matric == '2206') {
//  die($sSqlBuscaContrib);  
}
		      $rsSqlBuscaContrib = pg_query($sSqlBuscaContrib);
		      
		      $oBuscaContrib     = db_utils::fieldsMemory($rsSqlBuscaContrib, 0);
        	
          $sSqlVerifica = "select * from contlot where d05_contri = {$oBuscaContrib->contribuicao} and d05_idbql = {$oIptuBase->j01_idbql} ";
          $rsVerifica   = pg_query($sSqlVerifica);
          if (pg_num_rows($rsVerifica) == 0 || $rsVerifica == false) {
            $sSqlContlot  = "insert into contlot( d05_contri,                     ";
            $sSqlContlot .= "                     d05_idbql,                      ";
            $sSqlContlot .= "                     d05_testad )                    ";
            $sSqlContlot .= "            values ( {$oBuscaContrib->contribuicao}, ";
            $sSqlContlot .= "                     {$oIptuBase->j01_idbql},        ";
            $sSqlContlot .= "                     $oConsultaProjMelhoria->d )     ";

            db_log($sSqlContlot, $sArquivoLog, $iParamLog);
            db_log(' ', $sArquivoLog, $iParamLog);

            $rsSqlContlot = pg_query($sSqlContlot);
            if ( !$rsSqlContlot ) {
              throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA contlot!");
            }

            $sSqlContloTv  = "insert into contlotv( d06_contri,                      ";
            $sSqlContloTv .= "                      d06_idbql,                       ";
            $sSqlContloTv .= "                      d06_tipos,                       ";
            $sSqlContloTv .= "                      d06_fracao,                      ";
            $sSqlContloTv .= "                      d06_valor )                      ";
            $sSqlContloTv .= "             values ( {$oBuscaContrib->contribuicao},  ";
            $sSqlContloTv .= "                      {$oIptuBase->j01_idbql},         ";
            $sSqlContloTv .= "                      1,                               ";
            $sSqlContloTv .= "                      100.00,                          ";
            $sSqlContloTv .= "                      {$oConsultaProjMelhoria->j} )    ";

            db_log($sSqlContloTv, $sArquivoLog, $iParamLog);
            db_log(' ', $sArquivoLog, $iParamLog);

            $rsSqlContloTv = pg_query($sSqlContloTv);
            if ( !$rsSqlContloTv ) {
              throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA contlotv!");
            }
          }
        } else {
        	
          $sMensagem  = "ERRO MATRICULA {$oConsultaProjMelhoria->b} NAO EXISTE OU JA POSSUI IDBQL! \n ";
          db_log($sMensagem, $sArquivoMatricErro, $iParamLog);
        }        
      }
      
      $sCampos = "distinct a, c";
      $rsSqlConsultaProjMelhorias    = sqlRecordTabelaTemp($sCampos, null, 'a');
      $iNumRowsConsultaProjMelhorias = pg_num_rows($rsSqlConsultaProjMelhorias);
      
      for ($fInd = 0; $fInd < $iNumRowsConsultaProjMelhorias; $fInd++) {
        
        logProcessamento($fInd, $iNumRowsConsultaProjMelhorias, 1);
      
        $oConsultaProjMelhoria = db_utils::fieldsMemory($rsSqlConsultaProjMelhorias, $fInd);
        
        $sSqlBuscaContrib  = " select d02_contri as contribuicao                       ";
        $sSqlBuscaContrib .= "   from projmelhorias                                    ";
        $sSqlBuscaContrib .= "        inner join editalproj on d10_codigo = d40_codigo ";
        $sSqlBuscaContrib .= "        inner join editalrua  on d02_codedi = d10_codedi ";
        $sSqlBuscaContrib .= "                             and d02_codigo = d40_codlog "; 
        $sSqlBuscaContrib .= "        inner join projmelhoriasmatric on projmelhoriasmatric.d41_codigo = d40_codigo ";
        $sSqlBuscaContrib .= "  where d40_codlog = {$oConsultaProjMelhoria->c}         ";
        $sSqlBuscaContrib .= "    and d40_data = current_date                          ";
//        $sSqlBuscaContrib .= "    and d40_codigo = {$oConsultaProjMelhoria->a}         ";
        $rsSqlBuscaContrib = pg_query($sSqlBuscaContrib);
          
        $oBuscaContrib     = db_utils::fieldsMemory($rsSqlBuscaContrib, 0);
        
        $sSqlEditalRuaProj  = "insert into editalruaproj( d11_contri,        ";
        $sSqlEditalRuaProj .= "                           d11_codproj )      ";
        $sSqlEditalRuaProj .= "     values ( {$oBuscaContrib->contribuicao}, ";
        $sSqlEditalRuaProj .= "              {$oConsultaProjMelhoria->a} )   ";
        
        db_log($sSqlEditalRuaProj, $sArquivoLog, $iParamLog);
        db_log(' ', $sArquivoLog, $iParamLog);
        
        $rsSqlEditalRuaProj = pg_query($sSqlEditalRuaProj);
        if ( !$rsSqlEditalRuaProj ) {
          throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA editalruaproj!");
        }
      }
      
	    $sSqlConversao     = "  select b,                                                                ";
      $sSqlConversao    .= "         j,                                                                ";
      $sSqlConversao    .= "         c,                                                                ";
      $sSqlConversao    .= "         e, j01_idbql                                                       ";
//      $sSqlConversao    .= "         d05_contri,                                                       "; 
//      $sSqlConversao    .= "         d05_idbql                                                         ";
      $sSqlConversao    .= "    from w_conversao_t43042                                                ";
      $sSqlConversao    .= "         inner join iptubase on iptubase.j01_matric = w_conversao_t43042.b ";
//      $sSqlConversao    .= "         inner join contlot  on contlot.d05_idbql   = iptubase.j01_idbql   ";
//      $sSqlConversao    .= "   where not exists ( select 1                                             ";
//      $sSqlConversao    .= "                        from contrib                                       ";
//      $sSqlConversao    .= "                       where d07_contri = d05_contri                       ";
//      $sSqlConversao    .= "                         and d07_matric = j01_matric )                     ";
      
      $rsSqlConversao    = pg_query($sSqlConversao);
      $iNumRowsConversao = pg_num_rows($rsSqlConversao);
      
      for ($gInd = 0; $gInd < $iNumRowsConversao; $gInd++) {
        
        logProcessamento($gInd, $iNumRowsConversao, 1);
      
        $oConversao = db_utils::fieldsMemory($rsSqlConversao, $gInd);

        $sSqlBuscaContrib  = " select d02_contri as contribuicao                       ";
        $sSqlBuscaContrib .= "   from projmelhorias                                    ";
        $sSqlBuscaContrib .= "        inner join editalproj on d10_codigo = d40_codigo ";
        $sSqlBuscaContrib .= "        inner join editalrua  on d02_codedi = d10_codedi ";
        $sSqlBuscaContrib .= "                             and d02_codigo = d40_codlog "; 
        $sSqlBuscaContrib .= "        inner join projmelhoriasmatric on projmelhoriasmatric.d41_codigo = d40_codigo ";
        $sSqlBuscaContrib .= "  where d40_codlog = {$oConversao->c}         ";
        $sSqlBuscaContrib .= "    and d41_matric = {$oConversao->b}         ";
        $sSqlBuscaContrib .= "    and d40_data = current_date               ";
        $rsSqlBuscaContrib = pg_query($sSqlBuscaContrib);
          
        $oBuscaContrib     = db_utils::fieldsMemory($rsSqlBuscaContrib, 0);

        $sSqlContrib  = "insert into contrib( d07_contri,                ";
        $sSqlContrib .= "                     d07_matric,                ";
        $sSqlContrib .= "                     d07_idbql,                 ";
        $sSqlContrib .= "                     d07_vlrdes,                ";
        $sSqlContrib .= "                     d07_valor,                 ";
        $sSqlContrib .= "                     d07_data,                  ";
        $sSqlContrib .= "                     d07_venal )                ";
        $sSqlContrib .= "            values ( {$oBuscaContrib->contribuicao}, ";
        $sSqlContrib .= "                     {$oConversao->b},          ";
        $sSqlContrib .= "                     {$oConversao->j01_idbql},  ";
        $sSqlContrib .= "                     0,                         ";
        $sSqlContrib .= "                     {$oConversao->j},          ";
        $sSqlContrib .= "                     '{$dtDataHoje}',           ";
        $sSqlContrib .= "                     {$oConversao->e} )         ";
         
        db_log($sSqlContrib, $sArquivoLog, $iParamLog);
        db_log(' ', $sArquivoLog, $iParamLog);
          
        $rsSqlContrib = pg_query($sSqlContrib);
        if ( !$rsSqlContrib ) {
          throw new Exception("ERRO AO INCLUIR REGISTROS NA TABELA contrib!");
        }
      }
      
//	    pg_query("rollback");
 	    pg_query("commit");
	    
	    $sMensagem = "\n\n - CONVERSAO EXECUTADA COM SUCESSO. VERIFIQUE O ARQUIVO DE LOG! \n\n";
	    db_log($sMensagem, $sArquivoLog, $iParamLog);
	    
	    die($sMensagem);

    } else {
    	
    	$sMensagem  = "\n\n - IMPORTACAO JÁ FOI EXECUTADA NO CLIENTE! \n";
    	$sMensagem .= " - ALERTA: O SCRIPT DE IMPORTACÃO SÓ DEVERÁ SER EXECUTADO UM VEZ NO CLIENTE!";
      throw new Exception($sMensagem);    	
    }
	} catch (Exception $eException) {
	
	  pg_query("rollback");
	  
	  db_log($eException->getMessage(), $sArquivoLog, $iParamLog);
	  die("\n\n - OCORREU ALGUM ERRO AO EXECUTAR O SCRIPT DE CONVERSAO. VERIFIQUE O ARQUIVO DE LOG! \n\n");
	}
} else {
	die("\n\n - OCORREU ALGUM ERRO AO EXECUTAR O SCRIPT DE CONVERSAO. VERIFIQUE O ARQUIVO DE LOG! \n\n");
}

/**
 * Função para consultar tabela w_conversao_t43042
 *
 * @param string_type $sCampos
 * @param string_type $sWhere
 * @param string_type $sOrdem
 * @return $rsSql
 */
function sqlRecordTabelaTemp($sCampos="*", $sWhere=null, $sOrdem="a") { 

  $sSql = "select ";
  if ( $sCampos != "*" ) {
  	
    $aCamposSql = explode("#", $sCampos);
    $sVirgula   = "";
    for($i=0; $i < sizeof($aCamposSql); $i++) {
    	
      $sSql    .= $sVirgula.$aCamposSql[$i];
      $sVirgula = ",";
    }
  } else {
    $sSql .= $sCampos;
  }
  
  $sSql .= " from w_conversao_t43042 ";

  $sSql2 = "";
  if ( !empty($sWhere) ) {
    $sSql2 = " where {$sWhere} ";
  }
  
  $sSql .= $sSql2;
  if ( !empty($sOrdem) ) {
  	
    $sSql      .= " order by ";
    $aCamposSql = explode("#",$sOrdem);
    $sVirgula   = "";
    for ($i = 0; $i < sizeof($aCamposSql); $i++) {
    	
      $sSql    .= $sVirgula.$aCamposSql[$i];
      $sVirgula = ",";
    }
  }
  
  echo $sSql." \n\n";
  
  $rsSql = pg_query($sSql);
  
  return $rsSql;
}

/**
 * Funcao para dar echo dos Logs - retorna o TimeStamp
 *
 * Tipos: 0 = Saida Tela e Arquivo
 *        1 = Saida Somente Tela
 *        2 = Saida Somente Arquivo 
 * 
 * @param string_type $sLog
 * @param string_type $sArquivo
 * @param integer_type $iTipo
 * @param boolean_type $lLogDataHora
 * @param boolean_type $lQuebraAntes
 * @return $aDataHora
 */
function db_log($sLog = "", $sArquivo = "", $iTipo = 0, $lLogDataHora = true, $lQuebraAntes = true) {

  $aDataHora    = getdate();
  $sQuebraAntes = $lQuebraAntes ? "\n" : "";
  
  if ($lLogDataHora) {
  	
    $sOutputLog = sprintf("%s[%02d/%02d/%04d %02d:%02d:%02d] %s", 
                          $sQuebraAntes, 
                          $aDataHora ["mday"], 
                          $aDataHora ["mon"], 
                          $aDataHora ["year"], 
                          $aDataHora ["hours"], 
                          $aDataHora ["minutes"], 
                          $aDataHora ["seconds"], 
                          $sLog);
  } else {
    $sOutputLog = sprintf("%s%s", $sQuebraAntes, $sLog);
  }
  
  /* Se habilitado saida na tela */
  if ( $iTipo == 0 or $iTipo == 1 ) {
    echo $sOutputLog;
  }
  
  /* Se habilitado saida para arquivo */
  if ( $iTipo == 0 or $iTipo == 2 ) {
  	
    if ( !empty($sArquivo) ) {
    	
      $fd = fopen($sArquivo, "a+");
      if ($fd) {
      	
        fwrite($fd, $sOutputLog);
        fclose($fd);
      }
    }
  }
  
  return $aDataHora;
}

/**
 * Função que exibe na tela a quantidade de registros processados 
 * e a quandidade de memória utilizada
 *
 * @param integer $iInd      Indice da linha que está sendo processada
 * @param integer $iTotalLinhas  Total de linhas a processar
 * @param integer $iParamLog     Caso seja passado true é exibido na tela 
 */
function logProcessamento($iInd, $iTotalLinhas, $iParamLog){
  
  $nPercentual = round((($iInd + 1) / $iTotalLinhas) * 100, 2);
  $nMemScript  = (float)round( (memory_get_usage()/1024 ) / 1024,2);
  $sMemScript  = $nMemScript ." Mb";
  $sMsg        = "".($iInd+1)." de {$iTotalLinhas} Processando ".str_pad($nPercentual,5,' ',STR_PAD_LEFT)." %"." Total de memoria utilizada : {$sMemScript} ";
  $sMsg        = str_pad($sMsg,100," ",STR_PAD_RIGHT);
  
  db_log($sMsg."\r", null, $iParamLog, true, false);
}
?>
