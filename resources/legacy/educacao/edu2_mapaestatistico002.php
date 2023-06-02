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

require_once ("libs/db_stdlibwebseller.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_libdocumento.php");
require_once ("libs/db_libparagrafo.php");
require_once ("dbforms/db_funcoes.php");
require_once ('fpdf151/FpdfMultiCellBorder.php');

$oGet                   = db_utils::postMemory($_GET);

$aEtapasErEp            = array();
$aEtapasSegundoQuadro   = array();
$aEscolasPrimeiroQuadro = array();
$aEscolasSegundoQuadro  = array();

$iNumeroEtapasPrimeiroQuadro = 0;
$iNumeroEtapasSegundoQuadro  = 0;

$lRelatorioSemDadosParaPeriodoInformado = true;

try {

  if ( empty($oGet->dtInicio) ) {
    throw new Exception("É obrigatória a informação da data de início.");
  }
  if ( empty($oGet->dtFim) ) {
    throw new Exception("É obrigatória a informação da data de fim.");
  }

  $oDtInicio  = new DBDate($oGet->dtInicio);
  $oDtFim     = new DBDate($oGet->dtFim);
  $sFiltraAno = " ed52_i_ano = " . $oDtInicio->getAno();

  $aEscolasPrimeiroQuadro = buscaEscolas();
  $aEscolasSegundoQuadro  = unserialize(serialize($aEscolasPrimeiroQuadro));


  /** ***********************************************************************************************************
   ******************************* inicio da busca dos dados do PRIMEIRO QUADRO *********************************
   *********************************************************************************************************** **/
  /**
   * Busca os ensinos do tipo ENSINO REGULAR e EDUCAÇÃO DE JOVENS E ADULTOS
   */
  $aWhere   = array();
  $aWhere[] = $sFiltraAno;
  $aWhere[] = " ed57_i_tipoturma not in (6,7) ";

  $aEnsinosNoAno  = buscaCursosMinistradoAno( $aWhere );
  $sEnsinosFiltro = implode(", ", $aEnsinosNoAno);

  if (count($aEnsinosNoAno) > 0 ) {

    $aWherePrimeiroQuadro   = array();
    $aWherePrimeiroQuadro[] = " ed10_i_codigo in ({$sEnsinosFiltro}) ";
    $aWherePrimeiroQuadro[] = " ed10_i_tipoensino in (1,3) ";

    $rsPrimeiroQuadro = buscaDadosEnsinosMinistrados($aWherePrimeiroQuadro);
    $iLinhas          = pg_num_rows($rsPrimeiroQuadro);
    if ($iLinhas == 0) {
      throw new Exception("Não há turmas cadastradas para o ano: " . $oDtInicio->getAno() );
    }

    $iNumeroEtapasPrimeiroQuadro = $iLinhas;
    for ($i = 0; $i < $iLinhas; $i++) {

      $oDados  = db_utils::fieldsMemory($rsPrimeiroQuadro, $i);
      $iEnsino = $oDados->cod_ensino;
      if ( !array_key_exists($iEnsino, $aEtapasErEp) ) {

        $oEnsino = new stdClass();
        $oEnsino->iEnsino      = $oDados->cod_ensino;
        $oEnsino->sEnsino      = $oDados->ensino;
        $oEnsino->sEnsinoAbrev = $oDados->ensino_abrev;
        $oEnsino->iTotalEnsino = 0;
        $oEnsino->aEtapas      = array();

        $aEtapasErEp[$iEnsino] = $oEnsino;
      }

      $oEtapa = new stdClass();
      $oEtapa->iEtapa      = $oDados->cod_etapa;
      $oEtapa->sEtapa      = $oDados->etapa;
      $oEtapa->sEtapaAbrev = $oDados->etapa_abrev;
      $oEtapa->iFill       = 0;
      $oEtapa->iTotalEtapa = 0;

      $aEtapasErEp[$iEnsino]->aEtapas[] = $oEtapa;
    }
    // Adiciona a coluna de totalizador para cada ensino
    foreach ($aEtapasErEp as $oEnsino) {

      $iNumeroEtapasPrimeiroQuadro ++;
      $oEtapa = new stdClass();
      $oEtapa->iEtapa      = null;
      $oEtapa->sEtapa      = "Total";
      $oEtapa->sEtapaAbrev = "Total";
      $oEtapa->iFill       = 1;
      $oEtapa->iTotalEtapa = 0;
      $oEnsino->aEtapas[]  = $oEtapa;
    }
    // calcula Alunos Matriculados na Escola do primerio quadro
    calculaAlunosMatriculadosEscola($aEscolasPrimeiroQuadro, $aEtapasErEp, $oDtInicio, $oDtFim);

    foreach ($aEscolasPrimeiroQuadro as $oEscola) {

      if ( $oEscola->iTotalEscola != 0 ) {
        $lRelatorioSemDadosParaPeriodoInformado = false;
      }
    }
  }


  /** ************************************************************************************************************
   ********************************* inicio da busca dos dados do SEGUNDO QUADRO *********************************
   ************************************************************************************************************ **/

  /**
   * Busca ensinos que possuam turmas de correção de fluxo
   */
  $aWhereCorrecaoFluxo    = array();
  $aWhereCorrecaoFluxo[]  = " ed57_i_tipoturma = 7 ";
  $aWhereCorrecaoFluxo[]  = $sFiltraAno;
  $aEnsinosCorrecaoFluxo  = buscaCursosMinistradoAno ( $aWhereCorrecaoFluxo );
  $sEnsinosSegundoQuandro = implode(", ", $aEnsinosCorrecaoFluxo);

  if (count($aEnsinosCorrecaoFluxo) > 0 )  {

    $aWhereSegundoQuadro   = array();
    $aWhereSegundoQuadro[] = " ed10_i_codigo in ({$sEnsinosSegundoQuandro}) ";
    $rsSegundoQuandro      = buscaDadosEnsinosMinistrados($aWhereSegundoQuadro);

    $iLinhas = pg_num_rows($rsSegundoQuandro);
    if ($iLinhas == 0) {
      throw new Exception("Não há turmas cadastradas para o ano: " . $oDtInicio->getAno() );
    }

    $iNumeroEtapasSegundoQuadro = $iLinhas;
    for ($i = 0; $i < $iLinhas; $i++) {

      $oDados  = db_utils::fieldsMemory($rsSegundoQuandro, $i);
      $iEnsino = $oDados->cod_ensino;
      if ( !array_key_exists($iEnsino, $aEtapasSegundoQuadro) ) {

        $oEnsino = new stdClass();
        $oEnsino->iEnsino        = $oDados->cod_ensino;
        $oEnsino->sEnsino        = $oDados->ensino;
        $oEnsino->sEnsinoAbrev   = $oDados->ensino_abrev;
        $oEnsino->lCorrecaoFluxo = true;
        $oEnsino->iTotalEnsino   = 0;
        $oEnsino->aEtapas        = array();

        $aEtapasSegundoQuadro[$iEnsino] = $oEnsino;
      }

      $oEtapa = new stdClass();
      $oEtapa->iEtapa      = $oDados->cod_etapa;
      $oEtapa->sEtapa      = $oDados->etapa;
      $oEtapa->sEtapaAbrev = $oDados->etapa_abrev;
      $oEtapa->iFill       = 0;
      $oEtapa->iTotalEtapa = 0;

      $aEtapasSegundoQuadro[$iEnsino]->aEtapas[] = $oEtapa;
    }

    // Adiciona a coluna de totalizador para cada ensino
    foreach ($aEtapasSegundoQuadro as $oEnsino) {

      $iNumeroEtapasSegundoQuadro ++;
      $oEtapa = new stdClass();
      $oEtapa->iEtapa      = null;
      $oEtapa->sEtapa      = "Total";
      $oEtapa->sEtapaAbrev = "Total";
      $oEtapa->iFill       = 1;
      $oEtapa->iTotalEtapa = 0;
      $oEnsino->aEtapas[]  = $oEtapa;
    }

    calculaAlunosMatriculadosEscola($aEscolasSegundoQuadro, $aEtapasSegundoQuadro, $oDtInicio, $oDtFim);
  }

  /**
   * Busca os alunos matriculados nos cursos profissionais
   */
  foreach ($aEscolasSegundoQuadro as $oEscola) {

    $oEscola->iTotalMatriculasProfissional = buscaAlunosMatriculadosTipoEnsino($oEscola->codigo, 4, $oDtInicio, $oDtFim);
    $oEscola->iTotalEscola += $oEscola->iTotalMatriculasProfissional;
  }

  /**
   * Busca os alunos matriculados nos de educação especial
   */
  foreach ($aEscolasSegundoQuadro as $oEscola) {

    $oEscola->iTotalMatriculasEspecial = buscaAlunosMatriculadosTipoEnsino($oEscola->codigo, 2, $oDtInicio, $oDtFim);
    $oEscola->iTotalEscola += $oEscola->iTotalMatriculasEspecial;
  }

  /**
   * Busca todos alunos matriculados em turmas de AEE
   */
  foreach ($aEscolasSegundoQuadro as $oEscola) {

    $oEscola->iTotalMatriculasAee = buscaAlunosMatriculadosAEE($oEscola->codigo, $oDtInicio, $oDtFim);
    $oEscola->iTotalEscola += $oEscola->iTotalMatriculasAee;
  }

  /**
   * Busca todos alunos matriculados em turmas de atividade complementar
   */
  foreach ($aEscolasSegundoQuadro as $oEscola) {

    $oEscola->iTotalMatriculasComplementar = buscaAlunosMatriculadosAtivComplementar($oEscola->codigo, $oDtInicio, $oDtFim);
    $oEscola->iTotalEscola += $oEscola->iTotalMatriculasComplementar;

    if ( $oEscola->iTotalEscola != 0 ) {
      $lRelatorioSemDadosParaPeriodoInformado = false;
    }
  }

  if ($lRelatorioSemDadosParaPeriodoInformado) {
    throw new Exception("Relatório sem dados para o período informado.");
  }

} catch (Exception $e) {
  db_redireciona('db_erros.php?fechar=true&db_erro='.$e->getMessage());
}


