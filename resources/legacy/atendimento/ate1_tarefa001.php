<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
$clcriaabas     = new cl_criaabas;
$db_opcao = 1;
if(isset($menu))
  exit;
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
	 $clcriaabas->identifica = array("tarefa"=>"Tarefa","tarefaobs"=>"Observações","tarefausu"=>"Usu. iniciais","tarefaclientes"=>"Clientes","tarefaanexos"=>"Anexos");
	 if (isset($at05_seq)&&$at05_seq!=""){
	 	 $param = "ate1_tarefa004.php?at05_seq=$at05_seq"; 
	 	 if(isset($at40_responsavel)&&$at40_responsavel!="") {
	 	 	$param .= "&at40_responsavel=$at40_responsavel";
	 	 }
	 	 if(isset($at49_modulo)&&$at49_modulo!="") {
	 	 	$param .= "&at49_modulo=$at49_modulo";
	 	 }
	 	 $param .= "&tipo=".@$tipo; 
		 $clcriaabas->src = array("tarefa"=>$param);
	 }else{
		 $clcriaabas->src = array("tarefaobs"=>"ate1_tarefaobs001.php");
		 $clcriaabas->src = array("tarefa"=>"ate1_tarefa004.php?tipo=".@$tipo);
	 }
	 $clcriaabas->disabled   =  array("tarefaobs"=>"true","tarefausu"=>"true","tarefaclientes"=>"true","tarefaanexos"=>"true"); 
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
