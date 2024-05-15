<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("dbforms/db_funcoes.php");	
include("libs/db_utils.php");
db_postmemory($HTTP_POST_VARS);

include("classes/db_bens_classe.php");

$clbensbaix = new cl_bensbaix;
$db_opcao=2;
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
  
 <center>
	
	<form name="form1" method="post" action=""">
<center>
<fieldset style="width: 700px;margin-left: 2px; margin-top: 100px;">
<legend style="font-weight: bold;"> Relatório Baixa de Bens </legend>
<table border="0">

  <tr>
        <td nowrap title="Data referente a baixa">
      <b> Data referente a baixa:</b>
    </td>
    <td>
    <? db_inputdata('t55_baixaini', @$t55_baixaini_dia, @$t55_baixaini_mes, @$t55_baixaini_ano, true, 'text', 2, ""); ?>
	<b> a </b>
		<? db_inputdata('t55_baixafim', @$t55_baixafim_dia, @$t55_baixafim_mes, @$t55_baixafim_ano, true, 'text', 2, "");     ?> 
  </table>
  </fieldset>
  </center>
		<input name="emitir" type="submit" id="emitir" value="Emitir">

</form>

</body>
</html>

<?
	if(isset($emitir)){
		if(document.form1.t55_baixaini.value == '' || document.form1.t55_baixafim.value == '') {
			alert("Informe um período");
		}	else {
      echo "<script> jan = window.open('pat2_bensbaixa.php?databaixaini='+document.form1.t55_baixaini.value+'&databaixafim='+document.form1.t55_baixafim.value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');</script>";
		}
	}
		
	db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));

?>


