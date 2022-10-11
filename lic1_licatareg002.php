<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licatareg_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cllicatareg = new cl_licatareg;
$clliclicita= new cl_liclicita;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $cllicatareg->alterar($oid);
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $cllicatareg->sql_record($cllicatareg->sql_query_file(null,"*",null,"l221_sequencial = ".$chavepesquisa)); 
   db_fieldsmemory($result,0);
   $l221_numata = $l221_numata.'/'.$l221_exercicio;
   $db_botao = true;
   $rsObjeto = $clliclicita->sql_record($clliclicita->sql_query_file($l221_licitacao,"l20_objeto"));
   db_fieldsmemory($rsObjeto,0);
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
	<?
	include("forms/db_frmlicatareg.php");
	?>
    </center>


</body>
</html>
<?
if(isset($alterar)){
  if($cllicatareg->erro_status=="0"){
    $cllicatareg->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cllicatareg->erro_campo!=""){
      echo "<script> document.form1.".$cllicatareg->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cllicatareg->erro_campo.".focus();</script>";
    }
  }else{
    $cllicatareg->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","l221_licitacao",true,1,"l221_licitacao",true);
</script>
