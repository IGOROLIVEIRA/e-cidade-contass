<?php

/**
* Este programa ira salvar CONCORRENTEDETALHE (caso não exista), CONTACORRENTESALDO, CONEXTSALDO, CONCTBSALDO.
* as informações iram vir da tabela CTB20(ANOUSU) E EXT20(ANOUSU).
*/

require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("std/DBDate.php");
require_once "model/contabilidade/planoconta/ContaCorrente.model.php";
require_once "model/contabilidade/planoconta/ContaPlano.model.php";
require_once("classes/db_conextsaldo_classe.php");
require_once("classes/db_conctbsaldo_classe.php");
db_app::import("configuracao.*");
db_app::import("contabilidade.*");
db_app::import("contabilidade.planoconta.*");
db_app::import("financeiro.*");
db_app::import("exceptions.*");

db_postmemory($_POST);

$oJson  = new services_json();
$oParam = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = '';
$sqlerro = false;

$ano = $oParam->ano;
try {
    switch ($oParam->exec) {

      case 'importSaldoCtbExt':

          db_inicio_transacao();

          $sSqlGeral = "select  10 as tiporegistro,
                         k13_reduz as icodigoreduzido,
                         c61_codtce as codtce,
                         si95_reduz,
                         si09_codorgaotce,
                         c63_banco,
                         c63_agencia,
                         c63_conta,
                         c63_dvconta,
                         c63_dvagencia,
                         case when db83_tipoconta in (2,3) then 2 else 1 end as tipoconta,
                         ' ' as tipoaplicacao,
                         ' ' as nroseqaplicacao,
                         db83_descricao as desccontabancaria,
                         CASE WHEN (db83_convenio is null or db83_convenio = 2) then 2 else  1 end as contaconvenio,
                         case when db83_convenio = 1 then db83_numconvenio else null end as nroconvenio,
                         case when db83_convenio = 1 then db83_dataconvenio else null end as dataassinaturaconvenio,
                         o15_codtri as recurso, c61_codcon as codcon
                   from saltes
                   join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = ".db_getsession("DB_anousu")."
                   join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
                   join orctiporec on c61_codigo = o15_codigo
              left join conplanocontabancaria on c56_codcon = c61_codcon and c56_anousu = c61_anousu
              left join contabancaria on c56_contabancaria = db83_sequencial
              left join acertactb on si95_codtceant = c61_codtce
              left join infocomplementaresinstit on si09_instit = c61_instit
                where  k13_limite is null and c61_instit = ".db_getsession("DB_instit")."  order by k13_reduz ";
               
          $rsContas = db_query($sSqlGeral);
         // db_criatabela($rsContas);
          $aBancosAgrupados = array();

          $rsContas = db_query($sSqlGeral);

          for ($iCont = 0;$iCont < pg_num_rows($rsContas); $iCont++) {

              $oRegistro10 = db_utils::fieldsMemory($rsContas,$iCont);

              $aHash  = $oRegistro10->si09_codorgaotce;
              $aHash .= intval($oRegistro10->c63_banco);
              $aHash .= intval($oRegistro10->c63_agencia);
              $aHash .= ($oRegistro10->c63_dvagencia);
              $aHash .= intval($oRegistro10->c63_conta);
              $aHash .= ($oRegistro10->c63_dvconta);
              $aHash .= $oRegistro10->tipoconta;
              if ($oRegistro10->si09_codorgaotce == 5) {
                  $aHash .= $oRegistro10->tipoaplicacao;
              }

              if(!isset($aBancosAgrupados[$aHash])){

                  $cCtb10    =  new stdClass();

                  $cCtb10->icodigoreduzido = $oRegistro10->icodigoreduzido;
                  $cCtb10->codcon = $oRegistro10->codcon;
                  $cCtb10->codtce = $oRegistro10->codtce;
                  $cCtb10->si95_reduz = $oRegistro10->si95_reduz;
                  $cCtb10->contas = array();
                  $aBancosAgrupados[$aHash] = $cCtb10;

              }else{
                  $aBancosAgrupados[$aHash]->contas[] = $oRegistro10->icodigoreduzido;
              }

          }

          $anousu = db_getsession("DB_anousu") - 1;
          $aSaldoCtbExt = array();
          foreach ($aBancosAgrupados as $aBancosAgrupado) {
              //echo "<pre>";print_r($aBancosAgrupado);
            if ($ctb = $aBancosAgrupado->si95_reduz != '')
                $ctb = $aBancosAgrupado->si95_reduz ;
            else if($aBancosAgrupado->codtce != '' && $aBancosAgrupado->codtce != 0 )
                $ctb = $aBancosAgrupado->codtce ;
            else $ctb = $aBancosAgrupado->icodigoreduzido;
            $sSQL = "select si96_codfontrecursos, si96_vlsaldofinalfonte from ctb20{$anousu} where si96_codctb = {$ctb} and si96_mes = 12 and si96_instit = ".db_getsession("DB_instit");

           // echo $sSQL;
            $rsResult = db_query($sSQL);
            //db_criatabela($rsResult);exit;
            $oCtbFontes = db_utils::getCollectionByRecord($rsResult);
            
            foreach ($oCtbFontes as $oCtbFonte) {
              $aHash = $aBancosAgrupado->icodigoreduzido.$oCtbFonte->si96_codfontrecursos;

              $ctbFonte = new stdClass();
              $ctbFonte->icodigoreduzido = $aBancosAgrupado->icodigoreduzido;
              $ctbFonte->si96_codfontrecursos = $oCtbFonte->si96_codfontrecursos;
              $ctbFonte->si96_vlsaldofinalfonte = $oCtbFonte->si96_vlsaldofinalfonte;
              $ctbFonte->tipo = "ctb";
              $ctbFonte->codcon = $aBancosAgrupado->codcon;
              $aSaldoCtbExt[$aHash] = $ctbFonte;
            }
          }

          $sSqlExt = "select 10 as tiporegistro,c61_codcon as codcon,
               c61_reduz as codext,
               c61_codtce as codtce,
               si09_codorgaotce as codorgao,
               (select CASE
                      WHEN o41_subunidade != 0
                           OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
                              OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                                OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
                      ELSE lpad((CASE WHEN o40_codtri = '0'
                           OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
                             OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
                       end as unidade
            from orcunidade
            join orcorgao on o41_anousu = o40_anousu and o41_orgao = o40_orgao
            where o41_instit = " . db_getsession("DB_instit") . " and o40_anousu = " . db_getsession("DB_anousu") . " order by o40_orgao limit 1) as codUnidadeSub,
               substr(c60_tipolancamento::varchar,1,2) as tipolancamento,
               c60_subtipolancamento as subtipo,
               case when (c60_tipolancamento = 1 and c60_subtipolancamento in (1,2,3,4) ) or
                         (c60_tipolancamento = 4 and c60_subtipolancamento in (1,2) ) or
                         (c60_tipolancamento = 9999 and c60_desdobramneto is not null) then c60_desdobramneto
                    else 0
               end as desdobrasubtipo,
               substr(c60_descr,1,50) as descextraorc
          from conplano
          join conplanoreduz on c60_codcon = c61_codcon and c60_anousu = c61_anousu
          left join infocomplementaresinstit on si09_instit = c61_instit
          where c60_anousu = " . db_getsession("DB_anousu") . " and c60_codsis = 7 
          and c61_instit = " . db_getsession("DB_instit") . " order by c61_reduz ";
        
          $rsContasExtra = db_query($sSqlExt);  
          
          $aExt10Agrupado = array();
          for ($iCont10 = 0;$iCont10 < pg_num_rows($rsContasExtra); $iCont10++) {

              $oContaExtra = db_utils::fieldsMemory($rsContasExtra,$iCont10);

              $aHash  = $oContaExtra->codorgao;
              $aHash .= $oContaExtra->codunidadesub;
              $aHash .= $oContaExtra->tipolancamento;
              $aHash .= $oContaExtra->subtipo;
              $aHash .= $oContaExtra->desdobrasubtipo;

              if(!isset($aExt10Agrupado[$aHash])){
                  $cExt10 = new stdClass();

                  $cExt10->codext = $oContaExtra->codext;
                  $cExt10->codtce = $oContaExtra->codtce;
                  $cExt10->codcon = $oContaExtra->codcon;
                  $cExt10->extras = array();

                  $cExt10->extras[]= $oContaExtra->codext;
                  $aExt10Agrupado[$aHash] = $cExt10;
              }else{
                  $aExt10Agrupado[$aHash]->extras[] = $oContaExtra->codext;
              }

          }
          
          foreach ($aExt10Agrupado as $oExt10Agrupado) {
            $ext = $oExt10Agrupado->codtce != '' ? $oExt10Agrupado->codtce : $oExt10Agrupado->codext;
            $sSQL = "select si165_codfontrecursos, si165_vlsaldoatualfonte, si165_natsaldoatualfonte from ext20{$anousu} 
                      where si165_codext = {$ext} and si165_mes = 12 
                      and si165_instit = ".db_getsession("DB_instit"); 
            $rsResult = db_query($sSQL); 
            $oExtFontes = db_utils::getCollectionByRecord($rsResult);

            foreach ($oExtFontes as $oExtFonte) {
              $aHash = $oExt10Agrupado->codext.$oExtFonte->si165_codfontrecursos;

              $extFonte = new stdClass();
              $extFonte->icodigoreduzido = $oExt10Agrupado->codext;
              $extFonte->si96_codfontrecursos = $oExtFonte->si165_codfontrecursos;
              $extFonte->si96_vlsaldofinalfonte = $oExtFonte->si165_natsaldoatualfonte=='C' ? abs($oExtFonte->si165_vlsaldoatualfonte) * (-1) : abs($oExtFonte->si165_vlsaldoatualfonte);
              $extFonte->tipo = "ext";
              $extFonte->codcon = $oExt10Agrupado->codcon;
              $aSaldoCtbExt[$aHash] = $extFonte;
            }
          }

          foreach ($aSaldoCtbExt as $oSaldoCtb) {

              $oDaoContaCorrenteDetalhe = db_utils::getDao('contacorrentedetalhe');
              $oDaoVerificaDetalhe = db_utils::getDao('contacorrentedetalhe');

              $iReduzido = $oSaldoCtb->icodigoreduzido; // do array
              $iCodCon = $oSaldoCtb->codcon;
              $iContaCorrente = 103; // sempre 103
              $iInstituicao = db_getsession("DB_instit");
              $iAnoUsu = db_getsession("DB_anousu");

              $iTipoReceita = $oSaldoCtb->si96_codfontrecursos;// si96_codfontrecursos
              $iConcarPeculiar = null; // null
              $iContaBancaria = null; // null
              $iEmpenho = null; // null
              $iNome = null; // null
              $iOrgao = null; // null
              $iUnidade = null; // null
              $iAcordo = null; // null

              $sWhereVerificacao =  "     c19_contacorrente       = {$iContaCorrente}    ";
              $sWhereVerificacao .= " and c19_orctiporec          = {$iTipoReceita}      ";
              $sWhereVerificacao .= " and c19_instit              = {$iInstituicao}      ";
              $sWhereVerificacao .= " and c19_reduz               = {$iReduzido}         ";
              $sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}           ";

              $sSqlVerificaDetalhe = $oDaoVerificaDetalhe->sql_query_file(null, "*", null, $sWhereVerificacao);
             
              $rsVerificacao = $oDaoVerificaDetalhe->sql_record($sSqlVerificaDetalhe);

              if ($oDaoVerificaDetalhe->numrows > 0) {
                  $sDescricaoContaCorrenteErro = "103 - Fonte de Recurso";
                  $oContaCorrente = db_utils::fieldsMemory($rsVerificacao, 0);
              }

              $oDaoContaCorrenteDetalhe->c19_contacorrente = $iContaCorrente;
              $oDaoContaCorrenteDetalhe->c19_orctiporec = $iTipoReceita;
              $oDaoContaCorrenteDetalhe->c19_instit = $iInstituicao;
              $oDaoContaCorrenteDetalhe->c19_reduz = $iReduzido;
              $oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu = $iAnoUsu;

              if ($oDaoVerificaDetalhe->numrows == 0) {

                  $oDaoContaCorrenteDetalhe->incluir(null);
                  if ($oDaoContaCorrenteDetalhe->erro_status == 0 || $oDaoContaCorrenteDetalhe->erro_status == '0') {
                      $sqlerro = true;
                      throw new DBException(urlencode('ERRO - [ 1 ] - Incluindo Detalhe de Conta Corrente : ' 
                        . $oDaoContaCorrenteDetalhe->erro_msg));
                  }
                  salvarSaldo($oDaoContaCorrenteDetalhe, $oSaldoCtb->si96_vlsaldofinalfonte);
                  salvarSaldoSICOMAM($oSaldoCtb);
                  continue;
              }
              salvarSaldo($oContaCorrente, $oSaldoCtb->si96_vlsaldofinalfonte);
              salvarSaldoSICOMAM($oSaldoCtb);
              
              $oRetorno->message = urlencode("Implantação realizada com sucesso."); 
          }
          db_fim_transacao(false);
          break;

		case "importSaldoCtbExtContaCorrenteDetalhe":

			$iAnoUsu = db_getsession("DB_anousu");

			$sSqlConSaldoCtbExt = "	SELECT c.ces01_reduz AS reduzido,
											c.ces01_fonte AS fonte,
											c61_codtce AS codtce,
											c.ces01_valor AS valor,
											c.ces01_anousu AS anousu,
											c.ces01_inst AS instit,
											CASE 
												WHEN c.ces01_valor < 0 THEN c62_vlrcre
												ELSE c62_vlrdeb
											END AS saldoinicial,
											(SELECT coalesce(sum(ces01_valor),0)
												FROM conextsaldo
												WHERE ces01_reduz = c.ces01_reduz
													AND ces01_anousu = c.ces01_anousu) AS totalconta,
											'EXT' AS tipo
									FROM conextsaldo AS c
										INNER JOIN conplanoexe ON c62_reduz = c.ces01_reduz AND c62_anousu = c.ces01_anousu
										INNER JOIN conplanoreduz ON c61_reduz = c.ces01_reduz AND c61_anousu = c.ces01_anousu
									WHERE c.ces01_anousu = {$iAnoUsu}
											AND c.ces01_valor <> 0	
									UNION ALL								
									SELECT c.ces02_reduz AS reduzido,
											c.ces02_fonte AS fonte,
											c61_codtce AS codtce,
											c.ces02_valor AS valor,
											c.ces02_anousu AS anousu,
											c.ces02_inst AS instit,
											CASE 
												WHEN c.ces02_valor < 0 THEN c62_vlrcre
												ELSE c62_vlrdeb
											END AS saldoinicial,
											(SELECT coalesce(sum(ces02_valor),0)
												FROM conctbsaldo
												WHERE ces02_reduz = c.ces02_reduz
													AND ces02_anousu = c.ces02_anousu) AS totalconta,
											'CTB' AS tipo
									FROM conctbsaldo AS c
										INNER JOIN conplanoexe ON c62_reduz = c.ces02_reduz AND c.ces02_anousu = c62_anousu
										INNER JOIN conplanoreduz ON c61_reduz = c.ces02_reduz AND c61_anousu = c.ces02_anousu
									WHERE c.ces02_anousu = {$iAnoUsu}
										AND c.ces02_valor <> 0";

			$rsConSaldoCtbExt = db_query($sSqlConSaldoCtbExt);
			
			if (pg_num_rows($rsConSaldoCtbExt) < 1) {
				throw new DBException(urlencode('ERRO - [ 2 ] - Nenhum registro encontrado nas tabelas conctbsaldo/conextsaldo!'));
			}

			db_inicio_transacao();

			$sLogContasNaoImplantadas = '';

			for ($iCont = 0;$iCont < pg_num_rows($rsConSaldoCtbExt); $iCont++) {

				$oConta = db_utils::fieldsMemory($rsConSaldoCtbExt,$iCont);

				if ($oConta->saldoinicial != abs($oConta->totalconta)) {
					
					$sLogContasNaoImplantadas .= "Tipo: {$oConta->tipo}, ";
					$sLogContasNaoImplantadas .= "Cod. Reduzido: {$oConta->reduzido}, ";
					$sLogContasNaoImplantadas .= "Fonte: {$oConta->fonte}, ";
					$sLogContasNaoImplantadas .= "Cod. TCE: {$oConta->codtce}, ";
					$sLogContasNaoImplantadas .= "Valor: {$oConta->valor}, ";
					$sLogContasNaoImplantadas .= "Instituição: {$oConta->instit}, ";
					$sLogContasNaoImplantadas .= "Saldo Inicial: {$oConta->saldoinicial}. \n\n";

					continue;

				}

				$oDaoContaCorrenteDetalhe 	= db_utils::getDao('contacorrentedetalhe');
              	$oDaoVerificaDetalhe 		= db_utils::getDao('contacorrentedetalhe');

              	$iReduzido 		= $oConta->reduzido;
				$iContaCorrente = 103;
				$iInstituicao 	= db_getsession("DB_instit");
				$iTipoReceita 	= $oConta->fonte;

				$sWhereVerificacao =  "     c19_contacorrente       = {$iContaCorrente}    ";
				$sWhereVerificacao .= " and c19_orctiporec          = {$iTipoReceita}      ";
				$sWhereVerificacao .= " and c19_instit              = {$iInstituicao}      ";
				$sWhereVerificacao .= " and c19_reduz               = {$iReduzido}         ";
				$sWhereVerificacao .= " and c19_conplanoreduzanousu = {$iAnoUsu}           ";

              	$sSqlVerificaDetalhe 	= $oDaoVerificaDetalhe->sql_query_file(null, "*", null, $sWhereVerificacao);             
              	$rsVerificacao 			= $oDaoVerificaDetalhe->sql_record($sSqlVerificaDetalhe);

				$oDaoContaCorrenteDetalhe->c19_contacorrente 		= $iContaCorrente;
				$oDaoContaCorrenteDetalhe->c19_orctiporec 			= $iTipoReceita;
				$oDaoContaCorrenteDetalhe->c19_instit 				= $iInstituicao;
				$oDaoContaCorrenteDetalhe->c19_reduz 				= $iReduzido;
				$oDaoContaCorrenteDetalhe->c19_conplanoreduzanousu 	= $iAnoUsu;

              	if ($oDaoVerificaDetalhe->numrows == 0) {

                  	$oDaoContaCorrenteDetalhe->incluir(null);
                  	if ($oDaoContaCorrenteDetalhe->erro_status == 0 || $oDaoContaCorrenteDetalhe->erro_status == '0') {
                      	$sqlerro = true;
                      	throw new DBException(urlencode('ERRO - [ 3 ] - Erro ao incluir no Conta Corrente Detalhe!: ' 
                        	. $oDaoContaCorrenteDetalhe->erro_msg));
                  	}
                  	
					salvarSaldo($oDaoContaCorrenteDetalhe, $oConta->valor);
                  	continue;
              	}

				if ($oDaoVerificaDetalhe->numrows > 0) {
					$sDescricaoContaCorrenteErro = "103 - Fonte de Recurso";
					$oContaCorrente = db_utils::fieldsMemory($rsVerificacao, 0);
				}

				salvarSaldo($oContaCorrente, $oConta->valor);
              
              	$oRetorno->message = urlencode("Implantação no conta corrente detalhe realizada com sucesso.");

			}

			$oRetorno->sArquivoLog = '';

			if (!empty($sLogContasNaoImplantadas)) {
				
				$sArquivoLog = 'tmp/implantacao_saldo_conta_corrente_' . date('Y-m-d_H:i:s') . '.log';
				file_put_contents($sArquivoLog, $sLogContasNaoImplantadas);
				$oRetorno->sArquivoLog = $sArquivoLog;

			}

			db_fim_transacao($sqlerro);

		break;

    }

  } catch(Exception $eErro) {

      $oRetorno->status  = 2;
      $sGetMessage       = $eErro->getMessage();
      $oRetorno->message = $sGetMessage;

  }
function salvarSaldoSICOMAM( $oSaldoCtb ){
    
    if($oSaldoCtb->tipo == 'ext'){
      $clconextsaldo = new cl_conextsaldo;
      $clconextsaldo->ces01_codcon  = $oSaldoCtb->codcon;
      $clconextsaldo->ces01_reduz = $oSaldoCtb->icodigoreduzido;
      $clconextsaldo->ces01_fonte = $oSaldoCtb->si96_codfontrecursos;
      $clconextsaldo->ces01_valor = $oSaldoCtb->si96_vlsaldofinalfonte;
      $clconextsaldo->ces01_anousu = db_getsession('DB_anousu');
      $clconextsaldo->ces01_inst = db_getsession('DB_instit');
      $rsVerificacaoExt = $clconextsaldo->sql_record($clconextsaldo->sql_query('','*','',"ces01_codcon =  $oSaldoCtb->codcon 
        and ces01_fonte = $oSaldoCtb->si96_codfontrecursos and ces01_anousu = " . db_getsession('DB_anousu') ." 
        and c60_anousu = " . db_getsession('DB_anousu') ));
      
      if($clconextsaldo->erro_status > 0){
          throw new DBException("ERRO 12 " . $clconextsaldo->erro_msg);
      }
      if($clconextsaldo->numrows > 0){

        $oExt = db_utils::fieldsMemory($rsVerificacaoExt, 0);
        $clconextsaldo->ces01_valor = $oSaldoCtb->si96_vlsaldofinalfonte;
        $clconextsaldo->ces01_sequencial = $oExt->ces01_sequencial;
        $clconextsaldo->alterar($oExt->ces01_sequencial);
        
        if($clconextsaldo->erro_status == 0){
          throw new DBException("ERRO 13 " . $clconextsaldo->erro_msg);
        }

      }else{
        if($oSaldoCtb->si96_vlsaldofinalfonte <> 0){
            $clconextsaldo->incluir($ces01_sequencial);

          if($clconextsaldo->erro_status == 0){
            throw new DBException("ERRO 14 " . $clconextsaldo->erro_msg);
          }
        }

      }
    }else{

      $clconctbsaldo = new cl_conctbsaldo;
      $clconctbsaldo->ces02_codcon  = $oSaldoCtb->codcon;
      $clconctbsaldo->ces02_reduz = $oSaldoCtb->icodigoreduzido;
      $clconctbsaldo->ces02_fonte = $oSaldoCtb->si96_codfontrecursos;
      $clconctbsaldo->ces02_valor = $oSaldoCtb->si96_vlsaldofinalfonte;
      $clconctbsaldo->ces02_anousu = db_getsession('DB_anousu');
      $clconctbsaldo->ces02_inst = db_getsession('DB_instit');
      $rsVerificacaoCtb = $clconctbsaldo->sql_record($clconctbsaldo->sql_query('','*',''," ces02_codcon =  $oSaldoCtb->codcon 
        and ces02_fonte = $oSaldoCtb->si96_codfontrecursos and ces02_anousu = " . db_getsession('DB_anousu') ) );

      if($clconctbsaldo->numrows > 0){

        $oCtb = db_utils::fieldsMemory($rsVerificacaoCtb, 0);
        $clconctbsaldo->ces02_valor = $oSaldoCtb->si96_vlsaldofinalfonte;
        $clconctbsaldo->ces02_sequencial = $oCtb->ces02_sequencial;
        $clconctbsaldo->alterar($oCtb->ces02_sequencial);

        if($clconctbsaldo->erro_status == 0){
          throw new DBException("ERRO 15 " . $clconctbsaldo->erro_msg);
        }

      }else{
        if($oSaldoCtb->si96_vlsaldofinalfonte <> 0){
           $clconctbsaldo->incluir($ces02_sequencial);
           if($clconctbsaldo->erro_status == 0){
              throw new DBException("ERRO 16 " . $clconctbsaldo->erro_msg);
           }
        }
      }
    }
}
function salvarSaldo($saldo, $valorSaldo){
  
  $iCodigoReduzido = $saldo->c19_reduz;
  $sColunaImplantar = "c29_credito";
  $sColunaZerar = "c29_debito";

  $iAnoUsu = db_getsession("DB_anousu");

      /**
       * Remove os registros existentes na contacorrentesaldo para o ano atual e mes 0 do contacorrentedetalhe em questao
       */
      $oDaoContaCorrenteSaldo = new cl_contacorrentesaldo();
      $sWhereExcluir = "c29_anousu = {$iAnoUsu} and c29_mesusu = 0 and c29_contacorrentedetalhe = {$saldo->c19_sequencial}";
      $oDaoContaCorrenteSaldo->excluir(null, $sWhereExcluir);
      
      if ($oDaoContaCorrenteSaldo->erro_status == "0") {
          throw new DBException(urlencode("ERRO [ 22 ] - Excluindo Registros - " . $oDaoContaCorrenteSaldo->erro_msg ."<br>"));
      }

      if ($valorSaldo <> 0) {
          
          if ($valorSaldo < 0) {

              $sColunaImplantar = "c29_credito";
              $sColunaZerar = "c29_debito";

          } else {
              $sColunaImplantar = "c29_debito";
              $sColunaZerar = "c29_credito";
          }

          
          /*
           * modificação para reajustar valores, basicamente devemos verificar se
           * ja foi feita implantação na contacorrentesaldo pelo detalhe em questão
           * se retornar registro, para o detalhe, ano e mes = 0, significa que devemos altera-lo
           * se não retornar significa que é a primeira vez que está sendo implantado e logo devemos incluir registro na
           * contacorrentesaldo
           */
          $sWhereImplantacao = "     c29_contacorrentedetalhe = {$saldo->c19_sequencial} ";
          $sWhereImplantacao .= " and c29_anousu = {$iAnoUsu} ";
          $sWhereImplantacao .= " and c29_mesusu = 0 ";
          $sSqlImplantcao = $oDaoContaCorrenteSaldo->sql_query_file(null, "*", null, $sWhereImplantacao);
          $rsImplantacao = $oDaoContaCorrenteSaldo->sql_record($sSqlImplantcao);

          $oDaoContaCorrenteSaldo->c29_contacorrentedetalhe = $saldo->c19_sequencial;
          $oDaoContaCorrenteSaldo->c29_anousu = $iAnoUsu;
          $oDaoContaCorrenteSaldo->c29_mesusu = '0';
          $oDaoContaCorrenteSaldo->$sColunaImplantar = abs($valorSaldo);
          $oDaoContaCorrenteSaldo->$sColunaZerar = '0';

          // se retornou registros devemos alterar
          if ($oDaoContaCorrenteSaldo->numrows > 0) {

              $oValoresInplantados = db_utils::fieldsMemory($rsImplantacao, 0);

              $oDaoContaCorrenteSaldo->c29_sequencial = $oValoresInplantados->c29_sequencial;
              $oDaoContaCorrenteSaldo->alterar($oDaoContaCorrenteSaldo->c29_sequencial);

          } else { // senao, incluimos

              $oDaoContaCorrenteSaldo->incluir(null);

          }


          if ($oDaoContaCorrenteSaldo->erro_status == "0") {
              throw new DBException(urlencode("ERRO [ 2 ] - Atualizando Registros - " . $oDaoContaCorrenteSaldo->erro_msg));
          }
      }

}

if (isset($oRetorno->erro)) {
  $oRetorno->erro = utf8_encode($oRetorno->erro);
}

echo $oJson->encode($oRetorno);
