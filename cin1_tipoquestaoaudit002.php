<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_tipoquestaoaudit_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cltipoquestaoaudit = new cl_tipoquestaoaudit;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $cltipoquestaoaudit->alterar($ci01_codtipo);
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $cltipoquestaoaudit->sql_record($cltipoquestaoaudit->sql_query($chavepesquisa)); 
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
<table width="390" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmtipoquestaoaudit.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){
  if($cltipoquestaoaudit->erro_status=="0"){
    $cltipoquestaoaudit->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cltipoquestaoaudit->erro_campo!=""){
      echo "<script> document.form1.".$cltipoquestaoaudit->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cltipoquestaoaudit->erro_campo.".focus();</script>";
    }
  }else{
    $cltipoquestaoaudit->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}

if(isset($chavepesquisa)){
  echo "
    <script>
        function js_db_libera(){
          parent.document.formaba.questaoauditquestoes.disabled=false;
          top.corpo.iframe_questaoauditquestoes.location.href='cin1_questaoaudit004.php?ci01_codtipo=".@$ci01_codtipo."';
      ";
          if(isset($liberaaba)){
            echo "  parent.mo_camada('questaoauditquestoes');";
          }
  echo"}\n
      js_db_libera();
    </script>\n
  ";
}
?>