<?php 

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1035 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1035 extends EventoBase
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
            if (!isset($oDado->ideCarreira->iniValid)) {
                continue;
            }
            $oDadosAPI                             = new \stdClass;
            $oDadosAPI->evtTabCarreira             = new \stdClass;
            $oDadosAPI->evtTabCarreira->sequencial = $iSequencial;
            $oDadosAPI->evtTabCarreira->codCarreira   = $oDado->ideCarreira->codCarreira;
            $oDadosAPI->evtTabCarreira->inivalid   = $oDado->ideCarreira->iniValid;
            if (!empty($oDado->ideCarreira->fimValid)) {
                $oDadosAPI->evtTabCarreira->fimvalid = $oDado->ideCarreira->fimValid;
            }
            $oDadosAPI->evtTabCarreira->modo       = 'INC';
            $oDadosAPI->evtTabCarreira->dadosCarreira = $oDado->dadosCarreira;
            
            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }

        return $aDadosAPI;
	}

}