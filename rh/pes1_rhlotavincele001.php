<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_rhlota_classe.php");
include("classes/db_rhlotavinc_classe.php");
include("classes/db_rhlotavincativ_classe.php");
include("classes/db_rhlotavincele_classe.php");
include("classes/db_rhelementoemp_classe.php");
include("classes/db_orcprojativ_classe.php");
include("classes/db_orcelemento_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);
$clrhlota = new cl_rhlota;
$clrhlotavinc = new cl_rhlotavinc;
$clrhlotavincativ = new cl_rhlotavincativ;
$clrhlotavincele = new cl_rhlotavincele;
$clrhelementoemp = new cl_rhelementoemp;
$clorcprojativ = new cl_orcprojativ;
$clorcelemento = new cl_orcelemento;
$db_opcao = 1;
$opcoesae = 3;
$db_botao = true;
if(!isset($default)){
  $default = "";
}

if(isset($opcao) && $opcao=="alterar"){
  $db_opcao = 2;
  $db_botao = false;
}else if(isset($opcao) && $opcao=="excluir"){
  $db_opcao = 3;
  $db_botao = false;
}else if(isset($db_opcaoal)){
  if($db_opcaoal=="false"){
    $db_opcao = 3;
    $opcoesae = 3;
    $db_botao = false;
  }
}
$limpachavee1 = false;
$limpachave2e3 = false;
if(isset($incluir)){
  $sqlerro = false;
  db_inicio_transacao();
  $clrhlotavincele->rh28_codelenov   = $rh28_codelenov;
  $clrhlotavincele->incluir($rh25_codlotavinc,$rh28_codeledef);
  $erro_msg = $clrhlotavincele->erro_msg;
  if($clrhlotavincele->erro_status==0){
    $sqlerro=true;
  }
  if($sqlerro==false && trim($rh39_projativ)!=""){
    $clrhlotavincativ->rh39_anousu      = $rh39_anousu;
    $clrhlotavincativ->rh39_projativ    = $rh39_projativ;
    $clrhlotavincativ->incluir($rh25_codlotavinc,$rh28_codelenov);
    if($clrhlotavincativ->erro_status==0){
      $erro_msg = $clrhlotavincativ->erro_msg;
      $sqlerro=true;
    }
  }
  db_fim_transacao($sqlerro);
}else if(isset($excluir)){
  $sqlerro = false;
  db_inicio_transacao();
  if($sqlerro==false){
    $clrhlotavincativ->excluir($rh25_codlotavinc,$rh28_codelenov);
    $erro_msg = $clrhlotavincativ->erro_msg;
    if($clrhlotavincativ->erro_status==0){
      $sqlerro=true;
    }
  }

  if($sqlerro==false){
    $clrhlotavincele->excluir($rh25_codlotavinc,$rh28_codeledef);
    $erro_msg1 = $clrhlotavincele->erro_msg;
    if($clrhlotavincele->erro_status==0){
      $sqlerro=true;
    }
  }

  db_fim_transacao($sqlerro);
}else if(isset($opcao) && !isset($npass)){
  $result_descr = $clrhlota->sql_record($clrhlota->sql_query_file($rh25_codigo,"r70_codigo as rh25_codigo,r70_descr as rh25_descr"));
  if($clrhlota->numrows>0){
    db_fieldsmemory($result_descr,0);
  }
  if(isset($lotavinc)){
    $result_lotavinc = $clrhlotavinc->sql_record($clrhlotavinc->sql_query_file($rh25_codlotavinc,"rh25_codlotavinc"));
    if($clrhlotavinc->numrows>0){
      db_fieldsmemory($result_lotavinc,0);
    }
  }
  $result = $clrhlotavincele->sql_record($clrhlotavincele->sql_query_ele($rh28_codlotavinc,$rh28_codeledef,"rh39_projativ,rh39_anousu,o55_descr,rh28_codeledef,orcelemento.o56_descr as o56_descr,rh28_codelenov,a.o56_descr as o56_descrnov"));
  if($clrhlotavinc->numrows>0){
    $db_botao = true;
    db_fieldsmemory($result,0);
    $default = $rh28_codeledef;
  }
}else if(isset($lotacao)){
  if(isset($opcao) && $opcao=="alterar"){
    $db_botao = true;
  }
  $result_descr = $clrhlota->sql_record($clrhlota->sql_query_file($lotacao,"r70_codigo as rh25_codigo,r70_descr as rh25_descr"));
  if($clrhlota->numrows>0){
    db_fieldsmemory($result_descr,0);
  }
  if(isset($lotavinc)){
    $result_lotavinc = $clrhlotavinc->sql_record($clrhlotavinc->sql_query_file($lotavinc,"rh25_codlotavinc"));
    if($clrhlotavinc->numrows>0){
      db_fieldsmemory($result_lotavinc,0);
    }
  }
  if(isset($chave) && trim($chave)!="" && isset($chave1) && trim($chave1)!=""){
    //  echo "<BR><BR>".($clorcprojativ->sql_query_file($chave,$chave1,"o55_projativ as rh39_projativ,o55_anousu as rh39_anousu,o55_descr"));
    if($chave1!="true"){
      $result_projativ = $clorcprojativ->sql_record($clorcprojativ->sql_query_file($chave,$chave1,"o55_projativ as rh39_projativ,o55_anousu as rh39_anousu,o55_descr"));
      if($clorcprojativ->numrows>0){
	db_fieldsmemory($result_projativ,0);
      }
    }else{
      $rh39_projativ = "";
      $rh39_anousu   = "";
      $o55_descr = $chave;
    }
  }
  if(isset($chave2) && trim($chave2)!="" && isset($chave3) && trim($chave3)!=""){
    if($chave3!="true"){
      $result_elemento = $clorcelemento->sql_record($clorcelemento->sql_query_file($chave2,db_getsession("DB_anousu"),"o56_codele as rh28_codeledef,o56_descr"));
      if($clorcelemento->numrows >0){
	db_fieldsmemory($result_elemento,0);
      }
    }else{
      $rh28_codeledef = "";
      $o56_descr = $chave2;
    }
  }
  if(isset($chave4) && trim($chave4)!="" && isset($chave5) && trim($chave5)!=""){
    if($chave5!="true"){
      $result_elemento = $clorcelemento->sql_record($clorcelemento->sql_query_file($chave4,db_getsession("DB_anousu"),"o56_codele as rh28_codelenov,o56_descr as o56_descrnov"));
      if($clorcelemento->numrows >0){
	db_fieldsmemory($result_elemento,0);
      }
    }else{
      $rh28_codelenov = "";
      $o56_descrnov = $chave4;
    }
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="750" border="2" cellspacing="0" cellpadding="0">
  <tr>
    <td height="355" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmrhlotavincele.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar) || isset($excluir) || isset($incluir)){
  if(isset($alterar)){
    $erro_msg = str_replace("Inclusão","Alteração",$erro_msg);
    $erro_msg = str_replace("Inclusao","Alteração",$erro_msg);
  }
  if($sqlerro==true){
    db_msgbox($erro_msg);
  }
  echo "<script> location.href = 'pes1_rhlotavincele001.php?lotacao=$rh25_codigo&lotavinc=$rh25_codlotavinc';</script>";
}
if(isset($opcao)){
  echo "<script> CurrentWindow.corpo.iframe_rhlotavinc.document.form1.opcaoiframe.value = '$opcao'; </script>";
  if($opcao=="alterar" && trim($default)==""){
    echo "<script> CurrentWindow.corpo.iframe_rhlotavinc.document.form1.defaultifra.value = '$rh28_codeledef'; </script>";
  }
}else{
  echo "<script> CurrentWindow.corpo.iframe_rhlotavinc.document.form1.opcaoiframe.value = ''; </script>";
}
/*
if($limpachavee1==true){
  echo "<script> parent.document.form1.chave.value = '';</script>";
  echo "<script> parent.document.form1.chave1.value = '';</script>";
}
if($limpachave2e3==true){
  echo "<script> parent.document.form1.chave2.value = '';</script>";
  echo "<script> parent.document.form1.chave3.value = '';</script>";
}
*/
?>