/**
 * Configuração do relatório
 * @var stdClass
 */
$oConfig                           = new stdClass();
$oConfig->iXMaxima                 = 281;
$oConfig->iYMaximo                 = 195;
$oConfig->iHLinha                  = 4;
$oConfig->iXEscola                 = 50;
$oConfig->iXSubTotal               = 10;
$oConfig->iXMaximoEnsino           = $oConfig->iXMaxima - $oConfig->iXEscola - $oConfig->iXSubTotal;
$oConfig->iColunaProfissional      = 10;
$oConfig->iColunaEspecial          = 10;
$oConfig->iColunaAee               = 10;
$oConfig->iColunaAtivComplementar  = 10;
$oConfig->iOutrasColunas           = ($oConfig->iColunaProfissional + $oConfig->iColunaEspecial + $oConfig->iColunaAee + $oConfig->iColunaAtivComplementar);
$oConfig->iXColunasEtapasPrimeriro = $oConfig->iXMaximoEnsino;
if (!empty($iNumeroEtapasPrimeiroQuadro)) {
  $oConfig->iXColunasEtapasPrimeriro = $oConfig->iXMaximoEnsino / $iNumeroEtapasPrimeiroQuadro;
}
$oConfig->iXColunasEtapasSegundo   = ($oConfig->iXMaximoEnsino - $oConfig->iOutrasColunas);
if ( !empty($iNumeroEtapasSegundoQuadro) ) {
  $oConfig->iXColunasEtapasSegundo   = ($oConfig->iXMaximoEnsino - $oConfig->iOutrasColunas) / $iNumeroEtapasSegundoQuadro;
}
$oConfig->iAlturaCabecalho         = 25;
$oConfig->iAnoImpressao            = $oDtInicio->getAno();
$oConfig->iLinhasPorPagina         = 26;

