<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_conciliacao_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_tipopendencia_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clconciliacao = new cl_conciliacao;
$cltipopendencia = new cl_tipopendencia;
$db_botao = false;
$db_opcao = 22;

if(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $abre_pesquisa=false;

  if($tipopendencia=="true"){
  			$cltipopendencia->alterar($k202_sequencial);
  }else{
	 	 	$clconciliacao->alterar($k199_sequencial);
	   }

  if ($clconciliacao->erro_status == '0') {

  	}
  	else if($tipopendencia!="true"){
		  echo "<script>CurrentWindow.corpo.iframe_db_insertconciliacao.location.href='cai4_carregaconciliacaomanu007.php?k199_codconta=+{$clconciliacao->k199_codconta}+&db83_descricao=+{$db83_descricao}+&k199_periodoini=+{$k199_periodoini}+&k199_periodofinal=+{$k199_periodofinal}+&k199_saldofinalextrato=+{$clconciliacao->k199_saldofinalextrato}+&k199_sequencial=+{$clconciliacao->k199_sequencial}+&alterou=true';</script>";
  		 db_fim_transacao();
  	} //testefalsevamosfalse
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $abre_pesquisa=false;
      if($tipopendencia=="true"){ echo $k202_data;
	   $result = $cltipopendencia->sql_record($cltipopendencia->sql_query($chavepesquisa));
	  }else{
	  	$result = $clconciliacao->sql_record($clconciliacao->sql_query($chavepesquisa));
	  }
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

    <center>
	<?
	include("forms/db_frmconciliacao.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){
  if($clconciliacao->erro_status=="0" || $cltipopendencia->erro_status=="0"){
    $clconciliacao->erro(true,false);
    $cltipopendencia->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clconciliacao->erro_campo!="" ||  $cltipopendencia->erro_campo!=""){
      echo "<script> document.form1.".$clconciliacao->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clconciliacao->erro_campo.".focus();</script>";

      echo "<script> document.form1.".$cltipopendencia->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cltipopendencia->erro_campo.".focus();</script>";
    }
  }else{
    $clconciliacao->erro(true,true);
    $cltipopendencia->erro(true,true);
  }
}
/*if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}*/
?>
<script>
js_tabulacaoforms("form1","k199_periodofinal",true,1,"k199_periodofinal",true);
</script>
