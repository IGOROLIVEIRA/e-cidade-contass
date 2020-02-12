<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licobrasituacao_classe.php");
include("classes/db_licobras_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cllicobrasituacao = new cl_licobrasituacao;
$cllicobras = new cl_licobras;

$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  $db_opcao = 2;
  $resultObras = $cllicobras->sql_record($cllicobras->sql_query($obr02_seqobra,"obr01_dtlancamento",null,null));
  db_fieldsmemory($resultObras,0);
  $dtLancamentoObras = (implode("/",(array_reverse(explode("-",$obr01_dtlancamento)))));

  try {

    if($dtLancamentoObras != null){
      if($obr02_dtlancamento < $dtLancamentoObras){
        throw new Exception ("Usuário: Data de Lançamento deve ser maior ou igual a data de lançamento da Obra.");
      }
    }
    $cllicobrasituacao->alterar($obr02_sequencial);

    if($cllicobrasituacao->erro_status == 0){
      $erro = $cllicobrasituacao->erro_msg;
      db_msgbox($erro);
      $sqlerro = true;
    }
    db_fim_transacao();

  }catch (Exception $eErro){
    db_msgbox($eErro->getMessage());
  }

}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $cllicobrasituacao->sql_record($cllicobrasituacao->sql_query($chavepesquisa));
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
<style>
  #obr02_descrisituacao{
    width: 710px;
    height: 43px;
  }
  #obr02_outrosmotivos{
    width: 756px;
    height: 34px;
  }

</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0" style="margin-left: 16%; margin-top: 2%;">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
      <center>
        <?
        include("forms/db_frmlicobrasituacao.php");
        ?>
      </center>
    </td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($alterar)){
  if($cllicobrasituacao->erro_status=="0"){
    $cllicobrasituacao->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cllicobrasituacao->erro_campo!=""){
      echo "<script> document.form1.".$cllicobrasituacao->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cllicobrasituacao->erro_campo.".focus();</script>";
    }
  }else{
    $cllicobrasituacao->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","obr02_seqobra",true,1,"obr02_seqobra",true);
</script>