$head1 = "Mapa Estatístico";
$head2 = "Período: {$oGet->dtInicio} até {$oGet->dtFim}";

$oPdf = new FpdfMultiCellBorder("L");
$oPdf->setExibeBrasao(true);
$oPdf->exibeHeader(true);
$oPdf->Open();
$oPdf->AliasNbPages();
$oPdf->SetMargins(8, 8);
$oPdf->SetFillColor(223);
$oPdf->SetAutoPageBreak(false, 10);



/**
 * Imprime os Alunos matriculados dos Níveis de ensino de todas as escolas
 * Este bloco abrange todos os alunos matriculados no período informado em turmas do tipo:
 * 1 - NORMAL
 * 2 - EJA
 * 3 - MULTIETAPA
 */
if (count($aEtapasErEp) > 0) {

  imprimePrimeiroCabecalho($oPdf, $oConfig, $aEtapasErEp);
  $iLinhasImpressas = 0;
  foreach ($aEscolasPrimeiroQuadro as $oEscola) {

    if ($oConfig->iLinhasPorPagina == $iLinhasImpressas) {

      $iLinhasImpressas = 0;
      imprimePrimeiroCabecalho($oPdf, $oConfig, $aEtapasErEp);
    }

    $sNomeEscola = cortaString($oPdf, $oEscola->escola, $oEscola->escola_abrev, $oConfig->iXEscola);
    $oPdf->Cell($oConfig->iXEscola,  5, "{$sNomeEscola}", 1, 0);
    if ( isset($oEscola->aAlunosEtapa)) {

      foreach ($oEscola->aAlunosEtapa as $sIndex => $iAlunosMatriculados) {

        $iFill = 1;
        if (strpos($sIndex, "T") === false) {
          $iFill = 0;
        }
        $iAlunosMatriculados = $iAlunosMatriculados == 0 ? "" : $iAlunosMatriculados;
        $oPdf->Cell($oConfig->iXColunasEtapasPrimeriro, 5, $iAlunosMatriculados , 1, 0, 'C', $iFill);
      }
    }
    $oPdf->Cell($oConfig->iXSubTotal, 5, $oEscola->iTotalEscola , 1, 0, 'C', $iFill);
    $oPdf->ln();


    $iLinhasImpressas ++;
  }

  /**
   * Totalizador do primeiro quadro
   */
  $oPdf->SetFont('arial', 'B', 7);
  $oPdf->Cell($oConfig->iXEscola,  5, "Total", 1, 0, 'L', 1);
  $oPdf->SetFont('arial', '', 6);
  $iTotalGeralPrimeiroQuadro = 0;
  foreach ($aEtapasErEp as $oEnsino) {

    $iTotalGeralPrimeiroQuadro += $oEnsino->iTotalEnsino;
    foreach ($oEnsino->aEtapas as $oEtapa) {

      $oPdf->Cell($oConfig->iXColunasEtapasPrimeriro,  5, $oEtapa->iTotalEtapa, 1, 0, 'C', 1);
    }
  }
  $oPdf->Cell($oConfig->iXSubTotal,  5, $iTotalGeralPrimeiroQuadro, 1, 0, 'C', 1);
}


/**
 * Imprime os Alunos matriculados dos Níveis de ensino de todas as escolas
 * Este bloco abrange todos os alunos matriculados no período informado em turmas do tipo:
 * 7 - CORREÇÃO DE FLUXO
 * ATENDIMENTO EDUCACIONAL ESPECIAL - AEE
 */
imprimeSegundoCabecalho($oPdf, $oConfig, $aEtapasSegundoQuadro);
$iLinhasImpressas             = 0;
$iTotalMatriculasProfissional = 0;
$iTotalMatriculasEspecial     = 0;
$iTotalMatriculasAee          = 0;
$iTotalMatriculasComplementar = 0;

