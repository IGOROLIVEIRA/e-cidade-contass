<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
require_once("libs/db_app.utils.php");
include("classes/db_apostilamentonovo_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clapostilamento = new cl_apostilamentonovo;
$db_opcao = 1;
$db_botao = true;
if (isset($incluir)) {
  $clapostilamento->si03_acordo = $ac16_sequencial;
  db_inicio_transacao();
  $clapostilamento->incluir(null);
  $si03_sequencial = $clapostilamento->si03_sequencial;
  $db_opcao = 3;
  db_fim_transacao();
}
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

    /*
    #oGridItensrow0checkbox {
      width: 21px !important;

    }


    #col1 {
      width: 21px !important;

    }
    */

    #tableoGridItensheader>tbody:nth-child(1)>tr:nth-child(1)>td:nth-child(1) {
      width: 21px !important;

    }

    #oGridItensrow0checkbox {
      width: 21px !important;

    }

    #tablegridDotacoesheader>tbody:nth-child(1)>tr:nth-child(1)>td:nth-child(1) {
      width: 20% !important;

    }

    #tablegridDotacoesheader>tbody:nth-child(1)>tr:nth-child(1)>td:nth-child(2) {
      width: 60% !important;

    }

    #tablegridDotacoesheader>tbody:nth-child(1)>tr:nth-child(1)>td:nth-child(3) {
      width: 20% !important;

    }

    #oGridItensrow0cell0 {
      width: 50px !important;

    }



    #col2 {
      width: 50px !important;

    }

    #oGridItensrow0cell1 {
      width: 380px !important;

    }

    #col3 {
      width: 380px !important;

    }

    #oGridItensrow0cell3 {
      width: 90px !important;

    }

    #col5 {
      width: 90px !important;

    }
  </style>

</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <center>
    <?
    include("forms/db_frmapostilamentonovo.php");
    ?>
  </center>
  <?
  db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
  ?>
</body>

</html>

<?
if (isset($incluir)) {
  if ($clapostilamento->erro_status == "0") {
    $clapostilamento->erro(true, false);
    $db_botao = true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if ($clapostilamento->erro_campo != "") {
      echo "<script> document.form1." . $clapostilamento->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1." . $clapostilamento->erro_campo . ".focus();</script>";
    }
  } else {
    //$clapostilamento->erro(true,true);
    db_msgbox("Inclusao efetuada com Sucesso");
  }
}
?>