<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_consconsorcios_classe.php");
include("classes/db_consvalorestransf_classe.php");
include("classes/db_consexecucaoorc_classe.php");
include("classes/db_consdispcaixaano_classe.php");
include("classes/db_consretiradaexclusao_classe.php");
$clconsconsorcios = new cl_consconsorcios;
 
$clconsvalorestransf = new cl_consvalorestransf;
$clconsexecucaoorc = new cl_consexecucaoorc;
$clconsdispcaixaano = new cl_consdispcaixaano;
$clconsretiradaexclusao = new cl_consretiradaexclusao;
 
db_postmemory($HTTP_POST_VARS);
   $db_opcao = 33;
$db_botao = false;
if(isset($excluir)){
  $sqlerro=false;
  db_inicio_transacao();
  /*$clconsvalorestransf->c201_consconsorcios=$c200_sequencial;
  $clconsvalorestransf->excluir();

  if($clconsvalorestransf->erro_status==0){
    $sqlerro=true;
  } 
  $erro_msg = $clconsvalorestransf->erro_msg; 
  $clconsexecucaoorc->c202_consconsorcios=$c200_sequencial;
  $clconsexecucaoorc->excluir();

  if($clconsexecucaoorc->erro_status==0){
    $sqlerro=true;
  } 
  $erro_msg = $clconsexecucaoorc->erro_msg; 
  $clconsdispcaixaano->c203_consconsorcios=$c200_sequencial;
  $clconsdispcaixaano->excluir();

  if($clconsdispcaixaano->erro_status==0){
    $sqlerro=true;
  } 
  $erro_msg = $clconsdispcaixaano->erro_msg; 
  $clconsretiradaexclusao->c204_consconsorcios=$c200_sequencial;
  $clconsretiradaexclusao->excluir();

  if($clconsretiradaexclusao->erro_status==0){
    $sqlerro=true;
  } 
  $erro_msg = $clconsretiradaexclusao->erro_msg; 
  $clconsconsorcios->excluir($c200_sequencial);
  if($clconsconsorcios->erro_status==0){
    $sqlerro=true;
  } 
  */
  $clconsconsorcios->excluir($c200_sequencial);
  $erro_msg = $clconsconsorcios->erro_msg;
  if($clconsconsorcios->erro_status==0){
    $sqlerro=true;
    $erro_msg = $clconsconsorcios->erro_msg;
    if (eregi("ainda é referenciada", $clconsconsorcios->erro_msg)) {
      $erro_msg = " Existem Registros Vinculados a esse Cadastro nas abas Seguintes!";
    } else {
    	$erro_msg = $clconsconsorcios->erro_msg;
    }
  } 
   
  db_fim_transacao($sqlerro);
   $db_opcao = 3;
   $db_botao = true;
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $db_botao = true;
   $result = $clconsconsorcios->sql_record($clconsconsorcios->sql_query($chavepesquisa)); 
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
	include("forms/db_frmconsconsorcios.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($excluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clconsconsorcios->erro_campo!=""){
      echo "<script> document.form1.".$clconsconsorcios->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clconsconsorcios->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
 echo "
  <script>
    function js_db_tranca(){
      parent.location.href='con1_consconsorcios003.php';
    }\n
    js_db_tranca();
  </script>\n
 ";
  }
}
if(isset($chavepesquisa)){
 echo "
  <script>
      function js_db_libera(){
         parent.document.formaba.consvalorestransf.disabled=false;
         top.corpo.iframe_consvalorestransf.location.href='con1_consvalorestransf001.php?db_opcaoal=33&c201_consconsorcios=".@$c200_sequencial."';
         parent.document.formaba.consexecucaoorc.disabled=false;
         top.corpo.iframe_consexecucaoorc.location.href='con1_consexecucaoorc001.php?db_opcaoal=33&c202_consconsorcios=".@$c200_sequencial."';
         parent.document.formaba.consdispcaixaano.disabled=false;
         top.corpo.iframe_consdispcaixaano.location.href='con1_consdispcaixaano001.php?db_opcaoal=33&c203_consconsorcios=".@$c200_sequencial."';
         parent.document.formaba.consretiradaexclusao.disabled=false;
         top.corpo.iframe_consretiradaexclusao.location.href='con1_consretiradaexclusao001.php?db_opcaoal=33&c204_consconsorcios=".@$c200_sequencial."';
         parent.document.formaba.consmesreferencia.disabled=false;
         top.corpo.iframe_consmesreferencia.location.href='con1_consmesreferencia001.php?db_opcao=3&c202_consconsorcios=".@$c200_sequencial."';
     ";
         if(isset($liberaaba)){
           echo "  parent.mo_camada('consvalorestransf');";
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
