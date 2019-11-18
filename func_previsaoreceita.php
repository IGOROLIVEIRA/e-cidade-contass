<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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
include("classes/cl_prevconvenioreceita.php");
include("dbforms/db_classesgenericas.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

//$cl_prevconvenioreceita->rotulo->label();

ini_set('display_errors', 'On');
error_reporting(E_ALL);

//echo $iCodRec.'<br>';
//echo $sReceita.'<br>';
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;

$clprevconvenioreceita = new cl_prevconvenioreceita;
$clprevconvenioreceita->rotulo->label("c229_fonte");
$clprevconvenioreceita->rotulo->label("c229_convenio");
$clprevconvenioreceita->rotulo->label("c229_vlprevisto");
$c229_anousu = db_getsession('DB_anousu');

if(isset($c229_fonte)){
//    echo 'tem fonte.<br>';
}

if(isset($opcao) && $opcao=="alterar"){
    $db_opcao = 1;
//    echo "<script>
//          js_OpenJanelaIframe('','db_iframe_newparag','con4_docparag006.php?chavepesquisa=$db02_idparag','Altera Paragrafo',true,0);
//        </script>";
//    $db02_idparag="";
//    $db02_descr="";
}elseif(isset($opcao) && $opcao=="excluir" || isset($db_opcao) && $db_opcao==3){
    $db_opcao = 3;
}else{
    $db_opcao = 1;
}

if(isset($incluir)){
    $sqlerro=false;
    db_inicio_transacao();
    $clprevconvenioreceita->c229_fonte = $c229_fonte;
    $clprevconvenioreceita->c229_convenio = $c229_convenio;
    $clprevconvenioreceita->c229_vlprevisto = $c229_vlprevisto;
    $clprevconvenioreceita->c229_anousu = db_getsession('DB_anousu');
    $clprevconvenioreceita->incluir($c229_anousu, $c229_fonte);
    $erro_msg=$clprevconvenioreceita->erro_msg;
    if ($clprevconvenioreceita->erro_status==0){
        $sqlerro=true;
    }else{
        $c229_anousu="";
        $c229_fonte="";
    }
    db_fim_transacao($sqlerro);

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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
        <td width="360" height="18">&nbsp;</td>
        <td width="263">&nbsp;</td>
        <td width="25">&nbsp;</td>
        <td width="140">&nbsp;</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td height="120" align="left" valign="top" bgcolor="#CCCCCC">
            <center>
            <?
            include("forms/db_frmconvprevreceita.php");
            ?>
            </center>
        </td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>

<?php
if(isset($incluir) ||  isset($excluir)){
if($sqlerro==true){
    $clprevconvenioreceita->erro(true,false);
if($clprevconvenioreceita->erro_campo!=""){
echo "<script> parent.document.form1.".$clprevconvenioreceita->erro_campo.".style.backgroundColor='#99A9AE';</script>";
echo "<script> parent.document.form1.".$clprevconvenioreceita->erro_campo.".focus();</script>";
}
}else{
db_msgbox($erro_msg);
echo "<script>
    document.form1.pesquisar.click();
</script>";

}
}
?>
