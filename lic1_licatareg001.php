<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licatareg_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cllicatareg = new cl_licatareg;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  db_inicio_transacao();
  $cllicatareg->incluir();
  db_fim_transacao();
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >


    <center>
      <fieldset style="margin-top: 30px;">
        <legend>Ata de Refistro de Preço</legend>
          <?
            include("forms/db_frmlicatareg.php");
          ?>
      </fieldset>
    </center>


</body>
</html>
<script>
js_tabulacaoforms("form1","l221_licitacao",true,1,"l221_licitacao",true);
</script>
<?
if(isset($incluir)){
  if($cllicatareg->erro_status=="0"){
    $cllicatareg->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cllicatareg->erro_campo!=""){
      echo "<script> document.form1.".$cllicatareg->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cllicatareg->erro_campo.".focus();</script>";
    }
  }else{
    $cllicatareg->erro(true,true);
  }
}
?>
