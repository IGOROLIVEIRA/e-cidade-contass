<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2022/GerarCONCIBANC.model.php");

/**
 * Conciliação Bancária Sicom Acompanhamento Mensal
 * @author Elvio
 * @package Contabilidade
 */
class SicomArquivoConciliacaoBancaria extends SicomArquivoBase implements iPadArquivoBaseCSV
{

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 229;

    
    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'CONCIBANC';

    /**
     *
     * Construtor da classe
     */
    public function __construct()
    {

    }

    /**
     * Retorna o codigo do layout
     *
     * @return Integer
     */
    public function getCodigoLayout()
    {
        return $this->iCodigoLayout;
    }

    /**
     * Esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
     */
    public function getCampos()
    {

    }

    /**
     * selecionar os dados
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados()
    {

        $oGerarCONCIBANC = new GerarCONCIBANC();
        $oGerarCONCIBANC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarCONCIBANC->gerarDados();

    }

}
