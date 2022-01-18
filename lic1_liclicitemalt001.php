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
        'solicitem.*,
    (select pc16_codmater from solicitempcmater where pc16_solicitem = solicitem.pc11_codigo)
    ',
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
        // $nova_quantidade = floatval($oItemOrigem->pc11_quant) + floatval($oSolicitemReservado->pc11_quant);

        // print_r($oItemOrigem);
        // echo $nova_quantidade . ' ';
        // echo $oSolicitemReservado->pc11_quant;

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
        $oDaoSolicitemControle = db_utils::getDao('solicitem');
        if ($l20_usaregistropreco == "t") {

            $rsSolicitemControle = $oDaoSolicitemControle->sql_record("select distinct
                  abertura.pc55_solicitempai as vinculopai,
                  abertura.pc55_solicitemfilho as vinculofilho,
                  itemdaabertura.pc11_codigo as itemdaabertura,
                  itemdaestimativa.pc11_codigo as itemdaestimativa,
                  itemdaestimativa.pc11_numero as itemdaestimativanumero,
                  vinculo.pc55_solicitempai,
                  vinculo.pc55_solicitemfilho
                  from solicitem as compilacao
                  join solicita as compsolicita on compsolicita.pc10_numero=compilacao.pc11_numero
                  left join solicitemvinculo as vinculo on vinculo.pc55_solicitemfilho = compilacao.pc11_codigo
                  left join solicitem as itemdaestimativa on itemdaestimativa.pc11_codigo = vinculo.pc55_solicitempai
                  left join solicita as estisolicita on estisolicita.pc10_numero = itemdaestimativa.pc11_numero
                  left join solicitemvinculo as abertura on abertura.pc55_solicitemfilho=vinculo.pc55_solicitempai
                  left join solicitem as itemdaabertura on itemdaabertura.pc11_codigo = abertura.pc55_solicitempai
                  left join solicita as solabertura on solabertura.pc10_numero = itemdaabertura.pc11_numero
                  left join solicitemregistropreco on pc57_solicitem=compilacao.pc11_codigo
                  where
                  compilacao.pc11_codigo = $oSolicitemReservado->pc11_codigo");

            $oItemControle = db_utils::fieldsMemory($rsSolicitemControle, 0);
        }

        $rsSolicitemControle2 = $oDaoSolicitemControle->sql_record("select pc11_codigo,pc11_reservado,pc11_quant,
          pc16_codmater,pc11_seq
        from solicitem
        join solicitempcmater on pc16_solicitem = pc11_codigo
        where
          pc11_numero = $oSolicitemReservado->pc11_numero
          and pc16_codmater = $oSolicitemReservado->pc16_codmater order by pc11_reservado asc");

        $nova_quantidade2 = db_utils::fieldsMemory($rsSolicitemControle2, 0)->pc11_quant + db_utils::fieldsMemory($rsSolicitemControle2, 1)->pc11_quant;
        $codNReservado     = db_utils::fieldsMemory($rsSolicitemControle2, 0)->pc11_codigo;
        $codReservado     = db_utils::fieldsMemory($rsSolicitemControle2, 1)->pc11_codigo;



        if ($l20_usaregistropreco == 't') {

            $rsSolicitemControle3 = $oDaoSolicitemControle->sql_record("select pc11_codigo,pc11_reservado,pc11_quant,
      pc16_codmater,pc11_seq
    from solicitem
    join solicitempcmater on pc16_solicitem = pc11_codigo
    where
      pc11_numero = $oItemControle->itemdaestimativanumero
      and pc16_codmater = $oSolicitemReservado->pc16_codmater order by pc11_reservado asc");

            $nova_quantidade3 = db_utils::fieldsMemory($rsSolicitemControle3, 0)->pc11_quant + db_utils::fieldsMemory($rsSolicitemControle3, 1)->pc11_quant;
            $codNReservado2    = db_utils::fieldsMemory($rsSolicitemControle3, 0)->pc11_codigo;
            $codReservado2     = db_utils::fieldsMemory($rsSolicitemControle3, 1)->pc11_codigo;
        }

        if ($l20_usaregistropreco != 't') {

            $oDaoPcDotacOrigem = db_utils::getDao('pcdotac');
            //$oDaoPcDotacOrigem->pc13_quant = $nova_quantidade2;
            $rsDotacaoItemOrigem = db_query('SELECT pc13_sequencial from pcdotac where pc13_codigo = ' . $oItemOrigem->pc11_codigo);
            $oDotacaoItemOrigem = db_utils::fieldsMemory($rsDotacaoItemOrigem, 0);

            /**
             * Altera a quantidade da dotação do item origem
             */
            $oDaoPcDotacOrigem->pc13_sequencial = $oDotacaoItemOrigem->pc13_sequencial;
            $oDaoPcDotacOrigem->pc13_quant = $nova_quantidade2;
            $oDaoPcDotacOrigem->alterar($oDotacaoItemOrigem->pc13_sequencial);

            if ($oDaoPcDotacOrigem->erro_status == '0') {
                $erro_msg = $oDaoPcDotacOrigem->erro_msg;
                $sqlerro = true;
            }
        }

        if (!$sqlerro && $l20_usaregistropreco == "t") {

            /**
             * Altera a quantidade do item origem na solicitemunid
             */
            $oDaoSolicitemUnidOrigem = db_utils::getDao('solicitemunid');
            $oDaoSolicitemUnidOrigem->pc17_quant = $nova_quantidade2;
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
                $sSqlSolicitemRegPreco = "select pc57_sequencial from solicitemregistropreco where pc57_solicitem = $codNReservado";
                $rsSolicitemRegPreco = $oDaoSolicitemRegPreco->sql_record($sSqlSolicitemRegPreco);

                $oSolicitemRegPreco = db_utils::fieldsMemory($rsSolicitemRegPreco, 0);
                $oDaoSolicitemRegPreco = db_utils::getDao('solicitemregistropreco');
                $oDaoSolicitemRegPreco->pc57_quantmax = $nova_quantidade2;
                $oDaoSolicitemRegPreco->pc57_sequencial = $oSolicitemRegPreco->pc57_sequencial;
                $oDaoSolicitemRegPreco->alterar($oSolicitemRegPreco->pc57_sequencial);

                $oDaoSolicitemRegPreco = db_utils::getDao('solicitemregistropreco');
                $oDaoSolicitemRegPreco->excluir('', "pc57_solicitem = $oSolicitemReservado->pc11_codigo");
                //estimativa
                $oDaoSolicitemRegPreco = db_utils::getDao('solicitemregistropreco');
                $sSqlSolicitemRegPreco = "select pc57_sequencial from solicitemregistropreco where pc57_solicitem = $codNReservado2";
                $rsSolicitemRegPreco = $oDaoSolicitemRegPreco->sql_record($sSqlSolicitemRegPreco);

                $oSolicitemRegPreco = db_utils::fieldsMemory($rsSolicitemRegPreco, 0);
                $oDaoSolicitemRegPreco = db_utils::getDao('solicitemregistropreco');
                $oDaoSolicitemRegPreco->pc57_quantmax = $nova_quantidade3;
                $oDaoSolicitemRegPreco->pc57_sequencial = $oSolicitemRegPreco->pc57_sequencial;
                $oDaoSolicitemRegPreco->alterar($oSolicitemRegPreco->pc57_sequencial);

                $oDaoSolicitemRegPreco = db_utils::getDao('solicitemregistropreco');
                $oDaoSolicitemRegPreco->excluir('', "pc57_solicitem = $oItemControle->itemdaestimativa");
                //abertura
                $oDaoSolicitemRegPreco = db_utils::getDao('solicitemregistropreco');
                $oDaoSolicitemRegPreco->excluir('', "pc57_solicitem = $oItemControle->itemdaabertura");
            }
        }

        if (!$sqlerro) {
            $oDaoSolicitemEle = db_utils::getDao('solicitemele');
            $oDaoSolicitemEle->excluir($oSolicitemReservado->pc11_codigo);
            $sqlerro = $oDaoSolicitemEle->erro_status == '0' ? true : false;
        }

        if (!$sqlerro) {
            $oDaoSolicitemPcMater = db_utils::getDao('solicitempcmater');
            $oDaoSolicitemPcMater->excluir($oSolicitemReservado->pc16_codmater, $codReservado);
            $sqlerro = $oDaoSolicitemPcMater->erro_status == '0' ? true : false;
        }

        if ($l20_usaregistropreco == 't') {
            //estimativa
            if (!$sqlerro) {
                $oDaoSolicitemPcMater = db_utils::getDao('solicitempcmater');
                $oDaoSolicitemPcMater->excluir($oSolicitemReservado->pc16_codmater, $oItemControle->itemdaestimativa);
                $sqlerro = $oDaoSolicitemPcMater->erro_status == '0' ? true : false;
            }
            //abertura
            if (!$sqlerro) {
                $oDaoSolicitemPcMater = db_utils::getDao('solicitempcmater');
                $oDaoSolicitemPcMater->excluir($oSolicitemReservado->pc16_codmater, $oItemControle->itemdaabertura);
                $sqlerro = $oDaoSolicitemPcMater->erro_status == '0' ? true : false;
            }
        }

        if (!$sqlerro) {
            $oDaoSolicitemUnid = db_utils::getDao('solicitemunid');
            $oDaoSolicitemUnid->excluir($oSolicitemReservado->pc11_codigo);
            $sqlerro = $oDaoSolicitemUnid->erro_status == '0' ? true : false;
        }

        if ($l20_usaregistropreco == 't') {
            //estimativa
            if (!$sqlerro) {
                $oDaoSolicitemUnid = db_utils::getDao('solicitemunid');
                $oDaoSolicitemUnid->excluir($oItemControle->itemdaestimativa);
                $sqlerro = $oDaoSolicitemUnid->erro_status == '0' ? true : false;
            }
            //abertura
            if (!$sqlerro) {
                $oDaoSolicitemUnid = db_utils::getDao('solicitemunid');
                $oDaoSolicitemUnid->excluir($oItemControle->itemdaabertura);
                $sqlerro = $oDaoSolicitemUnid->erro_status == '0' ? true : false;
            }
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
        if ($l20_usaregistropreco == 't') {

            if (!$sqlerro) {
                $oDaoVinculo = db_utils::getDao('solicitemvinculo');
                $oDaoVinculo->excluir(null, "pc55_solicitempai = $oItemControle->itemdaestimativa and pc55_solicitemfilho = $oSolicitemReservado->pc11_codigo");
                $sqlerro = $oDaoVinculo->erro_status == '0' ? true : false;
            }

            //estimativa
            if (!$sqlerro) {
                $oDaoVinculo = db_utils::getDao('solicitemvinculo');
                $oDaoVinculo->excluir(null, "pc55_solicitempai = $oItemControle->itemdaabertura and pc55_solicitemfilho = $oItemControle->itemdaestimativa");
                $sqlerro = $oDaoVinculo->erro_status == '0' ? true : false;
            }
            //abertura
            // if (!$sqlerro) {
            //   $oDaoVinculo = db_utils::getDao('solicitemvinculo');
            //   $oDaoVinculo->excluir(null, "pc55_solicitemfilho = $oItemControle->itemdaabertura");
            //   $sqlerro = $oDaoVinculo->erro_status == '0' ? true : false;
            // }
        }

        if (!$sqlerro) {
            //compilação
            $oDaoReservado = db_utils::getDao('solicitem');
            $oDaoReservado->pc11_quant = $nova_quantidade2;
            $oDaoReservado->pc11_codigo = $codNReservado;
            $oDaoReservado->alterar($codNReservado);

            if (!$oDaoReservado->numrows_alterar) {
                $erro_msg = $oDaoReservado->erro_msg;
                $sqlerro = true;
                break;
            }

            $oDaoReservado = db_utils::getDao('solicitem');
            $oDaoReservado->excluir($oSolicitemReservado->pc11_codigo);
            $sqlerro = $oDaoReservado->erro_status == '0' ? true : false;

            if ($l20_usaregistropreco == "t") {
                //estimativa

                $oDaoReservado = db_utils::getDao('solicitem');
                $oDaoReservado->pc11_quant = $nova_quantidade3;
                $oDaoReservado->pc11_codigo = $codNReservado2;
                $oDaoReservado->alterar($codNReservado2);

                if (!$oDaoReservado->numrows_alterar) {
                    $erro_msg = $oDaoReservado->erro_msg;
                    $sqlerro = true;
                    break;
                }

                $oDaoReservado = db_utils::getDao('solicitem');
                $oDaoReservado->excluir($codReservado2);
                $sqlerro = $oDaoReservado->erro_status == '0' ? true : false;

                //abertura
                $oDaoReservado = db_utils::getDao('solicitem');
                $oDaoReservado->excluir($oItemControle->itemdaabertura);
                $sqlerro = $oDaoReservado->erro_status == '0' ? true : false;
            }
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