<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licobrasmedicao_classe.php");
include("classes/db_licobrasituacao_classe.php");
include("classes/db_condataconf_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cllicobrasmedicao = new cl_licobrasmedicao;
$cllicobrasituacao = new cl_licobrasituacao;
$clcondataconf = new cl_condataconf;

$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  $dtfimmedicao = DateTime::createFromFormat('d/m/Y', $obr03_dtfimmedicao);
  $dtiniciomedicao = DateTime::createFromFormat('d/m/Y', $obr03_dtiniciomedicao);
  $dtentregamedicao = DateTime::createFromFormat('d/m/Y', $obr03_dtentregamedicao);
  $dtlancamentomedicao = DateTime::createFromFormat('d/m/Y', $obr03_dtlancamento);

  $data = (implode("/",(array_reverse(explode("-",$obr02_dtsituacao)))));
  $dtsituacao = DateTime::createFromFormat('d/m/Y', $data);

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

    $resultsituacao = $cllicobrasituacao->sql_record($cllicobrasituacao->sql_query(null,"*",null,"obr02_seqobra = $obr03_seqobra and obr02_situacao = 7"));

    if(pg_num_rows($resultsituacao > 0)){
      if($dtentregamedicao >= $dtsituacao){
        throw new Exception("Obra Concluída e recebida definitivamente!");
      }
    }

    if($dtfimmedicao < $dtiniciomedicao){
      throw new Exception("Usuário: Data Fim da Medição deve ser igual ou maior que Data Inicio da Medição.");
    }

    if($dtentregamedicao < $dtfimmedicao){
      throw new Exception("Usuário: Entrega da Medição deve ser igual ou maior que Fim da Medição.");
    }

    if($obr03_nummedicao != null){
      $resultMedicao = $cllicobrasmedicao->sql_record($cllicobrasmedicao->sql_query_file(null,"*",null,"obr03_nummedicao = $obr03_nummedicao and obr03_seqobra = $obr03_seqobra"));

      if(pg_num_rows($resultMedicao) > 0){
        throw new Exception("Usuário: Numero da Medição já utilizado.");
      }
    }

    if ($obr03_vlrmedicao == null || $obr03_vlrmedicao == "0"){
      throw new Exception("Usuário: Valor Medição nao informado.");
    }

    db_inicio_transacao();
    $cllicobrasmedicao->obr03_seqobra            = $obr03_seqobra;
    $cllicobrasmedicao->obr03_dtlancamento       = $obr03_dtlancamento;
    $cllicobrasmedicao->obr03_nummedicao         = $obr03_nummedicao;
    $cllicobrasmedicao->obr03_tipomedicao        = $obr03_tipomedicao;
    $cllicobrasmedicao->obr03_dtiniciomedicao    = $obr03_dtiniciomedicao;
    $cllicobrasmedicao->obr03_outrostiposmedicao = $obr03_outrostiposmedicao;
    $cllicobrasmedicao->obr03_descmedicao        = $obr03_descmedicao;
    $cllicobrasmedicao->obr03_dtfimmedicao       = $obr03_dtfimmedicao;
    $cllicobrasmedicao->obr03_dtentregamedicao   = $obr03_dtentregamedicao;
    $cllicobrasmedicao->obr03_vlrmedicao         = $obr03_vlrmedicao;
    $cllicobrasmedicao->obr03_instit             = db_getsession('DB_instit');
    $cllicobrasmedicao->incluir();
    db_fim_transacao();

    if($cllicobrasmedicao->erro_status == 0){
      $erro = $cllicobrasmedicao->erro_msg;
      $sqlerro = true;
    }
    db_fim_transacao();
    if($sqlerro == false){
      db_redireciona("obr1_licobrasmedicao002.php?&chavepesquisa=$cllicobrasmedicao->obr03_sequencial");
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
    /*background-color:#E6E4F1;*/
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
<script>
js_tabulacaoforms("form1","obr03_seqobra",true,1,"obr03_seqobra",true);
</script>
<?
if(isset($incluir)){
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
?>
