<?php 

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1000 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1000 extends EventoBase
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

        if (empty($this->dados[0]->infoCadastro->indOpcCP)) {
            $this->dados[0]->infoCadastro->indOpcCP = null;
        }

        $oDadosAPI                                          = new \stdClass;
        $oDadosAPI->evtInfoEmpregador                       = new \stdClass;
        $oDadosAPI->evtInfoEmpregador->sequencial           = 1;
        $oDadosAPI->evtInfoEmpregador->modo                 = "INC";
        $oDadosAPI->evtInfoEmpregador->ideperiodo           = new \stdClass;
        $oDadosAPI->evtInfoEmpregador->ideperiodo->inivalid = $this->iniValid;
        $oDadosAPI->evtInfoEmpregador->infoCadastro         = $this->dados[0]->infoCadastro;
        $oDadosAPI->evtInfoEmpregador->dadosIsencao         = empty($this->dados[0]->dadosIsencao) ? null : $this->dados[0]->dadosIsencao;
        $oDadosAPI->evtInfoEmpregador->infoOrgInternacional = empty($this->dados[0]->infoOrgInternacional) ? null : $this->dados[0]->infoOrgInternacional;

        return $oDadosAPI;
	}

}