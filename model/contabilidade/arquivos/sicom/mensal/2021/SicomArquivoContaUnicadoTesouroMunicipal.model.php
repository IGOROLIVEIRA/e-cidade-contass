<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_cute102021_classe.php");
require_once ("classes/db_cute202021_classe.php");
require_once ("classes/db_cute212021_classe.php");
require_once ("classes/db_cute302021_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2021/GerarCUTE.model.php");
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
        $db_cute102021 = new cl_cute102021();
        $db_cute202021 = new cl_cute202021();
        $db_cute212021 = new cl_cute212021();
        $db_cute302021 = new cl_cute302021();

        $oGerarCUTE = new GerarCUTE();
        $oGerarCUTE->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarCUTE->gerarDados();
    }

}