<?php 

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1050 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1050 extends EventoBase
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
            if (!isset($oDado->ideHorContratual->iniValid)) {
                continue;
            }
            $oDadosAPI                           = new \stdClass;
            $oDadosAPI->evtTabHorTur             = new \stdClass;
            $oDadosAPI->evtTabHorTur->sequencial = $iSequencial;
            $oDadosAPI->evtTabHorTur->codHorContrat  = $oDado->ideHorContratual->codHorContrat;
            $oDadosAPI->evtTabHorTur->inivalid   = $oDado->ideHorContratual->iniValid;
            if (!empty($oDado->ideHorContratual->fimValid)) {
                $oDadosAPI->evtTabHorTur->fimvalid = $oDado->ideHorContratual->fimValid;
            }
            $oDadosAPI->evtTabHorTur->modo       = 'INC';
            $oDadosAPI->evtTabHorTur->dadosHorContratual = $oDado->dadosHorContratual;
            if ($oDado->horarioIntervalo->tpInterv == 2) {
                unset($oDado->horarioIntervalo->iniInterv);
                unset($oDado->horarioIntervalo->termInterv);
            }
            if (!empty($oDado->horarioIntervalo->durInterv)) {
                $oDadosAPI->evtTabHorTur->dadosHorContratual->horarioIntervalo[0] = $oDado->horarioIntervalo;
            } else {
                $oDadosAPI->evtTabHorTur->dadosHorContratual->horarioIntervalo = null;
            }

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }

        return $aDadosAPI;
	}

}