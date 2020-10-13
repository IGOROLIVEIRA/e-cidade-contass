<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licpregaocgm_classe.php");
include("classes/db_licpregao_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cllicpregaocgm = new cl_licpregaocgm;
$cllicpregao = new cl_licpregao;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
  /*
$cllicpregaocgm->l46_sequencial = $l46_sequencial;
$cllicpregaocgm->l46_tipo = $l46_tipo;
$cllicpregaocgm->l46_numcgm = $l46_numcgm;
$cllicpregaocgm->l46_comissao = $l46_comissao;
  */
}
if(isset($incluir)){
    if($sqlerro==false){
        $result_comissao = $cllicpregao->sql_record($cllicpregao->sql_query($l46_licpregao));
        db_fieldsmemory($result_comissao, 0);

        $result_dtcadcgm = db_query("select z09_datacadastro from historicocgm where z09_numcgm = {$l46_numcgm} order by z09_sequencial desc");
        db_fieldsmemory($result_dtcadcgm, 0)->z09_datacadastro;

        if($l45_data < $z09_datacadastro){
            $erro_msg = "Usuário: A data de cadastro do CGM informado é superior a data do procedimento que está sendo realizado. Corrija a data de cadastro do CGM e tente novamente!";
            $sqlerro = true;
        }

    }
    if($sqlerro==false){
        db_inicio_transacao();
        $cllicpregaocgm->incluir($l46_sequencial);
        $erro_msg = $cllicpregaocgm->erro_msg;
        if($cllicpregaocgm->erro_status==0){
            $sqlerro=true;
        }
        db_fim_transacao($sqlerro);
    }
}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $cllicpregaocgm->alterar($l46_sequencial);
    $erro_msg = $cllicpregaocgm->erro_msg;
    if($cllicpregaocgm->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $cllicpregaocgm->excluir($l46_sequencial);
    $erro_msg = $cllicpregaocgm->erro_msg;
    if($cllicpregaocgm->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
   $result = $cllicpregaocgm->sql_record($cllicpregaocgm->sql_query($l46_sequencial));
   if($result!=false && $cllicpregaocgm->numrows>0){
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
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmlicpregaocgm.php");
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
    if($cllicpregaocgm->erro_campo!=""){
        echo "<script> document.form1.".$cllicpregaocgm->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$cllicpregaocgm->erro_campo.".focus();</script>";
    }
}
?>
