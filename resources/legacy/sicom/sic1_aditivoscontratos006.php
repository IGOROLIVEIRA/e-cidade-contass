<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_aditivoscontratos_classe.php");
include("classes/db_itensaditivados_classe.php");
include("classes/db_contratos_classe.php");
$clcontratos = new cl_contratos;
$claditivoscontratos = new cl_aditivoscontratos;
$clitensaditivados   = new cl_itensaditivados;

db_postmemory($HTTP_POST_VARS);
   $db_opcao = 33;
$db_botao = false;
if(isset($excluir)){
  $sqlerro=false;
  db_inicio_transacao();
  $clitensaditivados->si175_sequencial=$si174_sequencial;
  $clitensaditivados->excluir($si174_sequencial);
  if($clitensaditivados->erro_status==0){
    $sqlerro=true;
  }
  $erro_msg = $clitensaditivados->erro_msg;
  $claditivoscontratos->excluir($si174_sequencial);
  if($claditivoscontratos->erro_status==0){
    $sqlerro=true;
  }
  $erro_msg = $claditivoscontratos->erro_msg;
  db_fim_transacao($sqlerro);
   $db_opcao = 3;
   $db_botao = true;
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $db_botao = true;
   $result = $claditivoscontratos->sql_record($claditivoscontratos->sql_query_file($chavepesquisa));
   db_fieldsmemory($result,0);
   $result = $clcontratos->sql_record($clcontratos->sql_query_novo(null,"si172_sequencial, si172_exercicioprocesso, si172_nrocontrato, z01_nome, si172_dataassinatura",null,"si172_sequencial = $si174_nrocontrato"));
   db_fieldsmemory($result,0);
   $nrocontrato         = $si172_nrocontrato.'/'.$si172_exercicioprocesso;
   $dataassinatura      = $si172_dataassinatura;
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
<legend><b>Aditivos Contratos</b></legend>
  <?
  include("forms/db_frmaditivoscontratos.php");
  ?>
</fieldset>
</center>
</body>
</html>
<?
if(isset($excluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($claditivoscontratos->erro_campo!=""){
      echo "<script> document.form1.".$claditivoscontratos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$claditivoscontratos->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
 echo "
  <script>
    function js_db_tranca(){
      parent.location.href='sic1_aditivoscontratos003.php';
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
         parent.document.formaba.itensaditivados.disabled=false;
         CurrentWindow.corpo.iframe_itensaditivados.location.href='sic1_itensaditivados001.php?db_opcaoal=33&si175_codaditivo=".@$si174_sequencial."';
     ";
         if(isset($liberaaba)){
           echo "  parent.mo_camada('itensaditivados');";
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
