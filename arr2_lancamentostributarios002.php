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

require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("std/DBNumber.php");

/**
 * Variaveis do header do PDF
 */

$oGet         = db_utils::postMemory($_GET);

$oDaoIptuCalv = db_utils::getDao('iptucalv');
$rsIptuCalv   = $oDaoIptuCalv->sql_record($oDaoIptuCalv->sql_queryValoresCalculoIptu($oGet->iAnoCalculo));
$aCalculoIptu = db_utils::getCollectionByRecord($rsIptuCalv);

$oDaoIssCalc  = db_utils::getDao('isscalc');
$rsIssCalc    = $oDaoIssCalc->sql_record($oDaoIssCalc->sql_queryIssqnVistorias($oGet->iAnoCalculo));
$aCalculoIssqn = db_utils::getCollectionByRecord($rsIssCalc);

$head3 = "Relatório de Lançamentos Tributários";
$head5 = "Exercício dos Lançamentos: $oGet->iAnoCalculo";
$head6 = "Data de Geração: " . date('d/m/Y', db_getsession('DB_datausu'));
$head7 = '';

$nTotalGeral = 0;

$oPdf = new PDF('L');
$oPdf->Open();
$oPdf->AliasNbPages();

$oPdf->AddPage();
$oPdf->SetFillColor(235);

/**
 * Escreve titulo do IPTU
 */
$oPdf->Setfont('Arial', 'b', 9);
$oPdf->cell( largura(0), 6, "IPTU {$oGet->iAnoCalculo}", 1, 0, 'L', 1);
$oPdf->ln(6);

/**
 * Escreve colunas de cabecalhos do IPTU
 */
inserirLinha($oPdf, array('CodigoReceitaIPTU'    => 'Receita',
                          'DescricaoReceitaIPTU' => 'Descrição',
                          'QuantidadeIPTU'       => 'Quantidade',
                          'ValorCalculado'       => 'Valor Calculado',
                          'ValorIsento'          => 'Valor Isento',
                          'ValorImportado'       => 'Valor Importado',
                          'ValorPago'            => 'Valor Pago/Bruto',
                          'ValorCancelado'       => 'Valor Cancelado',
                          'ValorAPagar'          => 'Valor a Pagar'), false, true);

/**
 * linhas do IPTU
 */
$nTotalCalculado = 0;
$nTotalIsento    = 0;
$nTotalImportado = 0;
$nTotalPago      = 0;
$nTotalCancelado = 0;
$nTotalaPagar    = 0;

foreach ($aCalculoIptu as $oCalculoIptu) {

  inserirLinha($oPdf, array('CodigoReceitaIPTU'    => $oCalculoIptu->codigo_receita,
                            'DescricaoReceitaIPTU' => $oCalculoIptu->descricao_receita,
                            'QuantidadeIPTU'       => $oCalculoIptu->quantidade,
                            'ValorCalculado'       => $oCalculoIptu->valor_calculado,
                            'ValorIsento'          => $oCalculoIptu->valor_isento,
                            'ValorImportado'       => $oCalculoIptu->valor_importado,
                            'ValorPago'            => $oCalculoIptu->valor_pago,
                            'ValorCancelado'       => $oCalculoIptu->valor_cancelado,
                            'ValorAPagar'          => $oCalculoIptu->valor_a_pagar));

  $nTotalCalculado +=  $oCalculoIptu->valor_calculado;
  $nTotalIsento    +=  $oCalculoIptu->valor_isento;
  $nTotalImportado +=  $oCalculoIptu->valor_importado;
  $nTotalPago      +=  $oCalculoIptu->valor_pago;
  $nTotalCancelado +=  $oCalculoIptu->valor_cancelado;
  $nTotalaPagar    +=  $oCalculoIptu->valor_a_pagar;
}

inserirLinha($oPdf, array('CodigoReceitaIPTU'    => '',
                          'DescricaoReceitaIPTU' => '',
                          'QuantidadeIPTU'       => 'TOTAIS',
                          'ValorCalculado'       => $nTotalCalculado,
                          'ValorIsento'          => $nTotalIsento   ,
                          'ValorImportado'       => $nTotalImportado,
                          'ValorPago'            => $nTotalPago     ,
                          'ValorCancelado'       => $nTotalCancelado,
                          'ValorAPagar'          => $nTotalaPagar), true);

$nTotalGeral += $nTotalaPagar;

/**
 * Espaco entre as duas tabelas
 */
$oPdf->ln(10);

/**
 * Escreve titulo do ISSQN
 */
$oPdf->Setfont('Arial', 'b', 9);
$oPdf->cell( largura(0), 6, "ISSQN / Vistorias {$oGet->iAnoCalculo}", 1, 0, 'L', 1);
$oPdf->ln(6);

/**
 * Escreve colunas de cabecalhos do ISSQN
 */
inserirLinha($oPdf, array('TipoDebito'            => 'Tipo',
                          'CodigoReceitaISSQN'    => 'Receita',
                          'DescricaoReceitaISSQN' => 'Descrição',
                          'QuantidadeISSQN'       => 'Quantidade',
                          'ValorCalculado'        => 'Valor Calculado',
                          'ValorImportado'        => 'Valor Importado',
                          'ValorPago'             => 'Valor Pago',
                          'ValorCancelado'        => 'Valor Cancelado',
                          'ValorAPagar'           => 'Valor a Pagar'), false, true);

