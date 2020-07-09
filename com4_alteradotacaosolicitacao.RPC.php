<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("std/db_stdClass.php");
require_once("model/itemSolicitacao.model.php");
require_once("model/Acordo.model.php");
require_once("model/AcordoItem.model.php");
require_once("model/Dotacao.model.php");
require_once("model/empenho/AutorizacaoEmpenho.model.php");
require_once("classes/solicitacaocompras.model.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = 1;
$lErro             = false;
$sMensagem         = "";

switch($oParam->exec) {

	case "pesquisarSolicitacoes":

		$sWhere = " pc10_instit = " . db_getsession("DB_instit");
		if (isset($oParam->filtros->iLicitacao) && !empty($oParam->filtros->iLicitacao)) {
			$sWhere .= " and l20_codigo = {$oParam->filtros->iLicitacao}";
		}
		if ((isset($oParam->filtros->iNumeroSolicitacaoInicial) && !empty($oParam->filtros->iNumeroSolicitacaoInicial)) &&
			(isset($oParam->filtros->iNumeroSolicitacaoFinal) && !empty($oParam->filtros->iNumeroSolicitacaoFinal))) {

			$sBetween = "between {$oParam->filtros->iNumeroSolicitacaoInicial} and {$oParam->filtros->iNumeroSolicitacaoFinal}";
			$sWhere .= " and pc10_numero {$sBetween}";

		} else if (isset($oParam->filtros->iNumeroSolicitacaoInicial) && !empty($oParam->filtros->iNumeroSolicitacaoInicial)) {
			$sWhere .= " and pc10_numero = {$oParam->filtros->iNumeroSolicitacaoInicial}";
		}

		if ((isset($oParam->filtros->dtDataSolicitacaoInicial) && !empty($oParam->filtros->dtDataSolicitacaoInicial)) &&
			(isset($oParam->filtros->dtDataSolicitacaoFinal) && !empty($oParam->filtros->dtDataSolicitacaoFinal))) {

			$sDataInicial = implode("-", array_reverse(explode("/", $oParam->filtros->dtDataSolicitacaoInicial)));
			$sDataFinal = implode("-", array_reverse(explode("/", $oParam->filtros->dtDataSolicitacaoFinal)));
			$sWhere .= " and pc10_data between '{$sDataInicial}' and '{$sDataFinal}'";
		} else if (isset($oParam->filtros->dtDataSolicitacaoInicial) && !empty($oParam->filtros->dtDataSolicitacaoInicial)) {

			$sDataInicial = implode("-", array_reverse(explode("/", $oParam->filtros->dtDataSolicitacaoInicial)));
			$sWhere .= " and pc10_data =  '{$sDataInicial}'";
		}
		if (isset($oParam->filtros->aSolicitacoes) && count($oParam->filtros->aSolicitacoes) > 0) {
			$sWhere .= " and pc10_numero in(" . implode(", ", $oParam->filtros->aSolicitacoes) . ")";
		}
		$sWhere .= " and pc10_solicitacaotipo in (1, 2)";
		$sWhere .= " group by pc10_numero,  pc10_data, pc10_resumo, pc10_solicitacaotipo";

		$oDaoSolicita = db_utils::getDao("solicita");

		$sCamposSolicita = " distinct             ";
		$sCamposSolicita .= "pc10_numero,          ";
		$sCamposSolicita .= "pc10_data,            ";
		$sCamposSolicita .= "pc10_resumo,          ";
		$sCamposSolicita .= "pc10_solicitacaotipo, ";
		$sCamposSolicita .= "array_to_string(array_accum(distinct pc13_coddot||'/'||pc13_anousu),', ')  as pc13_coddot";

		$sSqlDadosSolicitacao = $oDaoSolicita->sql_query_licitacao_dotacao(null, $sCamposSolicita, null, $sWhere);
		$rsDadosSolicitacao = $oDaoSolicita->sql_record($sSqlDadosSolicitacao);

		$aSolicitacoes = db_utils::getColectionByRecord($rsDadosSolicitacao, false, false, false);
		$aDadosSolicitacao = array();
		$lIemSemDotacao = 0;

		foreach ($aSolicitacoes as $iIndSolicitacoes => $oValorSolicitacoes) {

			$oDados = new stdClass();

			/*
			 * verificamos se a solicitacao possui algum item sem dotacao
			 */
			$lIemSemDotacao = itemSolicitacao::verificaItemSolicitacaoSemDotacao($oValorSolicitacoes->pc10_numero);

			$sResumo = $oValorSolicitacoes->pc10_resumo;
			$oDados->solicitacao = $oValorSolicitacoes->pc10_numero;
			$oDados->dtEmis = db_formatar($oValorSolicitacoes->pc10_data, "d");
			$oDados->dotacoes = $oValorSolicitacoes->pc13_coddot;
			$oDados->resumo = urlencode(substr($oValorSolicitacoes->pc10_resumo, 0, 100));
			$oDados->lIemSemDotacao = $lIemSemDotacao;
			$aDadosSolicitacao[] = $oDados;
		}

		$oRetorno->aSolicitacoes = $aDadosSolicitacao;

		break;

	case "getDotacoes":

		$aDotacoesItens = array();
		$oDadosSolicitacao = db_utils::getDao("solicitem");
		$whereItensDotacao = "pc10_numero = {$oParam->iCodigoSolicitacao}";
		$sCamposItensDotacao = "pc13_anousu,     ";
		$sCamposItensDotacao .= "pc13_coddot,     ";
		$sCamposItensDotacao .= "pc13_valor,      ";
		$sCamposItensDotacao .= "pc13_quant,      ";
		$sCamposItensDotacao .= "pc13_sequencial, ";
		$sCamposItensDotacao .= "pc01_codmater,   ";
		$sCamposItensDotacao .= "pc11_codigo,     ";
		$sCamposItensDotacao .= "pc01_descrmater, ";
		$sCamposItensDotacao .= "o56_elemento,    ";
		$sCamposItensDotacao .= "pc11_seq         ";

		$sSqlItensDotacao = $oDadosSolicitacao->sql_query_pcmater_dotacao(null,
			$sCamposItensDotacao,
			"pc13_coddot, pc11_seq, pc01_codmater",
			$whereItensDotacao
		);

		$rsItensDotacao = $oDadosSolicitacao->sql_record($sSqlItensDotacao);

		if ($oDadosSolicitacao->numrows == 0) {

			$oRetorno->message = "Não existe itens para esta solicitação.";
			$oRetorno->status = 2;
		} else {

			$iNumRows = $oDadosSolicitacao->numrows;
			for ($i = 0; $i < $iNumRows; $i++) {

				$oItensDotacao = db_utils::fieldsMemory($rsItensDotacao, $i, false, false, true);
				$iCodigoDotacao = "d" . $oItensDotacao->pc13_coddot . $oItensDotacao->pc13_anousu;
				if (!isset($aDotacoesItens[$iCodigoDotacao])) {

					$sElemento = substr($oItensDotacao->o56_elemento, 0, 7);

					$oDotacao = new stdClass();
					$oDotacao->iDotacao = $oItensDotacao->pc13_coddot;
					$oDotacao->iAnoDotacao = $oItensDotacao->pc13_anousu;
					$oDotacao->sElemento = $sElemento;
					$oDotacao->aItens = array();
					$oDotacao->lAutorizado = "false";

					if (AutorizacaoEmpenho::verificaItemAutorizado($oItensDotacao->pc11_codigo,
						$oItensDotacao->pc13_coddot,
						$oParam->iCodigoSolicitacao)) {

						$oDotacao->lAutorizado = 'true';
					}

					$aDotacoesItens[$iCodigoDotacao] = $oDotacao;
				} else {
					$oDotacao = $aDotacoesItens[$iCodigoDotacao];
				}

				/*
				 * enquanto percorre os itens,
				 * verificamos se eles possuem autorização
				 * se possuir não será exibido
				 */

				if (!AutorizacaoEmpenho::verificaItemAutorizado($oItensDotacao->pc11_codigo,
					$oItensDotacao->pc13_coddot,
					$oParam->iCodigoSolicitacao)) {
					/*
					 * caso o elemento seja vazio, significa que a solicitação nao tem dotação
					* logo, buscamos o elemento baseado no item
					*/
					if ($sElemento == '') {

						$oItemSolicitacao = new itemSolicitacao($oItensDotacao->pc11_codigo);
						$sElemento = substr($oItemSolicitacao->getDesdobramento(), 0, 7);

					}

					$oItem = new stdClass();
					$oItem->iItem = $oItensDotacao->pc01_codmater;
					$oItem->iOrdem = $oItensDotacao->pc11_seq;
					$oItem->sNomeItem = $oItensDotacao->pc01_descrmater;
					$oItem->iDotacao = $oItensDotacao->pc13_coddot;
					$oItem->nValor = $oItensDotacao->pc13_valor;
					$oItem->nQuantidade = $oItensDotacao->pc13_quant;
					$oItem->iAnoDotacao = $oItensDotacao->pc13_anousu;
					$oItem->iDotacaoSequencial = $oItensDotacao->pc13_sequencial;
					$oItem->iCodigoItem = $oItensDotacao->pc11_codigo;
					$oItem->lAlterado = false;
					$oItem->sElemento = $sElemento;
					$oDotacao->aItens[] = $oItem;
				}
			}

		}

		$oRetorno->aDotacoes = $aDotacoesItens;

		$oRetorno->iAnoSessao = db_getsession("DB_anousu");
		break;

	case "alteraDotacoes":

		try {

			db_inicio_transacao();


			$iSolicitacao = $oParam->iCodigoSolicitacao;
			foreach ($oParam->aItens as $oItem) {

				$oItemSolicitacao = new itemSolicitacao($oItem->iCodigoItem);
				$oItemSolicitacao->alterarDotacao($oItem->iCodigoDotacaoItem, $oItem->iCodigoDotacao, $oItem->iAnoDotacao);
			}

			db_fim_transacao(false);
		} catch (Exception $eErro) {

			$oRetorno->status = 2;
			$oRetorno->message = urlencode($eErro->getMessage());
		}
		break;

	case "alteraDotacoesAcordo":

		try {
			db_inicio_transacao();

			$iAcordo = $oParam->iCodigoAcordo;

			$oAcordo = new Acordo($iAcordo);

			if(count($oAcordo->getAutorizacoes())){
				throw new Exception('Acordo já autorizado!');
			}

			$aItens = $oParam->aItens;

			foreach ($oParam->aItens as $oItem) {
				$oAcordoItem = AcordoItem::alterarDotacao($oItem->iCodigoDotacaoItem, $oItem->iCodigoDotacao, $oItem->iAnoDotacao, $iAcordo, $oItem->iCodigoItem);
			}

			db_fim_transacao(false);

		} catch (Exception $eErro) {

			$oRetorno->status = 2;
			$oRetorno->message = urlencode($eErro->getMessage());
		}
		break;

	case 'getAcordoDotacoes':

		$sql = "
				 SELECT DISTINCT ac22_coddot, ac22_anousu
					FROM acordoposicao
				INNER JOIN acordoitem ON ac20_acordoposicao = ac26_sequencial
				INNER JOIN acordoitemdotacao ON ac22_acordoitem = ac20_sequencial
				WHERE ac26_acordo = $oParam->iCodigoAcordo AND
				 ac20_acordoposicao = (SELECT max(ac26_sequencial)
										 FROM acordoposicao
										 WHERE ac26_acordo = $oParam->iCodigoAcordo)";
		$rsDotacoes = db_query($sql);

		if (pg_num_rows($rsDotacoes) == 0) {
			$oRetorno->message = "Não existe dotações para este Acordo.";
			$oRetorno->status = 2;
		} else {

			$aItensDotacao = array();

			for ($count = 0; $count < pg_num_rows($rsDotacoes); $count++) {

				$oDotacaoAcordo = db_utils::fieldsMemory($rsDotacoes, $count);

				$sSqlItens = "SELECT DISTINCT
								ac20_pcmater,
								ac20_ordem,
								pc01_descrmater,
								ac22_coddot ,
								ac22_valor ,
								ac20_quantidade,
								o58_anousu,
								ac20_sequencial ,
								ac22_anousu,
								o58_valor,
								ac22_quantidade ,
								ac20_acordoposicao ,
								ac20_valortotal,
								o56_elemento
								--ac16_numero ||'/'|| ac16_anousu AS contrato,
								--ac26_acordo,
								--ac22_sequencial ,
								--ac22_anousu ,
								--ac16_sequencial,
								--ac22_acordoitem ,
								--z01_nome,
								--ac27_descricao,
								--ac26_data,
								-- ac16_dataassinatura
							FROM orcdotacao
							JOIN acordoitemdotacao ON ac22_coddot=o58_coddot
							JOIN acordoitem ON ac22_acordoitem = ac20_sequencial
							JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
							JOIN acordoposicaotipo ON ac26_acordoposicaotipo = ac27_sequencial
							JOIN orcelemento ON o56_codele = ac20_elemento AND o56_anousu = o58_anousu
							JOIN acordo ON ac26_acordo = ac16_sequencial
							JOIN cgm ON ac16_contratado = z01_numcgm
							JOIN pcmater ON ac20_pcmater = pc01_codmater
							JOIN solicitempcmater on pc16_codmater = pc01_codmater
							JOIN solicitem on pc11_codigo = pc16_solicitem
							WHERE ac20_acordoposicao = (SELECT max(ac26_sequencial)
															FROM acordoposicao
															WHERE ac26_acordo = '" . $oParam->iCodigoAcordo . "') 
															AND ac16_sequencial = '" . $oParam->iCodigoAcordo . "'
															AND ac22_coddot = '" . $oDotacaoAcordo->ac22_coddot . "' 
															AND o58_anousu = '".(db_getsession("DB_anousu") - 1)."' 
															-- AND ac22_anousu = '".db_getsession("DB_anousu")."'
															ORDER BY ac20_acordoposicao DESC, ac20_sequencial ASC";

				$rsResultItens = db_query($sSqlItens);

				if (pg_num_rows($rsResultItens) == 0) {
					$oRetorno->message = "Não existe itens para este Acordo.";
					$oRetorno->status = 2;
				} else {

					$oDotacao = new stdClass();
					$oDotacao->aItens = array();

					for ($i = 0; $i < pg_num_rows($rsResultItens); $i++) {
						$aItens = db_utils::fieldsMemory($rsResultItens, $i);

						$iCodigoDotacao = $aItens->ac22_coddot;

						$sElemento = substr($aItens->o56_elemento, 0, 7);

						$oDotacao->iDotacao = $aItens->ac22_coddot;

						$oDotacao->iAnoDotacao = $aItens->o58_anousu;
						$oDotacao->sElemento = $sElemento;
						$oDotacao->lAutorizado = "false";

						if (AutorizacaoEmpenho::verificaItemAutorizado($aItens->pc11_codigo,
							$aItens->ac22_coddot,
							$oParam->iCodigoSolicitacao)) {

							$oDotacao->lAutorizado = 'true';
						}

						$oItem = new stdClass();
						$oItem->iItem = $aItens->ac20_pcmater;
						$oItem->iOrdem = $aItens->ac20_ordem;
						$oItem->sNomeItem = $aItens->pc01_descrmater;
						$oItem->iDotacao = $aItens->ac22_coddot;
						$oItem->nValor = $aItens->ac20_valortotal;
						$oItem->nQuantidade = $aItens->ac20_quantidade;
						$oItem->iAnoDotacao = $aItens->o58_anousu;

						$oItem->iDotacaoSequencial = $aItens->ac22_coddot;
						$oItem->iCodigoItem = $aItens->ac20_sequencial;
						$oItem->lAlterado = false;
						$oItem->sElemento = $aItens->o56_elemento;
						$oDotacao->aItens[] = $oItem;

						if (!isset($aItensDotacao[$iCodigoDotacao])) {
							$aItensDotacao[$iCodigoDotacao] = $oDotacao;
						}//else {
							//echo 'Dotação: ', $oDotacao;
//							array_push($aItensDotacao[$iCodigoDotacao] , $oDotacao);
//						}

						/*
						 * enquanto percorre os itens,
						 * verificamos se eles possuem autorização
						 * se possuir não será exibido
						 */

//						if (!AutorizacaoEmpenho::verificaItemAutorizado($aItens->pc11_codigo, $aItens->ac22_coddot, $oParam->iCodigoSolicitacao)) {
							/*
							 * caso o elemento seja vazio, significa que a solicitação nao tem dotação
							 * logo, buscamos o elemento baseado no item
							 */

//						}

					}

				}

				$oRetorno->aDotacoes = $aItensDotacao;
				$oRetorno->iAnoSessao = db_getsession("DB_anousu");

			}
		}
		break;
}
echo $oJson->encode($oRetorno);