<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S2200 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS2230Individual extends EventoBase
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
            //$oDadosAPI->evtAfastTemp->idevinculo->codcateg                  = $oDados->ideVinculo->codCateg;
            
            if($oDados->dtiniafast != null){
                $oDadosAPI->evtAfastTemp->iniafastamento->dtiniafast          = $oDados->dtiniafast;
                $oDadosAPI->evtAfastTemp->iniafastamento->codmotafast         = $oDados->codmotafast;
                if(!empty($oDados->dtinicio)){
                    $oDadosAPI->evtAfastTemp->iniafastamento->peraquis->dtinicio  = $oDados->dtinicio;                
                }
                if(!empty($oDados->dtfim)){
                    $oDadosAPI->evtAfastTemp->iniafastamento->peraquis->dtfim = $oDados->dtfim;
                }
            }
            if(!empty($oDados->dttermafastferias)){
                $oDadosAPI->evtAfastTemp->fimafastamento->dttermafast = $oDados->dttermafastferias;
            }

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }

        return $aDadosAPI;
    }
}
