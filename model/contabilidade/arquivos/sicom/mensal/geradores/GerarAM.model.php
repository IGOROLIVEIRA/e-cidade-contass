<?php

class GerarAM
{
  /**
   *
   * @var String
   */
  protected $sArquivo;

  /**
   *
   * @var String
   */
  protected $sDelimiter = ";";

  /**
   *
   * @var String
   */
  protected $_arquivo;

  /**
   *
   * @var String
   */
  protected $sLinha;

  function abreArquivo()
  {
    $this->_arquivo = fopen($this->sArquivo . '.csv', "w");
  }

  function fechaArquivo()
  {
    fclose($this->_arquivo);
  }

  function adicionaLinha()
  {
    $aLinha = array();
    foreach ($this->sLinha as $sLinha) {
      if ($sLinha == '' || $sLinha == null) {
        $sLinha = ' ';
      }
      $aLinha[] = $sLinha;
    }
    $sLinha = implode(";", $aLinha);
    fputs($this->_arquivo, $sLinha);
    fputs($this->_arquivo, "\r\n");
  }


  /**
   * Retorna data formatada para SICOM
   * @param $data date
   * @return string
   */
  public function sicomDate($data)
  {
    return implode("", array_reverse(explode("-", $data)));
  }


  /**
   * Retorna string preenchida de 0 à esquerda
   * @param $entrada string
   * @param $tamanho int
   * @return string
   */
  public function padLeftZero($entrada, $tamanho)
  {
    return str_pad($entrada, $tamanho, "0", STR_PAD_LEFT);
  }


  /**
   * Retorna valor Real formatado
   * @param $valor string
   * @param $decimal int
   * @return string
   */
  public function sicomNumberReal($valor, $decimal)
  {
    return number_format($valor, $decimal, ",", "");
  }

  /**
   * Retorna bool se nmero  -0,00
   * @param $valor float
   * @return bool
   */
  public function isZeroNegativo($valor)
  {
    return pow(number_format($valor, 2, ".", ""), -1) === -INF;
  }


}