foreach ($aEscolasSegundoQuadro as $oEscola) {

  if ($oConfig->iLinhasPorPagina == $iLinhasImpressas) {

    $iLinhasImpressas = 0;
    imprimeSegundoCabecalho($oPdf, $oConfig, $aEtapasSegundoQuadro);
  }

  $sNomeEscola = cortaString($oPdf, $oEscola->escola, $oEscola->escola_abrev, $oConfig->iXEscola);
  $oPdf->Cell($oConfig->iXEscola,  5, "{$sNomeEscola}", 1, 0);
  if ( isset($oEscola->aAlunosEtapa)) {

    foreach ($oEscola->aAlunosEtapa as $sIndex => $iAlunosMatriculados) {

      $iFill = 1;
      if (strpos($sIndex, "T") === false) {
        $iFill = 0;
      }
      $iAlunosMatriculados = $iAlunosMatriculados == 0 ? "" : $iAlunosMatriculados;
      $oPdf->Cell($oConfig->iXColunasEtapasSegundo, 5, $iAlunosMatriculados , 1, 0, 'C', $iFill);
    }
  }
  // sempre que não tem etaoas de correção de fluxo, incrementa o eixo X
  if (count($aEtapasSegundoQuadro) == 0) {
    $oPdf->SetX($oPdf->GetX()+$oConfig->iXColunasEtapasSegundo);
  }

  $iTotalMatriculasProfissional += $oEscola->iTotalMatriculasProfissional;
  $iTotalMatriculasEspecial     += $oEscola->iTotalMatriculasEspecial;
  $iTotalMatriculasAee          += $oEscola->iTotalMatriculasAee;
  $iTotalMatriculasComplementar += $oEscola->iTotalMatriculasComplementar;
  $oPdf->Cell($oConfig->iXSubTotal, 5, (int) $oEscola->iTotalMatriculasProfissional, 1, 0, 'C', 1);
  $oPdf->Cell($oConfig->iXSubTotal, 5, (int) $oEscola->iTotalMatriculasEspecial,     1, 0, 'C', 1);
  $oPdf->Cell($oConfig->iXSubTotal, 5, (int) $oEscola->iTotalMatriculasAee,          1, 0, 'C', 1);
  $oPdf->Cell($oConfig->iXSubTotal, 5, (int) $oEscola->iTotalMatriculasComplementar, 1, 0, 'C', 1);
  $oPdf->Cell($oConfig->iXSubTotal, 5, (int) $oEscola->iTotalEscola,                 1, 0, 'C', 1);
  $oPdf->Line($oPdf->lMargin, $oPdf->GetY() + 5, $oConfig->iXMaxima, $oPdf->GetY() + 5);
  $oPdf->ln();

  $iLinhasImpressas ++;
}

/**
 * Totalizador do segundo quadro
 */
$oPdf->SetFont('arial', 'B', 7);
$oPdf->Cell($oConfig->iXEscola,  5, "Total", 1, 0, 'L', 1);
$oPdf->SetFont('arial', '', 6);
$iTotalGeralSegundoQuadro = 0;
foreach ($aEtapasSegundoQuadro as $oEnsino) {

  $iTotalGeralSegundoQuadro += $oEnsino->iTotalEnsino;
  foreach ($oEnsino->aEtapas as $oEtapa) {
    $oPdf->Cell($oConfig->iXColunasEtapasSegundo,  5, $oEtapa->iTotalEtapa, 1, 0, 'C', 1);
  }
}

$oPdf->Line($oPdf->lMargin, $oPdf->GetY(), $oConfig->iXMaxima, $oPdf->GetY());

// sempre que não tem etaoas de correção de fluxo, incrementa o eixo X
if (count($aEtapasSegundoQuadro) == 0) {
  $oPdf->SetX($oPdf->GetX()+$oConfig->iXColunasEtapasSegundo);
}

$iTotalGeralSegundoQuadro += $iTotalMatriculasProfissional;
$iTotalGeralSegundoQuadro += $iTotalMatriculasEspecial;
$iTotalGeralSegundoQuadro += $iTotalMatriculasAee;
$iTotalGeralSegundoQuadro += $iTotalMatriculasComplementar;
$oPdf->Cell($oConfig->iColunaProfissional     , 5, $iTotalMatriculasProfissional, 1, 0, 'C', 1);
$oPdf->Cell($oConfig->iColunaEspecial         , 5, $iTotalMatriculasEspecial    , 1, 0, 'C', 1);
$oPdf->Cell($oConfig->iColunaAee              , 5, $iTotalMatriculasAee         , 1, 0, 'C', 1);
$oPdf->Cell($oConfig->iColunaAtivComplementar , 5, $iTotalMatriculasComplementar, 1, 0, 'C', 1);
$oPdf->Cell($oConfig->iXSubTotal,               5, $iTotalGeralSegundoQuadro,     1, 0, 'C', 1);

$oPdf->ln();
$oPdf->Line($oPdf->lMargin, $oPdf->GetY(), $oConfig->iXMaxima, $oPdf->GetY());

AddPage($oPdf, $oConfig);
$oPdf->SetFont('arial', 'B', 7);
$oPdf->Cell($oConfig->iXMaxima, 5, "Totalizador Geral", 1, 1, 'C', 1);


