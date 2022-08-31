<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use DBPessoal;
use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;
use ECidade\RecursosHumanos\ESocial\Model\Formulario\EventoCargaS1207;

/**
 * Classe responsÃ¡vel por montar as informaÃ§Ãµes do evento S1207 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1207 extends EventoBase
{
    /**
     *
     * @param \stdClass $dados
     */
    public function __construct($dados)
    {
        parent::__construct($dados);
    }

    /**
     * Retorna dados no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    public function montarDados()
    {
        $aDadosAPI = array();
        $iSequencial = 1;
        foreach ($this->dados as $oDados) {
            $oDadosAPI                                   = new \stdClass();
            $oDadosAPI->evtBenPrRP                      = new \stdClass();
            $oDadosAPI->evtBenPrRP->sequencial          = $iSequencial;
            $oDadosAPI->evtBenPrRP->modo                = $this->modo;
            $oDadosAPI->evtBenPrRP->indRetif            = 1;
            $oDadosAPI->evtBenPrRP->nrRecibo            = null;

            $oDadosAPI->evtBenPrRP->indapuracao         = $this->indapuracao;
            $oDadosAPI->evtBenPrRP->perapur             = date('Y-m');
            if ($oDados->indapuracao == 2) {
                $oDadosAPI->evtBenPrRP->perapur         = date('Y');
            }
            $oDadosAPI->evtBenPrRP->cpfbenef             = $oDados->cpftrab;

            $oIdeestab = new \stdClass();
            $oIdeestab->idedmdev  = $this->buscarIdentificador($oDados->matricula);
            $oIdeestab->idedmdev  = $oIdeestab->codcateg;
            $oIdeestab->remumperant->matricula   = $oDados->matricula;
            $oIdeestab->remumperant->itensremun  = $this->buscarValorRubrica($oDados->matricula);

            $oDadosAPI->evtBenPrRP->dmdev->idedmdev  = $this->buscarIdentificador($oDados->matricula);

            $oIdeestab->tpinsc = 1;
            $oIdeestab->nrinsc = $oDados->nrinsc;

            $aIdeestab[] = $oIdeestab;
            $oDadosAPI->evtBenPrRP->dmdev->infoperant->ideperiodo = $aIdeestab;

            //$oDadosAPI->evtBenPrRP->dtAlteracao         = '2021-01-29'; //$oDados->altContratual->dtAlteracao;
            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
        // echo '<pre>';
        // print_r($aDadosAPI);
        // exit;
        return $aDadosAPI;
    }

    /**
     * Retorna dados das verbas rescis?rias formatados
     * @return array stdClass
     */
    private function buscarVerbasResc($matricula)
    {
        $eventoCarga = new EventoCargaS1207();
        $rsVerbas = $eventoCarga->getVerbasResc($matricula);
        if (pg_num_rows($rsVerbas) == 0) {
            return null;
        }
        $oVerbasResc = new \stdClass;
        $oVerbasResc->dmdev = array();
        for ($iCont = 0; $iCont < pg_num_rows($rsVerbas); $iCont++) {

            $oVerbasSql = \db_utils::fieldsMemory($rsVerbas, $iCont);
            $hashDmDev = $oVerbasSql->idedmdev;
            if (!isset($oVerbasResc->dmdev[$hashDmDev])) {
                $oVerbasFormatado = new \stdClass;
                $oVerbasFormatado->idedmdev = $oVerbasSql->idedmdev;

                $oVerbasFormatado->infoperapur = new \stdClass;
                $oVerbasFormatado->infoperapur->ideestablot = array();
                $oVerbasResc->dmdev[$hashDmDev] = $oVerbasFormatado;
            }

            $sHashIdeEstabLotItens = $oVerbasSql->tpinsc . $oVerbasSql->nrinsc . $oVerbasSql->codlotacao;
            if (!isser($oVerbasResc->dmdev[$hashDmDev]->infoperapur->ideestablot[$sHashIdeEstabLotItens])) {
                $oIdeEstabLotItens = new \stdClass;
                $oIdeEstabLotItens->tpinsc = $oVerbasSql->tpinsc;
                $oIdeEstabLotItens->nrinsc = $oVerbasSql->nrinsc;
                $oIdeEstabLotItens->codlotacao = $oVerbasSql->codlotacao;
                $oIdeEstabLotItens->detverbas = array();
                $oIdeEstabLotItens->infoagnocivo = new \stdClass;
                $oIdeEstabLotItens->infoagnocivo->grauexp = $oVerbasSql->grauexp;
                $oVerbasResc->dmdev[$hashDmDev]->infoperapur->ideestablot[$sHashIdeEstabLotItens] = $oIdeEstabLotItens;
            }

            $oDetVerbasItems = new \stdClass;
            $oDetVerbasItems->codrubr = $oVerbasSql->codrubr;
            $oDetVerbasItems->idetabrubr = $oVerbasSql->idetabrubr;
            $oDetVerbasItems->qtdrubr = $oVerbasSql->qtdrubr;
            $oDetVerbasItems->vrrubr = $oVerbasSql->vrrubr;
            $oDetVerbasItems->indapurir = $oVerbasSql->indapurir;
            $oVerbasResc->dmdev[$hashDmDev]->infoperapur->ideestablot[$sHashIdeEstabLotItens]->detverbas[] = $oDetVerbasItems;
        }

        if (!empty($oVerbasSql->indmv) && !isset($oVerbasResc->infomv->indmv)) {
            $oVerbasResc->infomv->indmv = $oVerbasSql->indmv;
            $oVerbasResc->infomv->remunoutrempr = array();
            $oItemsRemuOutrEmpr = new stdClass;
            $oItemsRemuOutrEmpr->tpinsc = $oVerbasSql->tpinscremunoutrempr;
            $oItemsRemuOutrEmpr->nrinsc = $oVerbasSql->nrinscremunoutrempr;
            $oItemsRemuOutrEmpr->codcateg = $oVerbasSql->codcateg;
            $oItemsRemuOutrEmpr->vlrremunoe = $oVerbasSql->vlrremunoe;
            $oVerbasResc->infomv->remunoutrempr[] = $oItemsRemuOutrEmpr;
        }
        return $oVerbasResc;
    }

    /**
     * Retorna dados dos dependentes no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarIdentificador($matricula)
    {
        $iAnoUsu           = db_getsession('DB_anousu');
        $iMesusu           = DBPessoal::getMesFolha();
        $aPontos = array('salario', 'complementar', '13salario');
        $aIdentificadores = array();
        foreach ($aPontos as $opcao) {
            switch ($opcao) {
                case 'salario':
                    $sigla          = 'r14_';
                    $arquivo        = 'gerfsal';
                    $sTituloCalculo = 'Salário';
                    break;

                case 'complementar':
                    $sigla          = 'r48_';
                    $arquivo        = 'gerfcom';
                    $sTituloCalculo = 'Complementar';
                    break;

                case '13salario':
                    $sigla          = 'r35_';
                    $arquivo        = 'gerfs13';
                    $sTituloCalculo = '13? Sal?rio';
                    break;

                default:
                    continue;
                    break;
            }
            if ($opcao) {
                $sql = "  select distinct
                        case
                        when '{$arquivo}' = 'gerfsal' then 1
                        when '{$arquivo}' = 'gerfcom' then 3
                        when '{$arquivo}' = 'gerfs13' then 4
                        end as ideDmDev
                        from {$arquivo}
                        where " . $sigla . "anousu = '" . $iAnoUsu . "'
                        and  " . $sigla . "mesusu = '" . $iMesusu . "'
                        and  " . $sigla . "instit = " . db_getsession("DB_instit") . "
                        and {$sigla}regist = $matricula";
            }

            $rsIdentificadores = db_query($sql);
            if ($rsIdentificadores) {
                $oIdentificadores = \db_utils::fieldsMemory($rsIdentificadores, 0);
                // if (!empty($oIdentificadores->idedmdev)) {
                //     $aIdentificadores[] = $oIdentificadores->idedmdev;
                // }
                return $oIdentificadores->idedmdev;
            }
        }
        //return $aIdentificadores;
    }

    private function buscarValorRubrica($matricula)
    {
        $iAnoUsu           = db_getsession('DB_anousu');
        $iMesusu           = DBPessoal::getMesFolha();
        $aPontos = array('salario', 'complementar', '13salario');
        $aIdentificadores = array();
        foreach ($aPontos as $opcao) {
            switch ($opcao) {
                case 'salario':
                    $sigla          = 'r14_';
                    $arquivo        = 'gerfsal';
                    $sTituloCalculo = 'Salário';
                    break;

                case 'complementar':
                    $sigla          = 'r48_';
                    $arquivo        = 'gerfcom';
                    $sTituloCalculo = 'Complementar';
                    break;

                case '13salario':
                    $sigla          = 'r35_';
                    $arquivo        = 'gerfs13';
                    $sTituloCalculo = '13? Sal?rio';
                    break;

                default:
                    continue;
                    break;
            }
            if ($opcao) {
                $sql = "  select distinct
                        {$sigla}valor as valor,
                        {$sigla}rubric as rubrica
                        from {$arquivo}
                        where " . $sigla . "anousu = '" . $iAnoUsu . "'
                        and  " . $sigla . "mesusu = '" . $iMesusu . "'
                        and  " . $sigla . "instit = " . db_getsession("DB_instit") . "
                        and {$sigla}regist = $matricula
                        and not exists (select 1 from rhrubricas where rh27_rubric = {$sigla}rubric and rh27_pd = 3)";
            }

            $rsValores = db_query($sql);
            // echo $sql;
            // db_criatabela($rsValores);
            // exit;
            for ($iCont = 0; $iCont < pg_num_rows($rsValores); $iCont++) {
                $oResult = \db_utils::fieldsMemory($rsValores, $iCont);
                $oFormatado = new \stdClass();
                $oFormatado->codrubr    = $oResult->rubrica;
                $oFormatado->idetabrubr = 'tabrub1';
                $oFormatado->vrrubr     = $oResult->valor;
                $oFormatado->indapurir  = 0;

                $aItens[] = $oFormatado;
            }
        }
        return $aItens;
    }
}
