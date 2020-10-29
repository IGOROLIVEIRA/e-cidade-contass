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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_lancamverifaudit_classe.php");
include("classes/db_questaoaudit_classe.php");
include("classes/db_matrizachadosaudit_classe.php");

db_postmemory($HTTP_POST_VARS);

$iInstit = db_getsession('DB_instit');

$cllancamverifaudit = new cl_lancamverifaudit;
$clmatrizachadosaudit = new cl_matrizachadosaudit;

$sCampos    = "ci02_numquestao, ci02_questao::text, ci05_atendquestaudit, ci05_achados::text";
$sWhere     = "ci03_codproc = {$ci06_codproc} AND ci02_instit = {$iInstit} AND ci05_atendquestaudit = 'f'";

$clquestaoaudit = new cl_questaoaudit;
$sSqlQuestoes   = $clquestaoaudit->sql_questao_processo(null, $sCampos, "ci02_numquestao", $sWhere);
$rsQuestoes     = db_query($sSqlQuestoes);

$db_opcao = 1;
$db_botao = true;

if (isset($incluir)){
    
    $sqlerro  = false;

    db_inicio_transacao();
    $clmatrizachadosaudit->ci06_instit = db_getsession('DB_instit');
    
    $clmatrizachadosaudit->incluir($ci06_seq);

    if($clmatrizachadosaudit->erro_status=="0"){
        $sqlerro = true;
    }
    db_fim_transacao($sqlerro);
    
    $ci06_seq           = $clmatrizachadosaudit->ci06_seq;
    $ci02_codquestao    = $clmatrizachadosaudit->ci06_codquestao;
    $db_opcao = 1;
    $db_botao = true;
    
}

if (isset($alterar)) {

    $sqlerro  = false;

    db_inicio_transacao();

    $clmatrizachadosaudit->alterar($ci06_seq);

    if($clmatrizachadosaudit->erro_status=="0"){
        $sqlerro = true;
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
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">

</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
        <td width="360" height="18">&nbsp;</td>
        <td width="263">&nbsp;</td>
        <td width="25">&nbsp;</td>
        <td width="140">&nbsp;</td>
    </tr>
</table>

<table align="center" cellspacing='0' border="0">
    <tr>
        <td>&nbsp;</td>
    </tr>

    <tr> 
        <td height="" align="left" valign="top" bgcolor="#CCCCCC"> 
        <center>
	        <? include("forms/db_frmmatrizachadosaudit.php"); ?>
        </center>
	    </td>
    </tr>

</table>
<br>

<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($incluir) || isset($alterar)){
  if($clmatrizachadosaudit->erro_status=="0"){
    $clmatrizachadosaudit->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.btnSubmit.disabled=false;</script>  ";
    if($clmatrizachadosaudit->erro_campo!=""){
      echo "<script> document.form1.".$clmatrizachadosaudit->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clmatrizachadosaudit->erro_campo.".focus();</script>";
    }
    if ( isset($alterar) && isset($ci06_seq) ) {
        echo "<script> document.form1.btnSubmit.value = 'Alterar';</script>  ";
        echo "<script> document.form1.btnSubmit.name = 'alterar';</script>  ";
    }
  }else{
    db_msgbox($clmatrizachadosaudit->erro_msg);
    echo "<script> document.form1.btnSubmit.value = 'Alterar';</script>  ";
    echo "<script> document.form1.btnSubmit.name = 'alterar';</script>  ";
  }
}
?>
