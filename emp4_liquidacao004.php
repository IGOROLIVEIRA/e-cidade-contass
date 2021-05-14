<?
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

ini_set("ERROR_REPORTING", "E_ALL & ~ E_NOTICE");


require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_libcontabilidade.php");
require_once("libs/db_liborcamento.php");

require_once("classes/db_orcdotacao_classe.php");
require_once("classes/db_orctiporec_classe.php");
require_once("classes/db_empempenho_classe.php");
require_once("classes/db_empelemento_classe.php");
require_once("classes/db_pagordem_classe.php");
require_once("classes/db_pagordemele_classe.php");
require_once("classes/db_pagordemnota_classe.php");
require_once("classes/db_pagordemval_classe.php");
require_once("classes/db_pagordemrec_classe.php");
require_once("classes/db_pagordemtiporec_classe.php");
require_once("classes/db_empnota_classe.php");
require_once("classes/db_empnotaele_classe.php");
require_once("classes/db_tabrec_classe.php");
require_once("classes/db_conplanoreduz_classe.php");
require_once("classes/db_conlancam_classe.php");
require_once("classes/db_conlancamemp_classe.php");
require_once("classes/db_conlancamdoc_classe.php");
require_once("classes/db_conlancamele_classe.php");
require_once("classes/db_conlancamnota_classe.php");
require_once("classes/db_conlancamcgm_classe.php");
require_once("classes/db_conlancamdot_classe.php");
require_once("classes/db_conlancamval_classe.php");
require_once("classes/db_conlancamlr_classe.php");
require_once("classes/db_conlancamcompl_classe.php");
require_once("classes/db_conlancamord_classe.php");
require_once("classes/lancamentoContabil.model.php");

require_once("model/configuracao/Instituicao.model.php");
require_once("interfaces/ILancamentoAuxiliar.interface.php");
require_once("interfaces/IRegraLancamentoContabil.interface.php");
require_once("model/contabilidade/planoconta/interface/ISistemaConta.interface.php");

require_once("model/contabilidade/contacorrente/ContaCorrenteFactory.model.php");
require_once("model/contabilidade/contacorrente/ContaCorrenteBase.model.php");
require_once("model/financeiro/ContaBancaria.model.php");
require_once("model/contabilidade/planoconta/ContaPlano.model.php");
require_once("model/contabilidade/planoconta/ClassificacaoConta.model.php");
require_once("model/contabilidade/planoconta/ContaCorrente.model.php");
require_once("model/contabilidade/planoconta/ContaOrcamento.model.php");
require_once("model/contabilidade/planoconta/ContaPlanoPCASP.model.php");
require_once(Modification::getFile('model/agendaPagamento.model.php'));
require_once("model/retencaoNota.model.php");
require_once("model/ordemCompra.model.php");

require_once("model/contabilidade/planoconta/SistemaContaCompensado.model.php");
require_once("model/contabilidade/planoconta/SistemaContaFinanceiroBanco.model.php");
require_once("model/contabilidade/planoconta/SistemaContaFinanceiroCaixa.model.php");
require_once("model/contabilidade/planoconta/SistemaContaFinanceiroExtraOrcamentaria.model.php");
require_once("model/contabilidade/planoconta/SistemaContaFinanceiro.model.php");
require_once("model/contabilidade/planoconta/SistemaContaPatrimonial.model.php");
require_once("model/contabilidade/planoconta/SistemaContaOrcamentario.model.php");
require_once("model/contabilidade/planoconta/SistemaContaNaoAplicado.model.php");

require_once("model/contabilidade/planoconta/SubSistemaConta.model.php");
require_once("model/contabilidade/planoconta/SistemaConta.model.php");

require_once(Modification::getFile("classes/empenho.php"));
require_once("model/CgmFactory.model.php");

require_once("model/Dotacao.model.php");


db_app::import("exceptions.*");

$objEmpenho = new empenho();
$post = db_utils::postmemory($_POST);
$json = new services_json();
$objJson = $json->decode(str_replace("\\", "", $_POST["json"]));
$method = $objJson->method;
$oAgendaPagamento = new agendaPagamento();
$item = 0; //se deve trazer as notas, ou os itens do empenho.
$objEmpenho->setEmpenho($objJson->iEmpenho);
$objEmpenho->setEncode(true);


