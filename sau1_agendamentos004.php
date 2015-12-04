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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
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
	 $clcriaabas->identifica = array("a1"=>"Médico/Especialidade","a2"=>"Data/Agenda","a3"=>"Horário","a4"=>"Atualiza CGS");
	 $clcriaabas->src = array("a1"=>"sau1_agendamentos005.php","a2"=>"sau1_agendamentos002.php");
	 $clcriaabas->disabled   =  array("a2"=>"true","a3"=>"true");
     $clcriaabas->sizecampo  = array("a1"=>20,"a2"=>20,"a3"=>30);
     $clcriaabas->scrolling  = "yes";
	 $clcriaabas->cria_abas();
       ?>
       </td>
    </tr>
  </table>
  <?
	db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>
  </body>
  </html>
