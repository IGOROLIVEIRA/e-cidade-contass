<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_habilitacaoforn_classe.php");
include("dbforms/db_funcoes.php");
require_once ("classes/db_pcorcamforne_classe.php");
db_postmemory($HTTP_POST_VARS);
$clhabilitacaoforn = new cl_habilitacaoforn;
$clpcorcamforne    = new cl_pcorcamforne;

$db_opcao = 22;
$db_botao = false;
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
}

if(isset($incluir)){
	if($sqlerro==false){
    db_inicio_transacao();
    $clhabilitacaoforn->incluir($l206_sequencial);
    $erro_msg = $clhabilitacaoforn->erro_msg;
    if($clhabilitacaoforn->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clhabilitacaoforn->alterar($l206_sequencial);
    $erro_msg = $clhabilitacaoforn->erro_msg;
    if($clhabilitacaoforn->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clhabilitacaoforn->excluir($l206_sequencial);
    $erro_msg = $clhabilitacaoforn->erro_msg;
    if($clhabilitacaoforn->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
   $result = $clhabilitacaoforn->sql_record($clhabilitacaoforn->sql_query($l206_sequencial));
   if($result!=false && $clhabilitacaoforn->numrows>0){
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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="100" marginheight="20" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmhabilitacaoforn.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<script>
js_tabulacaoforms("form1","l206_fornecedor",true,1,"l206_fornecedor",true);
</script>
<?
/*if(isset($incluir)){
  if($clhabilitacaoforn->erro_status=="0"){
    $clhabilitacaoforn->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clhabilitacaoforn->erro_campo!=""){
      echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".focus();</script>";
    }
  }else{
    $clhabilitacaoforn->erro(true,true);
  }
}*/
if(isset($alterar) || isset($excluir) || isset($incluir)){
    db_msgbox($erro_msg);
    if($clhabilitacaoforn->erro_campo!=""){
        echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".focus();</script>";
    }
}
?>
