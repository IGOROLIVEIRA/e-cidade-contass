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

require_once("libs/db_stdlib.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conn.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sql.php");
require_once("std/db_stdClass.php");
require_once("libs/JSON.php");
require_once("libs/db_utils.php");
require_once("classes/db_pctipocompra_classe.php");
require_once("classes/db_emptipo_classe.php");
require_once("model/licitacao.model.php");
require_once("model/itemSolicitacao.model.php");
require_once("model/Dotacao.model.php");
require_once("model/CgmFactory.model.php");
require_once("model/CgmBase.model.php");
require_once("model/CgmFisico.model.php");
require_once("model/CgmJuridico.model.php");
require_once("classes/solicitacaocompras.model.php");
require_once("model/ProcessoCompras.model.php");
require_once("model/empenho/AutorizacaoEmpenho.model.php");
require_once("classes/db_condataconf_classe.php");

db_app::import("empenho.*");
$oDaoPcTipoCompra = new cl_pctipocompra();
$oDaoEmpTipo      = new cl_emptipo();

$oJson  = new services_json();
$oParam = $oJson->decode(str_replace("\\", "", $_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = "";


switch ($oParam->exec) {

  case "getProcessoAdministrativo":

    $oDaoSolicitaProtProcesso = new cl_solicitaprotprocesso();
    $sSqlProcesso = $oDaoSolicitaProtProcesso->sql_query_file(null, "*", null, " pc90_solicita = {$oParam->iSolicitacao} ");
    $rsProcesso   = $oDaoSolicitaProtProcesso->sql_record($sSqlProcesso);
    $oRetorno->pc90_numeroprocesso = '';
    if ($oDaoSolicitaProtProcesso->numrows > 0) {
      $sProcesso = urlencode(db_utils::fieldsMemory($rsProcesso, 0)->pc90_numeroprocesso);
      $oRetorno->pc90_numeroprocesso = $sProcesso;
    }

    break;



  case "getTipoLicitacao":

    $oDaoCfgLiclicita          = db_utils::getDao("cflicita");
    $sSqlTipoLicitacao         = $oDaoCfgLiclicita->sql_query_file(null, "l03_tipo, l03_descr", '', "l03_codcom = {$oParam->iTipoCompra}");
    $rsTipoLicitacao           = $oDaoCfgLiclicita->sql_record($sSqlTipoLicitacao);
    $oRetorno->aTiposLicitacao = array();

    if ($oDaoCfgLiclicita->numrows > 0) {

      for ($iTipoLicitacao = 0; $iTipoLicitacao < $oDaoCfgLiclicita->numrows; $iTipoLicitacao++) {
        $oRetorno->aTiposLicitacao[] = db_utils::fieldsMemory($rsTipoLicitacao, $iTipoLicitacao);
      }
    }

    /*
       * Busca os Tipos de Compra
       */
    $sSqlPcTipoCompra   = $oDaoPcTipoCompra->sql_query_file(null, 'pc50_codcom, pc50_descr,pc50_pctipocompratribunal', '', "pc50_codcom = {$oParam->iTipoCompra}");
    $rsExecPcTipoCompra = $oDaoPcTipoCompra->sql_record($sSqlPcTipoCompra);
    $oRetorno->tipocompratribunal = db_utils::fieldsMemory($rsExecPcTipoCompra, 0)->pc50_pctipocompratribunal;

    $oDaoAcordo = db_utils::getDao("acordo");
    $sSqlAcordoTipoorigem = $oDaoAcordo->sql_query($oParam->iAcordo,"ac16_tipoorigem",null,"");
    $rsAcordoTipoorigem = $oDaoAcordo->sql_record($sSqlAcordoTipoorigem);
    $oRetorno->tipoorigem = db_utils::fieldsMemory($rsAcordoTipoorigem, 0)->ac16_tipoorigem;


    break;
    /**
     * Busca os Tipos de Compra
     */
  case "getTipoCompraEmpenho":

    /**
     * Buscando resumo da solicitacao de compras
     */
    $oRetorno->sResumo = "";
    $oDaoSolicitacao   = db_utils::getDao("solicita");

    /*
     * Valida a origem dos dados.
     * 1 - Processo de Compras
     * 2 - Solicitação de Compras
     * undefined - Licitacao
     */
    if (isset($oParam->iOrigemDados) && $oParam->iOrigemDados == 1) {

      $sWhereResumo     = "pc81_codproc = {$oParam->iCodigo}";
      $oDaoBuscaDotacao = new ProcessoCompras($oParam->iCodigo);
    } else if (isset($oParam->iOrigemDados) && $oParam->iOrigemDados == 2) {

      $sWhereResumo     = "pc10_numero = {$oParam->iCodigo}";
      $oDaoBuscaDotacao = new solicitacaoCompra($oParam->iCodigo);
    } else {

      $sWhereResumo     = "l20_codigo = {$oParam->iCodigo}";
      $oDaoBuscaDotacao = new licitacao($oParam->iCodigo);
    }

    $aSolicitacaoComDotacaoAnoAnterior = $oDaoBuscaDotacao->getSolicitacoesDotacaoAnoAnterior();
    $oRetorno->solicitacaoComDotacaoAnoAnterior = $aSolicitacaoComDotacaoAnoAnterior;

    $sOrderResumo      = "pc10_numero desc limit 1";
    $sSqlBuscaResumo   = $oDaoSolicitacao->sql_query_estregistro(null, "pc10_resumo", $sOrderResumo, $sWhereResumo);
    $rsResumo          = $oDaoSolicitacao->sql_record($sSqlBuscaResumo);

    if ($rsResumo && pg_num_rows($rsResumo) > 0) {

      $oResumo           = db_utils::fieldsMemory($rsResumo, 0, false, false, false);
      $oRetorno->sResumo = utf8_encode($oResumo->pc10_resumo);
    }


    /*
     * Busca os Tipos de Compra
     */
    $sSqlPcTipoCompra   = $oDaoPcTipoCompra->sql_query_file(null, 'pc50_codcom, pc50_descr');
    $rsExecPcTipoCompra = $oDaoPcTipoCompra->sql_record($sSqlPcTipoCompra);
    $aPcTipoCompra      = array();

    if ($oDaoPcTipoCompra->numrows > 0) {

      for ($iRow = 0; $iRow < $oDaoPcTipoCompra->numrows; $iRow++) {

        $oDadosTipoCompra = db_utils::fieldsMemory($rsExecPcTipoCompra, $iRow, false, false, true);
        $aPcTipoCompra[] = $oDadosTipoCompra;
      }

      $oRetorno->aPcTipoCompra = $aPcTipoCompra;
    }

    /**
     * Busca o tipo de compra do registro
     * Tipos:  1 - Processo de Compras, 2 - Solicitação de Compras
     */
    !isset($oParam->iOrigemDados) ? $oParam->iOrigemDados = "" : $oParam->iOrigemDados;
    switch ($oParam->iOrigemDados) {

      case 1:

        $oDaoPcProc         = db_utils::getDao('pcproc');
        $sSqlProcessoCompra = $oDaoPcProc->sql_query_tipocompra($oParam->iCodigo, "pc50_codcom");
        $rsProcessoCompra   = $oDaoPcProc->sql_record($sSqlProcessoCompra);
        if ($oDaoPcProc->numrows > 0) {

          $iTipoCompra                  = db_utils::fieldsMemory($rsProcessoCompra, 0)->pc50_codcom;
          $oRetorno->iTipoCompraInicial = $iTipoCompra;
        }

        break;

      case 2:

        $oDaoSolicita        = db_utils::getDao('solicita');
        $sSqlBuscaTipoCompra = $oDaoSolicita->sql_query_tipocompra($oParam->iCodigo, "pc50_codcom");
        $rsBuscaTipoCompra   = $oDaoSolicita->sql_record($sSqlBuscaTipoCompra);
        if ($oDaoSolicita->numrows > 0) {

          $iTipoCompra = db_utils::fieldsMemory($rsBuscaTipoCompra, 0)->pc50_codcom;
          $oRetorno->iTipoCompraInicial = $iTipoCompra;
        }
        break;

      default:

        $oDaoLicLicita       = db_utils::getDao('liclicita');
        $sSqlBuscaTipoCompra = $oDaoLicLicita->sql_query($oParam->iCodigo, "pc50_codcom");
        $rsBuscaTipoCompra   = $oDaoLicLicita->sql_record($sSqlBuscaTipoCompra);
        if ($oDaoLicLicita->numrows > 0) {

          $iTipoCompra = db_utils::fieldsMemory($rsBuscaTipoCompra, 0)->pc50_codcom;
          $oRetorno->iTipoCompraInicial = $iTipoCompra;
        }
    }

    /*
     * Busca os Tipos de Empenho
     */
    $sSqlTipoEmpenho   = $oDaoEmpTipo->sql_query_file();
    $rsExecTipoEmpenho = $oDaoEmpTipo->sql_record($sSqlTipoEmpenho);

    $aTipoEmpenho = array();

    if ($oDaoEmpTipo->numrows > 0) {

      for ($iRow = 0; $iRow < $oDaoEmpTipo->numrows; $iRow++) {

        $oDadosTipoEmpenho = db_utils::fieldsMemory($rsExecTipoEmpenho, $iRow, false, false, true);
        $aTipoEmpenho[]    = $oDadosTipoEmpenho;
      }

      $oRetorno->aTipoEmpenho = $aTipoEmpenho;
    }

    if (count($aPcTipoCompra) > 0 && count($aTipoEmpenho) > 0) {
      $oRetorno->status = 0;
    }

    break;

    /**
     * Busca os Itens para uma Autorização
     */
  case "getItensParaAutorizacao":

    $oLicitacao       = new licitacao($oParam->iCodigo);
    $oRetorno->aItens = $oLicitacao->getItensParaAutorizacao();

    break;

  case "getDados":
    
    $oDaoLicLicita       = db_utils::getDao('liclicita');
    $sSqlDadoslicitacao = $oDaoLicLicita->sql_query_file($oParam->iCodigo, "l20_numero,l20_edital as numerolicitacao,l20_anousu,l20_codtipocom as tipocompra");
    $rsResult   = $oDaoLicLicita->sql_record($sSqlDadoslicitacao);
    $oDados = db_utils::fieldsMemory($rsResult, 0);

    $oRetorno->numerolicitacao = $oDados->numerolicitacao;
    $oRetorno->l20_numero = $oDados->l20_numero;
    $oRetorno->l20_anousu = $oDados->l20_anousu;
    $oRetorno->tipocompra = $oDados->tipocompra;
    $oRetorno->licitacao = 't';

    break;

    /**
     * Gera Autorização
     */
  case "gerarAutorizacoes":
    /* Ocorrência 2630
    * Validações de datas para geração de autorizações de empenhos e geração de empenhos
    * 1. Validar impedimento para geração de autorizações/empenhos com data anterior a data de homologação
    * 2. Validar impedimento para geração de autorizações de empenhos de licitações que não estejam homologadas.
    */
    $sSqlDataHomologacao = "select l202_datahomologacao from homologacaoadjudica where l202_licitacao = {$oParam->iCodigo}";
    if (pg_num_rows(db_query($sSqlDataHomologacao)) > 0) {
      if (strtotime(db_utils::fieldsMemory(db_query($sSqlDataHomologacao), 0)->l202_datahomologacao) > db_getsession('DB_datausu')) {
        $oRetorno->status  = 2;
        $oRetorno->message = urlencode("Não é permitido gerar autorizações de licitações cuja data de homologadação (" . date("d/m/Y", strtotime(db_utils::fieldsMemory(db_query($sSqlDataHomologacao), 0)->l202_datahomologacao)) . ") seja maior que a data da autorização (" . date("d/m/Y", db_getsession('DB_datausu')) . ").");
        break;
      }
    } else {
      $oRetorno->status  = 2;
      $oRetorno->message = urlencode("Não é permitido gerar autorizações de licitações não homologadas.");
      break;
    }

    /**
     * controle de encerramento peri. contabil
     */
    $clcondataconf = new cl_condataconf;
    $resultControle = $clcondataconf->sql_record($clcondataconf->sql_query_file(db_getsession('DB_anousu'), db_getsession('DB_instit'), 'c99_data'));
    db_fieldsmemory($resultControle, 0);

    $dtSistema = date("Y-m-d", db_getsession("DB_datausu"));

    if ($dtSistema <= $c99_data) {
      $oRetorno->status  = 2;
      $oRetorno->message = urlencode("Encerramento do periodo contabil para " . implode('/', array_reverse(explode('-', $c99_data))));
      break;
    }

    if (!isset($oParam->aAutorizacoes)) {

      $oRetorno->status  = 2;
      $oRetorno->message = urlencode("Há muitos itens selecionados. É necessário selecionar menos itens para gerar a autorização de empenho.");
    } else {

      try {

        /**
         * corrigimos as strings antes de salvarmos os dados
         */
        foreach ($oParam->aAutorizacoes as $oAutorizacao) {

          $oAutorizacao->destino           = addslashes(utf8_decode(db_stdClass::db_stripTagsJson(urldecode($oAutorizacao->destino))));
          $oAutorizacao->sContato          = addslashes(utf8_decode(db_stdClass::db_stripTagsJson(urldecode($oAutorizacao->sContato))));
          $oAutorizacao->sOutrasCondicoes  = addslashes(utf8_decode(db_stdClass::db_stripTagsJson(urldecode($oAutorizacao->sOutrasCondicoes))));
          $oAutorizacao->condicaopagamento = addslashes(utf8_decode(db_stdClass::db_stripTagsJson(urldecode($oAutorizacao->condicaopagamento))));
          $oAutorizacao->prazoentrega      = addslashes(utf8_decode(db_stdClass::db_stripTagsJson(urldecode($oAutorizacao->prazoentrega))));
          $oAutorizacao->resumo            = addslashes(utf8_decode(db_stdClass::db_stripTagsJson(urldecode($oAutorizacao->resumo))));

          foreach ($oAutorizacao->itens as $oItem) {
            $oItem->observacao = addslashes(utf8_decode(db_stdClass::db_stripTagsJson(urldecode($oItem->observacao))));
          }
        }

        db_inicio_transacao();
        $oLicitacao = new licitacao($oParam->iCodigo);
        $oRetorno->autorizacoes = $oLicitacao->gerarAutorizacoes($oParam->aAutorizacoes);
        db_fim_transacao(false);

        $oRetorno->status  = 1;
        $oRetorno->message = urlencode("Autorização efetuada com sucesso.");
      } catch (Exception $eErro) {

        $oRetorno->status  = 2;
        $oRetorno->message = urlencode($eErro->getMessage());
        db_fim_transacao(true);
      }
    }

    break;

  case "getFonercedoresLic":

    try {

      $oRetorno->cgms = getFonercedoresLic($oParam->licitacao);
    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }

    break;

  case "verificaSaldoCriterio":

    try {

      $oRetorno->itens   = verificaSaldoCriterio($oParam->e55_autori, $oParam->e55_item, $oParam->tipoitem, $oParam->pc94_sequencial);
      $oRetorno->itensqt = verificaSaldoCriterioItemQuantidade($oParam->e55_autori, $oParam->e55_item);
    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }

    break;

  case "validaSolicitacaoRegP":

    $sSQL = "SELECT l202_datahomologacao
              FROM solicita
                JOIN solicitem  ON pc11_numero = pc10_numero
                JOIN pcprocitem ON pc81_solicitem = pc11_codigo
                JOIN liclicitem ON l21_codpcprocitem = pc81_codprocitem
                JOIN liclicita  ON l20_codigo = l21_codliclicita
                JOIN homologacaoadjudica ON l202_licitacao = l20_codigo
                  WHERE pc10_numero = (
                                        SELECT pc53_solicitapai
                                          FROM solicitavinculo
                                            WHERE pc53_solicitafilho = (
                                                                        SELECT DISTINCT pc10_numero
                                                                          FROM solicita
                                                                            JOIN solicitem  ON pc11_numero    = pc10_numero
                                                                            JOIN pcprocitem ON pc81_solicitem = pc11_codigo
                                                                              WHERE pc81_codproc = {$oParam->iProcessoCompra}
                                                                      )
                                      ) limit 1";

    $rsConsulta = db_query($sSQL);
    $dataH = db_utils::getCollectionByRecord($rsConsulta);
    if (date("Y-m-d", db_getsession("DB_datausu")) < date('Y-m-d', strtotime($dataH[0]->l202_datahomologacao))) {
      $oRetorno->validacao = 0;
      $oRetorno->datahomologacao = date('d/m/Y', strtotime($dataH[0]->l202_datahomologacao));
    } else {
      $oRetorno->validacao = 1;
    }

    break;
}

function getFonercedoresLic($licitacao)
{
  $sSQL = "SELECT DISTINCT z01_numcgm ,z01_nome
  FROM liclicitem
    INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
    INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
    INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
    INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
    INNER JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
    LEFT JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
    LEFT JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
    LEFT JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
    LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
    LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
    LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
    LEFT JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
    LEFT JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
      AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
    LEFT JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
    LEFT JOIN cgm ON pc21_numcgm = z01_numcgm
    LEFT JOIN db_usuarios ON pcproc.pc80_usuario = db_usuarios.id_usuario
    LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
    LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
    LEFT JOIN pcsubgrupo ON pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo
    LEFT JOIN pctipo ON pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo
    LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
    LEFT JOIN orcelemento ON orcelemento.o56_codele = solicitemele.pc18_codele
      AND orcelemento.o56_anousu = " . db_getsession("DB_datausu") . "
    LEFT JOIN empautitempcprocitem ON empautitempcprocitem.e73_pcprocitem = pcprocitem.pc81_codprocitem
    LEFT JOIN empautitem ON empautitem.e55_autori = empautitempcprocitem.e73_autori
      AND empautitem.e55_sequen = empautitempcprocitem.e73_sequen
    LEFT JOIN empautoriza ON empautoriza.e54_autori = empautitem.e55_autori
    LEFT JOIN empempaut ON empempaut.e61_autori = empautitem.e55_autori
    LEFT JOIN empempenho ON empempenho.e60_numemp = empempaut.e61_numemp
    LEFT JOIN pcdotac ON solicitem.pc11_codigo = pcdotac.pc13_codigo
    LEFT JOIN pcorcamitem ON pc22_orcamitem=pc26_orcamitem
      WHERE l21_codliclicita = {$licitacao} and pc24_pontuacao=1";

  $rsConsulta = db_query($sSQL);
  $oCgm = db_utils::getCollectionByRecord($rsConsulta);
  return $oCgm;
}

function verificaSaldoCriterio($e55_autori, $e55_item, $tipoitem, $pc94_sequencial)
{
  $sSQL = "";
  if (strcasecmp($tipoitem, 'item') === 0) {
    $sSQL = "
     select sum(e55_vltot) as totalitens
      from empautitem
       inner join empautoriza on e54_autori = e55_autori
        where e54_codlicitacao = ( select e54_codlicitacao from empautoriza where e54_autori = {$e55_autori} )
         and e55_item = {$e55_item}
    ";
  } else {
    $sSQL = "
      select sum(e55_vltot) as totalitens
      from empautitem
       inner join empautoriza on e54_autori = e55_autori
       inner join pctabelaitem on pctabelaitem.pc95_codmater = empautitem.e55_item
       inner join pctabela on pctabela.pc94_sequencial = pctabelaitem.pc95_codtabela
        where e54_codlicitacao = (
                                  select e54_codlicitacao
                                   from empautoriza
                                    where e54_autori = {$e55_autori}
                                  )
                                  and pc94_sequencial = {$pc94_sequencial}
    ";
  }

  $rsConsulta = db_query($sSQL);
  $oItens = db_utils::getCollectionByRecord($rsConsulta);
  return $oItens;
}

function verificaSaldoCriterioItemQuantidade($e55_autori, $e55_item)
{

  $sSQL = "
   select sum(e55_quant) as totalitensqt
    from empautitem
     inner join empautoriza on e54_autori = e55_autori
      where e54_codlicitacao = ( select e54_codlicitacao from empautoriza where e54_autori = {$e55_autori} )
       and e55_item = {$e55_item}
  ";

  $rsConsulta = db_query($sSQL);
  $oItens = db_utils::getCollectionByRecord($rsConsulta);
  return $oItens;
}

echo $oJson->encode($oRetorno);