$oPdf->SetFont('arial', '', 6);
foreach ($aEtapasErEp as $oEnsino) {

  $oPdf->Cell(200, 5, $oEnsino->sEnsino,     1, 0, 'L', 0);
  $oPdf->Cell(81,  5, $oEnsino->iTotalEnsino, 1, 1, 'R', 0);
}

foreach ($aEtapasSegundoQuadro as $oEnsino) {

  $oPdf->Cell(200, 5, $oEnsino->sEnsino . " - CORREÇÃO DE FLUXO",     1, 0, 'L', 0);
  $oPdf->Cell(81,  5, $oEnsino->iTotalEnsino, 1, 1, 'R', 0);
}

$oPdf->Cell(200, 5, "EDUCAÇÃO PROFISSIONAL",                  1, 0, 'L');
$oPdf->Cell(81,  5, $iTotalMatriculasProfissional,            1, 1, 'R');
$oPdf->Cell(200, 5, "EDUCAÇÃO ESPECIAL",                      1, 0, 'L');
$oPdf->Cell(81,  5, $iTotalMatriculasEspecial,                1, 1, 'R');
$oPdf->Cell(200, 5, "ATENDIMENTO EDUCACIONAL ESPECIAL - AEE", 1, 0, 'L');
$oPdf->Cell(81,  5, $iTotalMatriculasAee,                     1, 1, 'R');
$oPdf->Cell(200, 5, "ATIVIDADE COMPLEMENTAR",                 1, 0, 'L');
$oPdf->Cell(81,  5, $iTotalMatriculasComplementar,            1, 1, 'R');


$oPdf->Output();

/**
 * Adiciona uma nova paginal
 * @param FpdfMultiCellBorder $oPdf    Instancia de FPDF
 * @param StdClass           $oConfig  Configuração do relatorio
 */
function addPage(FpdfMultiCellBorder $oPdf, $oConfig) {

  $oPdf->AddPage();
  $oPdf->SetFont('arial', 'B', 7);
  $oPdf->Cell($oConfig->iXMaxima, $oConfig->iHLinha, "Movimentação de Alunos", 1, 1, "C");
  $oPdf->SetFont('arial', '', 7);

}

/**
 * Imprime o primeiro cabeçalho
 * @param  FpdfMultiCellBorder $oPdf        Instancia de FPDF
 * @param  StdClass            $oConfig     Configuração do relatorio
 * @param  array               $aEtapasErEp Array com os ensinos e as etapas
 * @return void
 */
function imprimePrimeiroCabecalho(FpdfMultiCellBorder $oPdf, $oConfig, $aEtapasErEp) {

  addPage($oPdf, $oConfig);

  $iYInicial = $oPdf->GetY();
  $oPdf->Rect(8, $oPdf->GetY(), $oConfig->iXMaxima, $oConfig->iAlturaCabecalho);
  $oPdf->ln();
  $oPdf->SetFont('arial', 'B', 9);
  $oPdf->MultiCell($oConfig->iXEscola, 5, "Unidade\nEscolar",0, 'C');

  $oPdf->SetY($iYInicial);
  $oPdf->SetX($oPdf->lMargin + $oConfig->iXEscola);

  $iAlturaLinha = 5;

  $oPdf->SetFont('arial', '', 6);
  //imprime os níveis de ensino
  foreach ($aEtapasErEp as $oEnsino) {

    $iXEnsino = count($oEnsino->aEtapas) * $oConfig->iXColunasEtapasPrimeriro;

    $sEnsino = cortaString($oPdf, $oEnsino->sEnsino, $oEnsino->sEnsinoAbrev, $iXEnsino);
    $oPdf->Cell($iXEnsino, $iAlturaLinha, $sEnsino, 1, 0, 'C');
  }

  $oPdf->SetY($oPdf->GetY() + $iAlturaLinha);
  $oPdf->SetX($oPdf->lMargin + $oConfig->iXEscola);

  $iAlturaColunaEtapa = $oConfig->iAlturaCabecalho - $iAlturaLinha;
  //imprime as colunas das etapas
  foreach ($aEtapasErEp as $oEnsino) {

    foreach ($oEnsino->aEtapas as $oEtapa) {
      $oPdf->vCell($oConfig->iXColunasEtapasPrimeriro, $iAlturaColunaEtapa, $oEtapa->sEtapaAbrev, 1, 0, 'C', $oEtapa->iFill);
    }
  }

  $oPdf->SetFont('arial', 'B', 6);
  $oPdf->SetXY($oPdf->GetX(), $iYInicial);
  $oPdf->vCell($oConfig->iXSubTotal, $oConfig->iAlturaCabecalho, "TOTAL", 1, 0, 'C', 1);
  $oPdf->SetFont('arial', '', 6);
  $oPdf->SetY($iYInicial + $oConfig->iAlturaCabecalho);
}

/**
 * Busca os alunos matriculados para a escola um período e etapa
 * @param integer $iEscola   Código da escola
 * @param integer $iEtapa    Código da etapa
 * @param DBDate  $oDtInicio
 * @param DBDate  $oDtInicio Período de matricula
 * @param DBDate  $oDtFim    Período de matricula
 * @param boolean $lCorrecaoFluxo
 * @return int
 * @throws Exception
 */
