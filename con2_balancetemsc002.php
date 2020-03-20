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

          $head4 = "PERÍODO: ENCERRAMENTO";

      } else {
          throw new Exception ("Arquivo MSCEncerramento para o ano {$iAnoUsu} não existe. ");
      }

  } else {

      $sMscFilePath = "{$sMscPath}/MSC.model.php";

      if (file_exists($sMscFilePath)) {

          require_once($sMscFilePath);
          $msc = new MSC;

          $head4 = "PERÍODO: ".array_search($iMes, $aMeses);

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
  die($e->getMessage());
}

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$head2 = "BALANCETE MSC";
$head3 = "EXERCÍCIO: {$iAnoUsu}";
$head5 = "INSTIUIÇÕES: {$sInstituicoes}";
$alt   = 5;
$pdf->SetAutoPageBreak('on',0);
$pdf->line(2,148.5,208,148.5);

$pdf->addpage();

$pdf->setfont("arial", "B", 8);
$pdf->cell(79,$alt,"CONTA","B",0,"C",0);
$pdf->cell(29,$alt,"SALDO ANTERIOR","B",0,"C",0);
$pdf->cell(29,$alt,"DÉBITOS","B",0,"R",0);
$pdf->cell(29,$alt,"CRÉDITOS","B",0,"R",0);
$pdf->cell(29,$alt,"SALDO","B",0,"R",0);

$pdf->ln();
$pdf->setfont("arial", "", 8);

foreach ($aRegistros as $aRegistro) {

  $sBeginning_balance  = $aRegistro->beginning_balance  >= 0 ? $aRegistro->beginning_balance == 0 ? number_format(0, 2, ',', '.') : number_format($aRegistro->beginning_balance, 2, ',', '.')." D" : number_format(abs($aRegistro->beginning_balance), 2, ',', '.')." C";
  $sEnding_balance     = $aRegistro->ending_balance     >= 0 ? $aRegistro->ending_balance    == 0 ? number_format(0, 2, ',', '.') : number_format($aRegistro->ending_balance, 2, ',', '.')." D"    : number_format(abs($aRegistro->ending_balance), 2, ',', '.')." C";
  $sPeriod_change_deb  = $aRegistro->period_change_deb  == 0 ? number_format(0, 2, ',', '.') : number_format($aRegistro->period_change_deb, 2, ',', '.');
  $sPeriod_change_cred = $aRegistro->period_change_cred == 0 ? number_format(0, 2, ',', '.') : number_format(abs($aRegistro->period_change_cred), 2, ',', '.');

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

  $pdf->cell(79,$alt,$aRegistro->conta,"0",0,"C",0);
  $pdf->cell(29,$alt,"$sBeginning_balance","0",0,"R",0);
  $pdf->cell(29,$alt,"$sPeriod_change_deb","0",0,"R",0);
  $pdf->cell(29,$alt,"$sPeriod_change_cred","0",0,"R",0);
  $pdf->cell(29,$alt,"$sEnding_balance","0",0,"R",0);

  $pdf->ln();

  if ($pdf->gety() > ($pdf->h - 20)) {
    $pdf->addpage();
  }

}

if ($pdf->gety() > ($pdf->h - 20)) {
  $pdf->addpage();
}

$pdf->ln();
$iTotalAtivoBB = $iTotalAtivoBB>=0 ? $iTotalAtivoBB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalAtivoBB, 2, ',', '.')." D" : number_format(abs($iTotalAtivoBB), 2, ',', '.')." C";
$iTotalAtivoPD = $iTotalAtivoPD>=0 ? $iTotalAtivoPD==0 ? number_format(0, 2, ',', '.') : number_format($iTotalAtivoPD, 2, ',', '.')." D" : number_format(abs($iTotalAtivoPD), 2, ',', '.')." C";
$iTotalAtivoPC = $iTotalAtivoPC>=0 ? $iTotalAtivoPC==0 ? number_format(0, 2, ',', '.') : number_format($iTotalAtivoPC, 2, ',', '.')." D" : number_format(abs($iTotalAtivoPC), 2, ',', '.')." C";
$iTotalAtivoEB = $iTotalAtivoEB>=0 ? $iTotalAtivoEB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalAtivoEB, 2, ',', '.')." D" : number_format(abs($iTotalAtivoEB), 2, ',', '.')." C";
$pdf->setfont('arial','b',6);
$pdf->cell(79,$alt,"TOTAL ATIVO",0,0,"L",0,0,'.');
$pdf->setfont('arial','b',8);
$pdf->cell(29,$alt,"$iTotalAtivoBB","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalAtivoPD","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalAtivoPC","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalAtivoEB","0",0,"R",0);

