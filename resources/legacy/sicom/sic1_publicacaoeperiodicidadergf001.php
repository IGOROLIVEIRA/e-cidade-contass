<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_publicacaoeperiodicidadergf_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clpublicacaoeperiodicidadergf = new cl_publicacaoeperiodicidadergf;

$db_botao = true;

?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?php
  db_app::load("scripts.js, strings.js, prototype.js, estilos.css");
  ?>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
  <center>
    <fieldset   style="margin-left:40px; margin-top: 20px;">
      <legend><b>Publicação e Periodicidade do RGF</b></legend>
      <?
      include("forms/db_frmpublicacaoeperiodicidadergf.php");
      ?>
    </fieldset>
  </center>

</body>
</html>

