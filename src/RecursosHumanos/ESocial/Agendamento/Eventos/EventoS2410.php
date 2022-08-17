<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S2410 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Marcelo Hernane
 */
class EventoS2410 extends EventoBase
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
        // echo '<pre>';
        // print_r($this->dados);
        // exit;

        $iSequencial = 1;
        foreach ($this->dados as $oDados) {
            $oDadosAPI                                   = new \stdClass;
            $oDadosAPI->evtCdBenIn                      = new \stdClass;
            $oDadosAPI->evtCdBenIn->sequencial          = $iSequencial;
            $oDadosAPI->evtCdBenIn->modo                = $this->modo;
            $oDadosAPI->evtCdBenIn->indRetif            = 1;
            $oDadosAPI->evtCdBenIn->nrRecibo            = null;

            $oDadosAPI->evtCdBenIn->cpfBenef            = $oDados->cpfbenef;
            $oDadosAPI->evtCdBenIn->matricula           = $oDados->matricula;
            $oDadosAPI->evtCdBenIn->cnpjOrigem          = $oDados->cnpjorigem;
            $oDadosAPI->evtCdBenIn->cadIni              = $oDados->cadini;
            $oDadosAPI->evtCdBenIn->indSitBenef         = $oDados->indsitbenef;
            $oDadosAPI->evtCdBenIn->nrBeneficio         = $oDados->nrbeneficio;
            $oDadosAPI->evtCdBenIn->tpBeneficio         = $oDados->tpbeneficio;
            $oDadosAPI->evtCdBenIn->tpPlanRP            = $oDados->tpplanrp;
            $oDadosAPI->evtCdBenIn->dsc                 = $oDados->dsc;
            $oDadosAPI->evtCdBenIn->indDecJud           = $oDados->inddecjud;

            $oDadosAPI->evtCdBenIn->infopenmorte->tpPenMorte  = $oDados->tppenmorte;
            if (!empty($oDados->cpfinst))
                $oDadosAPI->evtCdBenIn->infopenmorte->instpenmorte->cpfInst     = $oDados->cpfinst;
            if (!empty($oDados->dtinst))
                $oDadosAPI->evtCdBenIn->infopenmorte->instpenmorte->dtInst      = $oDados->dtinst;

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
        // echo '<pre>';
        // print_r($aDadosAPI);
        // exit;
        return $aDadosAPI;
    }
}
