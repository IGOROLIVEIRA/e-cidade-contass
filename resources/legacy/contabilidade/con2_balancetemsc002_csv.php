<?php

include("libs/db_utils.php");
include("std/DBDate.php");
include("dbforms/db_funcoes.php");
include("fpdf151/pdf.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);

$aMeses = array(
  "JANEIRO" => "1", "FEVEREIRO" => "2", "MARÇO" => "3", "ABRIL" => "4", "MAIO" => "5", "JUNHO" => "6",
  "JULHO" => "7", "AGOSTO" => "8", "SETEMBRO" => "9", "OUTUBRO" => "10", "NOVEMBRO" => "11", "DEZEMBRO" => "12"
);

$aTipoValor = array('beginning_balance', 'period_change_deb', 'period_change_cred', 'ending_balance');

$iInstit = db_getsession('DB_instit');
$iAnoUsu      = date("Y", db_getsession("DB_datausu"));
$iMes         = (!empty($aFiltros['mes']))     ? $aFiltros['mes'] : '';
$sInstituicao = ($aFiltros['matriz'] == 'd')   ? " r.c61_instit = $iInstit and " : '';
$sTipoInstit  = !empty($sInstituicao)          ? " limit 1 " : '';
$aRegistros   = array();
$iConta       = "";
$_arquivo     = "";

$iTotalAtivoBB = 0;
$iTotalAtivoPD = 0;
$iTotalAtivoPC = 0;
$iTotalAtivoEB = 0;

$iTotalPassivoPatrimonioLiquidoBB = 0;
$iTotalPassivoPatrimonioLiquidoPD = 0;
$iTotalPassivoPatrimonioLiquidoPC = 0;
$iTotalPassivoPatrimonioLiquidoEB = 0;

$iTotalVariacaoPatrimonialDiminutivaBB = 0;
$iTotalVariacaoPatrimonialDiminutivaPD = 0;
$iTotalVariacaoPatrimonialDiminutivaPC = 0;
$iTotalVariacaoPatrimonialDiminutivaEB = 0;

$iTotalVariacaoPatrimonialAumentativaBB = 0;
$iTotalVariacaoPatrimonialAumentativaPD = 0;
$iTotalVariacaoPatrimonialAumentativaPC = 0;
$iTotalVariacaoPatrimonialAumentativaEB = 0;

$iTotalControlesAprovacaoPlanejamentoOrcamentoBB = 0;
$iTotalControlesAprovacaoPlanejamentoOrcamentoPD = 0;
$iTotalControlesAprovacaoPlanejamentoOrcamentoPC = 0;
$iTotalControlesAprovacaoPlanejamentoOrcamentoEB = 0;

$iTotalControlesExecucaoPlanejamentoOrcamentoBB = 0;
$iTotalControlesExecucaoPlanejamentoOrcamentoPD = 0;
$iTotalControlesExecucaoPlanejamentoOrcamentoPC = 0;
$iTotalControlesExecucaoPlanejamentoOrcamentoEB = 0;

$iTotalControlesDevedoresBB = 0;
$iTotalControlesDevedoresPD = 0;
$iTotalControlesDevedoresPC = 0;
$iTotalControlesDevedoresEB = 0;

$iTotalControlesCredoresBB = 0;
$iTotalControlesCredoresPD = 0;
$iTotalControlesCredoresPC = 0;
$iTotalControlesCredoresEB = 0;

try {

  $sMscPath = "model/contabilidade/arquivos/msc/{$iAnoUsu}";

  if ($iMes == 13) {

    $iMes = 12;
    $sMscFilePath = "{$sMscPath}/MSCEncerramento.model.php";

    if (file_exists($sMscFilePath)) {

      require_once($sMscFilePath);
      $msc = new MSCEncerramento;

    } else {
      throw new Exception ("Arquivo MSCEncerramento para o ano {$iAnoUsu} não existe. ");
    }

  } else {

    $sMscFilePath = "{$sMscPath}/MSC.model.php";

    if (file_exists($sMscFilePath)) {

      require_once($sMscFilePath);
      $msc = new MSC;

    } else {
      throw new Exception ("Arquivo MSC para o ano {$iAnoUsu} não existe. ");
    }

  }
  $sSQL = "
          select si09_instsiconfi, db21_nome
            from infocomplementaresinstit
              inner join db_config on codigo = si09_instit
              inner join db_tipoinstit on db21_codtipo = db21_tipoinstit
                order by db21_codtipo {$sTipoInstit}";

  $rsResult = db_query($sSQL);
  $sIdentifier = db_utils::fieldsMemory($rsResult,0)->si09_instsiconfi;

  if (empty($sIdentifier)) {
    throw new Exception ("Não existe código SICONFI para a Prefeitura no cadastro de Instituições");
  }
  $virgula       = "";
  $sInstituicoes = "";
  for($i=0; $i < pg_num_rows($rsResult); $i++) {
    $aux = explode(" ", strtoupper(db_utils::fieldsMemory($rsResult,$i)->db21_nome));
    $sInstituicoes .= $virgula.$aux[0];
    $virgula = ", ";
  }

  $msc->setTipoMatriz($sInstituicao);
  $aRegis = $msc->getConsulta($iAnoUsu, $iMes);
  $aRegistros = $msc->getRegistrosRelatorio($aRegis);

  if ($msc->getErroSQL() > 0 ) {
    throw new Exception ("Ocorreu um erro ao consultar a IC ".$msc->getErroSQL());
  }

} catch (Exception $e) {
  echo $e->getMessage();
}

$_arquivo = fopen("tmp/balanceteMSC.csv", "w");

$aCSV['info'] = "BALANCETE MSC - EXERCÍCIO: {$iAnoUsu} - PERÍODO: ".array_search($iMes, $aMeses)." - INSTIUIÇÕES: {$sInstituicoes}";
$sLinha = $aCSV;

$aLinha = array();
foreach ($sLinha as $sLin) {
  if ($sLin == '' || $sLin == null) {
    $sLin = ' ';
  }
  $aLinha[] = $sLin;
}
$sLin = implode(";", $aLinha);
fputs($_arquivo, $sLin);
fputs($_arquivo, "\r\n");

$aCabecalhoCSV['cont'] = 'CONTA';
$aCabecalhoCSV['sa']   = 'SALDO ANTERIOR';
$aCabecalhoCSV['nssa'] = 'NATUREZA SALDO';
$aCabecalhoCSV['deb']  = 'DÉBITOS';
$aCabecalhoCSV['cred'] = 'CRÉDITOS';
$aCabecalhoCSV['s']    = 'SALDO';
$aCabecalhoCSV['nss']  = 'NATUREZA SALDO';
$sLinha = $aCabecalhoCSV;

$aLinha = array();
foreach ($sLinha as $sLin) {
  if ($sLin == '' || $sLin == null) {
    $sLin = ' ';
  }
  $aLinha[] = $sLin;
}
$sLin = implode(";", $aLinha);
fputs($_arquivo, $sLin);
fputs($_arquivo, "\r\n");

foreach ($aRegistros as $aRegistro) {

  $sBeginning_balance  = $aRegistro->beginning_balance >= 0 ? $aRegistro->beginning_balance == 0 ? "$aRegistro->beginning_balance" : "$aRegistro->beginning_balance D" : abs($aRegistro->beginning_balance)." C";
  $sEnding_balance     = $aRegistro->ending_balance    >= 0 ? $aRegistro->ending_balance    == 0 ? "$aRegistro->ending_balance"    : "$aRegistro->ending_balance D"     : abs($aRegistro->ending_balance)." C";
  $sPeriod_change_deb  = $aRegistro->period_change_deb;
  $sPeriod_change_cred = abs($aRegistro->period_change_cred);

  $tipo = substr($aRegistro->conta,0,1);

  switch ($tipo) {
    case '1':
      $iTotalAtivoBB += $aRegistro->beginning_balance;
      $iTotalAtivoPD += $aRegistro->period_change_deb;
      $iTotalAtivoPC += $aRegistro->period_change_cred;
      $iTotalAtivoEB += $aRegistro->ending_balance;
    break;

    case '2':
      $iTotalPassivoPatrimonioLiquidoBB += $aRegistro->beginning_balance;
      $iTotalPassivoPatrimonioLiquidoPD += $aRegistro->period_change_deb;
      $iTotalPassivoPatrimonioLiquidoPC += $aRegistro->period_change_cred;
      $iTotalPassivoPatrimonioLiquidoEB += $aRegistro->ending_balance;
    break;

    case '3':
      $iTotalVariacaoPatrimonialDiminutivaBB += $aRegistro->beginning_balance;
      $iTotalVariacaoPatrimonialDiminutivaPD += $aRegistro->period_change_deb;
      $iTotalVariacaoPatrimonialDiminutivaPC += $aRegistro->period_change_cred;
      $iTotalVariacaoPatrimonialDiminutivaEB += $aRegistro->ending_balance;
    break;

    case '4':
      $iTotalVariacaoPatrimonialAumentativaBB += $aRegistro->beginning_balance;
      $iTotalVariacaoPatrimonialAumentativaPD += $aRegistro->period_change_deb;
      $iTotalVariacaoPatrimonialAumentativaPC += $aRegistro->period_change_cred;
      $iTotalVariacaoPatrimonialAumentativaEB += $aRegistro->ending_balance;
    break;

    case '5':
      $iTotalControlesAprovacaoPlanejamentoOrcamentoBB += $aRegistro->beginning_balance;
      $iTotalControlesAprovacaoPlanejamentoOrcamentoPD += $aRegistro->period_change_deb;
      $iTotalControlesAprovacaoPlanejamentoOrcamentoPC += $aRegistro->period_change_cred;
      $iTotalControlesAprovacaoPlanejamentoOrcamentoEB += $aRegistro->ending_balance;
    break;

    case '6':
      $iTotalControlesExecucaoPlanejamentoOrcamentoBB += $aRegistro->beginning_balance;
      $iTotalControlesExecucaoPlanejamentoOrcamentoPD += $aRegistro->period_change_deb;
      $iTotalControlesExecucaoPlanejamentoOrcamentoPC += $aRegistro->period_change_cred;
      $iTotalControlesExecucaoPlanejamentoOrcamentoEB += $aRegistro->ending_balance;
    break;

    case '7':
      $iTotalControlesDevedoresBB += $aRegistro->beginning_balance;
      $iTotalControlesDevedoresPD += $aRegistro->period_change_deb;
      $iTotalControlesDevedoresPC += $aRegistro->period_change_cred;
      $iTotalControlesDevedoresEB += $aRegistro->ending_balance;
    break;

    case '8':
      $iTotalControlesCredoresBB += $aRegistro->beginning_balance;
      $iTotalControlesCredoresPD += $aRegistro->period_change_deb;
      $iTotalControlesCredoresPC += $aRegistro->period_change_cred;
      $iTotalControlesCredoresEB += $aRegistro->ending_balance;

    break;

  }

  $aRegistrosCSV[0] = trim($aRegistro->conta);
  $aRegistrosCSV[1] = abs($aRegistro->beginning_balance);
  $aRegistrosCSV[2] = $aRegistro->beginning_balance >= 0 ? $aRegistro->beginning_balance == 0 ? '' : 'D' : 'C';
  $aRegistrosCSV[3] = $aRegistro->period_change_deb;
  $aRegistrosCSV[4] = abs($aRegistro->period_change_cred);
  $aRegistrosCSV[5] = abs($aRegistro->ending_balance);
  $aRegistrosCSV[6] = $aRegistro->ending_balance >= 0 ? $aRegistro->ending_balance == 0 ? '' : 'D' : 'C';

  $sLinha = $aRegistrosCSV;

  $aLinha = array();
  foreach ($sLinha as $sLin) {
    if ($sLin == '' || $sLin == null) {
      $sLin = ' ';
    }
    $aLinha[] = $sLin;
  }
  $sLin = implode(";", $aLinha);
  fputs($_arquivo, $sLin);
  fputs($_arquivo, "\r\n");

}

$aTotais = array(
  "TOTAL ATIVO"=>"iTotalAtivo",
  "TOTAL PASSIVO E PATRIMÔNIO LIQUIDO"=>"iTotalPassivoPatrimonioLiquido",
  "TOTAL VARIAÇÃO PATRIMONIAL DIMINUTIVA"=>"iTotalVariacaoPatrimonialDiminutiva",
  "TOTAL VARIAÇÃO PATRIMONIAL AUMENTATIVA"=>"iTotalVariacaoPatrimonialAumentativa",
  "TOTAL CONTROLES DA APROVAÇÃO DO PLANEJAMENTO E ORÇAMENTO"=>"iTotalControlesAprovacaoPlanejamentoOrcamento",
  "TOTAL CONTROLES DA EXECUÇÃO DO PLANEJAMENTO E ORÇAMENTO"=>"iTotalControlesExecucaoPlanejamentoOrcamento",
  "TOTAL CONTROLES DEVEDORES"=>"iTotalControlesDevedores",
  "TOTAL CONTROLES CREDORES"=>"iTotalControlesCredores"  
);

foreach ($aTotais as $key => $value) {
  $aTotCSV[0] = $key;
  $aTotCSV[1] = abs(${"{$value}BB"});
  $aTotCSV[2] = ${"{$value}BB"} >= 0 ? ${"{$value}BB"} == 0 ? '' : 'D' : 'C';
  $aTotCSV[3] = ${"{$value}PD"};
  $aTotCSV[4] = abs(${"{$value}PC"});
  $aTotCSV[5] = abs(${"{$value}EB"});
  $aTotCSV[6] = ${"{$value}EB"} >= 0 ? ${"{$value}EB"} == 0 ? '' : 'D' : 'C';

  $sLinha = $aTotCSV;

  $aLinha = array();
  foreach ($sLinha as $sLin) {
    if ($sLin == '' || $sLin == null) {
      $sLin = ' ';
    }
    $aLinha[] = $sLin;
  }
  $sLin = implode(";", $aLinha);
  fputs($_arquivo, $sLin);
  fputs($_arquivo, "\r\n");
}

fclose($_arquivo);

echo "<html><body bgcolor='#cccccc'><center><a href='tmp/balanceteMSC.csv'>Clique com botão direito para Salvar o arquivo <b>tmp/balanceteMSC.csv</b></a></body></html>";


?>
