<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S2200 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS2230 extends EventoBase
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
            $oDadosAPI                                                        = new \stdClass;
            $oDadosAPI->evtAfastTemp                                          = new \stdClass;
            $oDadosAPI->evtAfastTemp->sequencial                              = $iSequencial;
            $oDadosAPI->evtAfastTemp->modo                                    = $this->modo;
            $oDadosAPI->evtAfastTemp->indRetif                                = 1;
            $oDadosAPI->evtAfastTemp->nrRecibo                                = null;
            $oDadosAPI->evtAfastTemp->idevinculo->cpftrab                     = $oDados->cpftrab;
            $oDadosAPI->evtAfastTemp->idevinculo->matricula                   = $oDados->matricula;

            if ($oDados->dtiniafast != null) {
                $oDadosAPI->evtAfastTemp->iniafastamento->dtiniafast          = $oDados->dtiniafast;
                $oDadosAPI->evtAfastTemp->iniafastamento->codmotafast         = $oDados->codmotafast;
                if ($oDados->codmotafast == "15" && $oDados->rh30_regime == 2) {
                    if (!empty($oDados->dtinicio)) {
                        $oDadosAPI->evtAfastTemp->iniafastamento->peraquis->dtinicio  = $oDados->dtinicio;
                    }
                    if (!empty($oDados->dtfim)) {
                        $oDadosAPI->evtAfastTemp->iniafastamento->peraquis->dtfim = $oDados->dtfim;
                    }
                }
            }
            if (!empty($oDados->dttermafast)) {
                $oDadosAPI->evtAfastTemp->fimafastamento->dttermafast = $oDados->dttermafast;
            }
            if (!empty($oDados->dttermafastferias)) {
                $oDadosAPI->evtAfastTemp->fimafastamento->dttermafast = $oDados->dttermafastferias;
            }
            // echo '<pre>';
            // var_dump($oDadosAPI);
            // exit;
            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }

        return $aDadosAPI;
    }
}
