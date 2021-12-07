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
require_once("model/Acordo.model.php");
require_once("model/AcordoItem.model.php");
require_once("model/Dotacao.model.php");



$oJson             = new services_json();
$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\", "", $_POST["json"])));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = 1;
$lErro             = false;
$sMensagem         = "";

switch ($oParam->exec) {

	case "alteraDotacoesAcordo":

		try {
			db_inicio_transacao();

			$iAcordo = $oParam->iCodigoAcordo;
			$oAcordo = new Acordo($iAcordo);

			$aItens = $oParam->aItens;

			foreach ($oParam->aItens as $oItem) {

				if (count($oAcordo->getAutorizacoes('', $oItem->iAnoDotacao))) {
					throw new Exception('O contrato já possui autorização de empenho no ano vigente.');
				}

				$oItem->iAcordo = $iAcordo;
				if (strcmp($oParam->tipoSql, "update") == 0) {
					$oAcordoItem = AcordoItem::alterarDotacao($oItem);
				}

				if (strcmp($oParam->tipoSql, "insert") == 0) {
					$oAcordoItem = AcordoItem::inserirItensDotacao($oItem);
				}
			}

			db_fim_transacao(false);
		} catch (Exception $eErro) {

			$oRetorno->status = 2;
			$oRetorno->message = urlencode($eErro->getMessage());
		}
		break;

	case 'getAcordoDotacoes':

		$sql = "
				 SELECT DISTINCT ac22_coddot, ac22_anousu, ac20_pcmater
					FROM acordoposicao
					INNER JOIN acordoitem ON ac20_acordoposicao = ac26_sequencial
					INNER JOIN acordoitemdotacao ON ac22_acordoitem = ac20_sequencial
					WHERE ac26_acordo = $oParam->iCodigoAcordo AND
					 ac20_acordoposicao = (SELECT max(ac26_sequencial)
											 FROM acordoposicao
											 WHERE ac26_acordo = $oParam->iCodigoAcordo) ";

		$rsDotacoes = db_query($sql);
		if (pg_num_rows($rsDotacoes) == 0) {

			$aItensDotacao = array();

			$tipoSql = "insert";

			$sSqlItens = "SELECT DISTINCT
								ac20_pcmater,
								ac20_ordem,
								pc01_descrmater,
								ac20_valorunitario,
								ac20_quantidade,
								ac20_sequencial ,
								ac20_acordoposicao,
								ac20_quantidade,
								ac20_valortotal
								FROM orcdotacao, acordoitem
							JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
							JOIN acordoposicaotipo ON ac26_acordoposicaotipo = ac27_sequencial
							JOIN acordo ON ac26_acordo = ac16_sequencial
							JOIN cgm ON ac16_contratado = z01_numcgm
							JOIN pcmater ON ac20_pcmater = pc01_codmater
							WHERE ac20_acordoposicao = (SELECT max(ac26_sequencial)
															FROM acordoposicao
															WHERE ac26_acordo = '" . $oParam->iCodigoAcordo . "') 
															AND ac16_sequencial = '" . $oParam->iCodigoAcordo . "'
															ORDER BY ac20_acordoposicao DESC, ac20_sequencial ASC";

			$rsResultItens = db_query($sSqlItens);

			if (pg_num_rows($rsResultItens) == 0) {
				$oRetorno->message = urlencode("Não existe itens para este Acordo.");
				$oRetorno->status = 2;
			} else {

				$oDotacao = new stdClass();
				$oDotacao->aItens = array();
				for ($i = 0; $i < pg_num_rows($rsResultItens); $i++) {
					$aItens = db_utils::fieldsMemory($rsResultItens, $i);


					$oDotacao->sElemento = $sElemento;
					$oDotacao->lAutorizado = "false";

					$oItem = new stdClass();
					$oItem->iItem = $aItens->ac20_pcmater;
					$oItem->iOrdem = $aItens->ac20_ordem;
					$oItem->sNomeItem = $aItens->pc01_descrmater;
					$oItem->nValor = $aItens->ac20_valortotal;
					$oItem->nQuantidade = $aItens->ac20_quantidade;

					$oItem->iCodigoItem = $aItens->ac20_sequencial;
					$oItem->lAlterado = false;
					$oDotacao->aItens[] = $oItem;

					if (!isset($aItensDotacao[$i])) {
						$aItensDotacao[$i] = $oDotacao;
					}
				}
			}

			$oRetorno->aDotacoes = $aItensDotacao;
			$oRetorno->iAnoSessao = db_getsession("DB_anousu");
			$oRetorno->tipoSql = "insert";
		} else {

			$aItensDotacao = array();

			$tipoSql = "update";


			for ($count = 0; $count < pg_num_rows($rsDotacoes); $count++) {

				$oDotacaoAcordo = db_utils::fieldsMemory($rsDotacoes, $count);

				$sSqlItens = "SELECT DISTINCT
								ac20_pcmater,
								ac20_ordem,
								pc01_descrmater,
								ac22_coddot ,
								ac22_valor ,
								ac20_quantidade,
								ac20_sequencial ,
								ac22_anousu,
								ac22_quantidade ,
								ac20_acordoposicao ,
								ac20_valortotal,
								o56_elemento
							FROM orcdotacao
							JOIN acordoitemdotacao ON ac22_coddot=o58_coddot
							JOIN acordoitem ON ac22_acordoitem = ac20_sequencial
							JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
							JOIN acordoposicaotipo ON ac26_acordoposicaotipo = ac27_sequencial
							JOIN orcelemento ON o56_codele = ac20_elemento AND o56_anousu = o58_anousu
							JOIN acordo ON ac26_acordo = ac16_sequencial
							JOIN cgm ON ac16_contratado = z01_numcgm
							JOIN pcmater ON ac20_pcmater = pc01_codmater
							WHERE ac20_acordoposicao = (SELECT max(ac26_sequencial)
															FROM acordoposicao
															WHERE ac26_acordo = '" . $oParam->iCodigoAcordo . "') 
															AND ac16_sequencial = '" . $oParam->iCodigoAcordo . "'
															AND ac22_coddot = '" . $oDotacaoAcordo->ac22_coddot . "' 
															AND ac22_anousu = '" . $oDotacaoAcordo->ac22_anousu . "' 
															ORDER BY ac20_acordoposicao DESC, ac20_sequencial ASC";

				$rsResultItens = db_query($sSqlItens);

				if (pg_num_rows($rsResultItens) == 0) {
					$oRetorno->message = urlencode("Não existe itens para este Acordo.");
					$oRetorno->status = 2;
				} else {

					$oDotacao = new stdClass();
					$oDotacao->aItens = array();
					for ($i = 0; $i < pg_num_rows($rsResultItens); $i++) {
						$aItens = db_utils::fieldsMemory($rsResultItens, $i);
						$iCodigoDotacao = $aItens->ac22_coddot . $aItens->ac22_anousu;

						$sElemento = substr($aItens->o56_elemento, 0, 7);

						$oDotacao->iDotacao = $aItens->ac22_coddot;

						$oDotacao->iAnoDotacao = $aItens->ac22_anousu;
						$oDotacao->sElemento = $sElemento;
						$oDotacao->lAutorizado = "false";

						$oItem = new stdClass();
						$oItem->iItem = $aItens->ac20_pcmater;
						$oItem->iOrdem = $aItens->ac20_ordem;
						$oItem->sNomeItem = $aItens->pc01_descrmater;
						$oItem->iDotacao = $aItens->ac22_coddot;
						$oItem->nValor = $aItens->ac20_valortotal;
						$oItem->nQuantidade = $aItens->ac20_quantidade;
						$oItem->iAnoDotacao = $aItens->ac22_anousu;

						$oItem->iDotacaoSequencial = $aItens->ac22_coddot;
						$oItem->iCodigoItem = $aItens->ac20_sequencial;
						$oItem->lAlterado = false;
						$oItem->sElemento = $aItens->o56_elemento;
						$oDotacao->aItens[] = $oItem;

						if (!isset($aItensDotacao[$iCodigoDotacao])) {
							$aItensDotacao[$iCodigoDotacao] = $oDotacao;
						}
					}
				}

				$oRetorno->aDotacoes = $aItensDotacao;
				$oRetorno->iAnoSessao = db_getsession("DB_anousu");
				$oRetorno->tipoSql = "update";
			}
		}
		break;
}
echo $oJson->encode($oRetorno);
