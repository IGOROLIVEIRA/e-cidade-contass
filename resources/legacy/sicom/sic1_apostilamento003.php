<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_apostilamento_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_contratos_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clapostilamento = new cl_apostilamento;
$clcontratos = new cl_contratos;
$db_botao = false;
$db_opcao = 33;
if(isset($excluir)){
  db_inicio_transacao();
  $db_opcao = 3;
  $clapostilamento->excluir($si03_sequencial);
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $clapostilamento->sql_record($clapostilamento->sql_query($chavepesquisa)); 
   db_fieldsmemory($result,0);
   $result = $clcontratos->sql_record($clcontratos->sql_query_novo(null,"si172_sequencial, (si172_nrocontrato||'/'||si172_exercicioprocesso)::varchar as nrocontrato, z01_nome, si172_dataassinatura",null,"si172_sequencial = $si03_numcontrato"));
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
<fieldset   style="margin-left:40px; margin-top: 20px;">
<legend><b>Apostilamento</b></legend>
  <?
  include("forms/db_frmapostilamento.php");
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
  if($clapostilamento->erro_status=="0"){
    $clapostilamento->erro(true,false);
  }else{
    $clapostilamento->erro(true,true);
  }
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
