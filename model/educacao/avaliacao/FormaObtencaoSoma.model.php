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

/**
 * Calculo avaliacao por SOMA
 * Retorna um somatorio das avaliacoes
 * @package educacao
 * @subpackage avaliacao
 * @author Andrio Costa <andrio.costa@dbseller.com.br>
 * @version $Revision: 1.23 $
 */
require_once("model/educacao/avaliacao/iFormaObtencao.interface.php");
require_once("model/educacao/avaliacao/FormaObtencao.model.php");
class FormaObtencaoSoma extends FormaObtencao implements IFormaObtencao {

  /**
   * Define as notas que ira ser usaddo no calculo
   * Deverá ser instancias de AvaliacaoAproveitamento
   * @see IFormaObtencao::processarResultado()
   * @param array   $aAproveitamentos
   * @param integer $iAno
   * @return int|string|ValorAproveitamentoNota
   */
  public function processarResultado( $aAproveitamentos, $iAno ) {

    $mAproveitamento = '';
    $aNotasPeriodos  = $this->getElementosParaCalculo( $aAproveitamentos, $iAno );
    $aElementos      = $this->getResultadoAvaliacao()->getElementosComposicaoResultado();

    /**
     * Percorremos as avaliacoes que possuem valor
     * e somamos todas as avaliacoes
     */
    foreach ($aNotasPeriodos as $oNotaDoAproveitamento) {

      if ($oNotaDoAproveitamento->isAmparado()) {
        continue;
      }

      $oElemento                 = $aElementos[$oNotaDoAproveitamento->getOrdemSequencia()];
      $lValidaPeriodoObrigatorio = $oElemento->isObrigatorio();

      $oDiarioAvaliacaoDisciplina = $oNotaDoAproveitamento->getDiarioAvaliacaoDisciplina();
      if (!is_null($oDiarioAvaliacaoDisciplina)) {

        $oResultadoFinal            = $oDiarioAvaliacaoDisciplina->getResultadoFinal();
        $lUtilizaProporcionalidade  = false;

        if( $oResultadoFinal->getResultadoAvaliacao() != '' ) {
          $lUtilizaProporcionalidade  = $oResultadoFinal->getResultadoAvaliacao()->utilizaProporcionalidade();
        }

        /**
         * Quando o calculo do resultado final utiliza proporcionalidade devemos ignorar a obrigatoriedade do lançamento
         * de avaliação para o periodo de avaliação que não esta configurado a proporcionalidade
         */
        if ( $lUtilizaProporcionalidade ) {

          $aPeriodosProporcionais = $oNotaDoAproveitamento->getDiarioAvaliacaoDisciplina()->getOrdemPeriodosAplicaProporcionalidade();
          if (count($aPeriodosProporcionais) > 0
               && !in_array($oElemento->getOrdem(), $aPeriodosProporcionais)
               && $oElemento->isObrigatorio() ) {
            $lValidaPeriodoObrigatorio = false;
          }
        }
      }

      $nAproveitamentoPeriodo = $oNotaDoAproveitamento->getValorAproveitamento()->getAproveitamento();
      if (!$this->isCalculoNotaParcial() && $lValidaPeriodoObrigatorio && $nAproveitamentoPeriodo === "") {

        $mAproveitamento = '';
        $iTotalPeriodos  = 0;
        break;
      }
      if ($oNotaDoAproveitamento->getValorAproveitamento()->getAproveitamento() != "") {
        $mAproveitamento += $oNotaDoAproveitamento->getValorAproveitamento()->getAproveitamento();
      }
    }

    $mAproveitamento = ArredondamentoNota::arredondar( $mAproveitamento, $iAno );

    /**
     * Devolvemos as notas Originais
     */
    $this->acertaNotasSubstituidasParaCalculo($aNotasPeriodos);
    $mAproveitamento = new ValorAproveitamentoNota($mAproveitamento);
    return $mAproveitamento;
  }

