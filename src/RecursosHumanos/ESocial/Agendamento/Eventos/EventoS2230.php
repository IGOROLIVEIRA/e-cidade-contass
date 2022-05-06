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

            $oDadosAPI                                = new \stdClass;
            $oDadosAPI->evtAfastTemp                      = new \stdClass;
            $oDadosAPI->evtAfastTemp->sequencial          = $iSequencial;
            $oDadosAPI->evtAfastTemp->modo                = $this->modo;
            $oDadosAPI->evtAfastTemp->indRetif            = 1;
            $oDadosAPI->evtAfastTemp->nrRecibo            = null;
            $oDadosAPI->evtAfastTemp->idevinculo->cpftrab                     = $oDados->ideVinculo->cpfTrab;
            $oDadosAPI->evtAfastTemp->idevinculo->matricula                   = $oDados->ideVinculo->matricula;
            $oDadosAPI->evtAfastTemp->idevinculo->codcateg                    = $oDados->ideVinculo->codCateg;
            $oDadosAPI->evtAfastTemp->iniafastamento->dtiniafast              = $oDados->perAquis->dtInicio;
            $oDadosAPI->evtAfastTemp->iniafastamento->codmotafast             = $oDados->iniAfastamento->codMotAfast;
            $oDadosAPI->evtAfastTemp->iniafastamento->peraquis->dtinicio      = $oDados->perAquis->dtInicio;
            $oDadosAPI->evtAfastTemp->iniafastamento->peraquis->dtfim         = $oDados->perAquis->dtFim;
            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
        // echo '<pre>';
        // print_r($aDadosAPI);
        // exit;
        return $aDadosAPI;
    }
}
