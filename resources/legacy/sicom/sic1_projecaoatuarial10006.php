<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_projecaoatuarial10_classe.php");
include("classes/db_projecaoatuarial20_classe.php");
$clprojecaoatuarial10 = new cl_projecaoatuarial10;
$clprojecaoatuarial20 = new cl_projecaoatuarial20;
db_postmemory($HTTP_POST_VARS);
   $db_opcao = 33;
$db_botao = false;
if(isset($excluir)){
  $sqlerro=false;
  db_inicio_transacao();

  $clprojecaoatuarial20->excluir(null,"si169_projecaoatuarial10 = {$si168_sequencial} and si169_tipoplano = {$si168_tipoplano}");
    if($clprojecaoatuarial20->erro_status==0){
        $sqlerro=true;
    }
  $clprojecaoatuarial10->excluir($si168_sequencial);
  if($clprojecaoatuarial10->erro_status==0){
    $sqlerro=true;
  } 
  $erro_msg = $clprojecaoatuarial20->erro_msg;
  $erro_msg = $clprojecaoatuarial10->erro_msg;
  db_fim_transacao($sqlerro);
   $db_opcao = 3;
   $db_botao = true;
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $db_botao = true;
   $result = $clprojecaoatuarial10->sql_record($clprojecaoatuarial10->sql_query($chavepesquisa)); 
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
<center>
<fieldset   style="margin-left:40px; margin-top: 20px;">
<legend><b>Saldo Financeiro</legend>
  <?
  include("forms/db_frmprojecaoatuarial10.php");
  ?>
</fieldset>
</center>
</body>
</html>
<?
if(isset($excluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clprojecaoatuarial10->erro_campo!=""){
      echo "<script> document.form1.".$clprojecaoatuarial10->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clprojecaoatuarial10->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
 echo "
  <script>
    function js_db_tranca(){
      parent.location.href='sic1_projecaoatuarial10003.php';
    }\n
    js_db_tranca();
  </script>\n
 ";
  }
}

 if($db_opcao==22||$db_opcao==33){
    echo "<script>document.form1.pesquisar.click();</script>";
 }
?>
