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
$db_opcao = 1;
$db_botao = true;
$sqlerro  = false;
if(isset($incluir)){
    db_inicio_transacao();
    $clconsconsorcios->c200_instit = db_getsession("DB_instit");
    if($clconsconsorcios->valida_inclusao_consorcio($c200_numcgm)) {

        $result_dtcadcgm = db_query("select z09_datacadastro from historicocgm where z09_numcgm = {$c200_numcgm} order by z09_sequencial desc");
        db_fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;
        $z09_datacadastro = (implode("/",(array_reverse(explode("-",$z09_datacadastro)))));

        $dtcadastrocgm = DateTime::createFromFormat('d/m/Y', $z09_datacadastro);
        $dtcadastroadesao =   DateTime::createFromFormat('d/m/Y', $c200_dataadesao);

        if($dtcadastroadesao < $dtcadastrocgm){
            $erro_msg = "Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!";
            $sqlerro = true;
        }
        if($sqlerro==false){
            $clconsconsorcios->incluir($c200_sequencial);
        }
    } else {
        $clconsconsorcios->erro_status=0;
        $clconsconsorcios->erro_msg = "CNPJ já incluso";
    }
    if($clconsconsorcios->erro_status==0){
        $sqlerro=true;
    }
    $erro_msg = $clconsconsorcios->erro_msg;
    db_fim_transacao($sqlerro);
    $c200_sequencial= $clconsconsorcios->c200_sequencial;
    $db_opcao = 1;
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
if(isset($incluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clconsconsorcios->erro_campo!=""){
      echo "<script> document.form1.".$clconsconsorcios->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clconsconsorcios->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
   db_redireciona("con1_consconsorcios005.php?liberaaba=true&chavepesquisa=$c200_sequencial");
  }
}
?>