  /**
   * Calcula a nota projetada
   * @param AvaliacaoAproveitamento[] $aElementosAvaliacoes
   * @return string
   */
  public function calcularNotaProjetada(array $aElementosAvaliacoes) {

    $nMinimoAprovacao = $this->oResultadoAvaliacao->getAproveitamentoMinimo();
    $nSomaElementos   = 0;
    foreach ($aElementosAvaliacoes as $oElementoAvaliacao) {
      $nSomaElementos += $oElementoAvaliacao->getValorAproveitamento()->getAproveitamento();
    }

    $nNotaProjetada = $nMinimoAprovacao - $nSomaElementos;

    return $nNotaProjetada < 0 ? '' : $nNotaProjetada;
  }

  /**
   * Calcula a proporcionalidade da avaliação do aluno
   * @param  AvaliacaoAproveitamento[] $aElementos
   * @return float
   */
  public static function calcularProporcionalidade( $aElementosResultado, $aElementos ) {

    $nSomaAvaliacao  = 0;
    $nSomaMaiorValor = 0;

    foreach( $aElementos as $oElemento ) {

      $oElementoResultado        = $aElementosResultado[$oElemento->getOrdemSequencia()];
      $lValidaPeriodoObrigatorio = $oElementoResultado->isObrigatorio();

      if( $oElemento->isAmparado() ) {
        continue;
      }

      if( $lValidaPeriodoObrigatorio && $oElemento->getValorAproveitamento()->getAproveitamento() === '' ) {

        $nSomaAvaliacao = '';
        break;
      }

      $nSomaAvaliacao  += $oElemento->getValorAproveitamento()->getAproveitamento();
      $nSomaMaiorValor += $oElemento->getElementoAvaliacao()->getFormaDeAvaliacao()->getMaiorValor();
    }

    $nValorCalculado = $nSomaAvaliacao !== '' ? ($nSomaAvaliacao * 100) / $nSomaMaiorValor : '';

    return $nValorCalculado;
  }

  /**
   * Percorre todos os elementos de avaliação, e quando o período estiver amparado, utiliza o mínimo para aprovação, no
   * cálculo do aproveitamento
   * @param  array $aElementosAvaliacao
   * @return float
   */
  public function calculaNotaComAmparo( $aElementosAvaliacao, $iAno ) {

    $nAproveitamento  = null;
    $aPeriodosValidos = array();
    $aNotasPeriodos   = $this->getElementosParaCalculo( $aElementosAvaliacao, $iAno );
    $aElementos       = $this->getResultadoAvaliacao()->getElementosComposicaoResultado();

    foreach ($aNotasPeriodos as $oNotaDoAproveitamento ) {

      foreach ($aElementosAvaliacao as $oElementoAvaliacao) {

        if ($oNotaDoAproveitamento->getOrdemSequencia() == $oElementoAvaliacao->getOrdemSequencia() ) {

          if ($oElementoAvaliacao->isAmparado()) {
            continue;
          }

          $aPeriodosValidos[] = $oNotaDoAproveitamento;
        }
      }
    }

    $nSomaAvaliacao  = 0;
    $nSomaMaiorValor = 0;

    foreach ($aPeriodosValidos as $oAproveitamento) {

      $oElemento              = $aElementos[$oAproveitamento->getOrdemSequencia()];
      $nAproveitamentoPeriodo = $oAproveitamento->getValorAproveitamento()->getAproveitamento();
      if ( !$this->isCalculoNotaParcial() && $nAproveitamentoPeriodo === "" ) {
        return '';
      }

      $nSomaAvaliacao  += $oAproveitamento->getValorAproveitamento()->getAproveitamento();
      $nSomaMaiorValor += $oAproveitamento->getElementoAvaliacao()->getFormaDeAvaliacao()->getMaiorValor();

    }

    if ( empty($nSomaAvaliacao) && empty($nSomaMaiorValor) ) {
      return '';
    }

    $nValorCalculado = $nSomaAvaliacao !== '' ? ($nSomaAvaliacao * 100) / $nSomaMaiorValor : '';

    return $nValorCalculado;
  }
}