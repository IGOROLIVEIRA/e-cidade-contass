<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1010 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1010 extends EventoBase
{

    /**
     *
     * @param \stdClass $dados
     */
    function __construct($dados)
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

        foreach ($this->dados as $oDado) {

            if (!isset($oDado->dadosRubrica->natRubr)) {
                continue;
            }
            $oDadosAPI                            = new \stdClass;
            $oDadosAPI->evtTabRubrica             = new \stdClass;
            $oDadosAPI->evtTabRubrica->sequencial = $iSequencial;
            $oDadosAPI->evtTabRubrica->codRubr    = $oDado->ideRubrica->codRubr;
            $oDadosAPI->evtTabRubrica->ideTabRubr = $oDado->ideRubrica->ideTabRubr;
            $oDadosAPI->evtTabRubrica->inivalid   = $this->iniValid;
            if (!empty($this->fimValid)) {
                $oDadosAPI->evtTabRubrica->fimvalid = $this->fimValid;
            }
            $oDadosAPI->evtTabRubrica->modo         = $this->modo;
            // var_dump($oDado);
            // exit;

            $oDadosAPI->evtTabRubrica->dadosRubrica = $oDado->dadosRubrica;

            if (!empty($oDado->ideProcessoCP->nrProc)) {
                $oDadosAPI->evtTabRubrica->ideProcessoCP = $oDado->ideProcessoCP;
            }
            if (!empty($oDado->ideProcessoIRRF->nrProc)) {
                $oDadosAPI->evtTabRubrica->ideProcessoIRRF = $oDado->ideProcessoIRRF;
            }
            if (!empty($oDado->ideProcessoFGTS->nrProc)) {
                $oDadosAPI->evtTabRubrica->ideProcessoFGTS = $oDado->ideProcessoFGTS;
            }
            if (!empty($oDado->ideProcessoSIND->nrProc)) {
                $oDadosAPI->evtTabRubrica->ideProcessoSIND = $oDado->ideProcessoSIND;
            }
            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }

        return $aDadosAPI;
    }
}
