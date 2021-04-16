<?
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_libdicionario.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
include("classes/db_licobrasmedicao_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_condataconf_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$cllicobrasmedicao = new cl_licobrasmedicao;
$clcondataconf = new cl_condataconf;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){

  $dtfimmedicao = DateTime::createFromFormat('d/m/Y', $obr03_dtfimmedicao);
  $dtiniciomedicao = DateTime::createFromFormat('d/m/Y', $obr03_dtiniciomedicao);
  $dtentregamedicao = DateTime::createFromFormat('d/m/Y', $obr03_dtentregamedicao);
  $dtlancamentomedicao = DateTime::createFromFormat('d/m/Y', $obr03_dtlancamento);

  try{

    /**
     * validação com sicom
     */
    if(!empty($dtentregamedicao)){
      $anousu = db_getsession('DB_anousu');
      $instituicao = db_getsession('DB_instit');
      $result = $clcondataconf->sql_record($clcondataconf->sql_query_file($anousu,$instituicao,"c99_datapat",null,null));
      db_fieldsmemory($result);
      $data = (implode("/",(array_reverse(explode("-",$c99_datapat)))));
      $dtencerramento = DateTime::createFromFormat('d/m/Y', $data);

      if ($dtentregamedicao <= $dtencerramento) {
        throw new Exception ("O período já foi encerrado para envio do SICOM. Verifique os dados do lançamento e entre em contato com o suporte.");
      }
    }

    if($dtfimmedicao < $dtiniciomedicao){
      throw new Exception("Usuário: Data Fim da Medição deve ser igual ou maior que Data Inicio da Medição.");
    }

    if($dtentregamedicao < $dtfimmedicao){
      throw new Exception("Usuário: Entrega da Medição deve ser igual ou maior que Fim da Medição.");
    }

    $resulMedicao = $cllicobrasmedicao->sql_record($cllicobrasmedicao->sql_query_file(null,"*",null,"obr03_nummedicao = $obr03_nummedicao and obr03_sequencial != $obr03_sequencial"));
//    echo $cllicobrasmedicao->sql_query_file(null,"*",null,"obr03_nummedicao = $obr03_nummedicao and obr03_sequencial != $obr03_sequencial");exit;
    if(pg_num_rows($resulMedicao) > 0){
      throw new Exception("Usuário: Numero da Medicao já utilizado !");
    }
    db_inicio_transacao();
    $db_opcao = 2;
    $cllicobrasmedicao->alterar($obr03_sequencial);
    db_fim_transacao();
  }catch (Exception $eErro){
    db_msgbox($eErro->getMessage());
  }
}else if(isset($chavepesquisa)){
  $db_opcao = 2;
  $result = $cllicobrasmedicao->sql_record($cllicobrasmedicao->sql_query($chavepesquisa));
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
  #obr03_outrostiposmedicao{
    width: 733px;
    height: 50px;
    background-color:#E6E4F1;
  }

  #obr03_descmedicao{
    width: 733px;
    height: 50px;
    background-color:#E6E4F1;
  }
  #incluirmedicao{
    margin-top: 14px;
    margin-left: -58px;
    margin-bottom: 20px;
  }
  #tipocompra{
    width: 263px;
  }
  #obr04_legenda{
    width: 430px;
  }
</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0" style="margin-left: 16%; margin-top: 2%;">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
      <center>
        <?
        include("forms/db_frmlicobrasmedicao.php");
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
  if($cllicobrasmedicao->erro_status=="0"){
    $cllicobrasmedicao->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cllicobrasmedicao->erro_campo!=""){
      echo "<script> document.form1.".$cllicobrasmedicao->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cllicobrasmedicao->erro_campo.".focus();</script>";
    }
  }else{
    $cllicobrasmedicao->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
  js_tabulacaoforms("form1","obr03_seqobra",true,1,"obr03_seqobra",true);
</script>
