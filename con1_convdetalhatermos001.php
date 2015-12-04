<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_convdetalhatermos_classe.php");
include("classes/db_convconvenios_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clconvdetalhatermos = new cl_convdetalhatermos;
$clconvconvenios = new cl_convconvenios;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
  /*
$clconvdetalhatermos->c208_sequencial = $c208_sequencial;
$clconvdetalhatermos->c208_nroseqtermo = $c208_nroseqtermo;
$clconvdetalhatermos->c208_dscalteracao = $c208_dscalteracao;
$clconvdetalhatermos->c208_dataassinaturatermoaditivo = $c208_dataassinaturatermoaditivo;
$clconvdetalhatermos->c208_datafinalvigencia = $c208_datafinalvigencia;
$clconvdetalhatermos->c208_valoratualizadoconvenio = $c208_valoratualizadoconvenio;
$clconvdetalhatermos->c208_valoratualizadocontrapartida = $c208_valoratualizadocontrapartida;
$clconvdetalhatermos->c208_codconvenio = $c208_codconvenio;
  */
}
if(isset($incluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconvdetalhatermos->incluir($c208_sequencial);
    $erro_msg = $clconvdetalhatermos->erro_msg;
    if($clconvdetalhatermos->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconvdetalhatermos->alterar($c208_sequencial);
    $erro_msg = $clconvdetalhatermos->erro_msg;
    if($clconvdetalhatermos->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconvdetalhatermos->excluir($c208_sequencial);
    $erro_msg = $clconvdetalhatermos->erro_msg;
    if($clconvdetalhatermos->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
   $result = $clconvdetalhatermos->sql_record($clconvdetalhatermos->sql_query($c208_sequencial));
   if($result!=false && $clconvdetalhatermos->numrows>0){
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
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmconvdetalhatermos.php");
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
    if($clconvdetalhatermos->erro_campo!=""){
        echo "<script> document.form1.".$clconvdetalhatermos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clconvdetalhatermos->erro_campo.".focus();</script>";
    }
}
?>