$pdf->ln();
$iTotalPassivoPatrimonioLiquidoBB = $iTotalPassivoPatrimonioLiquidoBB>=0 ? $iTotalPassivoPatrimonioLiquidoBB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalPassivoPatrimonioLiquidoBB, 2, ',', '.')." D" : number_format(abs($iTotalPassivoPatrimonioLiquidoBB), 2, ',', '.')." C";
$iTotalPassivoPatrimonioLiquidoPD = $iTotalPassivoPatrimonioLiquidoPD>=0 ? $iTotalPassivoPatrimonioLiquidoPD==0 ? number_format(0, 2, ',', '.') : number_format($iTotalPassivoPatrimonioLiquidoPD, 2, ',', '.')." D" : number_format(abs($iTotalPassivoPatrimonioLiquidoPD), 2, ',', '.')." C";
$iTotalPassivoPatrimonioLiquidoPC = $iTotalPassivoPatrimonioLiquidoPC>=0 ? $iTotalPassivoPatrimonioLiquidoPC==0 ? number_format(0, 2, ',', '.') : number_format($iTotalPassivoPatrimonioLiquidoPC, 2, ',', '.')." D" : number_format(abs($iTotalPassivoPatrimonioLiquidoPC), 2, ',', '.')." C";
$iTotalPassivoPatrimonioLiquidoEB = $iTotalPassivoPatrimonioLiquidoEB>=0 ? $iTotalPassivoPatrimonioLiquidoEB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalPassivoPatrimonioLiquidoEB, 2, ',', '.')." D" : number_format(abs($iTotalPassivoPatrimonioLiquidoEB), 2, ',', '.')." C";
$pdf->setfont('arial','b',6);
$pdf->cell(79,$alt,"TOTAL PASSIVO E PATRIMÔNIO LIQUIDO",0,0,"L",0,0,'.');
$pdf->setfont('arial','b',8);
$pdf->cell(29,$alt,"$iTotalPassivoPatrimonioLiquidoBB","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalPassivoPatrimonioLiquidoPD","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalPassivoPatrimonioLiquidoPC","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalPassivoPatrimonioLiquidoEB","0",0,"R",0);

