<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_itensregpreco_classe.php");
include("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clitensregpreco = new cl_itensregpreco;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  db_inicio_transacao();
  $clitensregpreco->incluir($si07_sequencial);
  db_fim_transacao();
}
if(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $clitensregpreco->alterar($si07_sequencial);
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $clitensregpreco->sql_record($clitensregpreco->sql_query($chavepesquisa));
   db_fieldsmemory($result,0);
   $db_botao = true;
}
if(isset($excluir)){
  db_inicio_transacao();
  $db_opcao = 3;
  $clitensregpreco->excluir($si07_sequencial);
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $result = $clitensregpreco->sql_record($clitensregpreco->sql_query($chavepesquisa)); 
   db_fieldsmemory($result,0);
   $db_botao = true;
}

if($opcao == 3){
	$db_opcao = 3;
}

$sSql = "select * from itensregpreco inner join pcmater on pcmater.pc01_codmater = itensregpreco.si07_item inner join db_usuarios on db_usuarios.id_usuario = pcmater.pc01_id_usuario inner join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo 
where si07_sequencialadesao = ".$codigoAdesao;

$rsResultTabela = pg_query($sSql);
//db_criatabela($rsResultTabela);

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmitensregpreco.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<script>
js_tabulacaoforms("form1","si07_numerolote",true,1,"si07_numerolote",true);
</script>
<?
if(isset($incluir)){
  if($clitensregpreco->erro_status=="0"){
    $clitensregpreco->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clitensregpreco->erro_campo!=""){
      echo "<script> document.form1.".$clitensregpreco->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clitensregpreco->erro_campo.".focus();</script>";
    }
  }else{
  	$clitensregpreco->pagina_retorno=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?codigoAdesao=$si07_sequencialadesao";
    $clitensregpreco->erro(true,true);
  }
}
if(isset($alterar)){
  if($clitensregpreco->erro_status=="0"){
    $clitensregpreco->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clitensregpreco->erro_campo!=""){
      echo "<script> document.form1.".$clitensregpreco->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clitensregpreco->erro_campo.".focus();</script>";
    }
  }else{
  	$clitensregpreco->pagina_retorno=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?codigoAdesao=$si07_sequencialadesao";
    $clitensregpreco->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
if(isset($excluir)){
  if($clitensregpreco->erro_status=="0"){
    $clitensregpreco->erro(true,false);
  }else{
    $clitensregpreco->erro(true,true);
  }
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}

?>
