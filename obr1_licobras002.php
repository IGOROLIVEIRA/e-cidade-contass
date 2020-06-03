<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licobras_classe.php");
include("classes/db_homologacaoadjudica_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_condataconf_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cllicobras = new cl_licobras;
$clhomologacaoadjudica = new cl_homologacaoadjudica();
$clcondataconf = new cl_condataconf;

$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  $resulthomologacao = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_file(null,"l202_datahomologacao",null,"l202_licitacao = $obr01_licitacao"));
  db_fieldsmemory($resulthomologacao,0);
  $data = (implode("/",(array_reverse(explode("-",$l202_datahomologacao)))));

  $datahomologacao = DateTime::createFromFormat('d/m/Y', $data);
  $datalancamento = DateTime::createFromFormat('d/m/Y', $obr01_dtlancamento);
  $dtlancamentoobra = DateTime::createFromFormat('d/m/Y', $obr01_dtlancamento);

  try {

    /**
     * validação com sicom
     */
    if(!empty($datalancamento)){
      $anousu = db_getsession('DB_anousu');
      $instituicao = db_getsession('DB_instit');
      $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu,$instituicao,"c99_datapat",null,null));
      db_fieldsmemory($result);
      $data = (implode("/",(array_reverse(explode("-",$c99_datapat)))));
      $dtencerramento = DateTime::createFromFormat('d/m/Y', $data);

      if ($datalancamento <= $dtencerramento) {
        throw new Exception ("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
      }
    }

    if($datahomologacao != null){
      if($datalancamento < $datahomologacao){
        throw new Exception ("Usuário: Campo Data de lançamento deve ser maior ou igual a data de Homologação da Licitação.");
      }

    }

    $resultobras = $cllicobras->sql_record($cllicobras->sql_query(null,"obr01_numeroobra",null,"obr01_numeroobra = $obr01_numeroobra and obr01_sequencial != $obr01_sequencial"));
    if(pg_num_rows($resultobras) > 0){
      throw new Exception("Usuário: Numero da Obra ja utilizado !");
    }


    db_inicio_transacao();
    $db_opcao = 2;
    $cllicobras->alterar($obr01_sequencial);

    if($cllicobras->erro_status == 0){
      $erro = $cllicobras->erro_msg;
      db_msgbox($erro);
      $sqlerro = true;
    }
    db_fim_transacao();

  }catch (Exception $eErro){
    db_msgbox($eErro->getMessage());
  }
}else if(isset($chavepesquisa)){
  $db_opcao = 2;
  $campos = "obr01_sequencial,obr01_licitacaosistema,obr01_licitacao,obr01_linkobra,obr01_numeroobra,l20_edital,l03_descr,l20_numero,l20_objeto";
  $result = $cllicobras->sql_record($cllicobras->sql_query_pesquisa(null,$campos,null,"obr01_sequencial=$chavepesquisa"));
  db_fieldsmemory($result,0);
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
  <?php
  db_app::load("scripts.js, prototype.js, widgets/windowAux.widget.js,strings.js");
  db_app::load("widgets/dbtextField.widget.js, dbViewCadEndereco.classe.js");
  db_app::load("dbmessageBoard.widget.js, dbautocomplete.widget.js,dbcomboBox.widget.js, datagrid.widget.js");
  db_app::load("estilos.css,grid.style.css");
  ?>
</head>
<style>
  #l20_objeto{
    width: 711px;
    height: 55px;
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
  #obr05_numartourrt{
    background-color:#E6E4F1;
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
<?
if(isset($alterar)){
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
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
  js_tabulacaoforms("form1","obr01_licitacao",true,1,"obr01_licitacao",true);
</script>
