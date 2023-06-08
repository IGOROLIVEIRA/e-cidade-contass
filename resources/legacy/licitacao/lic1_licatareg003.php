<?php
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
$cllicataregitem = new cl_licataregitem;
$db_botao = false;
$db_opcao = 33;
if(isset($excluir)){
  
    $rscllicataregitem = $cllicataregitem->sql_record("select * from licataregitem where l222_licatareg = $l221_sequencial");
    if(pg_num_rows($rscllicataregitem)>0){
      $db_opcao = 3;
      db_msgbox("Ata já possui itens vinculados!");
    }else{
      db_inicio_transacao();
      $db_opcao = 3;
      $cllicatareg->excluir($l221_sequencial);
      db_fim_transacao();
      db_msgbox("Excluido com Sucesso!");
    }
  
  
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
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
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>

    <center>
  <?php
	include("forms/db_frmlicatareg.php");
	?>
    </center>

<?php
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?php
if(isset($excluir)){
  echo "<script>document.form1.pesquisar.click();</script>";
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
