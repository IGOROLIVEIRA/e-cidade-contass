<?php

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2016  DBSeller Servicos de Informatica
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

namespace ECidade\Tributario\NumeroControle;

use ECidade\Tributario\NumeroControle\Calculo\ModuloDez;
use ECidade\Tributario\NumeroControle\Calculo\ModuloOnze;

/**
 * Classe que calcula o N�mero de Controle a partir dos módulos dez e onze
 *
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */
class Calculo implements NumeroControle
{
  /**
   * Numeração que será usada no cálculo
   *
   * @var string
   */
  private $sNumeracao;

  /**
   * Numeração calculada a partir do módulo onze
   *
   * @var string
   */
  private $sNumeracaoCalculada;

  /**
   * Função responsável para calcular o n�mero de controle
   *
   * @return string N�mero de Controle calculado
   */
  public function calcular()
  {
    if (empty($this->sNumeracao)) {
      throw new \BusinessException("Numeração para o cálculo do N�mero de Controle(NC) n�o foi definida.");
    }

    /**
     * Calculamos o Módulo Dez
     */
    $oModuloDez = new ModuloDez();
    $oModuloDez->setNumeracao($this->sNumeracao);
    $oModuloDez->calcular();
    $iModuloDez = $oModuloDez->getNumeracaoCalculada();

    /**
     * Calculamos o Módulo Onze
     */
    $oModuloOnze = new ModuloOnze();
    $oModuloOnze->setNumeracao($this->sNumeracao . $iModuloDez);
    $oModuloOnze->setDigitoVerificador(false);
    $oModuloOnze->setPeso(7);
    $oModuloOnze->calcular();
    $iResto      = $oModuloOnze->getNumeracaoCalculada();

    if ($iResto == 1) {

      $iModuloDez++;

      if ($iModuloDez > 9) {
        $iModuloDez = 0;
      }

      $oModuloOnze->setNumeracao($this->sNumeracao . $iModuloDez);
      $oModuloOnze->calcular();
      $iModuloOnze = $oModuloOnze->getNumeracaoCalculada();
    } else if ($iResto == 0) {
      $iModuloOnze = $iResto;
    } else {

      $oModuloOnze->setDigitoVerificador(true);
      $oModuloOnze->calcular();
      $iModuloOnze = $oModuloOnze->getNumeracaoCalculada();
    }

    /**
     * Juntamos o módulo dez e onze formando o n�mero de controle
     */
    $iNumeroControle = $iModuloDez . $iModuloOnze;

    $this->sNumeracaoCalculada = $iNumeroControle;
  }

  /**
   * Função para alterar a numeração usada no cálculo
   *
   * @param string $sNumeracao
   */
  public function setNumeracao($sNumeracao)
  {
    $this->sNumeracao = $sNumeracao;
  }

  /**
   * Função para buscar a numeração usada no cálculo
   *
   * @return string
   */
  public function getNumeracao()
  {
    return $this->sNumeracao;
  }

  /**
   * Função para buscar a numeração calculada a partir do modulo onze
   *
   * @return string
   */
  public function getNumeracaoCalculada()
  {
    return $this->sNumeracaoCalculada;
  }
}
