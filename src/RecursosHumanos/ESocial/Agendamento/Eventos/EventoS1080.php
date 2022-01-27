<?php 

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1080 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1080 extends EventoBase
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
            if (!isset($oDado->ideOperPortuario->iniValid)) {
                continue;
            }
            $oDadosAPI                             = new \stdClass;
            $oDadosAPI->evtTabOperPort             = new \stdClass;
            $oDadosAPI->evtTabOperPort->sequencial = $iSequencial;
            $oDadosAPI->evtTabOperPort->cnpjOpPortuario = $oDado->ideOperPortuario->cnpjOpPortuario;
            $oDadosAPI->evtTabOperPort->inivalid = $oDado->ideOperPortuario->iniValid;
            if (!empty($oDado->ideOperPortuario->fimValid)) {
                $oDadosAPI->evtTabOperPort->fimvalid = $oDado->ideOperPortuario->fimValid;
            }
            $oDadosAPI->evtTabOperPort->modo = 'INC';
            $oDadosAPI->evtTabOperPort->dadosOperPortuario = $oDado->dadosOperPortuario;

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }

        return $aDadosAPI;
	}

}