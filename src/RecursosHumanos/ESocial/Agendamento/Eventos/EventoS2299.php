<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;
use ECidade\RecursosHumanos\ESocial\Model\Formulario\EventoCargaS2299;

/**
 * Classe responsável por montar as informações do evento S2299 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS2299 extends EventoBase 
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
            echo "<pre>"; print_r($oDados);
            exit;
            $oDadosAPI                                 = new \stdClass;
            $oDadosAPI->evtDeslig                      = new \stdClass;
            $oDadosAPI->evtDeslig->sequencial   = $iSequencial;
            $oDadosAPI->evtDeslig->indRetif     = 1;
            $oDadosAPI->evtDeslig->nrRecibo     = null;
            $oDadosAPI->evtDeslig->indGuia      = 1;
            $oDadosAPI->evtDeslig->cpfTrab      = $oDados->cpftrab;
            $oDadosAPI->evtDeslig->matricula    = $oDados->matricula;
            $oDadosAPI->evtDeslig->mtvdeslig    = $oDados->mtvdeslig;
            $oDadosAPI->evtDeslig->dtdeslig     = $oDados->dtdeslig;
            $oDadosAPI->evtDeslig->dtavprv      = $oDados->dtavprv;
            $oDadosAPI->evtDeslig->indpagtoapi  = $oDados->indpagtoapi;
            $oDadosAPI->evtDeslig->dtprojfimapi = $this->getQuantidadeDiasAviso($oDados->dtdeslig, $oDados->dtadmiss);
            $oDadosAPI->evtDeslig->pensalim     = $oDados->pensalim;
            $oDadosAPI->evtDeslig->percaliment  = null;
            $oDadosAPI->evtDeslig->vralim       = null;
            $oDadosAPI->evtDeslig->nrproctrab   = null;

            $oDadosAPI->evtDeslig->verbasresc = $this->buscarVerbasResc($oDados->matricula);

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
        echo '<pre>';
        print_r($aDadosAPI);
        exit;
        return $aDadosAPI;
    }

    /**
     * Retorna dados das verbas rescisórias formatados
     * @return array stdClass
     */
    private function buscarVerbasResc($matricula)
    {
        $eventoCarga = new EventoCargaS2299();
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
            
            $sHashIdeEstabLotItens = $oVerbasSql->tpinsc.$oVerbasSql->nrinsc.$oVerbasSql->codlotacao;
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
     * Calcula a quantidade de dias de aviso previo indenizado
     * @return integer
     */
    private function getQuantidadeDiasAviso($recis,$admiss) {
        $oDataRecis = new DateTime($recis);
        $oDataAdmiss = new DateTime($admiss);
        $oAnosAviso = $oDataRecis->diff($oDataAdmiss);
        $quantAviso = 0;
        if ($oAnosAviso->d > 0 || $oAnosAviso->m > 0) {
            $quantAviso = $oAnosAviso->y*3+30;
        } else {
            $quantAviso = $oAnosAviso->y*3+30-3;
        }
        return ($quantAviso < 90 ? $quantAviso : 90);
    }
}
