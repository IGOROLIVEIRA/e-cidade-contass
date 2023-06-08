<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licatareg_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cllicatareg = new cl_licatareg;
$clliclicita= new cl_liclicita;
$db_opcao = 22;
$db_botao = true;
if(isset($alterar)){

  $datainicial = DateTime::createFromFormat('d/m/Y', $l221_dataini);
  $datafinal = DateTime::createFromFormat('d/m/Y', $l221_datafinal);
  
  $rsLicatareg = $cllicatareg->sql_record("select * from licatareg where l221_numata= '$l221_numata' and l221_exercicio= '$l221_exercicio' and l221_licitacao <> $l221_licitacao");
    if(pg_num_rows($rsLicatareg)>0){
      $db_opcao = 2;
      $sqlerro=true;
      db_msgbox("Número da Ata já inserido nesse exercício!");
    }else if($l221_numata == "" || $l221_numata == null){
      $db_opcao = 2;
      $sqlerro=true;
      db_msgbox("Informe o número da Ata!");
    }else if($l221_dataini == "" || $l221_dataini == null){
      $db_opcao = 2;
      $sqlerro=true;
      db_msgbox("Insira uma Data Inicial!");
    }else if($l221_datafinal == "" || $l221_datafinal == null){
      $db_opcao = 2;
      $sqlerro=true;
      db_msgbox("Insira uma Data Final!");
    }else if($datainicial>$datafinal){
      $db_opcao = 2;
      $db_opcao = 2;
      $sqlerro=true;
      db_msgbox("Data inicial é maior que data final!");
    }  
  if($sqlerro == false){

    db_inicio_transacao();
    $db_opcao = 2;
    $cllicatareg->l221_licitacao = $l221_licitacao;
    $cllicatareg->l221_numata = $l221_numata;
    $cllicatareg->l221_exercicio = $l221_exercicio;
    $cllicatareg->l221_fornecedor = $l221_fornecedor;
    $cllicatareg->l221_dataini = $l221_dataini;
    $cllicatareg->l221_datafinal = $l221_datafinal;
    if($l221_datapublica != "" || $l221_datapublica != null){
      $cllicatareg->l221_datapublica = $l221_datapublica;
    }
    if($l221_veiculopublica != "" || $l221_veiculopublica != null){
      $cllicatareg->l221_veiculopublica = $l221_veiculopublica;
    }
    $cllicatareg->alterar($l221_sequencial);
    db_fim_transacao();
    db_msgbox("Alterado com Sucesso");
  }
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $cllicatareg->sql_record($cllicatareg->sql_query_file(null,"*",null,"l221_sequencial = ".$chavepesquisa)); 
   db_fieldsmemory($result,0);
   $db_botao = true;
   $rsObjeto = $clliclicita->sql_record($clliclicita->sql_query_file($l221_licitacao,"l20_objeto"));
   db_fieldsmemory($rsObjeto,0);
   echo "<script>
               parent.iframe_licataregitem.location.href='lic1_licataregitem001.php?l222_licatareg= $l221_sequencial&licitacao=$l221_licitacao&fornecedor=$l221_fornecedor';\n
               parent.document.formaba.licataregitem.disabled=false;\n
        </script>";
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
  <?php
	include("forms/db_frmlicatareg.php");
	?>
    </center>


</body>
</html>
<?php
if(isset($alterar)){
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
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","l221_licitacao",true,1,"l221_licitacao",true);
</script>
