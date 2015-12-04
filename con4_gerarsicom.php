<?php
/**
 * 
 * @author I
 * @revision $Author: dbiuri $
 * @version $Revision: 1.10 $
 */
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
$periodo = array("1"  => " 1 - Janeiro          ",
                 "2"  => " 2 - Fevereiro (1 Bim)",
                 "3"  => " 3 - Março            ",
                 "4"  => " 4 - Abril     (2 Bim)",
                 "5"  => " 5 - Maio             ",
                 "6"  => " 6 - Junho     (3 Bim)",
                 "7"  => " 7 - Julho            ", 
                 "8"  => " 8 - Agosto    (4 Bim)",
                 "9"  => " 9 - Setembro         ",
                 "10" => "10 - Outubro   (5 Bim)",
                 "11" => "11 - Novembro         ",
                 "12" => "12 - Dezembro  (6 Bim)");

$clrotulo = new rotulocampo;
$clrotulo->label("o124_descricao");
$clrotulo->label("o124_sequencial");
$clrotulo->label("o15_descr");
$clrotulo->label("o15_codigo");
?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
  </head>
<body bgcolor="#cccccc" style="margin-top: 25px;">

</body>
</html>
<? db_menu(db_getsession("DB_id_usuario"), 
           db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>


