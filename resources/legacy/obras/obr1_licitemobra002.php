<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licitemobra_classe.php");
include("classes/db_solicitempcmater_classe.php");
include("classes/db_condataconf_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cllicitemobra = new cl_licitemobra;
$clsolicitempcmater = new cl_solicitempcmater;
$clcondataconf = new cl_condataconf;

$db_opcao = 22;
$db_botao = false;
//if(isset($alterar)){
//  try{
//    db_inicio_transacao();
//    $resultItemObra = $cllicitemobra->sql_record($cllicitemobra->sql_query(null,"*",null,"obr06_pcmater = $obr06_pcmater and obr06_codigotabela = '$obr06_codigotabela' and obr06_versaotabela = '$obr06_versaotabela'"));
//    if(pg_num_rows($resultItemObra) > 0){
//      throw new Exception("Item Obra já Cadastrado!");
//    }
//
//    //tabela SINAP
//    if($obr06_tabela == "1"){
//      $rsItem = $cllicitemobra->sql_record($cllicitemobra->sql_query(null,"*",null,"obr06_pcmater = $obr06_pcmater and obr06_tabela != 1"));
//      if(pg_num_rows($rsItem) > 0){
//        throw new Exception("Inclusão Abortada! Material já cadastro como Item Obra!");
//      }
//    }
//
//    //tabela SIPRO
//    if($obr06_tabela == "2"){
//      $rsItem = $cllicitemobra->sql_record($cllicitemobra->sql_query(null,"*",null,"obr06_pcmater = $obr06_pcmater and obr06_tabela != 2"));
//      if(pg_num_rows($rsItem) > 0){
//        throw new Exception("Inclusão Abortada! Material já cadastro como Item Obra!");
//      }
//    }
//
//    //tabela Outras Tabelas
//    if($obr06_tabela == "3"){
//      $rsItem = $cllicitemobra->sql_record($cllicitemobra->sql_query(null,"*",null,"obr06_pcmater = $obr06_pcmater and obr06_tabela != 3"));
//      if(pg_num_rows($rsItem) > 0 ){
//        throw new Exception("Inclusão Abortada! Material já cadastro como Item Obra!");
//      }
//    }
//
//    //tabela Cadastro Próprio
//    if($obr06_tabela == "4"){
//      $rsItem = $cllicitemobra->sql_record($cllicitemobra->sql_query(null,"*",null,"obr06_pcmater = $obr06_pcmater and obr06_tabela != 4"));
//      if(pg_num_rows($rsItem) > 0){
//        throw new Exception("Inclusão Abortada! Material já cadastro como Item Obra!");
//      }
//    }
//
//    /**
//     * validação com sicom
//     */
//    $dtcadastro = DateTime::createFromFormat('d/m/Y', $obr06_dtcadastro);
//
//    if(!empty($dtcadastro)){
//      $anousu = db_getsession('DB_anousu');
//      $instituicao = db_getsession('DB_instit');
//      $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu,$instituicao,"c99_datapat",null,null));
//      db_fieldsmemory($result);
//      $data = (implode("/",(array_reverse(explode("-",$c99_datapat)))));
//      $dtencerramento = DateTime::createFromFormat('d/m/Y', $data);
//
//      if ($dtcadastro <= $dtencerramento) {
//        throw new Exception ("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
//      }
//    }
//    $db_opcao = 2;
//    $cllicitemobra->obr06_pcmater = $obr06_pcmater;
//    $cllicitemobra->obr06_tabela = $obr06_tabela;
//    $cllicitemobra->obr06_descricaotabela = $obr06_descricaotabela;
//    $cllicitemobra->obr06_codigotabela = $obr06_codigotabela;
//    $cllicitemobra->obr06_codigotabela = $obr06_codigotabela;
//    $cllicitemobra->obr06_versaotabela = $obr06_versaotabela;
//    $cllicitemobra->obr06_dtregistro = $obr06_dtregistro;
//    $cllicitemobra->obr06_dtcadastro = $obr06_dtcadastro;
//    $cllicitemobra->obr06_instit = db_getsession('DB_instit');
//    $cllicitemobra->alterar($obr06_sequencial);
//    db_fim_transacao();
//  }catch (Exception $eErro){
//    db_msgbox($eErro->getMessage());
//  }
//
//}else if(isset($chavepesquisa)){
//  /*
// * verifica se o item ja foi utilizado
// */
//  $resultitem = $cllicitemobra->sql_record($cllicitemobra->sql_query($chavepesquisa));
//  db_fieldsmemory($resultitem,0);
//  $result = $clsolicitempcmater->sql_record($clsolicitempcmater->sql_query($obr06_pcmater));
//  if(pg_num_rows($result) > 0){
//    $db_opcao = 33;
//  }else{
//    $db_opcao = 2;
//  }
//  $result = $cllicitemobra->sql_record($cllicitemobra->sql_query($chavepesquisa));
//  db_fieldsmemory($result,0);
//  $db_botao = true;
//}
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<center>
    <?
    include("forms/db_frmlicitemobra.php");
    ?>
</center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($alterar)){
  if($cllicitemobra->erro_status=="0"){
    $cllicitemobra->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cllicitemobra->erro_campo!=""){
      echo "<script> document.form1.".$cllicitemobra->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cllicitemobra->erro_campo.".focus();</script>";
    }
  }else{
    $cllicitemobra->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
  js_tabulacaoforms("form1","obr06_pcmater",true,1,"obr06_pcmater",true);
</script>
