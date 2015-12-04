<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_itensaditivados_classe.php");
include("classes/db_aditivoscontratos_classe.php");
include("classes/db_contratos_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clitensaditivados   = new cl_itensaditivados;
$claditivoscontratos = new cl_aditivoscontratos;
$clcontratos         = new cl_contratos;
$db_opcao = 22;
$db_botao = false;
$CTRL     = 1;  
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
  /*
$clitensaditivados->si175_sequencial = $si175_sequencial;
$clitensaditivados->si175_codaditivo = $si175_codaditivo;
$clitensaditivados->si175_coditem = $si175_coditem;
$clitensaditivados->si175_tipoalteracaoitem = $si175_tipoalteracaoitem;
$clitensaditivados->si175_quantacrescdecresc = $si175_quantacrescdecresc;
$clitensaditivados->si175_valorunitarioitem = $si175_valorunitarioitem;
  */
}
if(isset($incluir)){
  if($sqlerro==false){
    $iControle = pg_num_rows($clitensaditivados->sql_record($clitensaditivados->sql_query(null,'*',null,'si175_coditem = '. $si175_coditem .' and si175_codaditivo = '. $si175_codaditivo )));
    if ( $iControle != 1 || empty($iControle) ) {
      db_inicio_transacao();
      $clitensaditivados->incluir($si175_sequencial);
      $erro_msg = $clitensaditivados->erro_msg;
      if($clitensaditivados->erro_status==0){
        $sqlerro=true;
      }
      db_fim_transacao($sqlerro);
    }else {
      echo 
        "<script>alert('Item já cadastrado')</script>";
        unset($incluir);
        //$si172_sequencial = null;
        $CTRL = 0;
    }
  }
}else if(isset($alterar)){
  if($sqlerro==false){
    //$iControle = pg_num_rows($clitensaditivados->sql_record($clitensaditivados->sql_query(null,'*',null,'si175_coditem = '. $si175_coditem .' and si175_codaditivo = '. $si175_codaditivo )));
    //if ( $iControle != 1 || empty($iControle) ) {
      db_inicio_transacao();
      $clitensaditivados->alterar($si175_sequencial);
      $erro_msg = $clitensaditivados->erro_msg;
      if($clitensaditivados->erro_status==0){
        $sqlerro=true;
      }
      db_fim_transacao($sqlerro);
    /*}else {
      echo 
        "<script>alert('Item já cadastrado')</script>";
        unset($incluir);
        //$si172_sequencial = null;
        $CTRL = 0;
    }*/
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clitensaditivados->excluir($si175_sequencial);
    $erro_msg = $clitensaditivados->erro_msg;
    if($clitensaditivados->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
   $result = $clitensaditivados->sql_record($clitensaditivados->sql_query($si175_sequencial));
   if($result!=false && $clitensaditivados->numrows>0){
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
<center>
<fieldset   style="margin-left:40px; margin-top: 20px;">
<legend><b>Itens Aditivados</b></legend>
  <?
  include("forms/db_frmitensaditivados.php");
  ?>
</fieldset>
</center>
</body>
</html>
<?
if($CTRL == 0){
  echo '<script>
  document.form1.si175_sequencial.value = "";
  </script>';
}
if(isset($alterar) || isset($excluir) || isset($incluir)){
    db_msgbox($erro_msg);
    if($clitensaditivados->erro_campo!=""){
        echo "<script> document.form1.".$clitensaditivados->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clitensaditivados->erro_campo.".focus();</script>";
    }
}
?>
