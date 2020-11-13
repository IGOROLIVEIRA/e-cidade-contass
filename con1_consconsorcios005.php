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
  /*
$clconsvalorestransf = new cl_consvalorestransf;
$clconsexecucaoorc = new cl_consexecucaoorc;
$clconsdispcaixaano = new cl_consdispcaixaano;
$clconsretiradaexclusao = new cl_consretiradaexclusao;
  */
db_postmemory($HTTP_POST_VARS);
$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
    $sqlerro=false;
    db_inicio_transacao();
    $result_dtcadcgm = db_query("select z09_datacadastro from historicocgm where z09_numcgm = {$c200_numcgm} and z09_tipo = 1");
    db_fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;
    $z09_datacadastro = (implode("/",(array_reverse(explode("-",$z09_datacadastro)))));

    $dtcadastrocgm = DateTime::createFromFormat('d/m/Y', $z09_datacadastro);
    $dtcadastroadesao =   DateTime::createFromFormat('d/m/Y', $c200_dataadesao);

    if($dtcadastroadesao < $dtcadastrocgm){
        $erro_msg = "Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!";
        $sqlerro = true;
    }
    if($sqlerro==false) {
        $clconsconsorcios->c200_instit = db_getsession("DB_instit");
        $clconsconsorcios->alterar($c200_sequencial);
        $erro_msg = $clconsconsorcios->erro_msg;
    }
    db_fim_transacao($sqlerro);
    $db_opcao = 2;
    $db_botao = true;
}else if(isset($chavepesquisa)){
    $db_opcao = 2;
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
if(isset($alterar)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clconsconsorcios->erro_campo!=""){
      echo "<script> document.form1.".$clconsconsorcios->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clconsconsorcios->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
  }
}
if(isset($chavepesquisa)){
 echo "
  <script>
      function js_db_libera(){
         parent.document.formaba.consvalorestransf.disabled=false;
         top.corpo.iframe_consvalorestransf.location.href='con1_consvalorestransf001.php?c201_consconsorcios=".@$c200_sequencial."';
         parent.document.formaba.consexecucaoorc.disabled=false;
         top.corpo.iframe_consexecucaoorc.location.href='con1_consexecucaoorc001.php?c202_consconsorcios=".@$c200_sequencial."';
         parent.document.formaba.consdispcaixaano.disabled=false;
         top.corpo.iframe_consdispcaixaano.location.href='con1_consdispcaixaano001.php?c203_consconsorcios=".@$c200_sequencial."';
         parent.document.formaba.consretiradaexclusao.disabled=false;
         top.corpo.iframe_consretiradaexclusao.location.href='con1_consretiradaexclusao001.php?c204_consconsorcios=".@$c200_sequencial."';
         parent.document.formaba.consmesreferencia.disabled=false;
         top.corpo.iframe_consmesreferencia.location.href='con1_consmesreferencia001.php?db_opcao=2&c202_consconsorcios=".@$c200_sequencial."';
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
