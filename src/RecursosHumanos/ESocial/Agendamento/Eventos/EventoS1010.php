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

            if (!isset($oDado->natrubr)) {
                continue;
            }
            $oDadosAPI                            = new \stdClass;
            $oDadosAPI->evtTabRubrica             = new \stdClass;
            $oDadosAPI->evtTabRubrica->sequencial = $iSequencial;
            $oDadosAPI->evtTabRubrica->codRubr    = $oDado->codrubr;
            $oDadosAPI->evtTabRubrica->ideTabRubr = 'TABRUB1';
            $oDadosAPI->evtTabRubrica->inivalid   = $this->iniValid;
            if (!empty($this->fimValid)) {
                $oDadosAPI->evtTabRubrica->fimvalid = $this->fimValid;
            }
            $oDadosAPI->evtTabRubrica->modo         = $this->modo;

            $oDadosAPI->evtTabRubrica->dadosRubrica->dscrubr = $oDado->dscrubr;
            $oDadosAPI->evtTabRubrica->dadosRubrica->natrubr = intval($oDado->natrubr);
            $oDadosAPI->evtTabRubrica->dadosRubrica->tprubr = $oDado->tprubr;
            if (!empty($oDado->codinccp)) {
                $oDadosAPI->evtTabRubrica->dadosRubrica->codinccp = $oDado->codinccp;
            }
            if (!empty($oDado->codincirrf)) {
                $oDadosAPI->evtTabRubrica->dadosRubrica->codincirrf = $oDado->codincirrf;
            }
            if (!empty($oDado->codincfgts)) {
                $oDadosAPI->evtTabRubrica->dadosRubrica->codincfgts = $oDado->codincfgts;
            }
            if (!empty($oDado->codinccprp)) {
                $oDadosAPI->evtTabRubrica->dadosRubrica->codinccprp = $oDado->codinccprp;
            }
            if (!empty($oDado->tetoremun)) {
                $oDadosAPI->evtTabRubrica->dadosRubrica->tetoremun = $oDado->tetoremun;
            }

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }

        return $aDadosAPI;
    }
}
