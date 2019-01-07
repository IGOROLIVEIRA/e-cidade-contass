<?
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_parecerlicitacao_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clparecerlicitacao = new cl_parecerlicitacao;
$pctipocompra = new cl_pctipocompra();
$db_opcao = 1;
$db_botao = true;

if($_POST['json']){
    $oLicitacao = str_replace('\\','',$_POST);
    $oLicitacao = json_decode($oLicitacao['json']);
    $sqlDescricao = $pctipocompra->sql_buscaDescricao(""," DISTINCT pc50_descr, l20_anousu, l20_codigo ", " l20_anousu DESC ",
        " l20_edital = $oLicitacao->edital ",'1');
    $sqlNumber = db_query($sqlDescricao);
	$descricao = db_utils::fieldsMemory($sqlNumber, 0);
	$valores = array();
	$valores[] = utf8_encode($descricao->pc50_descr);
	$valores[] = $descricao->l20_codigo;
	echo json_encode($valores);
    die();
}


if(isset($incluir)){
  $sql = db_query("select z01_cgccpf as cpf from cgm where z01_numcgm = $l200_numcgm");
  $cgm = db_utils::fieldsMemory($sql, 0)->cpf;
  if(strlen($cgm) <= 11){
	  db_inicio_transacao();
	  $clparecerlicitacao->incluir($l200_sequencial);
	  db_fim_transacao();
  }else {
      echo "<script>alert('O CGM selecionado deverá ser de Pessoa Física.');</script>";
  }
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
  <fieldset style=" margin-top: 30px; width: 500px; height: 182px;">
  <legend>Parecer da Licita&ccedil;&atilde;o</legend>
	<?
	include("forms/db_frmparecerlicitacao.php");
	?>
  </fieldset>
  </center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","l200_licitacao",true,1,"l200_licitacao",true);
</script>
<?
if(isset($incluir)){
  if($clparecerlicitacao->erro_status=="0"){
    $clparecerlicitacao->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clparecerlicitacao->erro_campo!=""){
      echo "<script> document.form1.".$clparecerlicitacao->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clparecerlicitacao->erro_campo.".focus();</script>";
    }
  }else{
    $clparecerlicitacao->erro(true,true);
  }
}
?>