function buscaAlunosMatriculados($iEscola, $iEtapa, DBDate $oDtInicio, DBDate $oDtFim, $lCorrecaoFluxo) {

  if (is_null($iEtapa)) {
    return 0;
  }

  $sWhere  = " ed60_d_datamatricula <= '" . $oDtFim->getDate() . "' ";
  $sWhere .= " and extract(year FROM ed60_d_datamatricula) = " . $oDtFim->getAno();
  $sWhere .= " and ( ed60_d_datasaida is null or " ;
  $sWhere .= "       ed60_d_datasaida not between '" . $oDtInicio->getDate() . "' and '" . $oDtFim->getDate() . "') ";
  $sWhere .= " and ed60_c_situacao = 'MATRICULADO' ";
  $sWhere .= " and ed221_c_origem  = 'S' ";
  $sWhere .= " and ed57_i_escola   = $iEscola ";
  $sWhere .= " and ed221_i_serie   = $iEtapa  ";
  if ( $lCorrecaoFluxo ) {
    $sWhere .= " and ed57_i_tipoturma = 7 ";
  } else {
    $sWhere .= " and ed57_i_tipoturma not in (6, 7) ";
  }

  $oDaoMatricula = new cl_matricula();
  $sSqlMatricula = $oDaoMatricula->sql_query_bolsafamilia(null, " count(*) ", null, $sWhere);
  $rsMatricula   = db_query($sSqlMatricula);

  if ( !$rsMatricula ) {
    throw new Exception("Erro ao buscar alunos matrículados.\n" . pg_last_error());
  }

  $iMatriculas = 0;
  if (pg_num_rows($rsMatricula) > 0) {
    $iMatriculas = db_utils::fieldsMemory($rsMatricula, 0)->count;
  }
  return $iMatriculas;

}

/**
 * Valida se a String nome cabe na celula de destino.
 * Se não couber e haver um nome abreviado, retorna abreviatura
 * Se não couber e não tem um nome abreviado, corta a string
 *
 * @param  FpdfMultiCellBorder $oPdf           instancia de FPDF
 * @param  string              $sNome
 * @param  string              $sNomeAbreviado [description]
 * @param  integer             $iTamanhoCampo  Tamanho do campo (w)
 * @return string                              String compativel com o campo
 */
function cortaString(FpdfMultiCellBorder $oPdf, $sNome, $sNomeAbreviado, $iTamanhoCampo) {

  if ($oPdf->NbLines($iTamanhoCampo, $sNome) == 1) {
    return $sNome;
  }

  if ( !empty($sNomeAbreviado) ) {
    return $sNomeAbreviado;
  }

  return substr($sNome, 0, $iTamanhoCampo - 15) . "...";

}

function buscaCursosMinistradoAno($aFiltros) {

  $oDaoTurma = new cl_turma();
  $sCampo    = " distinct ed29_i_ensino ";
  $sWhere    = implode(" and ", $aFiltros);

  $sSql  = $oDaoTurma->sql_query_turma_ensino(null, $sCampo, null, $sWhere);
  $rs    = db_query($sSql);

  if ( !$rs ) {
    throw new Exception("Erro busca ensinos." . pg_last_error());
  }

  $iLinhas  = pg_num_rows($rs);
  $aEnsinos = array();

  for ($i=0; $i < $iLinhas; $i++) {
    $aEnsinos[] = db_utils::fieldsMemory($rs, $i)->ed29_i_ensino;
  }

  return $aEnsinos;
}

function buscaDadosEnsinosMinistrados($aFiltros) {

  $sWhere   = implode(" and ", $aFiltros);
  $sCampos  = " ed10_i_codigo as cod_ensino, trim(ed10_c_descr) as ensino, ed10_c_abrev as ensino_abrev, ";
  $sCampos .= " ed11_i_codigo as cod_etapa, trim(ed11_c_descr) as etapa, trim(ed11_c_abrev) as etapa_abrev ";

  $sSqlNivelEnsino  = " select {$sCampos}";
  $sSqlNivelEnsino .= "   from ensino ";
  $sSqlNivelEnsino .= "  inner join serie on ed11_i_ensino = ed10_i_codigo ";
  $sSqlNivelEnsino .= "  where {$sWhere}";
  $sSqlNivelEnsino .= "  order by ed10_ordem, ed11_i_sequencia; ";

  $rsNivelEnsino    = db_query($sSqlNivelEnsino);
  if (!$rsNivelEnsino) {
    throw new Exception("Falha ao buscar Níveis de Ensino.\n" . pg_last_error());
  }

  return $rsNivelEnsino;
}

