<?php 

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1030 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1030 extends EventoBase
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
            if (!isset($oDado->ideCargo->iniValid)) {
                continue;
            }
            $oDadosAPI                          = new \stdClass;
            $oDadosAPI->evtTabCargo             = new \stdClass;
            $oDadosAPI->evtTabCargo->sequencial = $iSequencial;
            $oDadosAPI->evtTabCargo->codCargo   = $oDado->ideCargo->codCargo;
            $oDadosAPI->evtTabCargo->inivalid   = $oDado->ideCargo->iniValid;
            if (!empty($oDado->ideCargo->fimValid)) {
                $oDadosAPI->evtTabCargo->fimvalid = $oDado->ideCargo->fimValid;
            }
            $oDadosAPI->evtTabCargo->modo       = 'INC';
            $oDadosAPI->evtTabCargo->dadosCargo = $oDado->dadosCargo;
            if (!empty($oDado->cargoPublico)) {
                $oDadosAPI->evtTabCargo->cargoPublico = $oDado->cargoPublico;
                $oDadosAPI->evtTabCargo->cargoPublico->leiCargo = $oDado->leiCargo;
            }
            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }

        return $aDadosAPI;
	}

}