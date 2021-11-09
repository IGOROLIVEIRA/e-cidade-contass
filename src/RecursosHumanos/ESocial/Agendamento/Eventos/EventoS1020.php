<?php 

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1020 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1020 extends EventoBase
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
		$oDadosAPI                            = new \stdClass;
        $oDadosAPI->evtTabLotacao             = new \stdClass;
        $oDadosAPI->evtTabLotacao->sequencial = 1;
        $oDadosAPI->evtTabLotacao->codLotacao = $this->dados->ideLotacao->codLotacao;
        $oDadosAPI->evtTabLotacao->iniValid   = $this->dados->ideLotacao->iniValid;
        if (!empty($oDado->ideLotacao->fimValid)) {
            $oDadosAPI->evtTabLotacao->fimvalid = $oDado->ideLotacao->fimValid;
        }

        $oDadosAPI->evtTabLotacao->modo               = "INC";
        $oDadosAPI->evtTabLotacao->dadosLotacao       = $this->dados->dadosLotacao;
        $oDadosAPI->evtTabLotacao->dadosLotacao->fpas = $this->dados->fpasLotacao->fpas;
        $oDadosAPI->evtTabLotacao->dadosLotacao->tpLotacao = str_pad($this->dados->dadosLotacao->tpLotacao,2,"0",STR_PAD_LEFT);
        $oDadosAPI->evtTabLotacao->dadosLotacao->tpInsc = empty($this->dados->dadosLotacao->tpInsc) ? null : $this->dados->dadosLotacao->tpInsc;
        $oDadosAPI->evtTabLotacao->dadosLotacao->nrInsc = empty($this->dados->dadosLotacao->nrInsc) ? null : $this->dados->dadosLotacao->nrInsc;
        $oDadosAPI->evtTabLotacao->dadosLotacao->codTercs = str_pad($this->dados->fpasLotacao->codTercs,4,"0",STR_PAD_LEFT);
        $oDadosAPI->evtTabLotacao->dadosLotacao->codTercsSusp = empty($this->dados->fpasLotacao->codTercsSusp) ? null : $this->dados->fpasLotacao->codTercsSusp;

        return $oDadosAPI;
	}

}