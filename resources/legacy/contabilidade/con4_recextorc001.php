<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
$clcriaabas     = new cl_criaabas;
$db_opcao = 1;
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <style type="text/css">
    .bordas {
      border-top:     1px outset rgb(204, 204, 204);
      border-right:   1px outset rgb(204, 204, 204);
      border-bottom:  1px outset rgb(0, 0, 0);
      border-left:    1px outset rgb(204, 204, 204);
    }

    .btn_ativo {
      border-top:     3px outset rgb(60, 60, 60) !important;
      border-right:   1px inset rgb(0, 0, 0) !important;
      border-bottom:  0px !important;
      border-left:    3px solid rgb(153, 153, 153) !important;
    }
  </style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="790" height="18"  border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table valign="top" marginwidth="0" width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
     <?
	     $clcriaabas->identifica = array(
          "controleext" => "Controle EXT",
          "controleextvlrtransf" => "Valores Transferidos"
        );
       $clcriaabas->src = array(
          "controleext" => "cai1_controleext001.php",
          "controleextvlrtransf" => "cai1_controleextvlrtransf001.php"
        );
       $clcriaabas->disabled   =  array("controleextvlrtransf"=>"false");
       $clcriaabas->sizecampo = array(
          "controleext" => "14",
          "controleextvlrtransf" => "18"
        );
       $clcriaabas->cria_abas();
     ?>
    </td>
  </tr>
</table>
<form name="form1">
</form>
<?
	db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script type="text/javascript">

var tabs = [
  'controleext',
  'controleextvlrtransf'
];

(tabs.forEach(function tiraFormatacaoPadrao (id, index) {

  var el = document.querySelector('table#' + id);

  el.setAttribute('style', '');

  if (index == 0) {
    el.classList.add('btn_ativo');
  }

}))();

function trocaTab(id) {

  tabs.forEach(function (el) {

    var div     = document.querySelector('#div_' + el);
    var button  = document.querySelector('table#' + el);

    if (el === id) {
      div.style.visibility  = 'visible';
      button.classList.add('btn_ativo');
    } else {
      div.style.visibility = 'hidden';
      button.classList.remove('btn_ativo');
    }

  });

}

function mo_camada(div) {

  if (div == 'controleextvlrtransf') {
    var k167_sequencial = iframe_controleext.document.getElementById('k167_sequencial');
    var k167_codcon     = iframe_controleext.document.getElementById('k167_codcon');

    if (isNaN(parseInt(k167_sequencial.value)) && isNaN(parseInt(k167_codcon.value))) {

      alert("Impossível alterar Valores Transferidos sem uma conta selecionada.");
      return false;

    }
  }

  trocaTab(div);

}

</script>
</body>
</html>