$dtDataSessao = db_getsession("DB_datausu");

$clempparametro       = new cl_empparametro;
$clempempenholiberado = new cl_empempenholiberado;
$lBloquear = false;
$result    = $clempparametro->sql_record($clempparametro->sql_query(db_getsession("DB_anousu")));
if($result != false && $clempparametro->numrows > 0){
    $oParam = db_utils::fieldsMemory($result,0);
}
if ($oParam->e30_liberaempenho == 't') {

    if (isset($objJson->iEmpenho) && !empty($objJson->iEmpenho)) {
        $sCampos = "empempenholiberado.*";
        $sWhere  = "e22_numemp = {$objJson->iEmpenho} ";
        $sWhere .= " AND EXISTS(SELECT 1 FROM empempenholiberado WHERE e22_numemp= e60_numemp)";
        $sWhere .= " AND NOT EXISTS(SELECT 1 FROM desdobramentosliberadosordemcompra WHERE pc33_codele = e64_codele ";
        $sWhere .= " AND pc33_anousu = ".db_getsession("DB_anousu").")";

        $sSqlEmpenhosLiberados  = $clempempenholiberado->sql_query(null,$sCampos,null,$sWhere);
        $rsSqlEmpenhosLiberados = $clempempenholiberado->sql_record($sSqlEmpenhosLiberados);

        if ($clempempenholiberado->numrows == 0) {
            $lBloquear = true;
        }
    }
}
//var_dump($lBloquear);exit("saiu");

//VERIFICA CPF E CNPJ ZERADOS OC 7037
    $result_cgmzerado = db_query("select z01_cgccpf from empempenho inner join cgm on z01_numcgm = e60_numcgm where e60_numemp = {$objJson->iEmpenho}");
    db_fieldsmemory($result_cgmzerado, 0)->z01_cgccpf;
    $zerado = false;

    if (strlen($z01_cgccpf) == 14) {
        if ($z01_cgccpf == '00000000000000') {
            $zerado = true;
        }
    }

    if (strlen($z01_cgccpf) == 11) {
        if ($z01_cgccpf == '00000000000') {
            $zerado = true;
        }
    }

//FIM OC 7037


