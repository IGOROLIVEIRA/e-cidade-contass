<?php
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
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

require_once(modification("libs/db_stdlib.php"));
require_once(modification("libs/db_utils.php"));
require_once(modification("libs/db_app.utils.php"));
require_once(modification("libs/db_conecta.php"));
require_once(modification("libs/db_sessoes.php"));
require_once(modification("libs/db_libcontabilidade.php"));
require_once(modification("libs/JSON.php"));
require_once(modification('model/contabilidade/lancamento/LancamentoAuxiliarInscricaoRestosAPagarProcessados.model.php'));
require_once(modification('model/contabilidade/lancamento/LancamentoAuxiliarInscricaoRestosAPagarNaoProcessados.model.php'));
require_once(modification('model/contabilidade/lancamento/LancamentoAuxiliarInscricaoRestosAPagarEmLiquidacao.model.php'));


require_once("dbforms/db_funcoes.php");

require_once("std/db_stdClass.php");
require_once("std/DBNumber.php");

db_app::import("exceptions.*");
db_app::import("configuracao.*");
db_app::import("CgmFactory");
db_app::import("contabilidade.lancamento.*");
db_app::import("contabilidade.*");
db_app::import("empenho.EmpenhoFinanceiro");
db_app::import("empenho.RestosAPagar");
db_app::import("contabilidade.contacorrente.*");
$oJson = new services_json();
$oParam = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno = new db_stdClass();
$oRetorno->status = 1;
$oRetorno->message = '';

$iInstituicao = db_getsession("DB_instit");
$iAnoSessao = db_getsession("DB_anousu");

/**
 * Rotina de Escrituração de Resto A Pagar Não Processado e Processado
 * @author: Contass Consultoria
 * @description: Desenvolvimento do SICOM Balancete. A rotina foi modificada para realizar a escrituração de
 * empenho por empenho. Também foi incluído na rotina a escrituração de resto a pagar processado.
 * Para isso foram criados as classes: EscrituracaoRestosApagarProcessados.model.php,
 * LancamentoAuxiliarInscricaoRestosAPagarProcessados.model.php e as tabelas inscricaorestosapagarprocessados,
 * conlancaminscrestosapagarprocessados
 *
 */