/**
 * Linhas do ISSQN
 */
$nTotalCalculado = 0;
$nTotalImportado = 0;
$nTotalPago      = 0;
$nTotalCancelado = 0;
$nTotalaPagar    = 0;

foreach ($aCalculoIssqn as $oCalculoIssqn) {

  inserirLinha($oPdf, array('TipoDebito'            => $oCalculoIssqn->tipodebito,
                            'CodigoReceitaISSQN'    => $oCalculoIssqn->codigo_receita,
                            'DescricaoReceitaISSQN' => $oCalculoIssqn->receita,
                            'QuantidadeISSQN'       => $oCalculoIssqn->quantidade,
                            'ValorCalculado'        => $oCalculoIssqn->valor_calculado,
                            'ValorImportado'        => $oCalculoIssqn->valor_importado,
                            'ValorPago'             => $oCalculoIssqn->valor_pago,
                            'ValorCancelado'        => $oCalculoIssqn->valor_cancelado,
                            'ValorAPagar'           => $oCalculoIssqn->valor_a_pagar));

  $nTotalCalculado +=  $oCalculoIssqn->valor_calculado;
  $nTotalImportado +=  $oCalculoIssqn->valor_importado;
  $nTotalPago      +=  $oCalculoIssqn->valor_pago;
  $nTotalCancelado +=  $oCalculoIssqn->valor_cancelado;
  $nTotalaPagar    +=  $oCalculoIssqn->valor_a_pagar;
}

inserirLinha($oPdf, array('TipoDebito'            => '',
                          'CodigoReceitaISSQN'    => '',
                          'DescricaoReceitaISSQN' => '',
                          'QuantidadeISSQN'       => 'TOTAIS',
                          'ValorCalculado'        => $nTotalCalculado,
                          'ValorImportado'        => $nTotalImportado,
                          'ValorPago'             => $nTotalPago     ,
                          'ValorCancelado'        => $nTotalCancelado,
                          'ValorAPagar'           => $nTotalaPagar), true);

$nTotalGeral += $nTotalaPagar;

$oPdf->ln(10);

inserirLinha($oPdf, array('TipoDebito'            => '',
                          'CodigoReceitaISSQN'    => '',
                          'DescricaoReceitaISSQN' => '',
                          'QuantidadeISSQN'       => '',
                          'ValorCalculado'        => '',
                          'ValorImportado'        => '',
                          'ValorPago'             => '',
                          'ValorCancelado'        => 'TOTAL GERAL',
                          'ValorAPagar'           => $nTotalGeral), true);


/**
 * Manda para o browser o pdf
 */
$oPdf->Output();


/**
 * Calcula a largura da linha pela porcentagem
 *
 * @param float $nPorcentagem
 * @access public
 * @return integer
 */
function largura($nPorcentagem = 0) {

  $iColuna = 0;
  $iTotalLinha = 280;

  if ( $nPorcentagem == 0 ) {
    return $iTotalLinha;
  }

  $iColuna = $nPorcentagem / 100 * $iTotalLinha;
  $iColuna = round($iColuna, 2);

  return $iColuna;
}

/**
 * Método genérico para inserção das linhas de valores
 *
 * @param  PDF     $oPdf
 * @param  array   $aLinha
 * @param  boolean $lTotal
 */
function inserirLinha($oPdf, $aLinha, $lTotal = false, $lCabecalho = false) {

  $aLarguras = array('TipoDebito'            => 18,
                     'CodigoReceitaIPTU'     => 7,
                     'CodigoReceitaISSQN'    => 5,
                     'DescricaoReceitaIPTU'  => 17,
                     'DescricaoReceitaISSQN' => 15,
                     'QuantidadeIPTU'        => 10,
                     'QuantidadeISSQN'       => 7,
                     'ValorCalculado'        => 11,
                     'ValorIsento'           => 11,
                     'ValorImportado'        => 11,
                     'ValorPago'             => 11,
                     'ValorCancelado'        => 11,
                     'ValorAPagar'           => 11);

  $oPdf->Setfont('Arial', $lCabecalho ? 'b' : '' , 8);

  foreach ($aLinha as $sChave => $sLinha) {

    /**
     * Verificamos se o valor em questão é um numero, para colocar seu devido alinhamento
     */
    $sAlinhamento = ( $lTotal || $lCabecalho ) ? 'C' : 'L';

    if (is_numeric($sLinha)) {

      if (stripos($sChave, 'Valor') !== FALSE) {
        $sLinha       = db_formatar($sLinha, 'f');
      }

      $sAlinhamento = 'R';
    }

    /**
     * Verificamos a necessidade de colocar borda ao torno do valor
     */
    $iBorda = 1;
    if ($lTotal && empty($sLinha)) {
      $iBorda = 0;
    }

    $oPdf->cell( largura($aLarguras[$sChave]), 5, $sLinha, $iBorda, 0, $sAlinhamento);
  }
  $oPdf->ln();
}