function calculaAlunosMatriculadosEscola($aEscolas, $aEnsinos, $oDtInicio, $oDtFim) {
  /**
   * Percorre as escolas do primeiro quado e soma os alunos matriculados para cada etapa
   */

  foreach ($aEscolas as $oEscola) {

    $oEscola->aAlunosEtapa = array();
    $oEscola->iTotalEscola = 0;
    foreach ($aEnsinos as $oEnsino) {

      $lCorrecaoFluxo = false;
      if (isset($oEnsino->lCorrecaoFluxo) && $oEnsino->lCorrecaoFluxo) {
        $lCorrecaoFluxo = $oEnsino->lCorrecaoFluxo;
      }
      $iTotalEnsino = 0;
      foreach ($oEnsino->aEtapas as $oEtapa) {

        if (is_null($oEtapa->iEtapa)) {
          continue;
        }

        $sHash                = "{$oEnsino->iEnsino}#{$oEtapa->iEtapa}";
        $iTotalAlunosEtapa    = buscaAlunosMatriculados($oEscola->codigo, $oEtapa->iEtapa, $oDtInicio, $oDtFim, $lCorrecaoFluxo);
        $iTotalEnsino        += $iTotalAlunosEtapa;
        $oEtapa->iTotalEtapa += $iTotalAlunosEtapa;

        $oEscola->aAlunosEtapa[$sHash] = $iTotalAlunosEtapa;
      }
      $sHash                         = "{$oEnsino->iEnsino}#T";
      $oEscola->aAlunosEtapa[$sHash] = $iTotalEnsino;
      $oEnsino->iTotalEnsino        += $iTotalEnsino;
      $oEscola->iTotalEscola        += $iTotalEnsino;
      $oEnsino->aEtapas[count($oEnsino->aEtapas) - 1]->iTotalEtapa += $iTotalEnsino;
    }
  }

}

/**
 * Imprime o segundo cabeçalho
 * @param  FpdfMultiCellBorder $oPdf                 Instancia de FPDF
 * @param  StdClass            $oConfig              Configuração do relatorio
 * @param  array               $aEtapasSegundoQuadro Array com os ensinos e as etapas
 * @return void
 */
function imprimeSegundoCabecalho($oPdf, $oConfig, $aEtapasSegundoQuadro) {

  addPage($oPdf, $oConfig);
  $iAlturaLinha = 5;
  $iAlturaCabecalho = $oConfig->iAlturaCabecalho + $iAlturaLinha;
  $iYInicial = $oPdf->GetY();
  $oPdf->Rect(8, $oPdf->GetY(), $oConfig->iXMaxima, $iAlturaCabecalho);
  $oPdf->Rect(8, $oPdf->GetY(), $oConfig->iXEscola, $iAlturaCabecalho);
  $oPdf->ln();
  $oPdf->SetFont('arial', 'B', 9);
  $oPdf->MultiCell($oConfig->iXEscola, 5, "Unidade\nEscolar",0, 'C');

  $oPdf->SetY($iYInicial);
  $oPdf->SetX($oPdf->lMargin + $oConfig->iXEscola);

  $iXCorrecaoFluxo = 0;
  foreach ($aEtapasSegundoQuadro as $oEnsino) {
    $iXCorrecaoFluxo += count($oEnsino->aEtapas) * $oConfig->iXColunasEtapasSegundo;
  }

  // Se não houver correção de fluxo na escola, imprime a coluna com o espaço reservado para as etapas
  if (count($aEtapasSegundoQuadro) == 0) {
    $iXCorrecaoFluxo = $oConfig->iXColunasEtapasSegundo;
  }

  $oPdf->SetFont('arial', 'B', 6);
  $oPdf->Cell($iXCorrecaoFluxo, $iAlturaLinha, "Correção de Fluxo", 1, 1, 'C');

  $oPdf->SetX($oPdf->lMargin + $oConfig->iXEscola);
  $oPdf->SetFont('arial', '', 6);
  //imprime os níveis de ensino
  foreach ($aEtapasSegundoQuadro as $oEnsino) {

    $iXEnsino = count($oEnsino->aEtapas) * $oConfig->iXColunasEtapasSegundo;
    $sEnsino  = cortaString($oPdf, $oEnsino->sEnsino, $oEnsino->sEnsinoAbrev, $iXEnsino);
    $oPdf->Cell($iXEnsino, $iAlturaLinha, $sEnsino, 1, 0, 'C');
  }


  $oPdf->SetY($oPdf->GetY() + $iAlturaLinha);
  $oPdf->SetX($oPdf->lMargin + $oConfig->iXEscola);

  $iAlturaColunaEtapa = $iAlturaCabecalho - $iAlturaLinha;
  //imprime as colunas das etapas
  foreach ($aEtapasSegundoQuadro as $oEnsino) {

    foreach ($oEnsino->aEtapas as $oEtapa) {
      $oPdf->vCell($oConfig->iXColunasEtapasSegundo, $iAlturaColunaEtapa, $oEtapa->sEtapaAbrev, 1, 0, 'C', $oEtapa->iFill);
    }
  }

  $oPdf->SetXY($oPdf->GetX(), $iYInicial);
  // sempre que não tem etaoas de correção de fluxo, incrementa o eixo X
  if (count($aEtapasSegundoQuadro) == 0) {
    $oPdf->SetXY($oPdf->GetX()+$oConfig->iXColunasEtapasSegundo, $iYInicial);
  }

  $oPdf->vCell($oConfig->iColunaProfissional     , $iAlturaCabecalho, "Edu. Profissional",  1, 0, 'C', 1);
  $oPdf->vCell($oConfig->iColunaEspecial         , $iAlturaCabecalho, "Edu. Especial",      1, 0, 'C', 1);
  $oPdf->vCell($oConfig->iColunaAee              , $iAlturaCabecalho, "Matrículas AEE",     1, 0, 'C', 1);
  $oPdf->vCell($oConfig->iColunaAtivComplementar , $iAlturaCabecalho, "Ativ. Complementar", 1, 0, 'C', 1);
  $oPdf->SetFont('arial', 'B', 6);
  $oPdf->vCell($oConfig->iXSubTotal, $iAlturaCabecalho, "TOTAL", 1, 0, 'C', 1);
  $oPdf->SetFont('arial', '', 6);
  $oPdf->SetY($iYInicial + $iAlturaCabecalho);
}

