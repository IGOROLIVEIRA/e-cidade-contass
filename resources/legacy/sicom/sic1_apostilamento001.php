<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_apostilamento_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_contratos_classe.php");
$clcontratos = new cl_contratos;
db_postmemory($HTTP_POST_VARS);
$clapostilamento = new cl_apostilamento;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
	$aNrocontrato      = explode('/', $nrocontrato);
  $nrocontrato      = $aNrocontrato[0];
  $anocontrato      = $aNrocontrato[1];
  $result           = $clcontratos->sql_record($clcontratos->sql_query_novo(null,"si172_sequencial, si172_nrocontrato, si172_dataassinatura",null,"si172_nrocontrato = $nrocontrato and si172_exerciciocontrato = $anocontrato"));
  $clapostilamento->si03_numcontrato = db_utils::fieldsMemory($result, 0)->si172_sequencial;
  db_inicio_transacao();
  $clapostilamento->incluir($si03_sequencial);
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
<script>
js_tabulacaoforms("form1","si03_licitacao",true,1,"si03_licitacao",true);
</script>
<?
if(isset($incluir)){
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
?>
