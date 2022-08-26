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

    private $eventoCarga;

    /**
     *
     * @param \stdClass $dados
     */
    public function __construct($dados)
    {
        parent::__construct($dados);
        $this->eventoCarga = new EventoCargaS2299();
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
            
            $oDadosAPI                                 = new \stdClass;
            $oDadosAPI->evtDeslig                      = new \stdClass;
            $oDadosAPI->evtDeslig->sequencial   = $iSequencial;
            $oDadosAPI->evtDeslig->indRetif     = 1;
            $oDadosAPI->evtDeslig->nrRecibo     = null;
            $oDadosAPI->evtDeslig->cpfTrab      = $oDados->cpftrab;
            $oDadosAPI->evtDeslig->matricula    = $oDados->matricula;
            $oDadosAPI->evtDeslig->mtvdeslig    = $oDados->mtvdeslig;
            $oDadosAPI->evtDeslig->dtdeslig     = $oDados->dtdeslig;
            $oDadosAPI->evtDeslig->dtavprv      = empty($oDados->dtavprv) ? NULL : $oDados->dtavprv;
            $oDadosAPI->evtDeslig->indpagtoapi  = $oDados->indpagtoapi;
            $oDadosAPI->evtDeslig->dtprojfimapi = $this->getDtProjetadaAviso($oDados->dtdeslig, $oDados->dtadmiss);
            $oDadosAPI->evtDeslig->pensalim     = $oDados->pensalim;
            $oDadosAPI->evtDeslig->percaliment  = null;
            $oDadosAPI->evtDeslig->vralim       = null;
            $oDadosAPI->evtDeslig->nrproctrab   = null;

            $oDtDeslig = new \DateTime($oVerbasSql->dtdeslig);
            $oDtAtual  = new \DateTime(db_getsession("DB_anousu")."-".date("m", db_getsession("DB_datausu"))."-".date("d", db_getsession("DB_datausu")));
            if ($oVerbasSql->rh30_regime == "2" && $oDtDeslig >= $oDtAtual) {
                $oDadosAPI->evtDeslig->verbasresc = $this->buscarVerbasResc($oDados->matricula);
            }

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
        return $aDadosAPI;
    }

    /**
     * Retorna dados das verbas rescisórias formatados
     * @param integer $matricula
     * @return stdClass
     */
    private function buscarVerbasResc($matricula)
    {
        $rsVerbas = $this->eventoCarga->getVerbasResc($matricula);
        if (pg_num_rows($rsVerbas) == 0) {
            return null;
        }
        $oVerbasResc = new \stdClass; 
        $oVerbasResc->dmdev = array();
        $aHashDmDev = array();
        $aHashIdeEstabLotItens = array();
        for ($iCont = 0; $iCont < pg_num_rows($rsVerbas); $iCont++) {
            
            $oVerbasSql = \db_utils::fieldsMemory($rsVerbas, $iCont);
            $hashDmDev = $oVerbasSql->idedmdev;
            if (!isset($oVerbasResc->dmdev[array_search($hashDmDev, $aHashDmDev)])) {
                $aHashDmDev[] = $hashDmDev;
                $oVerbasFormatado = new \stdClass;
                $oVerbasFormatado->idedmdev = $oVerbasSql->idedmdev;

                $oVerbasFormatado->infoperapur = new \stdClass;
                $oVerbasFormatado->infoperapur->ideestablot = array();
                $oVerbasResc->dmdev[array_search($hashDmDev, $aHashDmDev)] = $oVerbasFormatado;
            }
            
            $sHashIdeEstabLotItens = $oVerbasSql->tpinsc.$oVerbasSql->nrinsc.$oVerbasSql->codlotacao;
            if (!isset($oVerbasResc->dmdev[array_search($hashDmDev, $aHashDmDev)]->infoperapur->ideestablot[array_search($sHashIdeEstabLotItens, $aHashIdeEstabLotItens)])) {
                $aHashIdeEstabLotItens[] = $sHashIdeEstabLotItens;
                $oIdeEstabLotItens = new \stdClass;
                $oIdeEstabLotItens->tpinsc = $oVerbasSql->tpinsc;
                $oIdeEstabLotItens->nrinsc = $oVerbasSql->nrinsc;
                $oIdeEstabLotItens->codlotacao = $oVerbasSql->codlotacao;
                $oIdeEstabLotItens->detverbas = array();
                $oIdeEstabLotItens->infoagnocivo = new \stdClass;
                $oIdeEstabLotItens->infoagnocivo->grauexp = $oVerbasSql->grauexp;
                $oVerbasResc->dmdev[array_search($hashDmDev, $aHashDmDev)]->infoperapur->ideestablot[array_search($sHashIdeEstabLotItens, $aHashIdeEstabLotItens)] = $oIdeEstabLotItens;
            }

            $oDetVerbasItems = new \stdClass;
            $oDetVerbasItems->codrubr = $oVerbasSql->codrubr;
            $oDetVerbasItems->idetabrubr = $oVerbasSql->idetabrubr;
            $oDetVerbasItems->qtdrubr = empty($oVerbasSql->qtdrubr) ? NULL : $oVerbasSql->qtdrubr;
            $oDetVerbasItems->vrrubr = $oVerbasSql->vrrubr;
            $oDetVerbasItems->indapurir = $oVerbasSql->indapurir;
            $oVerbasResc->dmdev[array_search($hashDmDev, $aHashDmDev)]->infoperapur->ideestablot[array_search($sHashIdeEstabLotItens, $aHashIdeEstabLotItens)]->detverbas[] = $oDetVerbasItems;
            
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
     * com base na admissao e some esses dias a rescisao
     * @return integer
     */
    private function getDtProjetadaAviso($recis,$admiss) {
        $oDataRecis = new \DateTime($recis);
        $oDataAdmiss = new \DateTime($admiss);
        $oAnosAviso = $oDataRecis->diff($oDataAdmiss);
        $quantAviso = 0;
        if ($oAnosAviso->d > 0 || $oAnosAviso->m > 0) {
            $quantAviso = $oAnosAviso->y*3+30;
        } else {
            $quantAviso = $oAnosAviso->y*3+30-3;
        }
        $iDiasAviso = ($quantAviso < 90 ? $quantAviso : 90);
        $oDataRecis->add(new \DateInterval("P{$iDiasAviso}D"));
        return $oDataRecis->format("Y-m-d");
    }
}
