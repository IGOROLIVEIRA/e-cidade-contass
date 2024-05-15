<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Balancete Mensal
 * @author Rodrigo
 * @package Contabilidade
 */
class GerarFUNDOS extends GerarAM
{

    /**
     *
     * Mes de referência
     * @var Integer
     */
    public $iMes;

    public function gerarDados()
    {

        $this->sArquivo = "FUNDOS";
        $this->abreArquivo();

        $aCSV['tiporegistro'] = '99';
        $this->sLinha = $aCSV;
        $this->adicionaLinha();

  }

}
