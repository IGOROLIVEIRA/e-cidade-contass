<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_mtfis_ldo_classe.php");
include("classes/db_mtfis_anexo_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clmtfis_ldo = new cl_mtfis_ldo;
$clmtfis_anexo = new cl_mtfis_anexo;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){

  $db_opcao = 2;
  //echo $mtfis_anoinicialldo;
  $clmtfis_ldo->sql_record($clmtfis_ldo->sql_query(null,'*','',"mtfis_anoinicialldo = $mtfis_anoinicialldo "));
  if($clmtfis_ldo->numrows > 0){
      echo "<script> alert('Já existe registro para este ano'); </script>";
      $db_opcao = 1;
      echo "<script>
      top.corpo.iframe_db_anexo.location.href='orc1_mtfis_ldo001.php';
      </script>";
  }else {
      db_inicio_transacao();
      $clmtfis_ldo->mtfis_instit = db_getsession("DB_instit");
      $clmtfis_ldo->incluir($mtfis_sequencial);

      db_fim_transacao();

      $sSql = "select * from mtfis_ldo order by mtfis_sequencial desc limit 1;";
      $rsResult = pg_query($sSql);
      db_fieldsmemory($rsResult, 0);

      $result = $clmtfis_ldo->sql_record($clmtfis_ldo->sql_query($mtfis_sequencial));
      db_fieldsmemory($result, 0);
      $db_botao = true;

      if ($clmtfis_ldo->erro_campo == "") {
          echo "<script> alert('Incluído com sucesso'); </script>";

          echo "<script>
      top.corpo.iframe_db_anexo.location.href='orc1_mtfis_anexo001.php?mtfisanexo_ldo=" . $mtfis_sequencial . "&mtfis_anoinicialldo=" . $mtfis_anoinicialldo . "';
      parent.document.formaba.db_anexo.disabled=false;
      parent.mo_camada('db_anexo');
      </script>";
      } else {
          $clmtfis_ldo->erro(true, true);
      }
  }
}elseif(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $clmtfis_ldo->alterar($mtfis_sequencial);
  $rsResult = pg_query($sSql);
  db_fieldsmemory($rsResult,0);

  echo "<script>
  parent.document.formaba.db_anexo.disabled=false;
  parent.mo_camada('db_anexo');
  </script>";
  db_fim_transacao();
}elseif(isset($excluir)){
  db_inicio_transacao();
  $db_opcao = 3;
  $clmtfis_anexo->excluir(null, "mtfisanexo_ldo = $mtfis_sequencial");
  $clmtfis_ldo->excluir($mtfis_sequencial);
  db_fim_transacao();
}elseif(isset($chavepesquisa)){
  $db_opcao = 2;
  $result = $clmtfis_ldo->sql_record($clmtfis_ldo->sql_query($chavepesquisa));
  db_fieldsmemory($result,0);
  $db_botao = true;

  echo "<script>
    top.corpo.iframe_db_anexo.location.href='orc1_mtfis_anexo001.php?mtfisanexo_ldo=".$chavepesquisa."&mtfis_anoinicialldo=".$mtfis_anoinicialldo."';
    parent.document.formaba.db_anexo.disabled=false;
    //parent.mo_camada('db_anexo');
  </script>";
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
	include("forms/db_frmmtfis_ldo.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($excluir)){
  if($clmtfis_ldo->erro_status=="0"){
    $clmtfis_ldo->erro(true,false);
  }else{
    $clmtfis_ldo->erro(true,true);
  }
}
if($db_opcao==3){
  echo "<script>document.form1.pesquisar.click();</script>";
}

?>
