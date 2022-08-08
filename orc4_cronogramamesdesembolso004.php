<?
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_cronogramamesdesembolso_classe.php");
require_once("classes/db_orcorgao_classe.php");
require_once("classes/db_orcunidade_classe.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_liborcamento.php");
db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);

$clcronogramamesdesembolso = new cl_cronogramamesdesembolso;
$clorcunidade = new cl_orcunidade;
$clorcorgao = new cl_orcorgao;
$db_opcao = 1;
$db_botao = true;
try {

  $instit = db_getsession("DB_instit");
  $anousu = db_getsession("DB_anousu");
  if (!isset($o40_orgao)) {
    $sWhere  = " o40_anousu     = ".db_getSession("DB_anousu");
    $sWhere .= " and o41_instit = ".db_getSession("DB_instit");
    $sWhere .= " and exists (select 1 from orcdotacao inner join orcelemento on orcdotacao.o58_codele = orcelemento.o56_codele  where o58_orgao=o40_orgao and o58_anousu=o40_anousu and o58_unidade=o41_unidade and substring(o56_elemento,1,3) != '399')";
    $result = $clorcunidade->sql_record($clorcunidade->sql_query(
     null,null,null,"distinct o40_orgao,o40_descr,o41_unidade","o40_descr",$sWhere));
    db_fieldsmemory($result,0);
  }

  /**
   * Transacao necessaria por causa das tabelas criadas pela funcao db_dotacaosaldo
   */
  db_inicio_transacao();
  $where = " w.o58_orgao = {$o40_orgao} and w.o58_unidade = {$o41_unidade} and w.o58_instit = {$instit}";
  $rsTabela = db_dotacaosaldo(7,2,3,true,$where,$anousu,$anousu."-01-01",$anousu."-12-31",null,null,false,1);
  $aTipoDespesa = array("331" => "1-Pessoal e Encargos Sociais",
    "332" => "2-Juros e Encargos de Dívida",
    "333" => "3-Outras Despesas Correntes",
    "344" => "4-Investimentos",
    "345" => "5-Inversão Financeira",
    "346" => "6-Amortização da Dívida");
  $aDespesa = array();
  for ($iCont=0; $iCont < pg_num_rows($rsTabela); $iCont++) {
    $oDados = db_utils::fieldsMemory($rsTabela, $iCont);
    $sNivel = substr($oDados->o58_elemento,0,3);
    if (!isset($aTipoDespesa[$sNivel])) {
      continue;
    }
    if (!isset($aDespesa[$sNivel])) {
      $oDespesa = new stdClass();
      $oDespesa->nTotalOrcado = $oDados->dot_ini;
      $aDespesa[$sNivel] = $oDespesa;
    } else {
      $aDespesa[$sNivel]->nTotalOrcado += $oDados->dot_ini;
    }
  }


  /**
   * Verifica se existe cronograma para este orgao e unidade
   */
  $verificaResult = $clcronogramamesdesembolso->verificaResult($instit, $anousu, $o40_orgao, $o41_unidade);

  if (isset($salvar)) {


    if ($verificaResult) {
      $clcronogramamesdesembolso->removeCronograma($instit, $anousu, $o40_orgao, $o41_unidade);
      if ($clcronogramamesdesembolso->erro_status=="0") {
        throw new Exception("Erro ao remover Cronograma. ".$clcronogramamesdesembolso->erro_msg);
      }
    }
    foreach ($aDespesa as $sKey => $oDespesa) {

      $clcronogramamesdesembolso->o202_unidade   = $o41_unidade;
      $clcronogramamesdesembolso->o202_orgao     = $o40_orgao;
      $clcronogramamesdesembolso->o202_anousu    = $anousu;
      $clcronogramamesdesembolso->o202_instit    = $instit;
      $clcronogramamesdesembolso->o202_elemento  = str_pad($sKey, 13, "0", STR_PAD_RIGHT);
      $clcronogramamesdesembolso->o202_janeiro   = ${"o202_janeiro{$sKey}"};
      $clcronogramamesdesembolso->o202_fevereiro = ${"o202_fevereiro{$sKey}"};
      $clcronogramamesdesembolso->o202_marco     = ${"o202_marco{$sKey}"};
      $clcronogramamesdesembolso->o202_abril     = ${"o202_abril{$sKey}"};
      $clcronogramamesdesembolso->o202_maio      = ${"o202_maio{$sKey}"};
      $clcronogramamesdesembolso->o202_junho     = ${"o202_junho{$sKey}"};
      $clcronogramamesdesembolso->o202_julho     = ${"o202_julho{$sKey}"};
      $clcronogramamesdesembolso->o202_agosto    = ${"o202_agosto{$sKey}"};
      $clcronogramamesdesembolso->o202_setembro  = ${"o202_setembro{$sKey}"};
      $clcronogramamesdesembolso->o202_outubro   = ${"o202_outubro{$sKey}"};
      $clcronogramamesdesembolso->o202_novembro  = ${"o202_novembro{$sKey}"};
      $clcronogramamesdesembolso->o202_dezembro  = ${"o202_dezembro{$sKey}"};

      /**
       * Verificar valores antes de inserir
       */
      if (round($clcronogramamesdesembolso->getSomaValores(),2) != round($oDespesa->nTotalOrcado,2)) {
        throw new Exception("O valor Orçado está diferente do valor Programado para o grupo ".$aTipoDespesa[$sKey]);
      }
      $clcronogramamesdesembolso->incluir(null);
      if ($clcronogramamesdesembolso->erro_status=="0") {
        throw new Exception("Erro ao incluir/alterar grupo ".$aTipoDespesa[$sKey].". ".$clcronogramamesdesembolso->erro_msg);
      }

    }

  } else if ($verificaResult) {

    /**
     * Cria as variaveis com os valores para cada mes, de cara grupo da despesa
     */
    foreach ($aDespesa as $sKey => $oDespesa) {
      $rsValores = $clcronogramamesdesembolso->getValores($instit, $anousu, $o40_orgao, $o41_unidade, $sKey);
      db_fieldsmemory($rsValores, 0);
    }

  }
  db_fim_transacao(true);
} catch (Exception $oErro) {

  db_fim_transacao(true);
  $clcronogramamesdesembolso->erro_status = '0';
  $clcronogramamesdesembolso->erro_msg = $oErro->getMessage();
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
  .linha-tabela {
    background-color: #999999;
  }
  .tbody {
  overflow: auto;
}
</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
  <br><br>

  <center>
   <?
   include("forms/db_frmcronogramamesdesembolso.php");
   ?>
 </center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","o202_unidade",true,1,"o202_unidade",true);
</script>
<?
if(isset($salvar)){
  if($clcronogramamesdesembolso->erro_status=="0"){
    $clcronogramamesdesembolso->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clcronogramamesdesembolso->erro_campo!=""){
      echo "<script> document.form1.".$clcronogramamesdesembolso->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clcronogramamesdesembolso->erro_campo.".focus();</script>";
    }
  }else{
    $clcronogramamesdesembolso->erro(true,false);
  }
}
?>
