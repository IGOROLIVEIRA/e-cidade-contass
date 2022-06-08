<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_cute102022_classe.php");
require_once ("classes/db_cute202022_classe.php");
require_once ("classes/db_cute212022_classe.php");
require_once ("classes/db_cute302022_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2022/GerarCUTE.model.php");
/**
 * TomadasContasEspeciais Sicom Acompanhamento Mensal
 * @author Mario Junior
 * @package Contabilidade
 */
class SicomArquivoContaUnicadoTesouroMunicipal extends SicomArquivoBase implements iPadArquivoBaseCSV {

    protected $sNomeArquivo = 'CUTE';

    public function __construct()
    {

    }

    public function getCodigoLayout()
    {
//        return $this->iCodigoLayout;
        // TODO: Implement getCodigoLayout() method.
    }

    public function getCampos()
    {
        // TODO: Implement getCampos() method.
    }

    public function gerarDados()
    {
        $db_cute102022 = new cl_cute102022();
        $db_cute202022 = new cl_cute202022();
        $db_cute212022 = new cl_cute212022();
        $db_cute302022 = new cl_cute302022();

        $oGerarCUTE = new GerarCUTE();
        $oGerarCUTE->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarCUTE->gerarDados();
    }

}