<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_consexecucaoorc_classe.php");
include("classes/db_consconsorcios_classe.php");
include("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clconsexecucaoorc = new cl_consexecucaoorc;
$clconsconsorcios = new cl_consconsorcios;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
  /*
$clconsexecucaoorc->c202_sequencial = $c202_sequencial;
$clconsexecucaoorc->c202_consconsorcios = $c202_consconsorcios;
$clconsexecucaoorc->c202_mescompetencia = $c202_mescompetencia;
$clconsexecucaoorc->c202_funcao = $c202_funcao;
$clconsexecucaoorc->c202_subfuncao = $c202_subfuncao;
$clconsexecucaoorc->c202_elemento = $c202_elemento;
$clconsexecucaoorc->c202_valorempenhado = $c202_valorempenhado;
$clconsexecucaoorc->c202_valorempenhadoanu = $c202_valorempenhadoanu;
$clconsexecucaoorc->c202_valorliquidado = $c202_valorliquidado;
$clconsexecucaoorc->c202_valorpago = $c202_valorpago;
$clconsexecucaoorc->c202_valorpagoanu = $c202_valorpagoanu;
  */
}
if(isset($incluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconsexecucaoorc->incluir($c202_sequencial);
    $erro_msg = $clconsexecucaoorc->erro_msg;
    if($clconsexecucaoorc->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconsexecucaoorc->alterar($c202_sequencial);
    $erro_msg = $clconsexecucaoorc->erro_msg;
    if($clconsexecucaoorc->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconsexecucaoorc->excluir($c202_sequencial);
    $erro_msg = $clconsexecucaoorc->erro_msg;
    if($clconsexecucaoorc->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
   $result = $clconsexecucaoorc->sql_record($clconsexecucaoorc->sql_query($c202_sequencial));
   if($result!=false && $clconsexecucaoorc->numrows>0){
     db_fieldsmemory($result,0);
   }
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmconsexecucaoorc.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar) || isset($excluir) || isset($incluir)){
    db_msgbox($erro_msg);
    if($clconsexecucaoorc->erro_campo!=""){
        echo "<script> document.form1.".$clconsexecucaoorc->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clconsexecucaoorc->erro_campo.".focus();</script>";
    } else if (isset($excluir)) {
    	db_redireciona("con1_consexecucaoorc001.php?c202_consconsorcios=$c202_consconsorcios&db_opcaoal=33");
    }
}
?>
