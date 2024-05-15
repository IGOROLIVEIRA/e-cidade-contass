<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require_once ('libs/db_stdlib.php');
require_once ('libs/db_conecta.php');
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ('libs/db_utils.php');
require_once ('libs/db_app.utils.php');
require_once ('libs/JSON.php');
require_once ("std/DBDate.php");
require_once ('std/db_stdClass.php');

require_once ("model/CgmFactory.model.php");
require_once ("model/CgmBase.model.php");
require_once ("model/CgmJuridico.model.php");
require_once ("model/CgmFisico.model.php");
require_once ("model/Dotacao.model.php");
require_once ('dbforms/db_funcoes.php');
require_once ("model/contabilidade/planoconta/ContaPlano.model.php");
require_once ("model/contabilidade/planoconta/ContaPlanoPCASP.model.php");
require_once ("model/contabilidade/planoconta/ContaCorrente.model.php");
require_once ("model/contabilidade/planoconta/SubSistemaConta.model.php");
require_once ("model/contabilidade/planoconta/SistemaConta.model.php");
require_once ("model/contabilidade/planoconta/ClassificacaoConta.model.php");
require_once ("model/contabilidade/planoconta/ContaOrcamento.model.php");
require_once ("model/orcamento/Orgao.model.php");
require_once ("model/orcamento/Unidade.model.php");
require_once ("model/contabilidade/contacorrente/ContaCorrenteBase.model.php");
require_once ("model/contabilidade/contacorrente/AdiantamentoConcessao.model.php");
require_once ("model/empenho/PrestacaoConta.model.php");

db_app::import("exceptions.*");
db_app::import("configuracao.*");
db_app::import("empenho.*");
db_app::import('contabilidade.lancamento.*');
db_app::import('contabilidade.*');




$oJson    = new services_json();
$oRetorno = new stdClass();

$oParam             = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno->status   = 1;
$oRetorno->erro     = false;
$oRetorno->message  = '';

