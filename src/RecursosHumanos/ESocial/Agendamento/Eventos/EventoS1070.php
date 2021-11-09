<?php 

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1070 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1070 extends EventoBase
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
            if (!isset($oDado->ideProcesso->iniValid)) {
                continue;
            }
            $oDadosAPI                             = new \stdClass;
            $oDadosAPI->evtTabProcesso             = new \stdClass;
            $oDadosAPI->evtTabProcesso->sequencial = $iSequencial;
            $oDadosAPI->evtTabProcesso->tpProc     = $oDado->ideProcesso->tpProc;
            $oDadosAPI->evtTabProcesso->nrProc     = $oDado->ideProcesso->nrProc;
            $oDadosAPI->evtTabProcesso->inivalid   = $oDado->ideProcesso->iniValid;
            if (!empty($oDado->ideProcesso->fimValid)) {
                $oDadosAPI->evtTabProcesso->fimvalid = $oDado->ideProcesso->fimValid;
            }
            $oDadosAPI->evtTabProcesso->modo      = 'INC';
            $oDadosAPI->evtTabProcesso->dadosProc = $oDado->dadosProc;

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }

        return $aDadosAPI;
	}

}