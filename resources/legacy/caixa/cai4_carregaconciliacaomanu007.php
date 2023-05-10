<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_conciliacao_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clconciliacao = new cl_conciliacao;
$db_opcao=1;
$db_botao = true;
if(isset($incluir)){
  db_inicio_transacao();
  $clconciliacao->incluir($k199_sequencial);
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
		include("forms/db_frmcarregaconciliacaomanu.php");
	?>
    </center>
</body>
</html>
<script>
js_tabulacaoforms("form1","k199_periodofinal",true,1,"k199_periodofinal",true);
</script>
<?
if(isset($incluir)){
  if($clconciliacao->erro_status=="0"){
    $clconciliacao->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clconciliacao->erro_campo!=""){
      echo "<script> document.form1.".$clconciliacao->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clconciliacao->erro_campo.".focus();</script>";
    }
  }else{
    $clconciliacao->erro(true,true);
  }
}
?>
