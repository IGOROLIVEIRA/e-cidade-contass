<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_descontotabela_classe.php");
include("classes/db_liclicita_classe.php");
include("classes/db_homologacaoadjudica_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_habilitacaoforn_classe.php");
include("classes/db_pcorcamforne_classe.php");
db_postmemory($HTTP_POST_VARS);
$cldescontotabela      = new cl_descontotabela;
$clliclicita           = new cl_liclicita;
$clhomologacaoadjudica = new cl_homologacaoadjudica;
$clhabilitacaoforn     = new cl_habilitacaoforn;
$clpcorcamforne        = new cl_pcorcamforne; 
$db_opcao = 1;
$db_botao = true;

if ($l204_licitacao != '') {
  $result = $clliclicita->sql_record($clliclicita->sql_query(null,"l20_licsituacao","","l20_codigo=$l204_licitacao"));
  $iCodSituacao  = db_utils::fieldsMemory($result, 0)->l20_licsituacao;

  $rsHabilitacao = $clhabilitacaoforn->sql_record($clhabilitacaoforn->sql_query(null,"l206_sequencial,z01_numcgm,z01_nome",null,"l206_licitacao=$l204_licitacao"));
  
	 $result_orcamento = $clliclicita->sql_record($clliclicita->sql_query_pco($l204_licitacao));
	 $sWhere = " pc21_codorc=".db_utils::fieldsMemory($result_orcamento, 0)->pc20_codorc;
	 
   $rsFornec = $clpcorcamforne->sql_record($clpcorcamforne->sql_query(null,"pc21_numcgm,z01_nome","",$sWhere));
   
  if($iCodSituacao != 0) {

     echo 
        "<script>alert('Licitacao ja esta homologada ou julgada')</script>";

     db_redireciona('lic1_descontotabela001.php');

  } else if (pg_num_rows($rsHabilitacao) < pg_num_rows($rsFornec)) { 
  	  echo "<script>alert('Todos os Fornecedores da licitação devem estar habilitados');</script>";
      echo "<script>document.location.href=\"lic1_fornec001.php?l20_codigo={$l204_licitacao}\"</script>";
  }
  
}

if(isset($incluir)) {

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
    unset($_POST['incluir']);
    
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

        $cldescontotabela->incluir($l204_sequencial);
        
    }
    if ($cldescontotabela->erro_status != 0) {
    	$iCodOrc = $cldescontotabela->getCodOrc($l204_licitacao);
      $resultfornec = $cldescontotabela->sql_record($cldescontotabela->sql_query_fornec(null,"pc21_orcamforne,z01_nome","","pc21_codorc = $iCodOrc"));
      $resultdesctabela = $cldescontotabela->sql_record($cldescontotabela->sql_query(null,"l204_fornecedor","l204_fornecedor","l204_licitacao = $l204_licitacao"));
      echo pg_num_rows($resultfornec) ." / ". pg_num_rows($resultdesctabela);
      if (pg_num_rows($resultfornec) == pg_num_rows($resultdesctabela)) {
        $clhomologacaoadjudica->alteraLicitacao($l204_licitacao,1);
        $licitacao = $l204_licitacao;
      }
      
    }

    db_fim_transacao();
  
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
<script>
js_tabulacaoforms("form1","l204_licitacao",true,1,"l204_licitacao",true);
</script>
<?
if(isset($incluir)){
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
?>
