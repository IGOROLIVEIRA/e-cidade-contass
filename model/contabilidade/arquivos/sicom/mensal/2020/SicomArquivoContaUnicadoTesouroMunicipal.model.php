<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_cute102020_classe.php");
require_once ("classes/db_cute202020_classe.php");
require_once ("classes/db_cute212020_classe.php");
require_once ("classes/db_cute302020_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarCUTE.model.php");
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
        $db_cute102020 = new cl_cute102020();
        $db_cute202020 = new cl_cute202020();
        $db_cute212020 = new cl_cute212020();
        $db_cute302020 = new cl_cute302020();

        $oGerarCUTE = new GerarCUTE();
        $oGerarCUTE->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $oGerarCUTE->gerarDados();
    }

}