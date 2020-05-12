<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_homologacaoadjudica_classe.php");
include("classes/db_liclicita_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_condataconf_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clhomologacaoadjudica = new cl_homologacaoadjudica;
$clitenshomologacao    = new cl_itenshomologacao;
$clliclicita           = new cl_liclicita;
$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  
  if($l20_usaregistropreco == 'f' && empty($l202_dataadjudicacao)) {
    echo "<script>alert('Campo Data AdjudicaÃ§Ã£o Ã© ObrigatÃ³rio');</script>";
    db_redireciona('lic1_homologacaoadjudica001.php');
  }

//  /**
//   * Verificar Encerramento Periodo Contabil
//   */
//  $datahomologacao = db_utils::fieldsMemory(db_query($clhomologacaoadjudica->sql_query_file($l202_sequencial,"l202_datahomologacao")),0)->l202_datahomologacao;
//  if (!empty($datahomologacao)) {
//    $clcondataconf = new cl_condataconf;
//    if (!$clcondataconf->verificaPeriodoContabil($datahomologacao)) {
//      echo "<script>alert('{$clcondataconf->erro_msg}');</script>";
//      db_redireciona('lic1_homologacaoadjudica002.php');
//    }
//  }


    /**
     * Verificar Encerramento Periodo Patrimonial e data do julgamento da licitação
     */

  if (!empty($l202_datahomologacao)) {
    $clcondataconf = new cl_condataconf;
    if (!$clcondataconf->verificaPeriodoPatrimonial($l202_datahomologacao)) {
      echo "<script>alert('{$clcondataconf->erro_msg}');</script>";
      db_redireciona('lic1_homologacaoadjudica002.php');
    }

    $clliclicitasituacao  = new cl_liclicitasituacao;
    $sOrder               = 'l11_sequencial desc';
    $sWhere               = 'l11_liclicita = '.$l202_licitacao.'and l11_licsituacao = 1';
    $sSql                 = $clliclicitasituacao->sql_query(null, 'l11_data', $sOrder, $sWhere);
    $rsResult             = db_query($sSql);

    $sSql                 = $clliclicita->sql_query_file('', 'l20_dataaber, l20_licsituacao','','l20_codigo = '.$l202_licitacao);
    $oLicitacao           = db_utils::fieldsMemory(db_query($sSql), 0);

    if(pg_numrows($rsResult) > 0){

        if($oLicitacao->l20_licsituacao == 1 || $oLicitacao->l20_licsituacao == 10) {

          $oLicSituacao       = db_utils::fieldsMemory($rsResult, 0);

          $dtDataJulg         = $oLicSituacao->l11_data;
          $dtDataJulgShow     = str_replace('-', '/', date('d-m-Y', strtotime($dtDataJulg)));
          $dtDataHomologacao  = date('Y-m-d', strtotime(str_replace('/', '-', $l202_datahomologacao)));

          if($dtDataHomologacao < $dtDataJulg){

            $clliclicitasituacao->erro_msg = 'Licitação julgada em '.$dtDataJulgShow.'. A data da homologação deverá ser igual ou superior a data de julgamento.';
            echo "<script>alert('{$clliclicitasituacao->erro_msg}');</script>";
            db_redireciona('lic1_homologacaoadjudica002.php');

          }
      }
    }
  }

  db_inicio_transacao();
  $db_opcao = 2;
  $clhomologacaoadjudica->alterar($l202_sequencial);
  $clhomologacaoadjudica->excluirItens($l202_sequencial);

  $l203_itens = explode(',', $l203_itens[0]);

  foreach ($l203_itens as $item) {
    $clitenshomologacao->l203_item                = $item;
    $clitenshomologacao->l203_homologaadjudicacao = $clhomologacaoadjudica->l202_sequencial;
    $clitenshomologacao->incluir(null);
  }

  db_fim_transacao();
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
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
if(isset($alterar)){
  if($clhomologacaoadjudica->erro_status=="0"){
    $clhomologacaoadjudica->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clhomologacaoadjudica->erro_campo!=""){
      echo "<script> document.form1.".$clhomologacaoadjudica->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clhomologacaoadjudica->erro_campo.".focus();</script>";
    }
  }else{
    $clhomologacaoadjudica->erro(true,true);
  }
}
if($db_opcao==22){
  echo "<script>js_pesquisa(true);</script>";
}
?>
<script>
js_tabulacaoforms("form1","l202_licitacao",true,1,"l202_licitacao",true);
</script>