$pdf->ln();
$iTotalVariacaoPatrimonialDiminutivaBB = $iTotalVariacaoPatrimonialDiminutivaBB>=0 ? $iTotalVariacaoPatrimonialDiminutivaBB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalVariacaoPatrimonialDiminutivaBB, 2, ',', '.')." D" : number_format(abs($iTotalVariacaoPatrimonialDiminutivaBB), 2, ',', '.')." C";
$iTotalVariacaoPatrimonialDiminutivaPD = $iTotalVariacaoPatrimonialDiminutivaPD>=0 ? $iTotalVariacaoPatrimonialDiminutivaPD==0 ? number_format(0, 2, ',', '.') : number_format($iTotalVariacaoPatrimonialDiminutivaPD, 2, ',', '.')." D" : number_format(abs($iTotalVariacaoPatrimonialDiminutivaPD), 2, ',', '.')." C";
$iTotalVariacaoPatrimonialDiminutivaPC = $iTotalVariacaoPatrimonialDiminutivaPC>=0 ? $iTotalVariacaoPatrimonialDiminutivaPC==0 ? number_format(0, 2, ',', '.') : number_format($iTotalVariacaoPatrimonialDiminutivaPC, 2, ',', '.')." D" : number_format(abs($iTotalVariacaoPatrimonialDiminutivaPC), 2, ',', '.')." C";
$iTotalVariacaoPatrimonialDiminutivaEB = $iTotalVariacaoPatrimonialDiminutivaEB>=0 ? $iTotalVariacaoPatrimonialDiminutivaEB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalVariacaoPatrimonialDiminutivaEB, 2, ',', '.')." D" : number_format(abs($iTotalVariacaoPatrimonialDiminutivaEB), 2, ',', '.')." C";
$pdf->setfont('arial','b',6);
$pdf->cell(79,$alt,"TOTAL VARIAÇÃO PATRIMONIAL DIMINUTIVA",0,0,"L",0,0,'.');
$pdf->setfont('arial','b',8);
$pdf->cell(29,$alt,"$iTotalVariacaoPatrimonialDiminutivaBB","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalVariacaoPatrimonialDiminutivaPD","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalVariacaoPatrimonialDiminutivaPC","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalVariacaoPatrimonialDiminutivaEB","0",0,"R",0);

$pdf->ln();
$iTotalVariacaoPatrimonialAumentativaBB = $iTotalVariacaoPatrimonialAumentativaBB>=0 ? $iTotalVariacaoPatrimonialAumentativaBB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalVariacaoPatrimonialAumentativaBB, 2, ',', '.')." D" : number_format(abs($iTotalVariacaoPatrimonialAumentativaBB), 2, ',', '.')." C";
$iTotalVariacaoPatrimonialAumentativaPD = $iTotalVariacaoPatrimonialAumentativaPD>=0 ? $iTotalVariacaoPatrimonialAumentativaPD==0 ? number_format(0, 2, ',', '.') : number_format($iTotalVariacaoPatrimonialAumentativaPD, 2, ',', '.')." D" : number_format(abs($iTotalVariacaoPatrimonialAumentativaPD), 2, ',', '.')." C";
$iTotalVariacaoPatrimonialAumentativaPC = $iTotalVariacaoPatrimonialAumentativaPC>=0 ? $iTotalVariacaoPatrimonialAumentativaPC==0 ? number_format(0, 2, ',', '.') : number_format($iTotalVariacaoPatrimonialAumentativaPC, 2, ',', '.')." D" : number_format(abs($iTotalVariacaoPatrimonialAumentativaPC), 2, ',', '.')." C";
$iTotalVariacaoPatrimonialAumentativaEB = $iTotalVariacaoPatrimonialAumentativaEB>=0 ? $iTotalVariacaoPatrimonialAumentativaEB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalVariacaoPatrimonialAumentativaEB, 2, ',', '.')." D" : number_format(abs($iTotalVariacaoPatrimonialAumentativaEB), 2, ',', '.')." C";
$pdf->setfont('arial','b',6);
$pdf->cell(79,$alt,"TOTAL VARIAÇÃO PATRIMONIAL AUMENTATIVA",0,0,"L",0,0,'.');
$pdf->setfont('arial','b',8);
$pdf->cell(29,$alt,"$iTotalVariacaoPatrimonialAumentativaBB","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalVariacaoPatrimonialAumentativaPD","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalVariacaoPatrimonialAumentativaPC","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalVariacaoPatrimonialAumentativaEB","0",0,"R",0);

