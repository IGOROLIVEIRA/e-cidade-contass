<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_apostilamento_classe.php");
include("dbforms/db_funcoes.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clapostilamento = new cl_apostilamentonovo;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  $clapostilamento->si03_numcontrato = $ac16_sequencial;
  db_inicio_transacao();
  $db_opcao = 2;
  $clapostilamento->alterar($si03_sequencial);
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
    $result = $clapostilamento->sql_record($clapostilamento->sql_query($chavepesquisa));
    db_fieldsmemory($result,0);
   $db_botao = true;
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
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<center>
<fieldset   style="width: 50%; margin-left:40px; margin-top: 50px;">
<legend><b>Apostilamento</b></legend>
  <?
  include("forms/db_frmapostilamentonovo.php");
  ?>
   </fieldset>
</center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($alterar)){
  if($clapostilamento->erro_status=="0"){
    $clapostilamento->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clapostilamento->erro_campo!=""){
      echo "<script> document.form1.".$clapostilamento->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clapostilamento->erro_campo.".focus();</script>";
    }
  }else{
    $clapostilamento->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","si03_licitacao",true,1,"si03_licitacao",true);
</script>
