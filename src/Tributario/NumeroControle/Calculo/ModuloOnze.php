<?php

/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2015  DBSeller Servicos de Informatica
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

namespace ECidade\Tributario\NumeroControle\Calculo;

use ECidade\Tributario\NumeroControle\NumeroControle;

/**
 * Classe que representa o cálculo do módulo onze
 *
 * @author Roberto Carneiro <roberto@dbseller.com.br>
 */
class ModuloOnze implements NumeroControle
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
   * Peso utilizado para o cálculo do módulo onze
   *
   * @var integer
   */
  private $iPeso = 9;

  /**
   * Variável que determina se o valor retorna do cáculo é
   * o dígito verificador ou o resto da divisão(vide função do cálculo)
   *
   * @var boolean
   */
  private $lDigitoVerificador = true;

  /**
   * Função responsável para calcular o n�mero de controle
   */
  public function calcular()
  {
    if (empty($this->sNumeracao)) {
      throw new \BusinessException("Numeração para o cálculo do Módulo 11 n�o foi definida.");
    }

    $iDigitoVerificador = 2;

    if ($this->lDigitoVerificador) {
      $iDigitoVerificador = 1;
    }

    $oNumeroControle      = new \NumeroControle();
    $iResultadoModuloOnze = $oNumeroControle->calcularModuloOnze(
      $this->sNumeracao,
      $iDigitoVerificador,
      $this->iPeso
    );

    if (empty($iResultadoModuloOnze)) {
      $iResultadoModuloOnze = 0;
    }

    $this->sNumeracaoCalculada = $iResultadoModuloOnze;
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

  /**
   * Função para alterar o peso usado no cálculo
   *
   * @param integer $iPeso
   */
  public function setPeso($iPeso)
  {
    $this->iPeso = $iPeso;
  }

  /**
   * Função para buscar o peso usado no cálculo
   *
   * @return integer
   */
  public function getPeso()
  {
    return $this->iPeso;
  }

  /**
   * Função para alterar o peso usado no cálculo
   *
   * @param integer $iPeso
   */
  public function setDigitoVerificador($lDigitoVerificador)
  {
    $this->lDigitoVerificador = $lDigitoVerificador;
  }

  /**
   * Função para buscar o peso usado no cálculo
   *
   * @return integer
   */
  public function isDigitoVerificador()
  {
    return $this->lDigitoVerificador;
  }
}
