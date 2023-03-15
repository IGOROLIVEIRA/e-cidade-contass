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

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");

$oJson               = new services_json();
$oParam              = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno            = new stdClass();
$oRetorno->iStatus   = 1;
$oRetorno->sMensagem = '';
try {

  /*
   * Início Transação
   */
  db_inicio_transacao();

  switch ($oParam->exec) {

    case "salvarItens":
      //ini_set("display_errors", "on");
      $pc96_descricao = $oParam->descricaoImportacao;
      $rs_pc96_sequencial = db_query("select nextval('importacaoitens_pc96_sequencial_seq')");
      $pc96_sequencial = pg_result($rs_pc96_sequencial, 0, 0);

      $pc01_data = explode("/", $oParam->data);
      $pc01_data = $pc01_data[2] . "-" . $pc01_data[1] . "-" . $pc01_data[0];

      db_inicio_transacao();
      $sqlerro = false;
      foreach ($oParam->aItens as $oItem) {


        $clpcmater = new cl_pcmater;
        $clpcmaterele = new cl_pcmaterele;

        $GLOBALS["HTTP_POST_VARS"]["pc01_conversao"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_id_usuario"] = '0';
        $GLOBALS["HTTP_POST_VARS"]["pc01_libaut"] = 't';
        $GLOBALS["HTTP_POST_VARS"]["pc01_veiculo"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_veiculo"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_fraciona"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_validademinima"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_obrigatorio"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_liberaresumo"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_obras"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_taxa"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_tabela"] = 'f';
        $GLOBALS["HTTP_POST_VARS"]["pc01_ativo"] = 'f';



        $clpcmater->pc01_descrmater = utf8_decode($oItem->descricao);
        $clpcmater->pc01_complmater = utf8_decode($oItem->complemento);
        $clpcmater->pc01_data = $pc01_data;
        $clpcmater->pc01_servico   = $oItem->servico == "Sim" ? "true" : "false";
        $clpcmater->pc01_codsubgrupo = $oItem->codsubgrupo;
        $clpcmater->pc01_obras = $oItem->obra == "Sim" ? "true" : "false";
        $clpcmater->pc01_taxa   = $oItem->taxa == "Sim" ? "true" : "false";
        $clpcmater->pc01_tabela = $oItem->tabela == "Sim" ? "true" : "false";
        $clpcmater->pc01_ativo =  'f';
        $clpcmater->pc01_conversao = 'f';
        $clpcmater->pc01_id_usuario =  db_getsession("DB_id_usuario");
        $clpcmater->pc01_libaut = "true";
        $clpcmater->pc01_veiculo = 'f';
        $clpcmater->pc01_fraciona = 'f';
        $clpcmater->pc01_validademinima = 'f';
        $clpcmater->pc01_obrigatorio = 'f';
        $clpcmater->pc01_liberaresumo = 'f';

        $clpcmater->incluir(null);

        if ($clpcmater->erro_status == "0") {
          throw new Exception($clpcmater->erro_msg);
        }

        $clpcmaterele->pc07_codmater = $clpcmater->pc01_codmater;
        $clpcmaterele->pc07_codele = $oItem->codele;
        $clpcmaterele->incluir($clpcmater->pc01_codmater, $oItem->codele);

        if ($clpcmaterele->erro_status == "0") {
          throw new Exception($clpcmaterele->erro_msg);
        }
        $codigoitens .= $clpcmater->pc01_codmater . ",";

        db_query("INSERT INTO importacaoitens values ($pc96_sequencial,'$pc96_descricao',$clpcmater->pc01_codmater)");
      }

      $codigoitens = substr($codigoitens, 0, -1);
      $oRetorno->codigoitens = $codigoitens;
      $oRetorno->pc96_sequencial = $pc96_sequencial;

      db_fim_transacao($sqlerro);
      break;
  }
} catch (Exception $eErro) {

  db_fim_transacao(true);
  $oRetorno->iStatus   = 2;
  $oRetorno->sMensagem = urlencode($eErro->getMessage());
}

echo $oJson->encode($oRetorno);
