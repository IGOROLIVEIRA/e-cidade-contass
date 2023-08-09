<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_numeracaotipoproc_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clnumeracaotipoproc = new cl_numeracaotipoproc;
$db_opcao = 22;
$db_botao = true;
$p200_ano = db_getsession("DB_anousu");
$p200_tipoproc = $chavepesquisa;
if(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $clnumeracaotipoproc->sql_record($clnumeracaotipoproc->sql_query('','*','',"p200_tipoproc = $p200_tipoproc and p200_ano = $p200_ano") );
  if($clnumeracaotipoproc->numrows > 0){
      $clnumeracaotipoproc->p200_codigo = $p200_codigo;
      $clnumeracaotipoproc->p200_numeracao = $p200_numeracao;
      $clnumeracaotipoproc->p200_tipoproc = $p200_tipoproc;
      $clnumeracaotipoproc->p200_ano = $p200_ano;
      $clnumeracaotipoproc->alterar($p200_codigo);
  }else{
      $clnumeracaotipoproc->p200_numeracao = $p200_numeracao;
      $clnumeracaotipoproc->p200_tipoproc = $p200_tipoproc;
      $clnumeracaotipoproc->p200_ano = $p200_ano;
      $clnumeracaotipoproc->incluir(null);
  }

  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $clnumeracaotipoproc->sql_record($clnumeracaotipoproc->sql_query('','*','',"p200_tipoproc = $chavepesquisa and p200_ano = $p200_ano"));
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
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmnumeracaotipoproc.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){

if($sqlerro == true){
      if (trim($erro_msg) == ""){
           $erro_msg = "Inclusão abortada";
      }

      db_msgbox($erro_msg);

    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clliclicita->erro_campo!=""){
      echo "<script> document.form1.".$clliclicita->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clliclicita->erro_campo.".focus();</script>";
    };
  }else{
    $db_botao = true;
    db_msgbox("Alteração Efetuada com Sucesso!!");

  };

}
?>
