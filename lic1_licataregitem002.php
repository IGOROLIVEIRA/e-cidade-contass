<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licataregitem_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cllicataregitem = new cl_licataregitem;
$db_opcao = 33;
$db_botao = true;
if(isset($excluir)){
  db_inicio_transacao();
  $db_opcao = 3;
  $cllicataregitem->excluir(null,'l222_licatareg ='.$l222_licatareg);
  db_fim_transacao();
  db_msgbox("Itens excluidos com Sucesso!");
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
  <?php
	include("forms/db_frmlicataregitem.php");
	?>
    </center>


</body>
</html>
<script>
js_tabulacaoforms("form1","l222_ordem",true,1,"l222_ordem",true);
</script>
<?php
if(isset($excluir)){
  echo " <script>
  parent.iframe_licataregitem.location.href = 'lic1_licataregitem001.php?l222_licatareg= $l222_sequencial&licitacao=$licitacao&fornecedor=$fornecedor';
  </script> ";
}
?>
