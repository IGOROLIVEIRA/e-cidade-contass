<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_precoreferencia_classe.php");
include("classes/db_itemprecoreferencia_classe.php");
include("classes/db_liccomissaocgm_classe.php");
include("dbforms/db_funcoes.php");
$oPost = db_utils::postMemory($_POST);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clprecoreferencia = new cl_precoreferencia;
$clitemprecoreferencia = new cl_itemprecoreferencia;
$clliccomissaocgm      = new cl_liccomissaocgm();
$db_opcao = 22;
$db_botao = false;



if (isset($imprimir)) {

    if (!isset($si01_processocompra) || $si01_processocompra == '') {
        echo "<script>alert(\"Nenhum processo foi selecionado\")</script>";
    } else {

        echo "<script>
    jan = window.open('sic1_precoreferencia004.php?impjust=$impjustificativa&codigo_preco='+{$si01_processocompra}+'&quant_casas='+{$quant_casas}+
    '&tipoprecoreferencia='+$oPost->si01_tipoprecoreferencia,
                     'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	   jan.moveTo(0,0);
    </script>";
    }
}

if (isset($imprimircsv)) {

    if (!isset($si01_processocompra) || $si01_processocompra == '') {
        echo "<script>alert(\"Nenhum processo foi selecionado\")</script>";
    } else {

        echo "<script>
    jan = window.open('sic1_precoreferencia005.php?impjust=$impjustificativa&codigo_preco='+{$si01_processocompra}+'&quant_casas='+{$quant_casas}+
    '&tipoprecoreferencia='+$oPost->si01_tipoprecoreferencia,
                     'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	   jan.moveTo(0,0);
    </script>";
    }
}

if (isset($imprimirword)) {

    if (!isset($si01_processocompra) || $si01_processocompra == '') {
        echo "<script>alert(\"Nenhum processo foi selecionado\")</script>";
    } else {

        echo "<script>
    jan = window.open('sic1_precoreferencia006.php?impjust=$impjustificativa&codigo_preco='+{$si01_processocompra}+'&quant_casas='+{$quant_casas}+
    '&tipoprecoreferencia='+$oPost->si01_tipoprecoreferencia,
                     'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	   jan.moveTo(0,0);
    </script>";
    }
}

if (isset($alterar)) {
    if($respCotacaocodigo!=""&& $respOrcacodigo!=""){
        $clprecoreferencia->si01_tipoCotacao  = 3;
        $clprecoreferencia->si01_tipoOrcamento  = 4;
        $clprecoreferencia->si01_numcgmCotacao = $respCotacaocodigo;
        $clprecoreferencia->si01_numcgmOrcamento = $respOrcacodigo;
    }
    
    db_inicio_transacao();
    $db_opcao = 2;
    $clprecoreferencia->si01_justificativa = $si01_justificativa;
   
    /**
     * Atualização do valor dos itens do preço referência
     */

    if ($si01_tipoprecoreferencia == '1') {
        $sFuncao = "avg";
    } else if ($si01_tipoprecoreferencia == '2') {
        $sFuncao = "max";
    } else {
        $sFuncao = "min";
    }

    $sSql = "select pc23_orcamitem,round($sFuncao(pc23_vlrun),4) as valor,
                round($sFuncao(pc23_perctaxadesctabela),2) as percreferencia1,
                round($sFuncao(pc23_percentualdesconto),2) as percreferencia2,
                si02_sequencial as sequencial
                from pcproc
                join pcprocitem on pc80_codproc = pc81_codproc
                join pcorcamitemproc on pc81_codprocitem = pc31_pcprocitem
                join pcorcamitem on pc31_orcamitem = pc22_orcamitem
                join pcorcamval on pc22_orcamitem = pc23_orcamitem
                join itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
                where pc80_codproc = $si01_processocompra and pc23_vlrun > 0 group by pc23_orcamitem, si02_sequencial";

    $rsResult = db_query($sSql);

    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

        $oItem = db_utils::fieldsMemory($rsResult, $iCont);
        $clitemprecoreferencia->si02_vlprecoreferencia = $oItem->valor;
        $clitemprecoreferencia->alterar($oItem->sequencial);
    }

    if ($clitemprecoreferencia->numrows_alterar) {
        $clprecoreferencia->alterar($si01_sequencial);
    }

    db_fim_transacao();
} else if (isset($chavepesquisa)) {
    $db_opcao = 2;
    $result = $clprecoreferencia->sql_record($clprecoreferencia->sql_query($chavepesquisa));
    db_fieldsmemory($result, 0);
    $db_botao = true;
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
    <table width="790" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
                <center>
                    <?
                    include("forms/db_frmprecoreferencia.php");
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
if (isset($alterar)) {
    if ($clprecoreferencia->erro_status == "0") {
        $clprecoreferencia->erro(true, false);
        $db_botao = true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if ($clprecoreferencia->erro_campo != "") {
            echo "<script> document.form1." . $clprecoreferencia->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1." . $clprecoreferencia->erro_campo . ".focus();</script>";
        }
    } else {
        $clprecoreferencia->erro(true, true);
    }
}
if ($db_opcao == 22) {
    echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
    js_tabulacaoforms("form1", "si01_processocompra", true, 1, "si01_processocompra", true);
</script>