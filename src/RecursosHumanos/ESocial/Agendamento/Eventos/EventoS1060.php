<?php 

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1060 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1060 extends EventoBase
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
            if (!isset($oDado->ideAmbiente->iniValid)) {
                continue;
            }
            $oDadosAPI                             = new \stdClass;
            $oDadosAPI->evtTabAmbiente             = new \stdClass;
            $oDadosAPI->evtTabAmbiente->sequencial = $iSequencial;
            $oDadosAPI->evtTabAmbiente->codAmb     = $oDado->ideAmbiente->codAmb;
            $oDadosAPI->evtTabAmbiente->inivalid   = $oDado->ideAmbiente->iniValid;
            if (!empty($oDado->ideAmbiente->fimValid)) {
                $oDadosAPI->evtTabAmbiente->fimvalid = $oDado->ideAmbiente->fimValid;
            }
            $oDadosAPI->evtTabAmbiente->modo       = 'INC';
            $oDadosAPI->evtTabAmbiente->dadosAmbiente = $oDado->dadosAmbiente;

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }

        return $aDadosAPI;
	}

}