$pdf->ln();
$iTotalControlesAprovacaoPlanejamentoOrcamentoBB = $iTotalControlesAprovacaoPlanejamentoOrcamentoBB>=0 ? $iTotalControlesAprovacaoPlanejamentoOrcamentoBB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesAprovacaoPlanejamentoOrcamentoBB, 2, ',', '.')." D" : number_format(abs($iTotalControlesAprovacaoPlanejamentoOrcamentoBB), 2, ',', '.')." C";
$iTotalControlesAprovacaoPlanejamentoOrcamentoPD = $iTotalControlesAprovacaoPlanejamentoOrcamentoPD>=0 ? $iTotalControlesAprovacaoPlanejamentoOrcamentoPD==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesAprovacaoPlanejamentoOrcamentoPD, 2, ',', '.')." D" : number_format(abs($iTotalControlesAprovacaoPlanejamentoOrcamentoPD), 2, ',', '.')." C";
$iTotalControlesAprovacaoPlanejamentoOrcamentoPC = $iTotalControlesAprovacaoPlanejamentoOrcamentoPC>=0 ? $iTotalControlesAprovacaoPlanejamentoOrcamentoPC==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesAprovacaoPlanejamentoOrcamentoPC, 2, ',', '.')." D" : number_format(abs($iTotalControlesAprovacaoPlanejamentoOrcamentoPC), 2, ',', '.')." C";
$iTotalControlesAprovacaoPlanejamentoOrcamentoEB = $iTotalControlesAprovacaoPlanejamentoOrcamentoEB>=0 ? $iTotalControlesAprovacaoPlanejamentoOrcamentoEB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesAprovacaoPlanejamentoOrcamentoEB, 2, ',', '.')." D" : number_format(abs($iTotalControlesAprovacaoPlanejamentoOrcamentoEB), 2, ',', '.')." C";
$pdf->setfont('arial','b',6);
$pdf->cell(79,$alt,"TOTAL CONTROLES DA APROVAÇÃO DO PLANEJAMENTO E ORÇAMENTO",0,0,"L",0,0,'.');
$pdf->setfont('arial','b',8);
$pdf->cell(29,$alt,"$iTotalControlesAprovacaoPlanejamentoOrcamentoBB","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalControlesAprovacaoPlanejamentoOrcamentoPD","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalControlesAprovacaoPlanejamentoOrcamentoPC","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalControlesAprovacaoPlanejamentoOrcamentoEB","0",0,"R",0);

$pdf->ln();
$iTotalControlesExecucaoPlanejamentoOrcamentoBB = $iTotalControlesExecucaoPlanejamentoOrcamentoBB>=0 ? $iTotalControlesExecucaoPlanejamentoOrcamentoBB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesExecucaoPlanejamentoOrcamentoBB, 2, ',', '.')." D" : number_format(abs($iTotalControlesExecucaoPlanejamentoOrcamentoBB), 2, ',', '.')." C";
$iTotalControlesExecucaoPlanejamentoOrcamentoPD = $iTotalControlesExecucaoPlanejamentoOrcamentoPD>=0 ? $iTotalControlesExecucaoPlanejamentoOrcamentoPD==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesExecucaoPlanejamentoOrcamentoPD, 2, ',', '.')." D" : number_format(abs($iTotalControlesExecucaoPlanejamentoOrcamentoPD), 2, ',', '.')." C";
$iTotalControlesExecucaoPlanejamentoOrcamentoPC = $iTotalControlesExecucaoPlanejamentoOrcamentoPC>=0 ? $iTotalControlesExecucaoPlanejamentoOrcamentoPC==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesExecucaoPlanejamentoOrcamentoPC, 2, ',', '.')." D" : number_format(abs($iTotalControlesExecucaoPlanejamentoOrcamentoPC), 2, ',', '.')." C";
$iTotalControlesExecucaoPlanejamentoOrcamentoEB = $iTotalControlesExecucaoPlanejamentoOrcamentoEB>=0 ? $iTotalControlesExecucaoPlanejamentoOrcamentoEB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesExecucaoPlanejamentoOrcamentoEB, 2, ',', '.')." D" : number_format(abs($iTotalControlesExecucaoPlanejamentoOrcamentoEB), 2, ',', '.')." C";
$pdf->setfont('arial','b',6);
$pdf->cell(79,$alt,"TOTAL CONTROLES DA EXECUÇÃO DO PLANEJAMENTO E ORÇAMENTO",0,0,"L",0,0,'.');
$pdf->setfont('arial','b',8);
$pdf->cell(29,$alt,"$iTotalControlesExecucaoPlanejamentoOrcamentoBB","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalControlesExecucaoPlanejamentoOrcamentoPD","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalControlesExecucaoPlanejamentoOrcamentoPC","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalControlesExecucaoPlanejamentoOrcamentoEB","0",0,"R",0);

