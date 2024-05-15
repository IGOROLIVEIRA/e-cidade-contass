<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
$clcriaabas     = new cl_criaabas;
$db_opcao = 1;
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="790" height="18"  border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table valign="top" marginwidth="0" width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
     <?
	     $clcriaabas->identifica = array("consconsorcios"=>"Consórcio","consvalorestransf"=>"Valores Transferidos","consexecucaoorc"=>"Execução Orçamentária",
	     "consdispcaixaano"=>"Disponibilidade de Caixa 31/12","consretiradaexclusao"=>"Retirada/ Exclusão","consmesreferencia"=>"Mês Referência SICOM");  
	     $clcriaabas->src = array("consconsorcios"=>"con1_consconsorcios006.php");
	     $clcriaabas->sizecampo = array("consconsorcios"=>"10","consvalorestransf"=>"20","consexecucaoorc"=>"20",
	     "consdispcaixaano"=>"25","consretiradaexclusao"=>"20","consmesreferencia"=>"20");
	     $clcriaabas->disabled   =  array("consvalorestransf"=>"true","consexecucaoorc"=>"true","consdispcaixaano"=>"true","consretiradaexclusao"=>"true","consmesreferencia"=>"true"); 
	     $clcriaabas->cria_abas(); 
     ?> 
    </td>
  </tr>
</table>
<form name="form1">
</form>
<? 
	db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
