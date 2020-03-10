<?php

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
include_once "libs/db_sessoes.php";
include_once "libs/db_usuariosonline.php";

function gerarSQL($sMes, $sEnte) {

  $nEnte  = intval($sEnte);
  $nMes   = intval($sMes);
  $nAno   = intval(db_getsession('DB_anousu'));

  return "

    SELECT DISTINCT lpad(desmes.c217_funcao,2,0) funcao,
                    lpad(desmes.c217_subfuncao,3,0) subfuncao,
                    desmes.c217_natureza,
                    desmes.c217_subelemento,
                    desmes.c217_fonte,

        (SELECT sum(desatemes.c217_valorempenhado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes = {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu
             AND desatemes.c217_enteconsorciado = desmes.c217_enteconsorciado) AS empenhomes,

        (SELECT sum(desatemes.c217_valorempenhado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes <= {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu
             AND desatemes.c217_enteconsorciado = desmes.c217_enteconsorciado) AS empenhoatemes,

        (SELECT sum(desatemes.c217_valorempenhadoanulado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes = {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu
             AND desatemes.c217_enteconsorciado = desmes.c217_enteconsorciado) AS anuladomes,

        (SELECT sum(desatemes.c217_valorempenhadoanulado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes <= {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu
             AND desatemes.c217_enteconsorciado = desmes.c217_enteconsorciado) AS anuladoatemes,

        (SELECT sum(desatemes.c217_valorliquidado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes = {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu
             AND desatemes.c217_enteconsorciado = desmes.c217_enteconsorciado) AS liquidadomes,

        (SELECT sum(desatemes.c217_valorliquidado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes <= {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu
             AND desatemes.c217_enteconsorciado = desmes.c217_enteconsorciado) AS liquidadoatemes,

        (SELECT sum(desatemes.c217_valorliquidadoanulado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes = {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu
             AND desatemes.c217_enteconsorciado = desmes.c217_enteconsorciado) AS liquidadoanualdomes,

        (SELECT sum(desatemes.c217_valorliquidadoanulado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes <= {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu
             AND desatemes.c217_enteconsorciado = desmes.c217_enteconsorciado) AS liquidadoanualdoatemes,

        (SELECT sum(desatemes.c217_valorpago)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes = {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu
             AND desatemes.c217_enteconsorciado = desmes.c217_enteconsorciado) AS pagomes,

        (SELECT sum(desatemes.c217_valorpago)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes <= {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu
             AND desatemes.c217_enteconsorciado = desmes.c217_enteconsorciado) AS pagoatemes,

        (SELECT sum(desatemes.c217_valorpagoanulado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes = {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu
             AND desatemes.c217_enteconsorciado = desmes.c217_enteconsorciado) AS pagoanuladomes,

        (SELECT sum(desatemes.c217_valorpagoanulado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes <= {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu
             AND desatemes.c217_enteconsorciado = desmes.c217_enteconsorciado) AS pagoanuladoatemes
    FROM despesarateioconsorcio desmes
    WHERE desmes.c217_anousu = {$nAno}
        AND desmes.c217_enteconsorciado = {$nEnte}
    ORDER BY funcao,
             subfuncao,
             desmes.c217_natureza,
             desmes.c217_subelemento,
             desmes.c217_fonte

    ";

}

function gerarSQLReceitas($sMes, $sEnte) {

  $nEnte  = intval($sEnte);
  $nMes   = intval($sMes);
  $nAno   = intval(db_getsession('DB_anousu'));

  return "SELECT c216_tiporeceita,c218_descricao,c216_saldo3112,
               (sum(CASE
                        WHEN c71_coddoc = 100 THEN (c70_valor*(c216_percentual/100))
                        ELSE (c70_valor*(c216_percentual/100)) * -1
                    END)) AS receitasatemes
        FROM entesconsorciadosreceitas
        INNER JOIN orcreceita ON c216_receita=o70_codfon
        AND c216_anousu=o70_anousu
        LEFT JOIN conlancamrec ON c74_anousu=o70_anousu
        AND c74_codrec=o70_codrec
        LEFT JOIN conlancam ON c74_codlan=c70_codlan and date_part('MONTH',c70_data) <={$nMes} and date_part('YEAR',c70_data)={$nAno}
        LEFT JOIN conlancamdoc ON c71_codlan=c70_codlan
        INNER JOIN entesconsorciados ON c216_enteconsorciado=c215_sequencial
        INNER JOIN tipodereceitarateio ON c216_tiporeceita=c218_codigo
        WHERE  c216_enteconsorciado={$nEnte} and  c216_anousu={$nAno}
            AND c215_datainicioparticipacao <= '{$nAno}-{$nMes}-01'
        GROUP BY c216_tiporeceita,c218_descricao,c216_saldo3112
        ORDER BY c216_tiporeceita ";
}

function gerarSQLDespesas($sMes, $sEnte, $sTipo) {
  $nTipo  = intval($sTipo);
  $nEnte  = intval($sEnte);
  $nMes   = intval($sMes);
  $nAno   = intval(db_getsession('DB_anousu'));

  return "SELECT sum(c217_valorpago) despesasatemes
    FROM despesarateioconsorcio
    WHERE c217_enteconsorciado={$nEnte}
        AND substr(c217_natureza,1,2)='{$nTipo}'
        AND c217_mes<={$nMes}
        AND c217_anousu={$nAno}
    GROUP BY substr(c217_natureza,1,2)
    ORDER BY substr(c217_natureza,1,2) ";
}
$aMeses = array(
  1 => 'Janeiro',
    'Fevereiro',
    'Março',
    'Abril',
    'Maio',
    'Junho',
    'Julho',
    'Agosto',
    'Setembro',
    'Outubro',
    'Novembro',
    'Dezembro'
);

try {

  $rsRelatorio = db_query(gerarSQL($_GET['mes'], $_GET['c215_sequencial']));


  $oInfoRelatorio = new stdClass();
  $aDadosConsulta = db_utils::getCollectionByRecord($rsRelatorio);
  $oInfoRelatorio->aDados = array();

  foreach ($aDadosConsulta as $key => $oRow) {

    $nSomaLinha = $oRow->empenhomes
                + $oRow->empenhoatemes
                + $oRow->anuladomes
                + $oRow->anuladoatemes
                + $oRow->liquidadomes
                + $oRow->liquidadoatemes
                + $oRow->liquidadoanualdomes
                + $oRow->liquidadoanualdoatemes
                + $oRow->pagomes
                + $oRow->pagoatemes
                + $oRow->pagoanuladomes
                + $oRow->pagoanuladoatemes;

    if ($nSomaLinha != 0) {
      $oInfoRelatorio->aDados[] = $oRow;
    }


  }

  $rsRelatorioFinanceiro = db_query(gerarSQLReceitas($_GET['mes'], $_GET['c215_sequencial']));

  $aDadosConsultaFinanc = db_utils::getCollectionByRecord($rsRelatorioFinanceiro);

  $oInfoRelatorio->aDadosFinanceiros = array();
  $oEntes = new cl_entesconsorciados();
  foreach ($aDadosConsultaFinanc as $key => $oRow) {

    $oRelFinanceiro = new stdClass();
    $oRelFinanceiro->classificacao = $oRow->c216_tiporeceita." - ".$oRow->c218_descricao;
    $rsDesp = $oEntes->sql_record(gerarSQLDespesas($_GET['mes'], $_GET['c215_sequencial'],$oRow->c216_tiporeceita));
    $nDesp = db_utils::fieldsMemory($rsDesp, 0)->despesasatemes;
    $oRelFinanceiro->saldoinicial = $oRow->c216_saldo3112;
    $oRelFinanceiro->receitasatemes = $oRow->receitasatemes;
    $oRelFinanceiro->despesasatemes = $nDesp;
    $oRelFinanceiro->rps = 0;
    $oRelFinanceiro->saldo = $oRelFinanceiro->saldoinicial+$oRelFinanceiro->receitasatemes-$oRelFinanceiro->despesasatemes-$oRelFinanceiro->rps;
    $oInfoRelatorio->aDadosFinanceiros[] = $oRelFinanceiro;

  }

  switch ($_GET['tipoarquivo']) {
    case 'pdf':

      require_once('classes/db_entesconsorciados_classe.php');

      $oEntesCon  = new cl_entesconsorciados();
      $rsEntesCon = $oEntesCon->sql_record($oEntesCon->sql_query($_GET['c215_sequencial'], 'z01_nome'));
      $oEnte      = db_utils::fieldsMemory($rsEntesCon, 0);

      $oInfoRelatorio->aHeader = array();
      $oInfoRelatorio->aHeader[1] = 'Relatório de Rateio';
      $oInfoRelatorio->aHeader[3] = 'Ente: ' . $oEnte->z01_nome;
      $oInfoRelatorio->aHeader[4] = 'Mês: ' . $aMeses[intval($_GET['mes'])];

      require_once('con2_relatoriorateio002_pdf.php');

      break;

    case 'csv':

      require_once('con2_relatoriorateio002_csv.php');

      break;

    default:
      throw new Exception("Tipo de arquivo não suportado", 1);
      break;
  }

} catch (Exception $e) {

  db_redireciona('db_erros.php?fechar=true&db_erro=' . $e->getMessage());

}
