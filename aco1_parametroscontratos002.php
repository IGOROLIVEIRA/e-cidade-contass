<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_parametroscontratos_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);
$clparametroscontratos = new cl_parametroscontratos;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
   db_inicio_transacao();
   $result = $clparametroscontratos->sql_record($clparametroscontratos->sql_query());
   $clparametroscontratos->pc01_liberargerenciamentocontratos = $pc01_liberargerenciamentocontratos;
   if($result==false || $clparametroscontratos->numrows==0){
     $clparametroscontratos->incluir();
   }else{
     $clparametroscontratos->alterar($oid);
   }
   db_fim_transacao();
}
$db_opcao = 2;
$result = $clparametroscontratos->sql_record($clparametroscontratos->sql_query());
if($result!=false && $clparametroscontratos->numrows>0){
  db_fieldsmemory($result,0);
}
$db_botao = true;
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">

    <?
    db_app::load("scripts.js, prototype.js, widgets/windowAux.widget.js,strings.js,widgets/dbtextField.widget.js,
               DBViewProgramacaoFinanceira.classe.js,dbmessageBoard.widget.js,dbautocomplete.widget.js,
               dbcomboBox.widget.js,datagrid.widget.js,widgets/dbtextFieldData.widget.js");
    db_app::load("estilos.css,grid.style.css");
    ?>
    <style>
        td {
            white-space: nowrap;
        }

        fieldset table td:first-child {
            width: 80px;
            white-space: nowrap;
        }
    </style>

</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table border="0" align="center" cellspacing="0" cellpadding="0" style="padding-top:40px;">
    <tr>
        <td valign="top" align="center">
            <fieldset>
                <legend><b>Configuração de Parâmetros Contratos</b></legend>
                <table align="center" border="0">
                  <tr>
                    <td height="100" align="center" valign="top" bgcolor="#CCCCCC">

                    <?
                    include("forms/db_frmparametroscontratos.php");
                    ?>

                    </td>
                  </tr>
                </table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($alterar)){
  if($clparametroscontratos->erro_status=="0"){
    $clparametroscontratos->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clparametroscontratos->erro_campo!=""){
      echo "<script> document.form1.".$clparametroscontratos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clparametroscontratos->erro_campo.".focus();</script>";
    }
  }else{
    $clparametroscontratos->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
