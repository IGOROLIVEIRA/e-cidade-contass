<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licataregitem_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cllicataregitem = new cl_licataregitem;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  db_inicio_transacao();
  $cllicataregitem->incluir();
  db_fim_transacao();
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


    <center>
	<?
	include("forms/db_frmlicataregitem.php");
	?>
    </center>


</body>
</html>
<script>
js_tabulacaoforms("form1","l222_ordem",true,1,"l222_ordem",true);
</script>
<?
if(isset($incluir)){
  if($cllicataregitem->erro_status=="0"){
    $cllicataregitem->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cllicataregitem->erro_campo!=""){
      echo "<script> document.form1.".$cllicataregitem->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cllicataregitem->erro_campo.".focus();</script>";
    }
  }else{
    $cllicataregitem->erro(true,true);
  }
}
?>
