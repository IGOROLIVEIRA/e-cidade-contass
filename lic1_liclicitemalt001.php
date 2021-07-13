<?
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
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_liclicitemlote_classe.php");
require_once("classes/db_pcproc_classe.php");
require_once("classes/db_pcprocitem_classe.php");
require_once("classes/db_pcorcamitemproc_classe.php");
require_once("classes/db_itensregpreco_classe.php");
require_once("classes/db_adesaoregprecos_classe.php");
require_once("classes/db_solicitem_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clliclicita  = new cl_liclicita;
$clliclicitem = new cl_liclicitem;
$clliclicitemlote = new cl_liclicitemlote;
$clpcproc = new cl_pcproc;
$clpcprocitem = new cl_pcprocitem;
$clpcorcamitemproc = new cl_pcorcamitemproc;
$clitensregpreco = new cl_itensregpreco;
$cladesaoregprecos = new cl_adesaoregprecos;
$clsolicitem = new cl_solicitem;

$sqlerro = false;
$erro_msg = '';

if (isset($codprocesso) && $codprocesso != '') {

  $sSqlLicita = $clliclicita->sql_query_pco($licitacao, ' DISTINCT liclicita.* ');
  $rsLicita = $clliclicita->sql_record($sSqlLicita);
  $oLicitacao = db_utils::fieldsMemory($rsLicita, 0);

  if ($oLicitacao->l20_cadinicial != 1 && pg_num_rows($rsLicita)) {
    $sqlerro = true;
  }

  $sSqlFornec = $clliclicita->sql_query(
    $licitacao,
    " DISTINCT pcorcamforne.* ",
    '',
    " l20_codigo = $licitacao and pc21_orcamforne IS NOT NULL "
  );
  $rsFornec = $clliclicita->sql_record($sSqlFornec);

  if (pg_num_rows($rsFornec)) {
    $sqlerro = true;
  }
}

if (!$sqlerro && $codprocesso) {

  $oDaoPcorcamitemlic = db_utils::getDao('pcorcamitemlic');
  $sSqlOrcamItem = $oDaoPcorcamitemlic->sql_query(null, '*', null, 'pc81_codproc = ' . $codprocesso);
  $rsOrcamItem = $oDaoPcorcamitemlic->sql_record($sSqlOrcamItem);

  if (pg_numrows($rsOrcamItem)) {
    $sqlerro = true;
    $erro_msg = 'Processo de Compra ' . $codprocesso . ' não excluído. Existe fornecedor lançado para a licitação.';
  }

  $sSqlSolicitem = $clsolicitem->sql_query_item_licitacao(
    '',
    'solicitem.*',
    '',
    "pc81_codproc = " . $codprocesso . " and pc11_reservado = 't'"
  );
  $rsSolicitem = db_query($sSqlSolicitem);

  for ($count = 0; $count < pg_numrows($rsSolicitem); $count++) {

    $oSolicitemReservado = db_utils::fieldsMemory($rsSolicitem, $count);

    $oDaoItemOrigem = db_utils::getDao('solicitem');

    $iSeqOrigem = intval($oSolicitemReservado->pc11_seq) - 1;
    $sWhereItem = 'pc11_seq = ' . $iSeqOrigem . ' and pc11_numero = ' . $oSolicitemReservado->pc11_numero;
    $sSqlOrigem = $oDaoItemOrigem->sql_query_file(null, '*', 'pc11_codigo asc limit 1', $sWhereItem);
    $rsOrigem = $oDaoItemOrigem->sql_record($sSqlOrigem);

    db_inicio_transacao();

    $oItemOrigem = db_utils::fieldsMemory($rsOrigem, 0);
    $nova_quantidade = floatval($oItemOrigem->pc11_quant) + floatval($oSolicitemReservado->pc11_quant);
    //echo $sSqlOrigem;
    //echo $sSqlSolicitem;
    //echo $codprocesso;
    // echo $nova_quantidade;
    // exit;
    $result = $clliclicita->sql_record($clliclicita->sql_query($licitacao, "l08_altera, l20_usaregistropreco, l20_nroedital, l20_naturezaobjeto"));
    if ($clliclicita->numrows > 0) {
      db_fieldsmemory($result, 0);

      if ($l08_altera == "t") {
        $db_botao = true;
      }
      if ($l20_usaregistropreco == "t") {
        $lRegistroPreco = true;
      }
    }

    if ($l20_usaregistropreco != 't') {

      $oDaoPcDotacOrigem = db_utils::getDao('pcdotac');
      $oDaoPcDotacOrigem->pc13_quant = $nova_quantidade;
      $rsDotacaoItemOrigem = db_query('SELECT pc13_sequencial from pcdotac where pc13_codigo = ' . $oItemOrigem->pc11_codigo);
      $oDotacaoItemOrigem = db_utils::fieldsMemory($rsDotacaoItemOrigem, 0);

      /**
       * Altera a quantidade da dotação do item origem
       */
      $oDaoPcDotacOrigem->pc13_sequencial = $oDotacaoItemOrigem->pc13_sequencial;
      $oDaoPcDotacOrigem->pc13_quant = $nova_quantidade;
      $oDaoPcDotacOrigem->alterar($oDotacaoItemOrigem->pc13_sequencial);

      if ($oDaoPcDotacOrigem->erro_status == '0') {
        $erro_msg = $oDaoPcDotacOrigem->erro_msg;
        $sqlerro = true;
      }
    }

    if (!$sqlerro) {

      /**
       * Altera a quantidade do item origem na solicitemunid
       */
      $oDaoSolicitemUnidOrigem = db_utils::getDao('solicitemunid');
      $oDaoSolicitemUnidOrigem->pc17_quant = $nova_quantidade;
      $oDaoSolicitemUnidOrigem->pc17_codigo = $oItemOrigem->pc11_codigo;
      $oDaoSolicitemUnidOrigem->alterar($oItemOrigem->pc11_codigo);

      if ($oDaoSolicitemUnidOrigem->erro_status == '0') {
        $erro_msg = $oDaoSolicitemUnidOrigem->erro_msg;
        $sqlerro = true;
      }
    }

    /**
     * Remove os registros que o item com o valor reservado possui em outras tabelas
     */

    if (!$sqlerro) {


      if ($l20_usaregistropreco != 't') {

        /**
         * Lançar erros caso não exclua nas tabelas abaixo
         */

        $oDaoDotac = db_utils::getDao('pcdotac');
        $rsDotacaoReservado = db_query('SELECT pc13_sequencial from pcdotac where pc13_codigo = ' . $oSolicitemReservado->pc11_codigo);
        $oItemReservado = db_utils::fieldsMemory($rsDotacaoReservado, 0);
        $oDaoDotac->excluir($oItemReservado->pc13_sequencial);
        $sqlerro = $oDaoDotac->erro_status == '0' ? true : false;
      }

      if ($l20_usaregistropreco == 't') {

        $oDaoSolicitemRegPreco = db_utils::getDao('solicitemregistropreco');
        $oDaoSolicitemRegPreco->excluir('', "pc57_solicitem = $oSolicitemReservado->pc11_codigo");

        $sSqlSolicitemRegPreco = "select * from solicitemregistropreco left join solicitem on pc11_codigo = pc57_solicitem where pc11_numero = $oItemOrigem->pc11_numero and pc11_reservado = true";
        $rsSolicitemRegPreco = $oDaoSolicitemRegPreco->sql_record($sSqlSolicitemRegPreco);

        $sSqlSolicitemRegPreco = "select pc57_sequencial from solicitemregistropreco where pc57_solicitem = $oItemOrigem->pc11_codigo";
        $rsSolicitemRegPreco = $oDaoSolicitemRegPreco->sql_record($sSqlSolicitemRegPreco);

        $oSolicitemRegPreco = db_utils::fieldsMemory($rsSolicitemRegPreco, 0);

        $oDaoSolicitemRegPreco->pc57_quantmax = $nova_quantidade;
        $oDaoSolicitemRegPreco->pc57_sequencial = $oSolicitemRegPreco->pc57_sequencial;
        $oDaoSolicitemRegPreco->alterar($oSolicitemRegPreco->pc57_sequencial);
      }
    }

    if (!$sqlerro) {
      $oDaoSolicitemEle = db_utils::getDao('solicitemele');
      $oDaoSolicitemEle->excluir($oSolicitemReservado->pc11_codigo);
      $sqlerro = $oDaoSolicitemEle->erro_status == '0' ? true : false;
    }

    if (!$sqlerro) {
      $oDaoSolicitemPcMater = db_utils::getDao('solicitempcmater');
      $oDaoSolicitemPcMater->excluir('', $oSolicitemReservado->pc11_codigo);
      $sqlerro = $oDaoSolicitemPcMater->erro_status == '0' ? true : false;
    }

    if (!$sqlerro) {
      $oDaoSolicitemUnid = db_utils::getDao('solicitemunid');
      $oDaoSolicitemUnid->excluir($oSolicitemReservado->pc11_codigo);
      $sqlerro = $oDaoSolicitemUnid->erro_status == '0' ? true : false;
    }

    if (!$sqlerro) {
      $clliclicitemlote->excluir('', ' l04_liclicitem in (select l21_codigo from liclicitem
                where l21_codpcprocitem in (select pc81_codprocitem from pcprocitem where pc81_codproc = ' . $codprocesso . '))');

      if ($clliclicitemlote->erro_status == '0') {
        $sqlerro = true;
        $erro_msg = $clpcprocitem->erro_msg;
      }
    }

    if (!$sqlerro) {
      $clliclicitem->excluir(
        '',
        'l21_codpcprocitem in (select pc81_codprocitem from pcprocitem where pc81_codproc = ' . $codprocesso . ')'
      );

      if ($clliclicitem->erro_status == '0') {
        $sqlerro = true;
        $erro_msg = $clliclicitem->erro_msg;
      }
    }

    if (!$sqlerro) {
      $oDaoPcProcItem = db_utils::getDao('pcprocitem');
      $oDaoPcProcItem->excluir('', 'pc81_solicitem = ' . $oSolicitemReservado->pc11_codigo);
      $sqlerro = $oDaoPcProcItem->erro_status == '0' ? true : false;
    }

    if (!$sqlerro) {
      $oDaoVinculo = db_utils::getDao('solicitemvinculo');
      $oDaoVinculo->excluir(null, "pc55_solicitemfilho = $oSolicitemReservado->pc11_codigo");
      $sqlerro = $oDaoVinculo->erro_status == '0' ? true : false;
    }

    if (!$sqlerro) {
      $oDaoReservado = db_utils::getDao('solicitem');
      $oDaoReservado->excluir($oSolicitemReservado->pc11_codigo);
      $sqlerro = $oDaoReservado->erro_status == '0' ? true : false;
    }


    /**
     * Atualiza o item origem com o valor retornado do item que continha o valor reservado
     */
    $oDaoItemOrigem->pc11_quant = $nova_quantidade;
    $oDaoItemOrigem->alterar($oItemOrigem->pc11_codigo);

    if ($oDaoItemOrigem->erro_status == '0') {
      $sqlerro = true;
      $erro_msg = $oDaoItemOrigem->erro_msg;
    }

    db_fim_transacao($sqlerro);
  }

  if (!pg_numrows($rsSolicitem)) {

    if (!$sqlerro) {
      $clliclicitemlote->excluir('', ' l04_liclicitem in (select l21_codigo from liclicitem
                where l21_codpcprocitem in (select pc81_codprocitem from pcprocitem where pc81_codproc = ' . $codprocesso . '))');

      if ($clliclicitemlote->erro_status == '0') {
        $sqlerro = true;
        $erro_msg = $clpcprocitem->erro_msg;
      }
    }

    if (!$sqlerro) {
      $clliclicitem->excluir(
        '',
        'l21_codpcprocitem in (select pc81_codprocitem from pcprocitem where pc81_codproc = ' . $codprocesso . ')'
      );

      if ($clliclicitem->erro_status == '0') {
        $sqlerro = true;
        $erro_msg = $clliclicitem->erro_msg;
      }
    }

    if (!$sqlerro) {
      $clitensregpreco->excluir(
        '',
        'si07_sequencialadesao = (select si06_sequencial from adesaoregprecos where si06_processocompra = ' . $codprocesso . ')'
      );

      if ($clitensregpreco->erro_status = '0') {
        $sqlerro = true;
        $erro_msg = $clitensregpreco->erro_msg;
      }
    }
  }
}

if ($codprocesso) {
  if ($sqlerro) {
    if (!$erro_msg) {
      echo "<script>alert('Processo de Compra $codprocesso não pode ser excluído.');</script>";
    } else {
      echo "<script>alert('$erro_msg');</script>";
    }
  } else {
    echo "<script>alert('Processo de Compra $codprocesso excluído com sucesso!');</script>";
  }
}


$db_opcao = 1;
$db_botao = true;
$lRegistroPreco = false;
if (isset($licitacao) && trim($licitacao) != "" && !$sqlerro) {
  $result = $clliclicita->sql_record($clliclicita->sql_query($licitacao, "l08_altera, l20_usaregistropreco, l20_nroedital, l20_naturezaobjeto"));
  if ($clliclicita->numrows > 0) {
    db_fieldsmemory($result, 0);

    if ($l08_altera == "t") {
      $db_botao = true;
    }
    if ($l20_usaregistropreco == "t") {
      $lRegistroPreco = true;
    }
  }
}
$db_botao = true;
?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <table width="790" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="360" height="18">&nbsp;</td>
      <td width="263">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>
  <table width="790" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;">
    <tr>
      <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
        <center>
          <?
          include("forms/db_frmliclicitemalt.php");
          ?>
        </center>
      </td>
    </tr>
  </table>
</body>

</html>
