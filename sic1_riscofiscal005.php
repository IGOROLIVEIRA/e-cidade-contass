<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_riscofiscal_classe.php");
include("classes/db_riscoprovidencia_classe.php");
$clriscofiscal = new cl_riscofiscal;
  /*
$clriscoprovidencia = new cl_riscoprovidencia;
  */
db_postmemory($HTTP_POST_VARS);
   $db_opcao = 22;
$db_botao = false;
if (isset($alterar)){
	
	$sWhere 		= "si53_codriscofiscal = '{$si53_codriscofiscal}' AND si53_exercicio = '{$si53_exercicio}' AND si53_instit = ".db_getsession('DB_instit');
	$sSqlVerifica 	= $clriscofiscal->sql_query_file(null, "*", null, $sWhere);
	$rsVerifica	 	= db_query($sSqlVerifica);
	$iCodRisco 		= db_utils::fieldsMemory($rsVerifica, 0)->si53_codriscofiscal;
	
	if ( pg_num_rows($rsVerifica) > 0 && $iCodRisco != $si53_codriscofiscal ) {

		$erro_msg 	= "Já existe risco fiscal com o Código Risco para o exercício.";
		$sqlerro 	= true;

	} else {

		$sqlerro=false;
		db_inicio_transacao();
		$clriscofiscal->alterar($si53_sequencial);
		if($clriscofiscal->erro_status==0){
			$sqlerro=true;
		} 
		$erro_msg = $clriscofiscal->erro_msg; 
		db_fim_transacao($sqlerro);
		$db_opcao = 2;
		$db_botao = true;

	}
	   
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $db_botao = true;
   $result = $clriscofiscal->sql_record($clriscofiscal->sql_query($chavepesquisa)); 
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
	include("forms/db_frmriscofiscal.php");
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
    if($clriscofiscal->erro_campo!=""){
      echo "<script> document.form1.".$clriscofiscal->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clriscofiscal->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
  }
}
if(isset($chavepesquisa)){
 echo "
  <script>
      function js_db_libera(){
         parent.document.formaba.riscoprovidencia.disabled=false;
         top.corpo.iframe_riscoprovidencia.location.href='sic1_riscoprovidencia001.php?si54_seqriscofiscal=".@$si53_sequencial."';
     ";
         if(isset($liberaaba)){
           echo "  parent.mo_camada('riscoprovidencia');";
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
