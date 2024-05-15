<?php

require_once("model/contabilidade/arquivos/sicom/mensal/geradores/GerarAM.model.php");

/**
 * Sicom Acompanhamento Mensal
 * @author Elvio
 * @package Contabilidade
 */
class GerarCONCIBANC extends GerarAM
{

    /**
     *
     * Mes de refer�ncia
     * @var Integer
     */
    public $iMes;

    
    public function gerarDados()
    {

        // Arquivo ser� construido.
        $this->sArquivo = "CONCIBANC";
        $this->abreArquivo();

        $aCSV['tiporegistro'] = '99';
        $this->sLinha = $aCSV;
        $this->adicionaLinha();


    }
}
