<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_descontotabela_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cldescontotabela = new cl_descontotabela;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  
  db_inicio_transacao();

  $db_opcao = 2;
  $cldescontotabela->excluir(null,"l204_licitacao = $l204_licitacao");
  //$cldescontotabela->alterar($l204_sequencial);

  db_fim_transacao();

  /**
  * passar os valores para o objeto para ser salvo
  */
        
  $l204_licitacao  = $_POST['l204_licitacao'];   
  $l204_fornecedor = $_POST['l204_fornecedor']; 

  unset($_POST['l204_sequencial']);
  unset($_POST['l204_licitacao']);
  unset($_POST['l20_codigo']);
  unset($_POST['l204_fornecedor']);
  unset($_POST['l204_fornecedordescr']);
  unset($_POST['alterar']);
  
  /**
  * passar os valores para o objeto para ser atualizado
  */  
  foreach ($_POST as $coll => $value) {
    $oItem = new stdClass();
      
    $oItem->pc01_codmater   = $coll;
    $oItem->vldesconto      = $value;
    
    $aItens[]               = $oItem;    
  }
  
  db_inicio_transacao();

  foreach ($aItens as $oRow) {
 
      $cldescontotabela->l204_licitacao  = $l204_licitacao;
      $cldescontotabela->l204_fornecedor = $l204_fornecedor;
      $cldescontotabela->l204_item       = $oRow->pc01_codmater;
      $cldescontotabela->l204_valor      = $oRow->vldesconto;

      $cldescontotabela->incluir(null);
 
  }

  db_fim_transacao();

}else if(isset($chavepesquisa)) {
   $db_opcao = 2;
   $result = $cldescontotabela->sql_record($cldescontotabela->sql_query("","*","","l204_licitacao = $chavepesquisa and l204_fornecedor = $fornecedor")); 
   db_fieldsmemory($result,0);
   $db_botao = true;
} else if (isset($l204_licitacao) && isset($l204_fornecedor)) {
	 $db_opcao = 2;
   $result = $cldescontotabela->sql_record($cldescontotabela->sql_query("","*","","l204_licitacao = $l204_licitacao and l204_fornecedor = $l204_fornecedor")); 
   db_fieldsmemory($result,0);
   $db_botao = true;
}
echo $l204_fornecedor."<br>";
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
  <fieldset style=" margin-top: 30px; width: 500px; height: 400px;">
  <legend>Desconto Tabela</legend>
  <?
  include("forms/db_frmdescontotabela.php");
  ?>
  </fieldset>
  </center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($alterar)){
  if($cldescontotabela->erro_status=="0"){
    $cldescontotabela->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cldescontotabela->erro_campo!=""){
      echo "<script> document.form1.".$cldescontotabela->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cldescontotabela->erro_campo.".focus();</script>";
    }
  }else{
    $cldescontotabela->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","l204_licitacao",true,1,"l204_licitacao",true);
</script>
