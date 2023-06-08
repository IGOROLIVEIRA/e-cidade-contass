<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_descontotabela_classe.php");
include("classes/db_homologacaoadjudica_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cldescontotabela      = new cl_descontotabela;
$clhomologacaoadjudica = new cl_homologacaoadjudica;
$db_botao = false;
$db_opcao = 33;
if(isset($excluir)){
  db_inicio_transacao();
  $db_opcao = 3;
  $cldescontotabela->excluir("","l204_licitacao = $l204_licitacao");
  $clhomologacaoadjudica->alteraLicitacao($l204_licitacao,0);
  db_fim_transacao();
  db_redireciona('lic1_descontotabela003.php');
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $cldescontotabela->sql_record($cldescontotabela->sql_query("","*","","l204_licitacao = $chavepesquisa")); 
   db_fieldsmemory($result,0);
   $db_botao = true;
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
  <fieldset style=" margin-top: 30px; width: 500px; height: 400px;">
  <legend>Desconto Tabela</legend>
  <?
  include("forms/db_frmdescontotabela.php");
  ?>
  </fieldset>
  </center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($excluir)){
  if($cldescontotabela->erro_status=="0"){
    $cldescontotabela->erro(true,false);
  }else{
    $cldescontotabela->erro(true,true);
  }
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
