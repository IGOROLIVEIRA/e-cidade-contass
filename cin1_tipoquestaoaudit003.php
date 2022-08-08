<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_tipoquestaoaudit_classe.php");
include("classes/db_questaoaudit_classe.php");
include("classes/db_processoaudit_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cltipoquestaoaudit = new cl_tipoquestaoaudit;
$clquestaoaudit = new cl_questaoaudit;
$db_botao = false;
$db_opcao = 33;

if (isset($excluir)) {

	$sqlerro = false;

  	$clprocessoaudit  = new cl_processoaudit;
  	$sSqlProcAudit    = $clprocessoaudit->sql_query(null, "*", null, "ci03_codtipoquest = {$ci01_codtipo}");
  	$clprocessoaudit->sql_record($sSqlProcAudit);

  	if ($clprocessoaudit->numrows > 0) {

		$erro_msg 	= "Não é possível excluir questões de auditoria que estão vinculadas a processos de auditoria!";
		$sqlerro 	= true;

	}

	if (!$sqlerro) {

  		db_inicio_transacao();
  		$db_opcao = 3;

  		$clquestaoaudit->excluir(null, "ci02_codtipo = {$ci01_codtipo} AND ci02_instit = ".db_getsession('DB_instit'));

		if ( $clquestaoaudit->erro_status == 0 ){
    		$sqlerro = true;
    		$cltipoquestaoaudit->erro_status = 0;
  		}

		$erro_msg = $clquestaoaudit->erro_msg;

  		if (!$sqlerro) {

			$cltipoquestaoaudit->excluir($ci01_codtipo);

    		if ( $cltipoquestaoaudit->erro_status == 0 ) {
      			$sqlerro = true;
			}

    		$erro_msg = $cltipoquestaoaudit->erro_msg;
  		}

		db_fim_transacao($sqlerro);

	} else {
		$cltipoquestaoaudit->erro_status = 0;
	}

} else if (isset($chavepesquisa)) {

	$db_opcao = 3;
   	$result = $cltipoquestaoaudit->sql_record($cltipoquestaoaudit->sql_query($chavepesquisa));
   	db_fieldsmemory($result,0);
   	$db_botao = true;

   	$sSql = $clquestaoaudit->sql_query_file(null, "*", null, "ci02_codtipo = {$ci01_codtipo} AND ci02_instit = ".db_getsession('DB_instit'));
   	$clquestaoaudit->sql_record($sSql);
	$iNumQuestoesTipo = $clquestaoaudit->numrows;

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
if(isset($excluir)){
  if($cltipoquestaoaudit->erro_status=="0"){
    db_msgbox($erro_msg);
  }else{
    $cltipoquestaoaudit->erro(true,true);
  }
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}

if(isset($chavepesquisa)){
  echo "
    <script>
        function js_db_libera(){
          parent.document.formaba.questaoauditquestoes.disabled=false;
          CurrentWindow.corpo.iframe_questaoauditquestoes.location.href='cin1_questaoaudit004.php?db_opcaoal=33&ci01_codtipo=".@$ci01_codtipo."';
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
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>


