<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_cute102024_classe.php");
require_once ("classes/db_cute202024_classe.php");
require_once ("classes/db_cute212024_classe.php");
require_once ("classes/db_cute302024_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2024/GerarCUTE.model.php");
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
        $db_cute102024 = new cl_cute102024();
        $db_cute202024 = new cl_cute202024();
        $db_cute212024 = new cl_cute212024();
        $db_cute302024 = new cl_cute302024();

        $oGerarCUTE = new GerarCUTE();
        $oGerarCUTE->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarCUTE->gerarDados();
    }

}
