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
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_libcontabilidade.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("classes/db_materialestoquegrupo_classe.php");

db_app::import("configuracao.DBEstrutura");
db_app::import("estoque.MaterialGrupo");
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->erro    = false;
$oRetorno->message = '';

switch ($oParam->exec) {

  case "getCodigoEstrutural":

    $oRetorno->iCodigoEstrutura = '';
    $aParametro = db_stdClass::getParametro("matparam", array());
    if (count($aParametro) > 0) {
      $oRetorno->iCodigoEstrutura = $aParametro[0]->m90_db_estrutura;
    }
    break;

  case "salvarGrupo":

    try {
      db_inicio_transacao();

      if ($oParam->oGrupo->iConta == '' ||   $oParam->oGrupo->iContaVPD == '') {
        throw new BusinessException('ERRO - Nenhuma conta vinculada ao grupo.\nCampos: Conta Contábil e Conta Contábil VPD são obrigatórias.');
      }

      $oMaterialGrupo = new MaterialGrupo($oParam->iCodigoGrupo);

      $oMaterialGrupo->setDescricao(db_stdClass::db_stripTagsJson(utf8_decode($oParam->oGrupo->sDescricao)))
        ->setEstrutura((int)$oParam->oGrupo->iCodigoEstrutura)
        ->setTipoConta($oParam->oGrupo->iTipo)
        ->setEstrutural(db_stdClass::db_stripTagsJson(utf8_decode($oParam->oGrupo->sEstrutural)))
        ->setAtivo($oParam->oGrupo->lAtivo == 1 ? true : false)
        ->setConta($oParam->oGrupo->iConta)
        ->setCodigoContaVPD($oParam->oGrupo->iContaVPD)
        ->setCodigoContaTransf($oParam->oGrupo->iContaTransferencia)
        ->setCodigoContaTransfVPD($oParam->oGrupo->iContaTransferenciaVPD)
        ->setCodigoContaDoacao($oParam->oGrupo->iContaDoacao)
        ->setCodigoContaDoacaoVPD($oParam->oGrupo->iContaDoacaoVPD)
        ->setCodigoContaPerdaAtivo($oParam->oGrupo->iContaPerdaAtivo)
        ->setCodigoContaPerdaAtivoVPD($oParam->oGrupo->iContaPerdaAtivoVPD)
        ->setCodigoContaCredito($oParam->oGrupo->iCodigoContaCredito)
        ->setCodigoContaDebito($oParam->oGrupo->iCodigoContaDebito)
        ->salvar();

      db_fim_transacao(false);
    } catch (Exception $eErro) {

      db_fim_transacao(true);
      $oRetorno->status  = 2;
      $oRetorno->erro    = true;
      $oRetorno->message = urlencode(str_replace("\\n", "\n", $eErro->getMessage()));
    }
    break;

  case "getDadosGrupo":

    $oMaterialGrupo              = new MaterialGrupo($oParam->iCodigoGrupo);
    $oRetorno->descricao         = urlencode($oMaterialGrupo->getDescricao());
    $oRetorno->estrutural        = urlencode($oMaterialGrupo->getEstrutural());
    $oRetorno->tipoconta         = $oMaterialGrupo->getTipoConta();
    $oRetorno->ativo             = $oMaterialGrupo->isAtivo() ? 1 : 2;
    $oRetorno->codigoconta       = $oMaterialGrupo->getConta();
    $oRetorno->codigocontaVPD    = $oMaterialGrupo->getCodigoContaVPD();
    $oRetorno->codigogrupo       = $oMaterialGrupo->getCodigo();
    $oRetorno->descricaoconta    = urlencode($oMaterialGrupo->getDescricaoConta());
    $oRetorno->descricaocontaVPD = "";
    $oRetorno->codigocontatransf        = $oMaterialGrupo->getCodigoContaTransf();
    $oRetorno->codigocontatransfVPD     = $oMaterialGrupo->getCodigoContaTransfVPD();
    $oRetorno->codigocontadoacao        = $oMaterialGrupo->getCodigoContaDoacao();
    $oRetorno->codigocontadoacaoVPD     = $oMaterialGrupo->getCodigoContaDoacaoVPD();
    $oRetorno->codigocontaperdaativo    = $oMaterialGrupo->getCodigoContaPerdaAtivo();
    $oRetorno->codigocontaperdaativoVPD = $oMaterialGrupo->getCodigoContaPerdaAtivoVPD();
    $oRetorno->codigocontacredito    = $oMaterialGrupo->getCodigoContaCredito();
    $oRetorno->codigocontadebito = $oMaterialGrupo->getCodigoContaDebito();


    $rsDescricaoTransferencia = db_query("select c60_descr from conplano where c60_codcon = $oRetorno->codigocontatransf and c60_anousu = " . db_getsession('DB_anousu'));
    $sDescricaoTransferencia = db_utils::fieldsMemory($rsDescricaoTransferencia, 0)->c60_descr;

    $rsDescricaoTransferenciaVPD = db_query("select c60_descr from conplano where c60_codcon = $oRetorno->codigocontatransfVPD  and c60_anousu = " . db_getsession('DB_anousu'));
    $sDescricaoTransferenciaVPD  = db_utils::fieldsMemory($rsDescricaoTransferenciaVPD, 0)->c60_descr;

    $rsDescricaoDoacao = db_query("select c60_descr from conplano where c60_codcon = $oRetorno->codigocontadoacao  and c60_anousu = " . db_getsession('DB_anousu'));
    $sDescricaoDoacao = db_utils::fieldsMemory($rsDescricaoDoacao, 0)->c60_descr;

    $rsDescricaoDoacaoVPD = db_query("select c60_descr from conplano where c60_codcon = $oRetorno->codigocontadoacaoVPD and c60_anousu = " . db_getsession('DB_anousu'));
    $sDescricaoDoacaoVPD  = db_utils::fieldsMemory($rsDescricaoDoacaoVPD, 0)->c60_descr;

    $rsDescricaoPerdaAtivo = db_query("select c60_descr from conplano where c60_codcon = $oRetorno->codigocontaperdaativo and c60_anousu = " . db_getsession('DB_anousu'));
    $sDescricaoPerdaAtivo = db_utils::fieldsMemory($rsDescricaoPerdaAtivo, 0)->c60_descr;

    $rsDescricaoPerdaAtivoVPD = db_query("select c60_descr from conplano where c60_codcon = $oRetorno->codigocontaperdaativoVPD  and c60_anousu = " . db_getsession('DB_anousu'));
    $sDescricaoPerdaAtivoVPD  = db_utils::fieldsMemory($rsDescricaoPerdaAtivoVPD, 0)->c60_descr;

    $rsDescricaoCredito = db_query("select c60_descr from conplano where c60_codcon = $oRetorno->codigocontacredito and c60_anousu = " . db_getsession('DB_anousu'));
    $sDescricaoCredito  = db_utils::fieldsMemory($rsDescricaoCredito, 0)->c60_descr;

    $rsDescricaoDebito = db_query("select c60_descr from conplano where c60_codcon = $oRetorno->codigocontadebito and c60_anousu = " . db_getsession('DB_anousu'));
    $sDescricaoDebito  = db_utils::fieldsMemory($rsDescricaoDebito, 0)->c60_descr;

    $oRetorno->sDescricaoTransferencia = $sDescricaoTransferencia;
    $oRetorno->sDescricaoTransferenciaVPD = $sDescricaoTransferenciaVPD;
    $oRetorno->sDescricaoDoacao = $sDescricaoDoacao;
    $oRetorno->sDescricaoDoacaoVPD = $sDescricaoDoacaoVPD;
    $oRetorno->sDescricaoPerdaAtivo = $sDescricaoPerdaAtivo;
    $oRetorno->sDescricaoPerdaAtivoVPD = $sDescricaoPerdaAtivoVPD;
    $oRetorno->sDescricaoCredito = $sDescricaoCredito;
    $oRetorno->sDescricaoDebito = $sDescricaoDebito;


    if ($oMaterialGrupo->getContaVPD() != "") {
      $oRetorno->descricaocontaVPD = urlencode($oMaterialGrupo->getContaVPD()->getDescricao());
    }
    break;

  case "getGrupos":

    $sCamposMateriais  = "distinct on (db121_estrutural) ";
    $sCamposMateriais .= "coalesce(db121_descricao, 'S/G') as descricaogrupo,";
    $sCamposMateriais .= "db121_sequencial as codigogrupo,";
    $sCamposMateriais .= "db121_nivel as nivel,";
    $sCamposMateriais .= "coalesce(db121_estrutural, '00.00') as estrutural,";
    $sCamposMateriais .= "coalesce(db121_estruturavalorpai, 0) as conta_pai ";
    $sOrdemMateriais   = "db121_estrutural";

    $oMatEstoqueGrupo    = new cl_materialestoquegrupo();
    $sSqlMatEstoqueGrupo = $oMatEstoqueGrupo->sql_query_conta(null, $sCamposMateriais, $sOrdemMateriais);
    $rsMatEstoqueGrupo   = $oMatEstoqueGrupo->sql_record($sSqlMatEstoqueGrupo);


    $aGrupos           = db_utils::getCollectionByRecord($rsMatEstoqueGrupo, false, false, true);
    $oRetorno->aGrupos = $aGrupos;
    break;
}
echo $oJson->encode($oRetorno);
