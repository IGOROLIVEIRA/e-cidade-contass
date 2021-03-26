<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_licpregao_classe.php");
include("classes/db_licpregaocgm_classe.php");
$cllicpregao = new cl_licpregao;
  /*
$cllicpregaocgm = new cl_licpregaocgm;
  */
db_postmemory($HTTP_POST_VARS);
   $db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  $sqlerro=false;
  db_inicio_transacao();
  $cllicpregao->alterar($l45_sequencial);
  if($cllicpregao->erro_status==0){
    $sqlerro=true;
  }
  $erro_msg = $cllicpregao->erro_msg;
  db_fim_transacao($sqlerro);
   $db_opcao = 2;
   $db_botao = true;
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $db_botao = true;
   $result = $cllicpregao->sql_record($cllicpregao->sql_query($chavepesquisa));
   db_fieldsmemory($result,0);
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
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmlicpregao.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($cllicpregao->erro_campo!=""){
      echo "<script> document.form1.".$cllicpregao->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cllicpregao->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
  }
}
if(isset($chavepesquisa)){
 echo "
  <script>
      function js_db_libera(){
         parent.document.formaba.licpregaocgm.disabled=false;
         CurrentWindow.corpo.iframe_licpregaocgm.location.href='lic1_licpregaocgm001.php?l46_licpregao=".@$l45_sequencial."';
     ";
         if(isset($liberaaba)){
           echo "  parent.mo_camada('licpregaocgm');";
         }
 echo"}\n
    js_db_libera();
  </script>\n
 ";
}
 if($db_opcao==22||$db_opcao==33){
    echo "<script>document.form1.pesquisar.click();</script>";
 }
?>
