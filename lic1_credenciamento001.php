<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_credenciamento_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clhomologacaoadjudica  = new cl_homologacaoadjudica;
$clpcorcamforne         = new cl_pcorcamforne;
$clcredenciamento       = new cl_credenciamento;
$clliclicitem           = new cl_liclicitem;
$clcgm                  = new cl_cgm;

$db_opcao = 1;
$db_botao = true;

if(isset($incluir)){
  db_inicio_transacao();
  $l205_itens = explode(',', $l205_itens[0]);
  foreach ($l205_itens as $item) {
    $clcredenciamento->l205_item                = $item;
    $clcredenciamento->incluir(null);
    if ($clcredenciamento->erro_status == 0) {
      $sqlerro = true;
			$erro_msg = $clcredenciamento->erro_msg;
			break;
		}  
  }
  db_fim_transacao();

}
if(isset($excluir)){  
  //$db_opcao = 3;
  db_inicio_transacao();
  $l205_itens = explode(',', $l205_itens[0]);
  foreach ($l205_itens as $item) {
    $clcredenciamento->excluir(null,"l205_fornecedor = $l205_fornecedor");
    if ($clcredenciamento->erro_status == 0) {
      $sqlerro = true;
			$erro_msg = $clcredenciamento->erro_msg;
			break;
		}
		$erro_msg = $clcredenciamento->erro_msg;
  }
  db_fim_transacao();
}
if(isset($chavepesquisa)) {

   $db_opcao = 3;
   $result = $clcredenciamento->sql_record($clcredenciamento->sql_query('','*','',"l205_fornecedor = $chavepesquisa"));
   db_fieldsmemory($result,0);

   $sCampos  = " distinct l20_codigo";
   $sWhere   = "pc81_codprocitem = {$l205_item} ";
   // die($clliclicitem->sql_query_inf(null, $sCampos, $sOrdem, $sWhere));
   $result2 = $clcredenciamento->sql_record($clliclicitem->sql_query_inf(null, $sCampos,'',$sWhere));  
   db_fieldsmemory($result2,0);
   unset($l205_sequencial);
   $db_botao = true;

}
if(isset($pc20_codorc) && !empty($pc20_codorc) && !isset($chavepesquisa)) {
   $sWhere  = "1!=1";
   $sWhere  = "pc21_codorc=".@$pc20_codorc;
   $result_forn = $clpcorcamforne->sql_record($clpcorcamforne->sql_query(null,"pc21_numcgm,z01_nome","",$sWhere));

   $result  = $clcredenciamento->sql_record($clcredenciamento->sql_query('','*','',"l205_fornecedor = $l205_fornecedor"));
   db_fieldsmemory($result,0);

   $result2 =  $clcgm->sql_record($clcgm->sql_query('','*','',"z01_numcgm = $l205_fornecedor"));
   $l205_inscriestadual = db_utils::fieldsMemory($result2, 0)->z01_incest;
   unset($l205_sequencial);
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
  
	<?
	include("forms/db_frmcredenciamento.php");
	?>
  
</html>
<script>
js_tabulacaoforms("form1","l205_fornecedor",true,1,"l205_fornecedor",true);
</script>
<?
if(isset($incluir)){
  if($clcredenciamento->erro_status=="0"){
    db_msgbox($erro_msg);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clcredenciamento->erro_campo!=""){
      echo "<script> document.form1.".$clcredenciamento->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clcredenciamento->erro_campo.".focus();</script>";
    }
  }else{
    //$clcredenciamento->erro(true,true);
  }
}

if(isset($excluir)){
  if($clcredenciamento->erro_status=="0"){
    db_msgbox($erro_msg);
  }
}
?>
