<?
require("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_empcontratos_classe.php");
include("classes/db_empempenho_classe.php");
include("classes/db_contratos_classe.php");
include("classes/db_liclicita_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clempcontratos = new cl_empcontratos;
$clcontratos = new cl_contratos;
$clliclicita = new cl_liclicita;
$clempempenho = new cl_empempenho;
$db_opcao = 22;
$db_botao = false;
$CTRL     = 1;  
/**
*
* SQL PARA BUSCA DE EMPENHO
*/

$result             = $clcontratos->sql_record($clcontratos->sql_query_file($si173_codcontrato));
$si172_fornecedor   = db_utils::fieldsMemory($result, 0)->si172_fornecedor;

if(isset($alterar) || isset($excluir) || isset($incluir)){
$sqlerro = false;

$iControle2 = pg_num_rows($clempcontratos->sql_record($clempempenho->sql_query_file(null,'*',null,"e60_numcgm = $si172_fornecedor and e60_codemp = '$si173_empenho'")));
}
if(isset($incluir)){
  if($sqlerro==false){
    $iControle = pg_num_rows($clempcontratos->sql_record($clempcontratos->sql_query_file(null,'*',null,'si173_empenho = '. $si173_empenho .' and si173_anoempenho = '. $si173_anoempenho) ) );

    if ( empty($iControle) && !empty($iControle2) ) {
      db_inicio_transacao();
      $clempcontratos->incluir($si173_sequencial);
      $erro_msg = $clempcontratos->erro_msg;
      if($clempcontratos->erro_status==0){
        $sqlerro=true;
      }
      db_fim_transacao($sqlerro);
    } else {
      if (!empty($iControle)) {
      echo 
        "<script>alert('Empenho já cadastrado para este ano')</script>";
        unset($incluir);
        //$si172_sequencial = null;
        $CTRL = 0;
      }
      if(empty($iControle2)) {
        echo
        "<script>alert('Empenho não pertence ao fornecedor do contrato')</script>";
        unset($incluir);
        //$si172_sequencial = null;
        $CTRL = 0;

      }
    }
  }
}else if(isset($alterar)){
  if($sqlerro==false){
    $iControle = pg_num_rows($clempcontratos->sql_record($clempcontratos->sql_query(null,'*',null,'si173_empenho = '. $si173_empenho .' and si173_anoempenho = '. $si173_anoempenho )));
    if ( empty($iControle) && !empty($iControle2) ) {
      db_inicio_transacao();
      $clempcontratos->alterar($si173_sequencial);
      $erro_msg = $clempcontratos->erro_msg;
      if($clempcontratos->erro_status==0){
        $sqlerro=true;
      }
      db_fim_transacao($sqlerro);
    } else {
      if (!empty($iControle)) {
      echo 
        "<script>alert('Empenho já cadastrado para este ano')</script>";
        unset($incluir);
        //$si172_sequencial = null;
        $CTRL = 0;
      }
      if(empty($iControle2)) {
        echo
        "<script>alert('Empenho não pertence ao fornecedor do contrato')</script>";
        unset($incluir);
        //$si172_sequencial = null;
        $CTRL = 0;

      }
    }

  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clempcontratos->excluir($si173_sequencial);
    $erro_msg = $clempcontratos->erro_msg;
    if($clempcontratos->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
  
   $result = $clempcontratos->sql_record($clempcontratos->sql_query($si173_sequencial));
   if($result!=false && $clempcontratos->numrows>0){
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
<legend><b>Emp Contratos</b></legend>
  <?
  include("forms/db_frmempcontratos.php");
  ?>
</fieldset>
</center>
</body>
</body>
</html>
<?
if($CTRL == 0){
  echo '<script>
  document.form1.si173_sequencial.value = "";
  </script>';
}
if(isset($alterar) || isset($excluir) || isset($incluir)){
    db_msgbox($erro_msg);
    if($clempcontratos->erro_campo!=""){
        echo "<script> document.form1.".$clempcontratos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clempcontratos->erro_campo.".focus();</script>";
    }
}
?>