try {

	switch ($oParam->exec) {

		case 'getDadosRestosAPagar' :

			$oRetorno->lBloquearTela = false;

			if ((EscrituracaoRestosAPagarNaoProcessados::existeLancamentoPeriodo($iAnoSessao, $iInstituicao, $oParam->lProcessados)) &&
				(EscrituracaoRestosAPagarProcessados::existeLancamentoPeriodo($iAnoSessao, $iInstituicao, $oParam->lProcessados)) &&
				(EscrituracaoRestosAPagarEmLiquidacao::existeLancamentoPeriodo($iAnoSessao, $iInstituicao, $oParam->lProcessados))
			) {
				$oRetorno->lBloquearTela = true;
			}

			//Nao Processados

			$nValorNp = EscrituracaoRestosAPagarNaoProcessados::getValorLancamento($iAnoSessao,
				$iInstituicao,
				$oParam->lProcessados);

			if ($nValorNp == 0) {
				$nValorNp = RestosAPagar::getValorRpNpAno($iAnoSessao, $iInstituicao);
			}

			// Em liquidacao

			$nValorEmLqd = EscrituracaoRestosAPagarEmLiquidacao::getValorLancamento($iAnoSessao,
				$iInstituicao,
				$oParam->lProcessados);

			if ($nValorEmLqd == 0) {
				$nValorEmLqd = RestosAPagar::getValorRpEmLiquidacaoAno($iAnoSessao, $iInstituicao);
			}

			//Processados

			$nValorP = EscrituracaoRestosAPagarProcessados::getValorLancamento($iAnoSessao,
				$iInstituicao,
				$oParam->lProcessados);

			if ($nValorP == 0) {
				$nValorP = RestosAPagar::getValorProcessadoAno($iAnoSessao, $iInstituicao);
			}

			$oRetorno->nValorNp = $nValorNp;
			$oRetorno->nValorP = $nValorP;
			$oRetorno->nValorEmLqd = $nValorEmLqd;

			break;

		case 'processar'    :

			db_inicio_transacao();


			/*
             * Resto A Pagar Não Processado
             *
             */

			$oEscrituracao = new EscrituracaoRestosAPagarNaoProcessados($iAnoSessao, $iInstituicao);

			$iCodigoEscrituracao = null;
			$iCodigoDocumento = null;
			$sObservacao = db_stdClass::normalizeStringJson($oParam->sObservacao);

			if ($oParam->exec == 'processar') {

				$iCodigoEscrituracao = $oEscrituracao->escriturar();

			} else {

				$iCodigoEscrituracao = $oEscrituracao->cancelarEscrituracao();
			}

			$rsSqlEmpresto = RestosAPagar::getValorRpAnalitico($iAnoSessao, $iInstituicao);

			for ($iContRP = 0; $iContRP < pg_num_rows($rsSqlEmpresto); $iContRP++) {

				$oEmpresto = db_utils::fieldsMemory($rsSqlEmpresto, $iContRP);

				$oEmpenhoFinanceiro = new EmpenhoFinanceiro($oEmpresto->e91_numemp);

				if ($oEmpenhoFinanceiro->getAnoUso() == db_getsession('DB_anousu') - 1) {

					if ($oParam->exec == 'processar') {

						// Documento 2005: INSCRIÇÃO DE RESTOS A PAGAR NÃO PROCESSADOS
						$iCodigoDocumento = 2005;

					} else {

						// Documento 2006:	ESTORNO DE INSCR. DE RP NÃO PROCESSADOS
						$iCodigoDocumento = 2006;
					}
				} else {

					if ($oParam->exec == 'processar') {

						// Documento 2009: INSCRIÇÃO DE RP NÃO PROCESSADOS - EXERCÍCIOS ANTERIORES
						$iCodigoDocumento = 2009;

					} else {

						// Documento 2010:	ESTORNO INSCRIÇÃO DE RP NÃO PROCESSADOS - EXERCÍCIOS ANTERIORES
						$iCodigoDocumento = 2010;

					}

				}

			    if($oEmpresto->valor_nao_processado > 0){
			    	$oContaCorrenteDetalhe = new ContaCorrenteDetalhe();
				    $oContaCorrenteDetalhe->setEmpenho($oEmpenhoFinanceiro);
				    $oLancamentoAuxiliar = new LancamentoAuxiliarInscricaoRestosAPagarNaoProcessado();
				    $oLancamentoAuxiliar->setValorTotal($oEmpresto->valor_nao_processado);
				    $oLancamentoAuxiliar->setObservacaoHistorico($sObservacao);
				    $oLancamentoAuxiliar->setInscricaoRestosAPagarNaoProcessados($iCodigoEscrituracao);
				    $oLancamentoAuxiliar->setContaCorrenteDetalhe($oContaCorrenteDetalhe);

				    $oEscrituracao->processarLancamentosContabeis($oLancamentoAuxiliar, $iCodigoDocumento);
			    }

			}

			/*
             * Resto A Pagar Em Liquidacao
             *
             */

			$oEscrituracao = new EscrituracaoRestosAPagarEmLiquidacao($iAnoSessao, $iInstituicao);

			$iCodigoEscrituracao = null;
			$iCodigoDocumento = null;
			$sObservacao = db_stdClass::normalizeStringJson($oParam->sObservacao);

			if ($oParam->exec == 'processar') {

				$iCodigoEscrituracao = $oEscrituracao->escriturar();

			}

			$rsSqlEmpresto = RestosAPagar::getValorRpAnalitico($iAnoSessao, $iInstituicao);

			for ($iContRP = 0; $iContRP < pg_num_rows($rsSqlEmpresto); $iContRP++) {

				$oEmpresto = db_utils::fieldsMemory($rsSqlEmpresto, $iContRP);

				$oEmpenhoFinanceiro = new EmpenhoFinanceiro($oEmpresto->e91_numemp);

				if ($oParam->exec == 'processar') {
					// Documento 2005: INSCRIÇÃO DE RESTOS A PAGAR EM LIQUIDAÇÃO
					$iCodigoDocumento = 2021;
				}
			    if($oEmpresto->valor_em_liquidacao > 0){
					$oContaCorrenteDetalhe = new ContaCorrenteDetalhe();
					$oContaCorrenteDetalhe->setEmpenho($oEmpenhoFinanceiro);
					$oLancamentoAuxiliar = new LancamentoAuxiliarInscricaoRestosAPagarEmLiquidacao();
					$oLancamentoAuxiliar->setValorTotal($oEmpresto->valor_em_liquidacao);
					$oLancamentoAuxiliar->setObservacaoHistorico($sObservacao);
					$oLancamentoAuxiliar->setInscricaoRestosAPagarEmLiquidacao($iCodigoEscrituracao);
					$oLancamentoAuxiliar->setContaCorrenteDetalhe($oContaCorrenteDetalhe);

					$oEscrituracao->processarLancamentosContabeis($oLancamentoAuxiliar, $iCodigoDocumento);
				}
			}

			/*
            * Resto A Pagar Processado
            *
            */

			$oEscrituracao = new EscrituracaoRestosAPagarProcessados($iAnoSessao, $iInstituicao);

			$iCodigoEscrituracao = null;
			$iCodigoDocumento = null;
			$sObservacao = db_stdClass::normalizeStringJson($oParam->sObservacao);

			if ($oParam->exec == 'processar') {

				$iCodigoEscrituracao = $oEscrituracao->escriturar();

			} else {

				$iCodigoEscrituracao = $oEscrituracao->cancelarEscrituracao();
			}

			$rsSqlEmpresto = RestosAPagar::getValorProcessadoAnalitico($iAnoSessao, $iInstituicao);

			for ($iContRP = 0; $iContRP < pg_num_rows($rsSqlEmpresto); $iContRP++) {

				$oEmpresto = db_utils::fieldsMemory($rsSqlEmpresto, $iContRP);

				$oEmpenhoFinanceiro = new EmpenhoFinanceiro($oEmpresto->e91_numemp);

				if ($oEmpenhoFinanceiro->getAnoUso() == db_getsession('DB_anousu') - 1) {

					if ($oParam->exec == 'processar') {

						// Documento 2007: INSCRIÇÃO DE RESTOS A PAGAR PROCESSADOS
						$iCodigoDocumento = 2007;


					} else {

						// Documento 2008:	ESTORNO DE INSCR. DE RP PROCESSADOS
						$iCodigoDocumento = 2008;

					}
				} else {

					if ($oParam->exec == 'processar') {

						// Documento 2011: INSCRIÇÃO DE RP PROCESSADOS - EXERC. ANTER.
						$iCodigoDocumento = 2011;

					} else {

						// Documento 2012:	ESTORNO INSCRIÇÃO DE RP PROCESSADOS - EXERC. ANTER.
						$iCodigoDocumento = 2012;

					}
				}

				$oContaCorrenteDetalhe = new ContaCorrenteDetalhe();
				$oContaCorrenteDetalhe->setEmpenho($oEmpenhoFinanceiro);
				$oLancamentoAuxiliar = new LancamentoAuxiliarInscricaoRestosAPagarProcessado();
				$oLancamentoAuxiliar->setValorTotal($oEmpresto->valor);
				$oLancamentoAuxiliar->setObservacaoHistorico($sObservacao);
				$oLancamentoAuxiliar->setInscricaoRestosAPagarProcessados($iCodigoEscrituracao);
				$oLancamentoAuxiliar->setContaCorrenteDetalhe($oContaCorrenteDetalhe);

				$oEscrituracao->processarLancamentosContabeis($oLancamentoAuxiliar, $iCodigoDocumento);

			}

			db_fim_transacao(false);

			break;
		case 'desprocessar' :
			db_inicio_transacao();


			$rsTabelaLancamentos = db_query("create temp table w_conlancam as
                                      SELECT DISTINCT c108_codlan c70_codlan
                                FROM conlancaminscrestosapagarnaoprocessados
                                inner join conlancam on c108_codlan = c70_codlan
                                inner join conlancaminstit on c02_codlan = c70_codlan and c02_instit = ".db_getsession('DB_instit')."
                                WHERE c70_anousu = " . db_getsession('DB_anousu') . "
                                UNION ALL
                                SELECT DISTINCT c108_codlan c70_codlan
                                FROM conlancaminscrestosapagarprocessados
                                inner join conlancam on c108_codlan = c70_codlan
                                inner join conlancaminstit on c02_codlan = c70_codlan and c02_instit = ".db_getsession('DB_instit')."
                                WHERE c70_anousu = " . db_getsession('DB_anousu')."
                                UNION ALL
                                SELECT DISTINCT c210_codlan c70_codlan
                                FROM conlancaminscrestosapagaremliquidacao
                                inner join conlancam on c210_codlan = c70_codlan
                                inner join conlancaminstit on c02_codlan = c70_codlan and c02_instit = ".db_getsession('DB_instit')."
                                WHERE c70_anousu = " . db_getsession('DB_anousu') );

			if (!$rsTabelaLancamentos) {
				throw new Exception('Não foi possivel criar tabela para exclusão de lançamentos');
			}

			$rsConlancamemp = db_query("DELETE FROM conlancamemp
                                        WHERE c75_codlan IN
                                            (select c70_codlan from w_conlancam)");

			if (!$rsConlancamemp) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamemp');
			}

			$rsConlancambol = db_query("DELETE FROM conlancambol
                                            WHERE c77_codlan IN
                                                (select c70_codlan from w_conlancam)");

			if (!$rsConlancambol) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancambol');
			}


			$rsConlancamdig = db_query("DELETE FROM conlancamdig
                                            WHERE c78_codlan IN
                                                (select c70_codlan from w_conlancam)");

			if (!$rsConlancamdig) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamdig');
			}

			$rsDeleteConlancamCgm = db_query("delete from conlancamcgm  where c76_codlan in (select c70_codlan from w_conlancam)");
			if (!$rsDeleteConlancamCgm) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamcgm');
			}
			$rsDeleteConlancamGrupo = db_query("delete from conlancamcorgrupocorrente
                                         where c23_conlancam in (select c70_codlan from w_conlancam)"
			);
			if (!$rsDeleteConlancamGrupo) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamGrupo');
			}

			$rsDeletePagordemdescontolanc = db_query("DELETE FROM pagordemdescontolanc
                                                        WHERE e33_conlancam IN (select c70_codlan from w_conlancam)");
			if (!$rsDeletePagordemdescontolanc) {
				throw new Exception('Não foi possivel excluir dados da tabela pagordemdescontolanc');
			}

			$rsDeleteconlancammatestoqueinimei = db_query("DELETE FROM conlancammatestoqueinimei
                                                        WHERE c103_conlancam IN (select c70_codlan from w_conlancam)");
			if (!$rsDeleteconlancammatestoqueinimei) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancammatestoqueinimei');
			}

			$rsDeleteConlancamCorrente = db_query("delete from conlancamcorrente
                                            where c86_conlancam in (select c70_codlan from w_conlancam)"
			);
			if (!$rsDeleteConlancamCorrente) {
				throw new Exception("Não foi possivel excluir dados da tabela conlancamcorrente\n" . pg_last_error());
			}

			$rsDeleteConlancamRec = db_query("delete from conlancamrec
                                       where c74_codlan in (select c70_codlan from w_conlancam)"
			);
			if (!$rsDeleteConlancamRec) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamrec');
			}

			$rsDeleteConlancamCompl = db_query("delete from conlancamcompl
                                       where c72_codlan in (select c70_codlan from w_conlancam)"
			);
			if (!$rsDeleteConlancamCompl) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamcompl');
			}

			$rsDeleteConlancamnota = db_query("DELETE FROM conlancamnota
                                                WHERE c66_codlan IN (select c70_codlan from w_conlancam)");
			if (!$rsDeleteConlancamnota) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamnota');
			}

			$rsDeleteConlancamele = db_query("DELETE FROM conlancamele
                                                WHERE c67_codlan IN (select c70_codlan from w_conlancam)");
			if (!$rsDeleteConlancamele) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamele');
			}

			$rsDeleteConlancamPag = db_query("delete from conlancampag
                                       where c82_codlan in (select c70_codlan from w_conlancam)"
			);
			if (!$rsDeleteConlancamPag) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancampag');
			}

			$rsDeleteConlancamDoc = db_query("delete from conlancamdoc
                                       where c71_codlan in (select c70_codlan from w_conlancam)"
			);
			if (!$rsDeleteConlancamDoc) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamdoc');
			}

			$rsDeleteConlancamdot = db_query("DELETE FROM conlancamdot
                                                    WHERE c73_codlan IN
                                                        (select c70_codlan from w_conlancam)");

			if (!$rsDeleteConlancamdot) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamdot');
			}

			$rsdeleteConlancamlr = db_query("DELETE FROM conlancamlr
                                                WHERE c81_sequen IN
                                                    (SELECT c69_sequen
                                                     FROM conlancamval
                                                     WHERE c69_codlan IN
                                                         (select c70_codlan from w_conlancam))");

			if (!$rsdeleteConlancamlr) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamlr');
			}

			$rsDeleteConlancamCC = db_query("delete from contacorrentedetalheconlancamval
                                       where c28_conlancamval in (select c69_sequen
                                                                    from conlancamval
                                                                   where c69_codlan in (select c70_codlan
                                                                                         from w_conlancam)
                                                                   )"
			);
			if (!$rsDeleteConlancamCC) {
				throw new Exception('Não foi possivel excluir dados da tabela contacorrentedetalheconlancamval');
			}

			$rsDeleteConlanordem = db_query(" delete from conlancamordem
                                        where c03_codlan in (select c70_codlan from w_conlancam)"
			);
			if (!$rsDeleteConlanordem) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamordem');
			}

			$rsDeleteConlancamVal = db_query(" delete from conlancamval
                                        where c69_codlan in (select c70_codlan from w_conlancam)"
			);
			if (!$rsDeleteConlancamVal) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamval '.pg_last_error());
			}

			$rsDeleteConlancamCP = db_query("delete from conlancamconcarpeculiar
                                      where c08_codlan in (select c70_codlan from w_conlancam)"
			);
			if (!$rsDeleteConlancamCP) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamconcarpeculiar');
			}

			$rsDeleteConlancamord = db_query("delete from conlancamord where c80_codlan in (select c70_codlan from w_conlancam)");

			if (!$rsDeleteConlancamord) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamord');
			}

			$rsDeleteConlancamInstit = db_query("delete from conlancaminstit where c02_codlan in (select c70_codlan from w_conlancam)");

			if (!$rsDeleteConlancamInstit) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancaminstit');
			}

			$rsDeleteConlancamOrdem = db_query("delete from conlancamordem where c03_codlan in (select c70_codlan from w_conlancam)");

			if (!$rsDeleteConlancamOrdem) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamordem');
			}

			$rsDeleteconlancambem = db_query("delete from conlancambem where c110_codlan in (select c70_codlan from w_conlancam)");

			if (!$rsDeleteConlancamOrdem) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancamordem');
			}

			$rsDeleteconlancaminscrestosapagarnaoprocessados = db_query("delete from conlancaminscrestosapagarnaoprocessados where c108_codlan in (select c70_codlan from w_conlancam)");

			if (!$rsDeleteconlancaminscrestosapagarnaoprocessados) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancaminscrestosapagarnaoprocessados');
			}

			$rsDeleteconlancaminscrestosapagarprocessados = db_query("delete from conlancaminscrestosapagarprocessados where c108_codlan in (select c70_codlan from w_conlancam)");

			if (!$rsDeleteconlancaminscrestosapagarprocessados) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancaminscrestosapagarprocessados');
			}
			$rsDeleteconlancaminscrestosapagaremliquidacao = db_query("delete from conlancaminscrestosapagaremliquidacao where c210_codlan in (select c70_codlan from w_conlancam)");

			if (!$rsDeleteconlancaminscrestosapagaremliquidacao) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancaminscrestosapagaremliquidacao');
			}

			$rsDeleteConlancam = db_query("delete from conlancam where c70_codlan in (select c70_codlan from w_conlancam)");
			if (!$rsDeleteConlancam) {
				throw new Exception('Não foi possivel excluir dados da tabela conlancam');
			}

			$rsDeleteInscricaorestosapagarprocessados = db_query("delete from inscricaorestosapagarprocessados where c107_instit = ".db_getsession('DB_instit')." and c107_ano = ".db_getsession('DB_anousu'));
			if (!$rsDeleteInscricaorestosapagarprocessados) {
				throw new Exception('Não foi possivel excluir dados da tabela inscricaorestosapagarprocessados');
			}

			$rsDeleteInscricaorestosapagarnaoprocessados = db_query("delete from inscricaorestosapagarnaoprocessados where c107_instit = ".db_getsession('DB_instit')." and c107_ano = ".db_getsession('DB_anousu'));
			if (!$rsDeleteInscricaorestosapagarnaoprocessados) {
				throw new Exception('Não foi possivel excluir dados da tabela inscricaorestosapagarnaoprocessados');
			}

			$rsDeleteInscricaorestosapagaremliquidacao = db_query("delete from inscricaorestosapagaremliquidacao where c107_instit = ".db_getsession('DB_instit')." and c107_ano = ".db_getsession('DB_anousu'));
			if (!$rsDeleteInscricaorestosapagaremliquidacao) {
				throw new Exception('Não foi possivel excluir dados da tabela inscricaorestosapagaremliquidacao');
			}
			db_fim_transacao(false);
			break;

	}

} catch (BusinessException $oErro) {

	$oRetorno->status = 2;
	$oRetorno->message = $oErro->getMessage();

	db_fim_transacao(true);

} catch (ParameterException $oErro) {

	$oRetorno->status = 2;
	$oRetorno->message = $oErro->getMessage();

} catch (DBException $oErro) {

	$oRetorno->status = 2;
	$oRetorno->message = $oErro->getMessage();

	db_fim_transacao(true);

} catch (Exception $oErro) {

	$oRetorno->status = 2;
	$oRetorno->message = $oErro->getMessage();

	db_fim_transacao(true);
}

$oRetorno->message = urlEncode($oRetorno->message);

echo $oJson->encode($oRetorno);
