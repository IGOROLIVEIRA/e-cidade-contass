<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("classes/db_emppresta_classe.php");
require_once("classes/db_empdescontonota_classe.php");
require_once("dbforms/db_funcoes.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clemppresta = new cl_emppresta;
$clempdescontonota = new cl_empdescontonota;
$oGet = db_utils::postMemory($_GET);
$oEmpenhooFinanceiro = EmpenhoFinanceiroRepository::getEmpenhoFinanceiroPorNumero($e60_numemp);
$rsempdescontonota = $clempdescontonota->sql_record("SELECT e46_numemp,
 e999_desconto,
 e46_nota,
 (sum(COALESCE(e46_valor,0))-sum(COALESCE(e46_desconto,0))) AS valor
 FROM empprestaitem
 JOIN emppresta ON e46_emppresta=e45_sequencial
 LEFT JOIN empdescontonota ON e999_empenho=e46_numemp
 AND e999_nota = e46_nota
 WHERE e46_numemp = $e60_numemp
 GROUP BY e46_nota, e46_numemp, e999_desconto
 ORDER BY e46_nota;");

$nTotalEmp = round($oEmpenhooFinanceiro->getValorEmpenho(),2);
$dadosItensNota = db_utils::getColectionByRecord($rsempdescontonota);
$db_opcao = 2;
$db_botao = true;

if (isset($atualizar) ) {
  $desconto = array();
  $i=0;
  foreach ($dadosItensNota as $nota) {
    $desconto[] = (float)$_POST['desconto'.$i];
    $i++;
  }

  db_inicio_transacao();
  $sqlerro = false;

  $oEmpenhoFinanceiro = EmpenhoFinanceiroRepository::getEmpenhoFinanceiroPorNumero($e60_numemp);
  $oPrestacaoContas = new PrestacaoConta($oEmpenhoFinanceiro, $oGet->e45_sequencial);
  if ( count($oPrestacaoContas->getItens()) == 0) {
    $sqlerro = true;
    $erro_msg = "Nenhum item lançado na prestação de contas.";
  } else {
    foreach ($oPrestacaoContas->getItens() as $oItem) {
      if ($oItem->e46_obs != '') {
        $sqlerro = true;
        $erro_msg = "Prestação de contas com observação no item {$oItem->e46_codigo}. Encerramento abortado.";
        break;
      }
    }
    if ($sqlerro != true) {
      $i=0;
      foreach ($dadosItensNota as $nota) {
        $clempdescontonota->e999_nota = $nota->e46_nota;
        $clempdescontonota->e999_valor = $nota->valor;
        $clempdescontonota->e999_empenho = $e60_numemp;
        $clempdescontonota->e999_desconto = $desconto[$i];
        $oDadosNt = $clempdescontonota->sql_record($clempdescontonota->sql_query(null,"*",null, "e999_nota='$nota->e46_nota' and e999_empenho = $e60_numemp"));

        if($clempdescontonota->numrows > 0){
          $oDadosNt = db_utils::fieldsMemory($oDadosNt);
          $clempdescontonota->alterar($oDadosNt->e999_sequencial);

        }else{
          $clempdescontonota->e999_sequencial = null;
          $clempdescontonota->incluir();
        }
        if($clempdescontonota->erro_status==0){

          $erro_msg = $clempdescontonota->erro_msg;
        }
        $i++;
      }
      $clemppresta->e45_numemp = $e60_numemp;
      $clemppresta->e45_sequencial = $oGet->e45_sequencial;
      $clemppresta->alterar($oGet->e45_sequencial);

      $erro_msg = $clemppresta->erro_msg;

      if ($clemppresta->erro_status == 0) {
        $sqlerro = true;
      }
    }
  }
  db_fim_transacao($sqlerro);
  $rsempdescontonota = $clempdescontonota->sql_record("SELECT e46_numemp,
   e999_desconto,
   e46_nota,
   (sum(COALESCE(e46_valor,0))-sum(COALESCE(e46_desconto,0))) AS valor
   FROM empprestaitem
   JOIN emppresta ON e46_emppresta=e45_sequencial
   LEFT JOIN empdescontonota ON e999_empenho=e46_numemp
   AND e999_nota = e46_nota
   WHERE e46_numemp = $e60_numemp
   GROUP BY e46_nota, e46_numemp, e999_desconto
   ORDER BY e46_nota;");

  $dadosItensNota = db_utils::getColectionByRecord($rsempdescontonota);
}

if (isset($oGet->e45_sequencial)) {
  $result = $clemppresta->sql_record( $clemppresta->sql_query_file($oGet->e45_sequencial,"e45_acerta") );

  db_fieldsmemory($result,0);

  if ($e45_acerta == '' ) {
    $db_opcao = 1;
  } else {
    $db_opcao = 2;
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
</head>
<body bgcolor=#CCCCCC leftmargin="0" style="margin-top: 30px" marginwidth="0" marginheight="0" onLoad="a=1" >
  <center>
   <?php
   require_once("forms/db_frmempprestaencerra.php");
   ?>
 </center>
</body>
</html>
<?php
if(isset($atualizar)){
  db_msgbox($erro_msg);
  echo "<script> parent.location.href='emp1_emppresta002.php'</script>";
}
?>
