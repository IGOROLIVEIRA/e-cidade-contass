<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_liclicitem_classe.php");
include("classes/db_liclicita_classe.php");
include("classes/db_liclicitaproc_classe.php");
include("classes/db_liclicitaweb_classe.php");
include("classes/db_db_usuarios_classe.php");
include("classes/db_pcorcamitemlic_classe.php");
include("classes/db_liclicitemlote_classe.php");
include("classes/db_liclicitemanu_classe.php");
include("classes/db_liclicitasituacao_classe.php");
include("classes/db_liclancedital_classe.php");
include("classes/db_editaldocumento_classe.php");
include("classes/db_obrasdadoscomplementares_classe.php");
include("classes/db_obrascodigos_classe.php");
include("classes/db_cflicita_classe.php");
include("classes/db_liccomissaocgm_classe.php");
include("classes/db_licobras_classe.php");
include("classes/db_credenciamentosaldo_classe.php");
include("classes/db_credenciamento_classe.php");
require_once("classes/db_situacaoitemcompra_classe.php");
require_once("classes/db_situacaoitemlic_classe.php");
require_once("classes/db_condataconf_classe.php");
require_once("classes/db_pccflicitapar_classe.php");
require_once("classes/db_pccflicitanum_classe.php");
require_once("classes/db_licanexopncp_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clliclicita         = new cl_liclicita;
$clliclicitem        = new cl_liclicitem;
$cldb_usuarios       = new cl_db_usuarios;
$clpcorcamitemlic    = new cl_pcorcamitemlic;
$clliclicitemlote    = new cl_liclicitemlote;
$clliclicitemanu     = new cl_liclicitemanu;
$clliclicitaweb      = new cl_liclicitaweb;
$clliclicitasituacao = new cl_liclicitasituacao;
$clcflicita          = new cl_cflicita;
$clliclicitaproc     = new cl_liclicitaproc;
$clliccomissaocgm    = new cl_liccomissaocgm;
$clliclancedital     = new cl_liclancedital;
$cleditaldocumentos  = new cl_editaldocumento;
$clobrasdadoscompl   = new cl_obrasdadoscomplementares;
$clobrascodigos      = new cl_obrascodigos;
$cllicobras          = new cl_licobras;
$clcredenciamento    = new cl_credenciamento();
$clcredenciamentosaldo = new cl_credenciamentosaldo();
$clpccflicitapar     = new cl_pccflicitapar();
$clpccflicitanum     = new cl_pccflicitanum();
$clsituacaoitemcompra= new cl_situacaoitemcompra();
$clsituacaoitemlic   = new cl_situacaoitemlic();
$cllicanexopncp = new cl_licanexopncp();
$erro_msg = '';
$db_botao = false;
$db_opcao = 33;
$instit     = db_getsession("DB_instit");
$anousu     = db_getsession("DB_anousu");
if (isset($excluir)) {
    $sqlerro = false;
    $db_opcao = 3;

    db_inicio_transacao();

    $sSql = $clliclicita->sql_query_file($l20_codigo, 'l20_cadinicial, l20_anousu');
    $rsSql = $clliclicita->sql_record($sSql);
    $oLicitacao = db_utils::fieldsMemory($rsSql, 0);
    $status = $oLicitacao->l20_cadinicial;
    $anousu = $oLicitacao->l20_anousu;
    /*
     * Apenas as licitações com o l20_cadinicial = 1 (PENDENTES) serão excluídas...
     * */
    $sqlerro = $status == 1 || !$status ? false : true;
    $erro_msg = $sqlerro ? 'Licitação possui Edital lançado.' : '';

    $oParamNumManual = db_query("select * from licitaparam;");
    $oParamNumManual = db_utils::fieldsmemory($oParamNumManual, 0);
    $l12_numeracaomanual = $oParamNumManual->l12_numeracaomanual;

    if ($l12_numeracaomanual == 't') {

        $numeracao_l20_edital = db_query("select * from pccflicitanum where l24_anousu = $anousu and l24_instit = $instit and l24_numero = $l20_edital;");
        if (pg_numrows($numeracao_l20_edital) > 0) {
            $l24_numero = $l20_edital - 1;
            db_query("UPDATE pccflicitanum SET l24_numero = $l24_numero WHERE l24_anousu = $anousu and l24_instit = $instit and l24_numero = $l20_edital;");
        }

        $numeracao_l20_numero = db_query("select * from pccflicitapar where l25_anousu = $anousu and l25_numero = $l20_numero and l25_codcflicita = $l20_codtipocom;");
        if (pg_numrows($numeracao_l20_numero) > 0) {
            $l25_numero = $l20_numero - 1;
            db_query("UPDATE pccflicitapar SET l25_numero = $l25_numero WHERE l25_anousu = $anousu and l25_numero = $l20_numero and l25_codcflicita = $l20_codtipocom;");
        }
        if ($l20_nroedital != null) {
            $numeracao_l20_nroedital = db_query("select * from pccfeditalnum where l47_anousu = $anousu and l47_instit = $instit and l47_numero = $l20_nroedital;");
            if (pg_numrows($numeracao_l20_nroedital) > 0) {
                db_query("DELETE FROM pccfeditalnum WHERE l47_numero = $l20_nroedital;");
            }
        }
    }

    if (!$sqlerro) {
        $sqlAnexos = $cleditaldocumentos->sql_query('', 'l48_arquivo', '', 'l48_liclicita = ' . $l20_codigo);
        $rsAnexos = $cleditaldocumentos->sql_record($sqlAnexos);

        if ($cleditaldocumentos->numrows) {
            $cleditaldocumentos->excluir('', 'l48_liclicita = ' . $l20_codigo);
            if ($cleditaldocumentos->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $cleditaldocumentos->erro_msg;
            }
        }
    }

    //verifica se existe anexos na licitacao

    $sSqlBusca   = $cllicanexopncp->sql_query_file(null,"l215_sequencial",null,"l215_liclicita = $l20_codigo");
    $rsAnexos = $cllicanexopncp->sql_record($sSqlBusca);

    if(pg_num_rows($rsAnexos) > 0){
        $cllicanexopncp->excluir(null,"l215_liclicita = $l20_codigo");
    }

    if (!$sqlerro) {
        $sqlCodigo = $clobrascodigos->sql_query('', 'db151_codigoobra', '', 'db151_liclicita = ' . $l20_codigo);
        $rsCodigo = $clobrascodigos->sql_record($sqlCodigo);
        $codigoObra = db_utils::fieldsMemory($rsCodigo, 0)->db151_codigoobra;

        if ($clobrascodigos->numrows) {
            $clobrasdadoscompl->excluir('', 'db150_codobra = ' . $codigoObra);
            if ($clobrasdadoscompl->erro_status == 0) {
                $sqlerro  = true;
                $erro_msg = $clobrasdadoscompl->erro_msg;
            }

            $clobrascodigos->excluir($codigoObra);
            if ($clobrascodigos->erro_status == 0) {
                $sqlerro  = true;
                $erro_msg = $clobrascodigos->erro_msg;
            }
        }

        if (!$sqlerro) {
            $sqledital = $clliclancedital->sql_query(null, "*", null, 'l47_liclicita = ' . $l20_codigo);
            $rsedital = $clliclancedital->sql_record($sqledital);

            if ($clliclancedital->numrows) {
                $clliclancedital->excluir('', 'l47_liclicita = ' . $l20_codigo);
                if ($clliclancedital->erro_status == 0) {
                    $sqlerro  = true;
                    $erro_msg = $clliclancedital->erro_msg;
                }
            }
        }
    }


    $clliclicitaweb->sql_record($clliclicitaweb->sql_query_file(null, "*", null, "l29_liclicita=$l20_codigo"));
    if ($clliclicitaweb->numrows > 0) {

        $sqlerro  = true;
        $erro_msg = "Licitação já publicada ou baixada.\\n Não pode ser Excluida";
    }
    if ($sqlerro == false) {
        $sqlSituacao = $clliclicitasituacao->sql_query(null, "*", null, "l11_liclicita = $l20_codigo");
        $rsSituacao = $clliclicitasituacao->sql_record($sqlSituacao);

        if ($clliclicitasituacao->numrows) {
            $clliclicitasituacao->excluir(null, "l11_liclicita = $l20_codigo");
            if ($clliclicitasituacao->erro_status == 0) {
                $sqlerro  = true;
                $erro_msg = $clliclicitasituacao->erro_msg;
            }
        }
    }

    if ($sqlerro == false) {
        $clliccomissaocgm->excluir(null, "l31_licitacao=$l20_codigo");
        if ($clliccomissaocgm->erro_status == 0) {
            $sqlerro = true;
            $erro_msg = $clliccomissaocgm->erro_msg;
        }
    }

    if($sqlerro == false){
        $sqlItensCompra = $clsituacaoitemcompra->sql_query(null,"l218_codigo",null,"l218_codigolicitacao=$l20_codigo");
        $rsItensCompra = $clsituacaoitemcompra->sql_record($sqlItensCompra);

        if(pg_num_rows($rsItensCompra) > 0){
            for ($item = 0; $item < pg_num_rows($rsItensCompra); $item++) {
                db_fieldsmemory($rsItensCompra, $item);
                $clsituacaoitemlic->excluir(null,"l219_codigo = $l218_codigo");
            }
        }
    }

    if($sqlerro == false) {
        $clsituacaoitemcompra->excluir(null,"l218_codigolicitacao=$l20_codigo");
        if ($clsituacaoitemcompra->erro_status == 0) {
            $sqlerro = true;
            $erro_msg = $clsituacaoitemcompra->erro_msg;
        }
    }

    if ($sqlerro == false) {

        $sqlCredSaldo = $clcredenciamentosaldo->sql_query_file(null, "*", null, 'l213_licitacao = ' . $l20_codigo);
        $rsCredSaldo = $clcredenciamentosaldo->sql_record($sqlCredSaldo);

        if ($clcredenciamentosaldo->numrows) {
            $clcredenciamentosaldo->excluir(null, 'l213_licitacao = ' . $l20_codigo);
            if ($clcredenciamentosaldo->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clcredenciamentosaldo->erro_msg;
            }
        }

        $sqlCred = $clcredenciamento->sql_query_file(null, "*", null, 'l205_licitacao = ' . $l20_codigo);
        $rsCred = $clcredenciamento->sql_record($sqlCred);

        if ($clcredenciamento->numrows) {
            $clcredenciamento->excluir_cred_licitacao($l20_codigo);
            if ($clcredenciamento->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clcredenciamento->erro_msg;
            }
        }
    }

    $result_item = $clliclicitem->sql_record($clliclicitem->sql_query_file(null, "l21_codigo", null, "l21_codliclicita=$l20_codigo"));
    $numrows_item = $clliclicitem->numrows;
    for ($w = 0; $w < $numrows_item; $w++) {
        db_fieldsmemory($result_item, $w);

        if ($sqlerro == false) {
            $clpcorcamitemlic->excluir(null, "pc26_liclicitem=$l21_codigo");
            if ($clpcorcamitemlic->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clpcorcamitemlic->erro_msg;
                break;
            }
        }

        if ($sqlerro == false) {
            $clliclicitemlote->excluir(null, "l04_liclicitem = $l21_codigo");
            if ($clliclicitemlote->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clliclicitemlote->erro_msg;
                break;
            }
        }

        if ($sqlerro == false) {
            $clliclicitemanu->excluir(null, "l07_liclicitem = $l21_codigo");
            if ($clliclicitemanu->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clliclicitemanu->erro_msg;
                break;
            }
        }
    }

    if ($sqlerro == false) {
        if ($numrows_item) {
            $clliclicitem->excluir(null, "l21_codliclicita=$l20_codigo");
            if ($clliclicitem->erro_status == 0) {
                $sqlerro = true;
                $erro_msg = $clliclicitem->erro_msg;
            }
        }
    }

    if ($sqlerro == false) {
        $clliclicitaproc->excluir("", " l34_liclicita = $l20_codigo");
        $erro_msg = $clliclicitaproc->erro_msg;
        if ($clliclicitaproc->erro_status == 0) {
            $sqlerro = true;
        }
    }

    if (!empty($l20_dtpubratificacao)) {
        $clcondataconf = new cl_condataconf;
        if (!$clcondataconf->verificaPeriodoPatrimonial($l20_dtpubratificacao)) {
            $erro_msg = $clcondataconf->erro_msg;
            $sqlerro  = true;
        }
    }

    try {

        $rsLicobras = $cllicobras->sql_record($cllicobras->sql_query(null, "*", null, "obr01_licitacao = $l20_codigo"));
        if (pg_num_rows($rsLicobras) > 0) {
            throw new Exception("Licitação vinculada a uma obra!");
            $sqlerro  = true;
        }
    } catch (Exception $eErro) {
        db_msgbox($eErro->getMessage());
    }


    if ($sqlerro == false) {
        db_query("delete from manutencaolicitacao where manutlic_licitacao = $l20_codigo");
        $clliclicita->excluir($l20_codigo);
        $erro_msg = $clliclicita->erro_msg;
        if ($clliclicita->erro_status == 0) {
            $sqlerro = true;
        }
    }

    db_fim_transacao($sqlerro);
} else if (isset($chavepesquisa)) {
    $db_opcao = 3;
    $result = $clliclicita->sql_record($clliclicita->sql_query($chavepesquisa));
    db_fieldsmemory($result, 0);
    if ($l08_altera == "t") {
        $db_botao = true;
    }
}
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
    <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
        <tr>
            <td width="360" height="18">&nbsp;</td>
            <td width="263">&nbsp;</td>
            <td width="25">&nbsp;</td>
            <td width="140">&nbsp;</td>
        </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <br>
        <tr>
            <td height="430" align="center" valign="top" bgcolor="#CCCCCC">
                <center>
                    <?
                    include("forms/db_frmliclicita.php");
                    ?>
                </center>
            </td>
        </tr>
    </table>
    <?
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
</body>

</html>
<?
if (isset($excluir)) {
    if ($clliclicita->erro_status == 0) {

        db_msgbox($erro_msg);
        $clliclicita->erro(true, false);
    } else {
        $clliclicita->erro(true, true);
    };
};
if ($db_opcao == 33) {
    echo "<script>document.form1.pesquisar.click();</script>";
}
?>
