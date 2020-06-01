<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licobras_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_homologacaoadjudica_classe.php");
include("classes/db_condataconf_classe.php");

db_postmemory($HTTP_POST_VARS);
$cllicobras = new cl_licobras;
$clhomologacaoadjudica = new cl_homologacaoadjudica();
$clcondataconf = new cl_condataconf;

$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){

  $resulthomologacao = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_file(null,"l202_datahomologacao",null,"l202_licitacao = $obr01_licitacao"));
  db_fieldsmemory($resulthomologacao,0);
  $data = (implode("/",(array_reverse(explode("-",$l202_datahomologacao)))));

  $datahomologacao = DateTime::createFromFormat('d/m/Y', $data);
  $dtlancamentoobra = DateTime::createFromFormat('d/m/Y', $obr01_dtlancamento);

  try {

    if($obr01_licitacao == null || $obr01_licitacao == ""){
      throw new Exception ("Nenhuma licitação informada!");
    }

    if($obr01_licitacaosistema != "2"){
        if($datahomologacao == null){
            throw new Exception ("Usuário: Licitação não homologada! Inclusão Abortada!");
        }
      }

    if($obr01_numeroobra == null || $obr01_numeroobra == "0"){
      throw new Exception ("Nº Obra não informado!");
    }

    $resultobras = $cllicobras->sql_record($cllicobras->sql_query(null,"obr01_numeroobra","obr01_numeroobra desc limit 1","obr01_numeroobra = $obr01_numeroobra"));

    if(pg_num_rows($resultobras) > 0){
      throw new Exception("Usuário: Numero da Obra ja utilizado !");
    }

    db_inicio_transacao();
    $cllicobras->obr01_licitacao           = $obr01_licitacao;
    $cllicobras->obr01_dtlancamento        = $obr01_dtlancamento;
    $cllicobras->obr01_numeroobra          = $obr01_numeroobra;
    $cllicobras->obr01_linkobra            = $obr01_linkobra;
    $cllicobras->obr01_instit              = db_getsession('DB_instit');
    $cllicobras->obr01_licitacaosistema       = $obr01_licitacaosistema;
    $cllicobras->incluir();

    if($cllicobras->erro_status == 0){
      $erro = $cllicobras->erro_msg;
      $sqlerro = true;
    }
    db_fim_transacao();
    if($sqlerro == false){
      db_redireciona("obr1_licobras002.php?&chavepesquisa=$cllicobras->obr01_sequencial");
    }

  }catch (Exception $eErro){
    db_msgbox($eErro->getMessage());
  }
}
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script type="text/javascript" src="wz_tooltip.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <?php
  db_app::load("scripts.js, prototype.js, widgets/windowAux.widget.js,strings.js");
  db_app::load("widgets/dbtextField.widget.js, dbViewCadEndereco.classe.js");
  db_app::load("dbmessageBoard.widget.js, dbautocomplete.widget.js,dbcomboBox.widget.js, datagrid.widget.js");
  db_app::load("estilos.css,grid.style.css");
  ?>
</head>
<style>
  #l20_objeto{
    width: 622px;
    height: 58px;
  }
  #obr01_linkobra{
    width: 617px;
    height: 18px;
  }
  #obr01_numartourrt{
    width: 162px;
  }
  #obr01_tiporegistro{
    width: 40%;
  }
  #col1{
    width: 24%;
  }
  #col2{
    width: 96%;
  }
  #col3{
    width: 15%
  }
  #tipocompra{
    width: 263px;
  }
  #obr05_numartourrt {
      background-color: #E6E4F1;
  }
  #obr01_licitacaosistema{
      width: 90px;
  }
</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0" style="margin-left: 16%; margin-top: 2%;">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
      <center>
        <?
        include("forms/db_frmlicobras.php");
        ?>
      </center>
    </td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
  js_tabulacaoforms("form1","obr01_licitacao",true,1,"obr01_licitacao",true);
</script>
<?
if(isset($incluir)){
  if($cllicobras->erro_status=="0"){
    $cllicobras->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cllicobras->erro_campo!=""){
      echo "<script> document.form1.".$cllicobras->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cllicobras->erro_campo.".focus();</script>";
    }
  }else{
    $cllicobras->erro(true,true);
  }
}
?>