switch ($objJson->method) {

  case "getEmpenhos":

  $lValidaNotasEmpenho = false;

  $oDaoElementos        = db_utils::getDao('orcelemento');
  $sWhereEmpenho        = " e60_numemp =  {$objJson->iEmpenho}";
  $sSqlBuscaElemento    = $oDaoElementos->sql_query_estrut_empenho(null, "substr(o56_elemento,1,7) AS o56_elemento", null, $sWhereEmpenho);
  $rsBuscaElemento      = $oDaoElementos->sql_record($sSqlBuscaElemento);

  $oDaoPatriInst    = db_utils::getDao('cfpatriinstituicao');
  $sWherePatriInst  = " t59_instituicao = " . db_getsession('DB_instit');
  $sSqlPatriInst    = $oDaoPatriInst->sql_query_file(null, "t59_dataimplanatacaodepreciacao", null, $sWherePatriInst);
  $rsPatriInst      = $oDaoPatriInst->sql_record($sSqlPatriInst);

  if ($oDaoPatriInst->numrows > 0) {

    $dtImplantacao = db_utils::fieldsMemory($rsPatriInst, 0)->t59_dataimplanatacaodepreciacao;
    if (!empty($dtImplantacao)) {
      $lValidaNotasEmpenho = true;
    }
  }

  $oDaoEmpNota      = db_utils::getDao('empnota');
  $sWhereBuscaNotas = " e69_numemp = {$objJson->iEmpenho} ";
  $sSqlBuscaNotas   = $oDaoEmpNota->sql_query_elemento_patrimonio(null, "empnota.* ", null, $sWhereBuscaNotas);
  $rsBuscaNotas     = $oDaoEmpNota->sql_record($sSqlBuscaNotas);
  $aBuscaNotas      = db_utils::getCollectionByRecord($rsBuscaNotas);
  $aNotasEmpenho    = array();
  $oGrupoElemento   = new stdClass();

  if (count($aBuscaNotas) > 0 && $lValidaNotasEmpenho) {

    foreach ($aBuscaNotas as $oNota) {

      $oDaoEmpNotaItemBensPendente      = db_utils::getDao('empnotaitembenspendente');
      $sWhereBuscaItensForaDoPatrimonio = " e69_codnota = {$oNota->e69_codnota} and e136_sequencial is null "
      . " and e139_sequencial is null and m73_cancelado is false ";

      $sSqlBuscaItensForaDoPatrimonio = $oDaoEmpNotaItemBensPendente->sql_query_patrimonio(
        null,
        "e69_codnota",
        null,
        $sWhereBuscaItensForaDoPatrimonio
        );
      $rsBuscaItensForaDoPatrimonio = $oDaoEmpNotaItemBensPendente->sql_record($sSqlBuscaItensForaDoPatrimonio);
      if ($oDaoEmpNotaItemBensPendente->numrows > 0) {
        $aNotasEmpenho[] = $oNota->e69_codnota;
      }
    }
  }

  $objEmpenho->operacao = $objJson->operacao;
  if (isset($objJson->itens)) {
    $item = 1;
  }
  $objEmpenho->setEmpenho($objJson->iEmpenho);

  if (count($aNotasEmpenho) > 0 && $lValidaNotasEmpenho) {

      //echo $objEmpenho->empenho2Json('',$item, $aNotasEmpenho);
    $oEmpenho = json_decode($objEmpenho->empenho2Json('', $item, $aNotasEmpenho));
    $oGrupoElemento->iGrupo = "";
    $oGrupoElemento->sGrupo = "";
    $oEmpenho->oGrupoElemento = $oGrupoElemento;
      $oEmpenho->LiberadoLic = $lBloquear;
      $oEmpenho->Zerado = $zerado;
      echo $json->encode($oEmpenho);

  }
  else {

    $oEmpenho = json_decode($objEmpenho->empenho2Json('', $item));
    $oGrupoContaOrcamento = GrupoContaOrcamento::getGrupoConta($oEmpenho->e64_codele, db_getsession("DB_anousu"));

    $oEmpenhoFinanceiro = new EmpenhoFinanceiro($oEmpenho->e60_numemp);
    if ($oGrupoContaOrcamento && !$oEmpenhoFinanceiro->isEmpenhoPassivo()) {

      $iGrupo = $oGrupoContaOrcamento->getCodigo();
      $sDescricao = $oGrupoContaOrcamento->getDescricao();

        /**
         * Caso o empennho seja dos grupos abaixo, nao devemos permitir a liquidacao
         * do mesmo atraves da rotina de liquidacao sem ordem de compra
         */
        if ($iGrupo != "") {

          if (in_array($iGrupo, array(7, 8, 9))) {


            $oGrupoElemento->iGrupo = $iGrupo;
            $oGrupoElemento->sGrupo = urlencode($sDescricao);
            $oEmpenho->oGrupoElemento = $oGrupoElemento;
            $oEmpenho->LiberadoLic = $lBloquear;
            $oEmpenho->Zerado = $zerado;
            echo $json->encode($oEmpenho);


          }
          else {

            //echo $objEmpenho->empenho2Json('',$item);
            $oEmpenho = json_decode($objEmpenho->empenho2Json('', $item));
            $oGrupoElemento->iGrupo = "";
            $oGrupoElemento->sGrupo = "";
            $oEmpenho->oGrupoElemento = $oGrupoElemento;
              $oEmpenho->LiberadoLic = $lBloquear;
              $oEmpenho->Zerado = $zerado;
              echo $json->encode($oEmpenho);
          }
        }
      }
      else {
        // echo $objEmpenho->empenho2Json('',$item);
        $oEmpenho = json_decode($objEmpenho->empenho2Json('', $item));
        $oEmpenho->sEstrutural = db_utils::fieldsMemory($rsBuscaElemento, 0)->o56_elemento;
        $oGrupoElemento->iGrupo = "";
        $oGrupoElemento->sGrupo = "";
        $oEmpenho->oGrupoElemento = $oGrupoElemento;
          $oEmpenho->LiberadoLic = $lBloquear;
          $oEmpenho->Zerado = $zerado;
          echo $json->encode($oEmpenho);
      }

    }
    break;

    case "liquidarAjax":

    if (isset($objJson->z01_credor) && !empty($objJson->z01_credor)) {
      $objEmpenho->setCredor($objJson->z01_credor);
    }

        try {

      $dtDataSessao = date("Y-m-d", $dtDataSessao);
      $oDaoConlancamEmp = new cl_conlancamemp();
      $sWhereEmpenho  = "     conlancamemp.c75_numemp = {$objJson->iEmpenho} ";
      $sWhereEmpenho .= " and conhistdoc.c53_tipo     = 200 ";
      $sWhereEmpenho .= " and conlancam.c70_data      > '{$dtDataSessao}' ";
      $sSqlBuscaDocumentos = $oDaoConlancamEmp->sql_query_documentos(null, "conhistdoc.*", 1, $sWhereEmpenho);
      $rsBuscaDocumentos = $oDaoConlancamEmp->sql_record($sSqlBuscaDocumentos);

      if ($oDaoConlancamEmp->numrows > 0) {
        throw new Exception("Não é possível realizar o lançamento contábil com data anterior a data dos lançamentos de controle de liquidação.");
      }

      $sHistorico = db_stdClass::normalizeStringJsonEscapeString($objJson->historico);//addslashes(stripslashes(utf8_decode()))
      $oRetorno   = $objEmpenho->liquidarAjax($objJson->iEmpenho, $objJson->notas, $sHistorico, $objJson->e50_compdesp);
      $oDadosRetorno = $json->decode(str_replace("\\", "", $oRetorno));
      if ($oRetorno !== false) {

        if ($oDadosRetorno->erro == 1) {

          //caso procedimento com sucesso  vincula o processo administrativo
          $sProcessoAdministrativo = addslashes(db_stdClass::normalizeStringJson($objJson->e03_numeroprocesso));

          if (!empty($sProcessoAdministrativo)) {

            $aOrdensGeradas = explode(",", $oDadosRetorno->sOrdensGeradas);

            foreach ($aOrdensGeradas as $iIndOrdensGeradas => $iOrdem) {

              $oDaoPagordemProcesso = new cl_pagordemprocesso();
              $oDaoPagordemProcesso->e03_numeroprocesso = $sProcessoAdministrativo;
              $oDaoPagordemProcesso->e03_pagordem = $iOrdem;
              $oDaoPagordemProcesso->incluir(null);
              if ($oDaoPagordemProcesso->erro_status == 0) {
                throw new Exception($oDaoPagordemProcesso->erro_msg);
              }
            }

          }

          echo $oRetorno;
        }

        /**[Extensao OrdenadorDespesa] inclusao_ordenador_1*/
      }


      if ($objEmpenho->lSqlErro && !empty($objEmpenho->sMsgErro)) {
        throw new Exception($objEmpenho->sMsgErro);
      }

    } catch (Exception $eErro) {

      $oRetorno = $json->encode(array("sMensagem" => urlencode($eErro->getMessage()), "lErro" => true));
      echo $oRetorno;
    }

    break;

    case "geraOC":

    $z01_credor = $objJson->z01_credor;
    $sHistorico = db_stdClass::normalizeStringJsonEscapeString($objJson->historico);
    $objEmpenho->setEmpenho($objJson->iEmpenho);
    $objEmpenho->setCredor($z01_credor);
    $chave = true;

    /**
     * Pode ser que o método gerarOrdemCompra retorne false ou um JSON
     */
    $oRetorno = $objEmpenho->gerarOrdemCompra(
      $objJson->e69_nota,
      $objJson->valorTotal,
      $objJson->notas,
      true,
      $objJson->e69_dtnota,
      $sHistorico,
      true,
      $objJson->oInfoNota,
      $objJson->e69_notafiscaleletronica,
      $objJson->e69_chaveacesso,
      $objJson->e69_nfserie,
      $objJson->e50_compdesp
    );

    if (isset($objJson->verificaChave) && $objJson->verificaChave == 1 && $objJson->e69_notafiscaleletronica != 2 && $objJson->e69_notafiscaleletronica != 3) {
      $ufs = array(

        11 => "RO", 12 => "AC", 13 => "AM", 14 => "RR", 15 => "PA", 16 => "AP", 17 => "TO", 21 => "MA", 22 => "PI",
        23 => "CE", 24 => "RN", 25 => "PB", 26 => "PE", 27 => "AL", 28 => "SE", 29 => "BA", 31 => "MG", 32 => "ES",
        33 => "RJ", 35 => "SP", 41 => "PR", 42 => "SC", 43 => "RS", 50 => "MS", 51 => "MT", 52 => "GO", 53 => "DF"

      );

      $ufKey   = substr($objJson->e69_chaveacesso,0,2);
      $dataKey = substr($objJson->e69_chaveacesso,2,4);
      $cnpjKey = substr($objJson->e69_chaveacesso,6,14);
      $nfKey   = substr($objJson->e69_chaveacesso,25,9);

      $oDaoCgm   = db_utils::getDao("cgm");
      $sSqlCgm   = $oDaoCgm->sql_query_file($objJson->cgm);
      $rsCgm     = $oDaoCgm->sql_record($sSqlCgm);
      $oDadosCgm = db_utils::fieldsMemory($rsCgm,0);


      $key  = (array_key_exists($ufKey, $ufs)) ? $ufKey : 0;
      $data = substr(implode("",array_reverse(explode("/", $objJson->e69_dtnota))), 2, 4);

      if ($ufs[$key] != $oDadosCgm->z01_uf) {
        $chave = false;
        $objEmpenho->sMsgErro   = "Chave de acesso inválida!\nVerifique a Cidade e o Estado do Fornecedor!";
      }

      else if (strcmp($data, $dataKey)) {
        $chave = false;
        $objEmpenho->sMsgErro   = "Chave de acesso inválida!\nVerifique a data da Nota Fiscal!";
      }

      else if (strcmp(str_pad($objJson->e69_nota, 9, "0", STR_PAD_LEFT), $nfKey)) {
        $chave = false;
        $objEmpenho->sMsgErro   = "Chave de acesso inválida!\nVerifique o Número da Nota!";
      }

      else if ($objJson->e69_notafiscaleletronica == 1) {
        if (strcmp($oDadosCgm->z01_cgccpf, $cnpjKey)) {
          $chave = false;//
          $objEmpenho->sMsgErro   = "Chave de acesso inválida!\nVerifique o CNPJ do Fornecedor!";
        }
      }
    }

    if ($chave !== false) {

      if ($oRetorno !== false) {


        //caso procedimento com sucesso  vincula o processo administrativo
        $sProcessoAdministrativo = addslashes(stripslashes(utf8_decode($objJson->e03_numeroprocesso)));
        $oDadosRetorno = $json->decode(str_replace("\\", "", $oRetorno));

        if ($oDadosRetorno->erro != 2) {

          if (!empty($sProcessoAdministrativo)) {

            $oDaoPagordemProcesso = new cl_pagordemprocesso();
            $oDaoPagordemProcesso->e03_numeroprocesso = $sProcessoAdministrativo;
            $oDaoPagordemProcesso->e03_pagordem = $oDadosRetorno->e50_codord;
            $oDaoPagordemProcesso->incluir(null);
            if ($oDaoPagordemProcesso->erro_status == 0) {
              throw new Exception($oDaoPagordemProcesso->erro_msg);
            }

          }
          /**[Extensao OrdenadorDespesa] inclusao_ordenador_2*/
        }

        echo $oRetorno;
      }
      else {

        $retorno = array("erro" => 2, "mensagem" => urlencode($objEmpenho->sMsgErro), "e50_codord" => null);
        echo $json->encode($retorno);
      }
    } else {
      $retorno = array("erro" => 2, "mensagem" => urlencode($objEmpenho->sMsgErro), "e50_codord" => null);
      echo $json->encode($retorno);
    }

    break;

    case "anularEmpenho":

    $objEmpenho->buscaUltimoDocumentoExecutadoDoc($objJson->iEmpenho,21,date('Y-m-d', db_getsession('DB_datausu')));
    if ($objEmpenho->lSqlErro) {
      $nMensagem = urlencode($objEmpenho->sErroMsg);
      $iStatus = 2;
    }else {
      $objEmpenho->setRecriarSaldo($objJson->lRecriarReserva);
      $objEmpenho->anularEmpenho($objJson->itensAnulados,
        $objJson->nValor,
        $objJson->sMotivo,
        $objJson->aSolicitacoes,
        $objJson->iTipoAnulacao);
      if ($objEmpenho->lSqlErro) {

        $nMensagem = urlencode($objEmpenho->sErroMsg);
        $iStatus = 2;

      } else {
        $nMensagem = '';
        $iStatus = 1;
      }
    }
    /**
    *ALTERAÇÃO DA ROTINA DE ANULAÇÃO DE EMPENHO
    *AJUSTE PARA SALDO VOLTAR PARA OS ITENS DA ULTIMA POSIÇÃO

    else {
      db_inicio_transacao();
      $aItens = $objJson->itensAnulados;
      for($iInd = 0; $iInd < count($aItens); $iInd++){
        $acordoMaterial = db_query("SELECT ac26_acordo, ac20_pcmater
          FROM acordoitemexecutadoempautitem
          JOIN acordoitemexecutado ON ac19_acordoitemexecutado=ac29_sequencial
          JOIN acordoitem ON ac29_acordoitem=ac20_sequencial
          JOIN acordoposicao ON ac20_acordoposicao=ac26_sequencial
          JOIN empautitem ON ac19_autori=e55_autori
          AND ac19_sequen=e55_sequen
          JOIN empautoriza ON e55_autori=e54_autori
          JOIN empempaut ON e61_autori=e54_autori
          JOIN empempitem ON e62_numemp=e61_numemp
          WHERE e62_sequencial = {$aItens[$iInd]->e62_sequencial}
          AND (ac29_quantidade < 0
          OR ac29_valor < 0)");

        $rsacordoMaterial = db_utils::fieldsMemory($acordoMaterial);

        $DaoacordoItemDotacao = db_utils::getDao('acordoitemdotacao');
        $Dotacao = $DaoacordoItemDotacao->sql_record("SELECT ac22_sequencial,ac22_valor,ac22_quantidade
          FROM acordoitemdotacao
          JOIN acordoitem ON ac20_sequencial = ac22_acordoitem
          JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
          WHERE ac26_acordo = {$rsacordoMaterial->ac26_acordo}
          AND ac20_pcmater = {$rsacordoMaterial->ac20_pcmater}
          AND ac20_acordoposicao =
          (SELECT max(ac26_sequencial)
          FROM acordoposicao
          WHERE ac26_acordo = {$rsacordoMaterial->ac26_acordo} and ac26_acordoposicaotipo <> 1)");
        if(pg_num_rows($Dotacao) == 0){
          break;
        }

        $Dotacao = db_utils::fieldsMemory($Dotacao);
        $DaoacordoItemDotacao->ac22_sequencial = $Dotacao->ac22_sequencial;
        $DaoacordoItemDotacao->ac22_valor = $Dotacao->ac22_valor + $aItens[$iInd]->vlrtot;
        $DaoacordoItemDotacao->ac22_quantidade = $Dotacao->ac22_quantidade + $aItens[$iInd]->quantidade;
        $DaoacordoItemDotacao->alterar($Dotacao->ac22_sequencial);
        if($DaoacordoItemDotacao->erro_status == 0){

          $nMensagem = urlencode($DaoacordoItemDotacao->erro_msg);
          $iStatus = 2;
          break;

        }


        $DaoacordoItem = db_utils::getDao('acordoitem');
        $ItemUltimaPosicao = $DaoacordoItem->sql_record("
          SELECT ac20_sequencial,ac20_quantidade,ac20_valortotal,ac20_valorunitario
          FROM acordoitem
          JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
          WHERE ac26_acordo = {$rsacordoMaterial->ac26_acordo}
          AND ac26_sequencial =
          (SELECT max(ac26_sequencial)
          FROM acordoposicao
          WHERE ac26_acordo = {$rsacordoMaterial->ac26_acordo})
          AND ac20_pcmater = {$rsacordoMaterial->ac20_pcmater} ");


        $ItemUltimaPosicao = db_utils::fieldsMemory($ItemUltimaPosicao);
        $DaoacordoItem->ac20_sequencial = $ItemUltimaPosicao->ac20_sequencial;
        $DaoacordoItem->ac20_quantidade = $ItemUltimaPosicao->ac20_quantidade + $aItens[$iInd]->quantidade;
        $DaoacordoItem->ac20_valortotal = $ItemUltimaPosicao->ac20_valortotal + $aItens[$iInd]->vlrtot;
        $DaoacordoItem->ac20_valorunitario = $ItemUltimaPosicao->ac20_valorunitario;
        $DaoacordoItem->alterar($ItemUltimaPosicao->ac20_sequencial);
        if($DaoacordoItem->erro_status == 0){

          $nMensagem = urlencode($DaoacordoItem->erro_msg);
          $iStatus = 2;
          break;
        }


      }

      if($iStatus == 2){
        db_fim_transacao(true);

      }else{
        db_fim_transacao(false);
        $nMensagem = '';
        $iStatus = 1;
      }
    }
    */
    echo $json->encode(array("mensagem" => $nMensagem, "status" => $iStatus));

    break;

    case "getDadosRP":

    if ($objEmpenho->getDadosRP($objJson->iTipoRP)) {
      echo $json->encode($objEmpenho->dadosEmpenho);
    }
    else {
      echo $json->encode(array("status" => 2, "sMensagem" => urlencode($objEmpenho->sErroMsg)));
    }
    break;

    case "estornarRP":

    try {

      $objEmpenho->buscaUltimoDocumentoExecutadoDoc($objJson->iEmpenho,21,date('Y-m-d', db_getsession('DB_datausu')));

      if ($objEmpenho->lSqlErro) {
        $sMensagem = urlencode($objEmpenho->sErroMsg);
        $iStatus = 2;
      }else {

        db_inicio_transacao();
        $objEmpenho->estornarRP(
          $objJson->iTipo,
          $objJson->aNotas,
          $objJson->sValorEstornar,
          $objJson->sMotivo,
          $objJson->aItens,
          $objJson->tipoAnulacao,
          $objJson->sAto,
          $objJson->dDataAto
        );
        db_fim_transacao(false);
        $iStatus = 1;
        $sMensagem = "Empenho estornado com sucesso";

      }

    } catch (Exception $e) {

      $iStatus = 2;
      $sMensagem = urlencode($e->getMessage());
      db_fim_transacao(true);
    }
    echo $json->encode(array("sMensagem" => $sMensagem, "iStatus" => $iStatus));
    break;

    case "getDadosRP":

    if ($objEmpenho->getDados($objJson->iEmpenho)) {

      $rsNotas = $objEmpenho->getNotas($objJson->iEmpenho);
      if ($rsNotas) {

        for ($iNotas = 0; $iNotas < $objEmpenho->iNumRowsNotas; $iNotas++) {

          $oNota = db_utils::fieldsMemory($rsNotas, $iNotas);
          $oNota->temMovimentoConfigurado = false;
          $oNota->temRetencao = false;
          $oNota->VlrRetencao = 0;
          /**
           * Pesquisamos se existem algum movimento para essa nota.
           */
          $sWhereIni = "e50_codord = {$oNota->e50_codord} and e97_codforma is not null";
          $sWhereIni .= " and corempagemov.k12_codmov is null and e81_cancelado is null";
          $sJoin = " left join empagenotasordem on e81_codmov         = e43_empagemov  ";
          $sJoin .= " left join empageordem      on e43_ordempagamento = e42_sequencial ";
          $aMOvimentos = $oAgendaPagamento->getMovimentosAgenda($sWhereIni, $sJoin, false, false);
          if (count($aMOvimentos) > 0) {

            $oNota->temMovimentoConfigurado = true;
          }

          //Verifica se a nota possui retenções lançadas
          $oRetencao = new retencaoNota($oNota->e69_codnota);
          if ($oNota->e50_codord != "" && $oRetencao->getValorRetencao($oNota->e50_codord) > 0) {

            $oNota->temRetencao = true;
            $oNota->VlrRetencao = $oRetencao->getValorRetencao($oNota->e50_codord);
          }
          $objEmpenho->dadosEmpenho->aNotas[] = $oNota;
        }
      }

      echo $json->encode($objEmpenho->dadosEmpenho);

    }
    else {
      echo $json->encode(array("status" => 2, "sMensagem" => urlencode($objEmpenho->sErroMsg)));
    }
    break;

    case "getDadosNotas" :

    if ($objEmpenho->getDados($objJson->iEmpenho)) {

      $rsNotas = $objEmpenho->getNotas($objJson->iEmpenho);
      if ($rsNotas) {

        for ($iNotas = 0; $iNotas < $objEmpenho->iNumRowsNotas; $iNotas++) {

          $oNota = db_utils::fieldsMemory($rsNotas, $iNotas);
          $oNota->temMovimentoConfigurado = false;
          $oNota->temRetencao = false;
          $oNota->VlrRetencao = 0;
          /**
           * Pesquisamos se existem algum movimento para essa nota.
           */
          $sWhereIni = "e50_codord = {$oNota->e50_codord} and e97_codforma is not null";
          $sWhereIni .= " and corempagemov.k12_codmov is null and e81_cancelado is null";
          $sJoin = " left join empagenotasordem on e81_codmov         = e43_empagemov  ";
          $sJoin .= " left join empageordem      on e43_ordempagamento = e42_sequencial ";
          $aMOvimentos = $oAgendaPagamento->getMovimentosAgenda($sWhereIni, $sJoin, false, false);
          if (count($aMOvimentos) > 0) {

            $oNota->temMovimentoConfigurado = true;
          }

          //Verifica se a nota possui retenções lançadas
          $oRetencao = new retencaoNota($oNota->e69_codnota);
          if ($oNota->e50_codord != "" && $oRetencao->getValorRetencao($oNota->e50_codord) > 0) {
            $oNota->temRetencao = true;
            $oNota->VlrRetencao = $oRetencao->getValorRetencao($oNota->e50_codord);
          }

          $objEmpenho->dadosEmpenho->aNotas[] = $oNota;
        }
      }
    }

    $objEmpenho->dadosEmpenho->isRestoPagar = $objEmpenho->isRestoPagar() || $objEmpenho->dadosEmpenho->e60_anousu < db_getsession("DB_anousu");

    echo $json->encode($objEmpenho->dadosEmpenho);
    break;

    case "getItensNota":

    /**
     * Busca os ITENS da nota
     */
    $oDadosRetorno = new stdClass();
    $objEmpenho->setEncode(true);
    $aItens = $objEmpenho->getItensNota($objJson->iCodNota);

    /** Pegar o total dos valores de retenção para esta OP */
    /** Retornar esses valores no JSON */
    $oRetencao = new retencaoNota($objJson->iCodNota);
    $oOrdemPag = new cl_pagordem();
    $nValorOP = $oRetencao->getValorOP();

    $sQueryQtdMovOP = $oOrdemPag->sql_query_movimento(
      null,
      "COUNT(e50_codord) as total",
      null,
      " (e50_codord = {$oRetencao->getCodOrd()}) AND (e81_cancelado IS NULL) "
      );
    $nValorRetencoes = $oRetencao->getRetencoesFromCodOrd(true);
    $nQtdMocOP = db_utils::fieldsMemory(db_query($sQueryQtdMovOP), 0)->total;

    if (!$aItens) {

      $oDadosRetorno->status = 1;
      $oDadosRetorno->sMensagem = "Não foi possível recuperar os itens da nota!";
    }
    else {

      $oDadosRetorno->status    = 2;
      $oDadosRetorno->iCodNota  = $objJson->iCodNota;
      $oDadosRetorno->iCodNota  = $objJson->iCodNota;
      $oDadosRetorno->iEmpenho  = $objJson->iEmpenho;
      $oDadosRetorno->aItens    = $aItens;
      $oDadosRetorno->nRetencoes  = $nValorRetencoes;
      $oDadosRetorno->nValorOP    = $nValorOP;
      $oDadosRetorno->nQtdMovOP   = $nQtdMocOP;

    }

    echo $json->encode($oDadosRetorno);
    break;

    default:
    echo $objEmpenho->$method($objJson->iEmpenho, $objJson->notas, $objJson->historico);
    break;
  }
