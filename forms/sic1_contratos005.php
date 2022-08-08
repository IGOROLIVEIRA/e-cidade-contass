<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_contratos_classe.php");
include("classes/db_empcontratos_classe.php");
include("classes/db_liclicita_classe.php");

$clcontratos = new cl_contratos;
$clliclicita = new cl_liclicita;
  /*
$clempcontratos = new cl_empcontratos;
  */
db_postmemory($HTTP_POST_VARS);
$db_opcao = 22;
$db_botao = false;
//$CTRL     = 1;
if(isset($alterar)){
  $sqlerro=false;
  //$iControle = pg_num_rows($clcontratos->sql_record($clcontratos->sql_contrato(null,'*',null,'si172_licitacao = '. $si172_licitacao .' and si172_nrocontrato = '. $si172_nrocontrato.' and si172_fornecedor = '.$si172_fornecedor .' and si172_exerciciocontrato = '. db_getsession('DB_anousu') )));
  //if ( $iControle != 1 || empty($iControle) ) {
    db_inicio_transacao();
    $clcontratos->alterar($si172_sequencial);
    if($clcontratos->erro_status==0){
      $sqlerro=true;
    }
    $erro_msg = $clcontratos->erro_msg;
    db_fim_transacao($sqlerro);
  /*}else{
     echo
        "<script>alert('Numero do contrato já existe para o fornecedor nesse ano')</script>";
        unset($incluir);
        //$si172_sequencial = null;
        $CTRL = 0;
  }*/
  $db_opcao = 2;
  $db_botao = true;
} else if (isset($chavepesquisa)) {
   $db_opcao = 2;
   $db_botao = true;
   $result   = $clcontratos->sql_record($clcontratos->sql_query_file($chavepesquisa,'*, (select z01_nome from cgm where z01_numcgm = si172_fornecedor)'));
   db_fieldsmemory($result,0);
   $result_novo = $clliclicita->sql_record($clliclicita->sql_query(null,'pc50_descr',null,'l20_codigo = '.$si172_licitacao));
   db_fieldsmemory($result_novo,0);
   $l20_codigo = $pc50_descr;

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
<legend><b>Contratos</b></legend>
  <?
  include("forms/db_frmcontratos.php");
  ?>
</fieldset>
</center>
</body>
</html>
<?
/*if($CTRL == 0){
  echo '<script>
  document.form1.si172_sequencial.value = "";
  </script>';
}*/
if(isset($alterar)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clcontratos->erro_campo!=""){
      echo "<script> document.form1.".$clcontratos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clcontratos->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
  }
}
if(isset($chavepesquisa)){
 echo "
  <script>
      function js_db_libera(){
         parent.document.formaba.empcontratos.disabled=false;
         CurrentWindow.corpo.iframe_empcontratos.location.href='sic1_empcontratos001.php?si173_codcontrato=".@$si172_sequencial."';
     ";
         if(isset($liberaaba)){
           echo "  parent.mo_camada('empcontratos');";
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
