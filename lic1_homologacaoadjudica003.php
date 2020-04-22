<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_homologacaoadjudica_classe.php");
include("classes/db_liclicita_classe.php");
include("dbforms/db_funcoes.php");
include("libs/db_utils.php");
include("classes/db_condataconf_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clhomologacaoadjudica = new cl_homologacaoadjudica;
$clpcprocitem          = new cl_pcprocitem;
$clliclicita           = new cl_liclicita;
$db_botao = false;
$db_opcao = 33;

$result = $clhomologacaoadjudica->sql_record($clpcprocitem->sql_query_pcmater(null,"e54_autori,e54_anulad","pc80_codproc,pc11_codigo","l21_codliclicita=$l202_licitacao"));
$iCodAutori  = db_utils::fieldsMemory($result, 0)->e54_autori;
$sAnulad     = db_utils::fieldsMemory($result, 0)->e54_anulad;

if(isset($excluir)){
  if(!empty($iCodAutori) && empty($sAnulad) ) {
    echo "<script>alert('A licitacao ja possui autorizacoes de empenho geradas')</script>";
    db_redireciona('lic1_homologacaoadjudica003.php');
  } else {
    db_inicio_transacao();
    $db_opcao = 3;
//   /**
//    * Verificar Encerramento Periodo Contabil
//    */
//    $datahomologacao = db_utils::fieldsMemory(db_query($clhomologacaoadjudica->sql_query_file($l202_sequencial,"l202_datahomologacao")),0)->l202_datahomologacao;
//    if (!empty($datahomologacao)) {
//      $clcondataconf = new cl_condataconf;
//      if (!$clcondataconf->verificaPeriodoContabil($datahomologacao)) {
//        echo "<script>alert('{$clcondataconf->erro_msg}');</script>";
//        db_redireciona('lic1_homologacaoadjudica003.php');
//      }
//    }

      /**
       * Verificar Encerramento Periodo Patrimonial
       */
      $datahomologacao = db_utils::fieldsMemory(db_query($clhomologacaoadjudica->sql_query_file($l202_sequencial,"l202_datahomologacao")),0)->l202_datahomologacao;

      if (!empty($datahomologacao)) {
          $clcondataconf = new cl_condataconf;
          if (!$clcondataconf->verificaPeriodoPatrimonial($datahomologacao)) {
              echo "<script>alert('{$clcondataconf->erro_msg}');</script>";
              db_redireciona('lic1_homologacaoadjudica003.php');
          }
      }

    $clhomologacaoadjudica->excluirItens($l202_sequencial);
    $clhomologacaoadjudica->excluir($l202_sequencial);
    $clhomologacaoadjudica->alteraLicitacao($l202_licitacao,1);
    db_fim_transacao();
    db_redireciona('lic1_homologacaoadjudica003.php');
  }
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $clhomologacaoadjudica->sql_record($clhomologacaoadjudica->sql_query($chavepesquisa)); 
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
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<center>
  <fieldset style=" margin-top: 30px; width: 500px; height: 400px;">
  <legend>Homologacao Adjudicacao</legend>
  <?
  include("forms/db_frmhomologacaoadjudica.php");
  ?>
    </fieldset>
  </center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($excluir)){
  if($clhomologacaoadjudica->erro_status=="0"){
    $clhomologacaoadjudica->erro(true,false);
  }else{
    $clhomologacaoadjudica->erro(true,true);
  }
}
if($db_opcao==33){
  echo "<script>js_pesquisa(true);</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
