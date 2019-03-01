<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_cute102019_classe.php");
require_once ("classes/db_cute202019_classe.php");
require_once ("classes/db_cute212019_classe.php");
require_once ("classes/db_cute302019_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2019/GerarCUTE.model.php");
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
        $db_cute102019 = new cl_cute102019();
        $db_cute202019 = new cl_cute202019();
        $db_cute212019 = new cl_cute212019();
        $db_cute302019 = new cl_cute302019();

        $oGerarCUTE = new GerarCUTE();
        $oGerarCUTE->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarCUTE->gerarDados();
    }

}