$pdf->ln();
$iTotalControlesDevedoresBB = $iTotalControlesDevedoresBB>=0 ? $iTotalControlesDevedoresBB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesDevedoresBB, 2, ',', '.')." D" : number_format(abs($iTotalControlesDevedoresBB), 2, ',', '.')." C";
$iTotalControlesDevedoresPD = $iTotalControlesDevedoresPD>=0 ? $iTotalControlesDevedoresPD==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesDevedoresPD, 2, ',', '.')." D" : number_format(abs($iTotalControlesDevedoresPD), 2, ',', '.')." C";
$iTotalControlesDevedoresPC = $iTotalControlesDevedoresPC>=0 ? $iTotalControlesDevedoresPC==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesDevedoresPC, 2, ',', '.')." D" : number_format(abs($iTotalControlesDevedoresPC), 2, ',', '.')." C";
$iTotalControlesDevedoresEB = $iTotalControlesDevedoresEB>=0 ? $iTotalControlesDevedoresEB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesDevedoresEB, 2, ',', '.')." D" : number_format(abs($iTotalControlesDevedoresEB), 2, ',', '.')." C";
$pdf->setfont('arial','b',6);
$pdf->cell(79,$alt,"TOTAL CONTROLES DEVEDORES",0,0,"L",0,0,'.');
$pdf->setfont('arial','b',8);
$pdf->cell(29,$alt,"$iTotalControlesDevedoresBB","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalControlesDevedoresPD","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalControlesDevedoresPC","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalControlesDevedoresEB","0",0,"R",0);

$pdf->ln();
$iTotalControlesCredoresBB = $iTotalControlesCredoresBB>=0 ? $iTotalControlesCredoresBB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesCredoresBB, 2, ',', '.')." D" : number_format(abs($iTotalControlesCredoresBB), 2, ',', '.')." C";
$iTotalControlesCredoresPD = $iTotalControlesCredoresPD>=0 ? $iTotalControlesCredoresPD==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesCredoresPD, 2, ',', '.')." D" : number_format(abs($iTotalControlesCredoresPD), 2, ',', '.')." C";
$iTotalControlesCredoresPC = $iTotalControlesCredoresPC>=0 ? $iTotalControlesCredoresPC==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesCredoresPC, 2, ',', '.')." D" : number_format(abs($iTotalControlesCredoresPC), 2, ',', '.')." C";
$iTotalControlesCredoresEB = $iTotalControlesCredoresEB>=0 ? $iTotalControlesCredoresEB==0 ? number_format(0, 2, ',', '.') : number_format($iTotalControlesCredoresEB, 2, ',', '.')." D" : number_format(abs($iTotalControlesCredoresEB), 2, ',', '.')." C";
$pdf->setfont('arial','b',6);
$pdf->cell(79,$alt,"TOTAL CONTROLES CREDORES",0,0,"L",0,0,'.');
$pdf->setfont('arial','b',8);
$pdf->cell(29,$alt,"$iTotalControlesCredoresBB","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalControlesCredoresPD","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalControlesCredoresPC","0",0,"R",0);
$pdf->cell(29,$alt,"$iTotalControlesCredoresEB","0",0,"R",0);

$pdf->Output();

?>
