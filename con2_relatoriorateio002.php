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
             AND desmes.c217_anousu = desatemes.c217_anousu) AS empenhomes,

        (SELECT sum(desatemes.c217_valorempenhado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes < {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu) AS empenhoatemes,

        (SELECT sum(desatemes.c217_valorempenhadoanulado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes = {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu) AS anuladomes,

        (SELECT sum(desatemes.c217_valorempenhadoanulado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes < {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu) AS anuladoatemes,

        (SELECT sum(desatemes.c217_valorliquidado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes = {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu) AS liquidadomes,

        (SELECT sum(desatemes.c217_valorliquidado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes < {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu) AS liquidadoatemes,

        (SELECT sum(desatemes.c217_valorliquidadoanulado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes = {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu) AS liquidadoanualdomes,

        (SELECT sum(desatemes.c217_valorliquidadoanulado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes < {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu) AS liquidadoanualdoatemes,

        (SELECT sum(desatemes.c217_valorpago)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes = {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu) AS pagomes,

        (SELECT sum(desatemes.c217_valorpago)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes < {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu) AS pagoatemes,

        (SELECT sum(desatemes.c217_valorpagoanulado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes = {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu) AS pagoanuladomes,

        (SELECT sum(desatemes.c217_valorpagoanulado)
         FROM despesarateioconsorcio desatemes
         WHERE desmes.c217_funcao=desatemes.c217_funcao
             AND desmes.c217_subfuncao=desatemes.c217_subfuncao
             AND desmes.c217_natureza=desatemes.c217_natureza
             AND desmes.c217_subelemento =desatemes.c217_subelemento
             AND desmes.c217_fonte =desatemes.c217_fonte
             AND desatemes.c217_mes < {$nMes}
             AND desmes.c217_anousu = desatemes.c217_anousu) AS pagoanuladoatemes
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
  $oInfoRelatorio->aDados = db_utils::getCollectionByRecord($rsRelatorio);

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
