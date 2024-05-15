<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_rhlota_classe.php");
include("classes/db_rhlotavinc_classe.php");
include("classes/db_orcprojativ_classe.php");
include("classes/db_orctiporec_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clrhlota = new cl_rhlota;
$clrhlotavinc = new cl_rhlotavinc;
$clorcprojativ = new cl_orcprojativ;
$clorctiporec = new cl_orctiporec;
$db_opcao = 1;
$opcoesae = 1;
$db_botao = true;

if(isset($opcao) && $opcao=="alterar"){
  $db_opcao = 2;
  $db_botao = false;
}else if(isset($opcao) && $opcao=="excluir"){
  $db_opcao = 3;
  $db_botao = false;
}else if(isset($db_opcaoal)){
  if($db_opcaoal=="false"){
    $db_opcao = 3;
    $opcoesae = 4;
    $db_botao = false;
  }
}

if(isset($incluir)){
  $sqlerro = false;
  db_inicio_transacao();
  $clrhlotavinc->rh25_codigo  = $rh25_codigo;
  $clrhlotavinc->rh25_projativ= $rh25_projativ;
  $clrhlotavinc->rh25_vinculo = $rh25_vinculo;
  $clrhlotavinc->rh25_anousu  = $rh25_anousu;
  $clrhlotavinc->rh25_recurso = $rh25_recurso;
  $clrhlotavinc->incluir(null);
  $erro_msg = $clrhlotavinc->erro_msg;
  if($clrhlotavinc->erro_status==0){
    $sqlerro=true;
  }
  db_fim_transacao($sqlerro);
}else if(isset($alterar)){
  $sqlerro = false;
  db_inicio_transacao();
  $clrhlotavinc->rh25_codlotavinc = $rh25_codlotavinc;
  $clrhlotavinc->rh25_codigo  = $rh25_codigo;
  $clrhlotavinc->rh25_projativ= $rh25_projativ;
  $clrhlotavinc->rh25_vinculo = $rh25_vinculo;
  $clrhlotavinc->rh25_anousu  = $rh25_anousu;
  $clrhlotavinc->rh25_recurso = $rh25_recurso;
  $clrhlotavinc->alterar($rh25_codlotavinc);
  $erro_msg = $clrhlotavinc->erro_msg;
  if($clrhlotavinc->erro_status==0){
    $sqlerro=true;
  }
  db_fim_transacao($sqlerro);
}else if(isset($excluir)){
  $sqlerro = false;
  db_inicio_transacao();
  $clrhlotavinc->excluir($rh25_codlotavinc);
  $erro_msg = $clrhlotavinc->erro_msg;
  if($clrhlotavinc->erro_status==0){
    $sqlerro=true;
  }
  db_fim_transacao($sqlerro);
}else if(isset($opcao)){
   $result = $clrhlotavinc->sql_record($clrhlotavinc->sql_query($rh25_codlotavinc));
   if($clrhlotavinc->numrows>0){
     $db_botao = true;
     if(!isset($incluirnovo)){
       db_fieldsmemory($result,0);
     }
   }
}else if(isset($chavepesquisa)){
  $result_descr = $clrhlota->sql_record($clrhlota->sql_query_file($chavepesquisa,"r70_codigo as rh25_codigo,r70_descr as rh25_descr"));
  if($clrhlota->numrows>0){
    db_fieldsmemory($result_descr,0);
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.form1.rh25_projativ.focus();" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmrhlotavinc.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar) || isset($excluir) || isset($incluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clrhlotavinc->erro_campo!=""){
      echo "<script> document.form1.".$clrhlotavinc->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clrhlotavinc->erro_campo.".focus();</script>";
    }
  }else{
    echo "<script> js_cancelar(); </script>";
  }
}
?>
