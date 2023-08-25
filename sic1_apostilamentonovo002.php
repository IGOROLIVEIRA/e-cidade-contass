<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
require_once("libs/db_app.utils.php");
include("classes/db_apostilamentonovo_classe.php");
include("dbforms/db_funcoes.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clapostilamento = new cl_apostilamentonovo;
$db_opcao = 1;
$db_botao = true;
$_GET['viewAlterar'] = true;

// if (isset($alterar)) {
//   $clapostilamento->si03_numcontrato = $ac16_sequencial;
//   db_inicio_transacao();
//   $db_opcao = 2;
//   $clapostilamento->alterar($si03_sequencial);
//   db_fim_transacao();
// } else if (isset($chavepesquisa)) {
//   $db_opcao = 2;
//   $result = $clapostilamento->sql_record($clapostilamento->sql_query($chavepesquisa));
//   db_fieldsmemory($result, 0);
//   $db_botao = true;
// }
?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbautocomplete.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextField.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextFieldData.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbcomboBox.widget.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBHint.widget.js"></script>

  <link href="estilos.css" rel="stylesheet" type="text/css">


  <style>
    #si03_tipoalteracaoapostila,
    #si03_tipoapostila,
    #si03_descrapostila {
      width: 350px;
    }

    #si03_numapostilamento {
      width: 80px !important;
    }

    #ac16_resumoobjeto {
      width: 290px !important;
    }

    #si03_dataapostila {
      width: 80px !important;
    }
  </style>


</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <center>

    <?php
    include("forms/db_frmapostilamentonovo.php");
    ?>
  </center>
  <?php
  db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
  ?>
</body>

</html>
<?php
if (isset($alterar)) {
  if ($clapostilamento->erro_status == "0") {
    $clapostilamento->erro(true, false);
    $db_botao = true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if ($clapostilamento->erro_campo != "") {
      echo "<script> document.form1." . $clapostilamento->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1." . $clapostilamento->erro_campo . ".focus();</script>";
    }
  } else {
    $clapostilamento->erro(true, true);
  }
}
?>
<!-- <script>
  js_tabulacaoforms("form1", "si03_licitacao", true, 1, "si03_licitacao", true);
</script> -->
