<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1010 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1010Individual extends EventoBase
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
            $oDadosAPI->evtTabRubrica->ideTabRubr = $oDado->ideTabRubr;
            $oDadosAPI->evtTabRubrica->inivalid   = $this->iniValid;
            if (!empty($this->fimValid)) {
                $oDadosAPI->evtTabRubrica->fimvalid = $this->fimValid;
            }
            $oDadosAPI->evtTabRubrica->modo         = $this->modo;
            // var_dump($oDado);
            // exit;

            $oDadosAPI->evtTabRubrica->dadosRubrica = $oDado->dadosRubrica;

            if (!empty($oDado->codinccp)) {
                $oDadosAPI->evtTabRubrica->ideProcessoCP = $oDado->codinccp;
            }
            if (!empty($oDado->codincirrf)) {
                $oDadosAPI->evtTabRubrica->ideProcessoIRRF = $oDado->codincirrf;
            }
            if (!empty($oDado->codincfgts)) {
                $oDadosAPI->evtTabRubrica->ideProcessoFGTS = $oDado->codincfgts;
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
