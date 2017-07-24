<?php

$sNomeArquivo = 'rateio' . date("d-m-Y - H:i:s") . '.csv';

header("Content-type: text/csv; charset=iso-8859-1");
header("Content-Disposition: attachment; filename=\"{$sNomeArquivo}\"");

function escreveLinha($valores = array()) {

  fputs($fp, implode(';', $valores) . "\n");
  echo implode(';', $valores) . "\n";

}


$aTotal = array(
  'empenhado' => array(
    'no_mes'    => 0,
    'ate_o_mes' => 0
  ),
  'emp_anualdo' => array(
    'no_mes'    => 0,
    'ate_o_mes' => 0
  ),
  'liquidado' => array(
    'no_mes'    => 0,
    'ate_o_mes' => 0
  ),
  'liq_anulado' => array(
    'no_mes'    => 0,
    'ate_o_mes' => 0
  ),
  'pago' => array(
    'no_mes'    => 0,
    'ate_o_mes' => 0
  ),
  'pago_anulado' => array(
    'no_mes'    => 0,
    'ate_o_mes' => 0
  )
);


foreach ($oInfoRelatorio->aDados as $key => $oRegistro) {

  $aTotal['empenhado']['no_mes']        += $oRegistro->empenhomes;
  $aTotal['empenhado']['ate_o_mes']     += $oRegistro->empenhoatemes;
  $aTotal['emp_anualdo']['no_mes']      += $oRegistro->anuladomes;
  $aTotal['emp_anualdo']['ate_o_mes']   += $oRegistro->anuladoatemes;
  $aTotal['liquidado']['no_mes']        += $oRegistro->liquidadomes;
  $aTotal['liquidado']['ate_o_mes']     += $oRegistro->liquidadoatemes;
  $aTotal['liq_anulado']['no_mes']      += $oRegistro->liquidadoanualdomes;
  $aTotal['liq_anulado']['ate_o_mes']   += $oRegistro->liquidadoanualdoatemes;
  $aTotal['pago']['no_mes']             += $oRegistro->pagomes;
  $aTotal['pago']['ate_o_mes']          += $oRegistro->pagoatemes;
  $aTotal['pago_anulado']['no_mes']     += $oRegistro->pagoanuladomes;
  $aTotal['pago_anulado']['ate_o_mes']  += $oRegistro->pagoanuladoatemes;

  $aLinha = array();
  $aLinha[] = $oRegistro->funcao;
  $aLinha[] = $oRegistro->subfuncao;
  $aLinha[] = $oRegistro->c217_natureza;
  $aLinha[] = $oRegistro->c217_subelemento;
  $aLinha[] = $oRegistro->c217_fonte;
  $aLinha[] = db_formatar($oRegistro->empenhomes, 'f');
  $aLinha[] = db_formatar($oRegistro->empenhoatemes, 'f');
  $aLinha[] = db_formatar($oRegistro->anuladomes, 'f');
  $aLinha[] = db_formatar($oRegistro->anuladoatemes, 'f');
  $aLinha[] = db_formatar($oRegistro->liquidadomes, 'f');
  $aLinha[] = db_formatar($oRegistro->liquidadoatemes, 'f');
  $aLinha[] = db_formatar($oRegistro->liquidadoanualdomes, 'f');
  $aLinha[] = db_formatar($oRegistro->liquidadoanualdoatemes, 'f');
  $aLinha[] = db_formatar($oRegistro->pagomes, 'f');
  $aLinha[] = db_formatar($oRegistro->pagoatemes, 'f');
  $aLinha[] = db_formatar($oRegistro->pagoanuladomes, 'f');
  $aLinha[] = db_formatar($oRegistro->pagoanuladoatemes, 'f');

  escreveLinha($aLinha);

}


$aLinhaTotal = array('', '', '', '', '');
$aLinhaTotal[] = db_formatar($aTotal['empenhado']['no_mes'], 'f');
$aLinhaTotal[] = db_formatar($aTotal['empenhado']['ate_o_mes'], 'f');
$aLinhaTotal[] = db_formatar($aTotal['emp_anualdo']['no_mes'], 'f');
$aLinhaTotal[] = db_formatar($aTotal['emp_anualdo']['ate_o_mes'], 'f');
$aLinhaTotal[] = db_formatar($aTotal['liquidado']['no_mes'], 'f');
$aLinhaTotal[] = db_formatar($aTotal['liquidado']['ate_o_mes'], 'f');
$aLinhaTotal[] = db_formatar($aTotal['liq_anulado']['no_mes'], 'f');
$aLinhaTotal[] = db_formatar($aTotal['liq_anulado']['ate_o_mes'], 'f');
$aLinhaTotal[] = db_formatar($aTotal['pago']['no_mes'], 'f');
$aLinhaTotal[] = db_formatar($aTotal['pago']['ate_o_mes'], 'f');
$aLinhaTotal[] = db_formatar($aTotal['pago_anulado']['no_mes'], 'f');
$aLinhaTotal[] = db_formatar($aTotal['pago_anulado']['ate_o_mes'], 'f');

escreveLinha($aLinhaTotal);
