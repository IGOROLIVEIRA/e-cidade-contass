<?php 

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1040 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1040 extends EventoBase
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
            if (!isset($oDado->ideFuncao->iniValid)) {
                continue;
            }
            $oDadosAPI                           = new \stdClass;
            $oDadosAPI->evtTabFuncao             = new \stdClass;
            $oDadosAPI->evtTabFuncao->sequencial = $iSequencial;
            $oDadosAPI->evtTabFuncao->codFuncao  = $oDado->ideFuncao->codFuncao;
            $oDadosAPI->evtTabFuncao->inivalid   = $oDado->ideFuncao->iniValid;
            if (!empty($oDado->ideFuncao->fimValid)) {
                $oDadosAPI->evtTabFuncao->fimvalid = $oDado->ideFuncao->fimValid;
            }
            $oDadosAPI->evtTabFuncao->modo       = 'INC';
            $oDadosAPI->evtTabFuncao->dadosFuncao = $oDado->dadosFuncao;

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }

        return $aDadosAPI;
	}

}