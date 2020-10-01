<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_convdetalhaconcedentes_classe.php");
include("classes/db_convconvenios_classe.php");
include("dbforms/db_funcoes.php");
require_once("classes/db_cgm_classe.php");
$clcgm = new cl_cgm;
$clcgm->rotulo->label();
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clconvdetalhaconcedentes = new cl_convdetalhaconcedentes;
$clconvconvenios = new cl_convconvenios;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
  /*
$clconvdetalhaconcedentes->c207_sequencial = $c207_sequencial;
$clconvdetalhaconcedentes->c207_nrodocumento = $c207_nrodocumento;
$clconvdetalhaconcedentes->c207_esferaconcedente = $c207_esferaconcedente;
$clconvdetalhaconcedentes->c207_valorconcedido = $c207_valorconcedido;
$clconvdetalhaconcedentes->c207_codconvenio = $c207_codconvenio;
  */
}
if(isset($incluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    if ($c207_esferaconcedente != 4 && empty($c207_nrodocumento)) {
      $erro_msg = "Campo Número do Documento é obrigatório!";
      $sqlerro=true;
    }
    if ($c207_esferaconcedente == 4 && empty($c207_descrconcedente)) {
      $erro_msg = "Campo Descrição do Concedente é obrigatório!";
      $sqlerro=true;
    }

    $result_convenio = $clconvconvenios->sql_record($clconvconvenios->sql_query_file($c207_codconvenio));
    db_fieldsmemory($result_convenio,0)->c206_datacadastro;

    $result_dtcadcgm = db_query("select z09_datacadastro from historicocgm inner join cgm on z01_numcgm = z09_numcgm where z01_cgccpf = '{$c207_nrodocumento}'order by z09_sequencial desc");
    db_fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;

    if($c206_datacadastro < $z09_datacadastro){
        $erro_msg = "Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!";
        $sqlerro = true;
    }

    if ($sqlerro==false) {
      $clconvdetalhaconcedentes->incluir($c207_sequencial);
      $erro_msg = $clconvdetalhaconcedentes->erro_msg;
      if($clconvdetalhaconcedentes->erro_status==0){
        $sqlerro=true;
      }
    }

    db_fim_transacao($sqlerro);
  }
}else if(isset($alterar)){
    db_inicio_transacao();
    $result_convenio = $clconvconvenios->sql_record($clconvconvenios->sql_query_file($c207_codconvenio));
    db_fieldsmemory($result_convenio,0)->c206_datacadastro;

    $result_dtcadcgm = db_query("select z09_datacadastro from historicocgm inner join cgm on z01_numcgm = z09_numcgm where z01_cgccpf = '{$c207_nrodocumento}'order by z09_sequencial desc");
    db_fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;

    if($c206_datacadastro < $z09_datacadastro){
       $erro_msg = "Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!";
       $sqlerro = true;
    }

    if($sqlerro==false){

        $clconvdetalhaconcedentes->alterar($c207_sequencial);
        $erro_msg = $clconvdetalhaconcedentes->erro_msg;
        if($clconvdetalhaconcedentes->erro_status==0){
            $sqlerro=true;
        }
    }
    db_fim_transacao($sqlerro);
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconvdetalhaconcedentes->excluir($c207_sequencial);
    $erro_msg = $clconvdetalhaconcedentes->erro_msg;
    if($clconvdetalhaconcedentes->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
   $result = $clconvdetalhaconcedentes->sql_record($clconvdetalhaconcedentes->sql_query($c207_sequencial));
   if($result!=false && $clconvdetalhaconcedentes->numrows>0){
     db_fieldsmemory($result,0);
   }
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
  #c207_esferaconcedente {
    width: 111px;
  }
  #c207_descrconcedente {
    background-color:#fff !important;
  }
  #descrconcedente {
    display: none;
  }
</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
    	<?php
    	 include("forms/db_frmconvdetalhaconcedentes.php");
    	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar) || isset($excluir) || isset($incluir)){
    db_msgbox($erro_msg);
    if($clconvdetalhaconcedentes->erro_campo!=""){
        echo "<script> document.form1.".$clconvdetalhaconcedentes->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clconvdetalhaconcedentes->erro_campo.".focus();</script>";
    }
}
?>
