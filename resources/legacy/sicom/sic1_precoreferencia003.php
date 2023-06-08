<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_precoreferencia_classe.php");
include("classes/db_pcproc_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clprecoreferencia = new cl_precoreferencia;
$clpcproc = new cl_pcproc;
$clprecoreferenciaacount = new cl_precoreferenciaacount;
$db_botao = false;
$db_opcao = 33;
if(isset($excluir)){
  db_inicio_transacao();
  $db_opcao = 3;
  $sSql = $clpcproc->sql_query_dados_licitacao(null, '*', '', 'pc80_codproc ='.$si01_processocompra);
  $rSql = $clpcproc->sql_record($sSql);
  if(!$clpcproc->numrows){
    $clprecoreferencia->excluir($si01_sequencial);

    $clprecoreferenciaacount->si233_precoreferencia = $si01_sequencial;
    $clprecoreferenciaacount->si233_acao =  'Excluir';
    $clprecoreferenciaacount->si233_idusuario = db_getsession("DB_id_usuario");
    $clprecoreferenciaacount->si233_datahr =  date("Y-m-d", db_getsession("DB_datausu"));
    $clprecoreferenciaacount->incluir(null);  
    
  }else{
    $db_botao = true;
    $db_opcao = 33;
  }
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $clprecoreferencia->sql_record($clprecoreferencia->sql_query($chavepesquisa));
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
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr>
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmprecoreferencia.php");
	?>
    </center>
	</td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($excluir)){
  if($clprecoreferencia->erro_status=="0"){
    $clprecoreferencia->erro(true,false);
  }else{
    $clprecoreferencia->erro(true,true);
  }
}
if($db_opcao==33){
  if($clpcproc->numrows > 0){
    echo "<script>alert('Existe licitação vinculada a esse Preço de Referência');</script>";
  }
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