try {

  switch ($oParam->exec) {

    case 'reaberturaPrestacaoConta' :

    db_inicio_transacao();

    $GLOBALS["HTTP_POST_VARS"]["e45_acerta_dia"] = '';

    $oDaoEmppresta = db_utils::getDao('emppresta');
    $oDaoEmppresta->e45_acerta = null;
    $oDaoEmppresta->e45_sequencial = $oParam->iSequencialEmpenho;
    $oDaoEmppresta->alterar($oParam->iSequencialEmpenho);

    if ( $oDaoEmppresta->erro_status == 0 ) {

     $sMsgErro  = 'Não foi possível reabrir a prestação de contas.\n';
     $sMsgErro .= $oDaoEmppresta->erro_msg;
     throw new Exception($sMsgErro);
   }

   db_fim_transacao(false);

   $oRetorno->message = "Prestação de contas reaberta.";

   break;

   case 'reaberturaConferencia' :

   db_inicio_transacao();

   $GLOBALS["HTTP_POST_VARS"]["e45_conferido_dia"] = '';

 		  /**
 		   * Libera data de encerramento - e45_conferido
 		   */
      $dataLancamento = new DBDate($oParam->dataLancamento);
      $dataLancamento = $dataLancamento->getDate();

      $oDaoEmppresta = db_utils::getDao('emppresta');
      $oDaoEmppresta->e45_conferido = null;
      $oDaoEmppresta->e45_sequencial = $oParam->iSequencialEmpenho;

      if(pg_num_rows(db_query("SELECT * FROM condataconf WHERE c99_anousu = ".db_getsession('DB_anousu')." "))>0){
        $oConsultaFimPeriodoContabil = db_query("SELECT * FROM condataconf WHERE c99_data < '$dataLancamento' AND c99_anousu = ".db_getsession('DB_anousu')." ");

        if(pg_num_rows($oConsultaFimPeriodoContabil) == 0){
          throw new Exception("Data informada inferior à data do fim do período contábil.");
        }
      }

      $oConsultaDataLancamento = db_query("SELECT *
                FROM conlancamemp
                JOIN conlancam ON c75_codlan=c70_codlan
                WHERE c75_numemp = {$oParam->iNumeroEmpenho} AND c75_data > '$dataLancamento'
                ORDER by c75_data DESC");

      if(pg_num_rows($oConsultaDataLancamento) > 0){
        throw new Exception("Já existe um lançamento com a data posterior à informada.");
      }

      $oDaoEmppresta->alterar($oParam->iSequencialEmpenho);

      if ( $oDaoEmppresta->erro_status == 0 ) {

       $sMsgErro  = 'Não foi possível reabrir a Conferência.\n';
       $sMsgErro .= $oDaoEmppresta->erro_msg;
       throw new Exception($sMsgErro);
     }

			/**
			 * Lancamento contabil
			 */
			$oEmpenhoFinanceiro = new EmpenhoFinanceiro($oParam->iNumeroEmpenho);
			$oPrestacaoConta    = new PrestacaoConta($oEmpenhoFinanceiro, $oParam->iSequencialEmpenho, $oParam->dataLancamento);
			$sComplemento       = db_stdClass::normalizeStringJson($oParam->sComplemento);

			$oPrestacaoConta->estornarLancamento($sComplemento);

      db_fim_transacao(false);

      $oRetorno->message = "Conferência de contas reaberta.";

      break;

      case "getDadosPrestacaoContas":

      $oEmpenhoFinanceiro   = new EmpenhoFinanceiro($oParam->iNumeroEmpenho);
      $oDadosPrestacaoConta = $oEmpenhoFinanceiro->getDadosPrestacaoContas();

      if (!$oDadosPrestacaoConta) {
        throw new BusinessException("Este empenho não é uma prestação de contas.");
      }

      $oPrestacaoConta = new stdClass();
      $oPrestacaoConta->iNumeroEmpenho				  = $oDadosPrestacaoConta->e45_numemp;
      $oPrestacaoConta->dtData								  = db_formatar($oDadosPrestacaoConta->e45_data, 'd');
      $oPrestacaoConta->dtFechamento					  = db_formatar($oParam->$oDadosPrestacaoConta->e45_conferido, 'd');
      $oPrestacaoConta->dtAcertoPrestacaoContas = db_formatar($oDadosPrestacaoConta->e45_acerta, 'd');
      $oPrestacaoConta->iTipo                   = $oDadosPrestacaoConta->e45_tipo;
      $oPrestacaoConta->sObservacao             = urlencode($oDadosPrestacaoConta->e45_obs);

      $oRetorno->dados = $oPrestacaoConta;

      break;

      case 'verificaDevolucaoAdiantamento':

      $oDaoComlancamEmp = new cl_conlancamemp();
      $sSqlBuscaLancamentos = $oDaoComlancamEmp->sql_query_documentos(null, "c71_coddoc", 'c03_ordem desc', "c75_numemp = {$oParam->iCodigoEmpenho}");
      $rsBuscaLancamento    = db_query($sSqlBuscaLancamentos);
      if (!$rsBuscaLancamento) {
        throw new DBException("Ocorreu um erro ao busca o registro na base de dados.");
      }

      $iUltimoLancamento = db_utils::fieldsMemory($rsBuscaLancamento, 0)->c71_coddoc;

      /*
       * Verificamos se o último lançamento é de estorno de empenho. Caso seja não é possível realizar
       * a reabertura da prestação de contas
       */
      $lPodeReabrir = true;
      if ($iUltimoLancamento == 411) {

        $oRetorno->mensagem = urlencode("Foi executado a devolução de adiantamento para o empenho. Não é possível reabrir a prestação de contas.");
        $lPodeReabrir = false;
      }

      $oRetorno->lPodeReabrir = $lPodeReabrir;
      break;

      default:
      throw new Exception("Nenhuma Opção Definida");

    }


  } catch (BusinessException $oErro) {

    $oRetorno->status   = 2;
    $oRetorno->message = $oErro->getMessage();
    $oRetorno->erro     = true;
    db_fim_transacao(true);

  } catch (DBException $oErro) {

    $oRetorno->status   = 2;
    $oRetorno->mensage = $oErro->getMessage();
    $oRetorno->erro     = true;
    db_fim_transacao(true);

  } catch (ParameterException $oErro) {

    $oRetorno->iStatus   = 2;
    $oRetorno->message = $oErro->getMessage();
    $oRetorno->erro     = true;

  } catch (Exception $oErro) {

    $oRetorno->status   = 2;
    $oRetorno->message = $oErro->getMessage();
    $oRetorno->erro     = true;

    db_fim_transacao(true);
  }

  $oRetorno->message = urlEncode($oRetorno->message);

  echo $oJson->encode($oRetorno);
