<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licobras_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_homologacaoadjudica_classe.php");
db_postmemory($HTTP_POST_VARS);
$cllicobras = new cl_licobras;
$clhomologacaoadjudica = new cl_homologacaoadjudica();

$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){

  $resulthomologacao = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query_file(null,"l202_datahomologacao",null,"l202_licitacao = $obr01_licitacao"));
  db_fieldsmemory($resulthomologacao,0);
  $dtHomologacaolic = (implode("/",(array_reverse(explode("-",$l202_datahomologacao)))));


  try {

    if($obr01_dtinicioatividades > $dtHomologacaolic){
      throw new Exception ("Usuário: Campo Data de Inicio das atividades maior que data de Homologação da Licitação.");
    }

    db_inicio_transacao();
    $cllicobras->obr01_licitacao           = $obr01_licitacao;
    $cllicobras->obr01_dtlancamento        = $obr01_dtlancamento;
    $cllicobras->obr01_numeroobra          = $obr01_numeroobra;
    $cllicobras->obr01_linkobra            = $obr01_linkobra;
    $cllicobras->obr01_tiporesponsavel     = $obr01_tiporesponsavel;
    $cllicobras->obr01_responsavel         = $obr01_responsavel;
    $cllicobras->obr01_tiporegistro        = $obr01_tiporegistro;
    $cllicobras->obr01_numregistro         = $obr01_numregistro;
    $cllicobras->obr01_numartourrt         = $obr01_numartourrt;
    $cllicobras->obr01_dtinicioatividades  = $obr01_dtinicioatividades;
    $cllicobras->obr01_vinculoprofissional = $obr01_vinculoprofissional;
    $cllicobras->obr01_instit              = db_getsession('DB_instit');
    $cllicobras->incluir();

    db_fim_transacao();


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
