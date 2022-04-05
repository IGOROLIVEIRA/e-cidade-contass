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

try {
    switch ($oParam->exec) {

      case 'importarSaldoContaCorrente':

		$iAnoUsu = $oParam->ano;

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