/**
 * Busca todos alunos matriculados na escola em turmas de AEE
 * @param  integer $iEscola   código da escola
 * @param  DBDate  $oDtInicio período da matricula
 * @param  DBDate  $oDtFim    período da matricula
 * @return integer            Número de alunos matriculados
 */
function buscaAlunosMatriculadosAEE($iEscola, $oDtInicio, $oDtFim) {

  $sWhere  = "     ed268_i_escola = {$iEscola} ";
  $sWhere .= " and ed268_i_tipoatend = 5 ";
  $sWhere .= " and ed52_i_ano = " . $oDtInicio->getAno();
  $sWhere .= " and ed269_d_data <= '" . $oDtFim->getDate() . "' ";
  $oDaoAee = new cl_turmaacmatricula();
  $rsAee   = db_query( $oDaoAee->sql_query_turma(null, "count(*)", null, $sWhere) );

  return db_utils::fieldsMemory($rsAee, 0)->count;
}

/**
 * Busca os alunos matriculados na escola pelo tipo de ensino
 * @param integer $iEscola     código da escola
 * @param integer $sTipoEnsino Tipo de ensino
 * @param DBDate  $oDtInicio   período da matricula
 * @param DBDate  $oDtFim      período da matricula
 * @return int
 * @throws Exception
 */
function buscaAlunosMatriculadosTipoEnsino ($iEscola, $sTipoEnsino, $oDtInicio, $oDtFim) {

  $sWhere  = " ed60_d_datamatricula <= '" . $oDtFim->getDate() . "' ";
  $sWhere .= " and extract(year FROM ed60_d_datamatricula) = " . $oDtFim->getAno();
  $sWhere .= " and ( ed60_d_datasaida is null or " ;
  $sWhere .= "       ed60_d_datasaida not between '" . $oDtInicio->getDate() . "' and '" . $oDtFim->getDate() . "') ";
  $sWhere .= " and ed60_c_situacao   = 'MATRICULADO' ";
  $sWhere .= " and ed60_c_situacao   = 'MATRICULADO' ";
  $sWhere .= " and ed221_c_origem    = 'S' ";
  $sWhere .= " and ed57_i_escola     = $iEscola ";
  $sWhere .= " and ed10_i_tipoensino = {$sTipoEnsino}";

  $oDaoMatricula = new cl_matricula();
  $sSqlMatricula = $oDaoMatricula->sql_query_alunomatriculado(null, " count(*) ", null, $sWhere);
  $rsMatricula   = db_query($sSqlMatricula);

  if ( !$rsMatricula ) {
    throw new Exception("Erro ao buscar alunos matrículados.\n" . pg_last_error());
  }

  $iMatriculas = 0;
  if (pg_num_rows($rsMatricula) > 0) {
    $iMatriculas = db_utils::fieldsMemory($rsMatricula, 0)->count;
  }
  return $iMatriculas;
}

/**
 * Busca todos alunos matriculados na escola em turmas de Atividades Complementares
 * @param  integer $iEscola   código da escola
 * @param  DBDate  $oDtInicio período da matricula
 * @param  DBDate  $oDtFim    período da matricula
 * @return integer            Número de alunos matriculados
 */
function buscaAlunosMatriculadosAtivComplementar($iEscola, $oDtInicio, $oDtFim) {

  $sWhere  = "     ed268_i_escola = {$iEscola} ";
  $sWhere .= " and ed268_i_tipoatend = 4 ";
  $sWhere .= " and ed52_i_ano = " . $oDtInicio->getAno();
  $sWhere .= " and ed269_d_data <= '" . $oDtFim->getDate() . "' ";
  $oDaoAee = new cl_turmaacmatricula();
  $rsAee   = db_query( $oDaoAee->sql_query_turma(null, "count(*)", null, $sWhere) );

  return db_utils::fieldsMemory($rsAee, 0)->count;
}

/**
 * Busca todas escolas da rede que tiveram alunos matriculados no período informado
 * @return array
 * @throws Exception
 */
function buscaEscolas() {

  $sCampos = " ed18_i_codigo as codigo, ed18_c_nome as escola, ed18_c_abrev as escola_abrev ";
  $sWhere  = "ed18_i_funcionamento = 1";

  $oDaoEscola = new cl_escola();
  $rsEscolas  = db_query( $oDaoEscola->sql_query_file( null, $sCampos, 'escola', $sWhere ) );

  if ( !$rsEscolas ) {
    throw new Exception("Falha ao buscar Escolas.\n" . pg_last_error());
  }
  if (pg_num_rows($rsEscolas) == 0) {
    throw new Exception("Não há escolas com alunos matriculados no período informado.");
  }

  $aEscolas = array();
  $iEscolas = pg_num_rows($rsEscolas);

  for ($i = 0; $i < $iEscolas; $i++) {

    $oEscola    = db_utils::fieldsMemory($rsEscolas, $i);
    $aEscolas[] = $oEscola;
  }

  return $aEscolas;
}