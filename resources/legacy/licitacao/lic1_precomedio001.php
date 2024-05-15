<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_precomedio_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clprecomedio = new cl_precomedio;
$db_opcao = 1;
$db_botao = true;



if (isset($_POST['btnProcessar'])) {

  $l209_licitacao = $_POST['l209_licitacao'];

    /**
  * pegar codigo do orcamento
  */  
  $sSql = "select * from liclicitem 
  join pcorcamitemlic on pc26_liclicitem = l21_codigo 
  join pcorcamitem on pc22_orcamitem = pc26_orcamitem 
  where l21_codliclicita = {$l209_licitacao} limit 1";
  
  $rsOrcamento = db_query($sSql);
  $oOrcamento = db_utils::fieldsMemory($rsOrcamento, 0);

}

if(isset($incluir)){

  $l209_licitacao   = $_POST['l209_licitacao'];
  $l209_datacotacao = $_POST['l209_datacotacao'];

  unset($_POST['l209_sequencial']);
  unset($_POST['l209_licitacao']); 
  unset($_POST['l209_datacotacao']);
  unset($_POST['l20_codigo']);
  unset($_POST['nroProcessoLicitatorio']);
  unset($_POST['dtCotacao']);
  unset($_POST['l209_datacotacao_dia']);
  unset($_POST['l209_datacotacao_mes']);
  unset($_POST['l209_datacotacao_ano']);
  unset($_POST['incluir']);
  
  foreach ($_POST as $coll => $value) {
      
      $oItem = new stdClass();
      
      $oItem->codigoitemprocesso       = $coll;
      $oItem->vlCotPrecosUnitario      = $value;
      
      $aItens[]                        = $oItem;
      
  }

  db_inicio_transacao();
  foreach ($aItens as $oRow) {

    $clprecomedio->l209_licitacao   = $l209_licitacao;
    $clprecomedio->l209_datacotacao = implode('-', array_reverse(explode('/', $l209_datacotacao)));
    $clprecomedio->l209_item        = $oRow->codigoitemprocesso;
    $clprecomedio->l209_valor       = $oRow->vlCotPrecosUnitario;

    $clprecomedio->incluir(null);

  }
  db_fim_transacao();

}

if(isset($alterar)){

  db_inicio_transacao();
  $db_opcao = 2;
 // $clprecomedio->alterar($l209_sequencial);
  $clprecomedio->excluir(null,'l209_licitacao = '.$l209_licitacao);

  $l209_licitacao   = $_POST['l209_licitacao'];
  $l209_datacotacao = $_POST['l209_datacotacao'];

  unset($_POST['l209_sequencial']);
  unset($_POST['l209_licitacao']); 
  unset($_POST['l209_datacotacao']);
  unset($_POST['l20_codigo']);
  unset($_POST['l209_datacotacao_dia']);
  unset($_POST['l209_datacotacao_mes']);
  unset($_POST['l209_datacotacao_ano']);
  unset($_POST['alterar']);
  
  foreach ($_POST as $coll => $value) {
      
      $oItem = new stdClass();
      
      $oItem->codigoitemprocesso       = $coll;
      $oItem->vlCotPrecosUnitario      = $value;
      
      $aItens[]                        = $oItem;
      
  }

  
  foreach ($aItens as $oRow) {

    $clprecomedio->l209_licitacao   = $l209_licitacao;
    $clprecomedio->l209_datacotacao = implode('-', array_reverse(explode('/', $l209_datacotacao)));
    $clprecomedio->l209_item        = $oRow->codigoitemprocesso;
    $clprecomedio->l209_valor       = $oRow->vlCotPrecosUnitario;

    $clprecomedio->incluir(null);

  }

  db_fim_transacao();

}
if(isset($excluir)){
  db_inicio_transacao();
  $db_opcao = 3;
  $clprecomedio->excluir(null,'l209_licitacao = '.$l209_licitacao);
  //$clprecomedio->excluir($l209_sequencial);
  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $clprecomedio->sql_record($clprecomedio->sql_query(null,'*',null,'l209_licitacao = '.$chavepesquisa)); 
   db_fieldsmemory($result,0);

    /**
    * pegar codigo do orcamento
    */  
    $sSql = "select * from liclicitem 
    join pcorcamitemlic on pc26_liclicitem = l21_codigo 
    join pcorcamitem on pc22_orcamitem = pc26_orcamitem 
    where l21_codliclicita = {$l209_licitacao} limit 1";
    
    $rsOrcamento = db_query($sSql);
    $oOrcamento = db_utils::fieldsMemory($rsOrcamento, 0);

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
<link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<center>
<fieldset   style="margin-left:40px; margin-top: 20px;">
<legend><b>Preço Médio</b></legend>
	<?
	include("forms/db_frmprecomedio.php");
	?>
    </center>
	</fieldset>
</center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","l209_licitacao",true,1,"l209_licitacao",true);
</script>
<?
if(isset($incluir)){
  if($clprecomedio->erro_status=="0"){
    $clprecomedio->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clprecomedio->erro_campo!=""){
      echo "<script> document.form1.".$clprecomedio->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clprecomedio->erro_campo.".focus();</script>";
    }
  }else{
    $clprecomedio->erro(true,true);
  }
}
if(isset($alterar)){
  if($clprecomedio->erro_status=="0"){
    $clprecomedio->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clprecomedio->erro_campo!=""){
      echo "<script> document.form1.".$clprecomedio->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clprecomedio->erro_campo.".focus();</script>";
    }
  }else{
    $clprecomedio->erro(true,true);
  }
}
if(isset($excluir)){
  if($clprecomedio->erro_status=="0"){
    $clprecomedio->erro(true,false);
  }else{
    $clprecomedio->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
