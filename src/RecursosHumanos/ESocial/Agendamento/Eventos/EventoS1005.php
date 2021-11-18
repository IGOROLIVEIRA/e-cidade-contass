<?php 

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1005 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1005 extends EventoBase
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

		if (empty($this->dados[0]->dadosEstab->aliqGilrat->procAdmJudRat->tpProc)) {
            unset($this->dados[0]->dadosEstab->aliqGilrat->procAdmJudRat);
        }
        if (empty($this->dados[0]->dadosEstab->aliqGilrat->procAdmJudFap->tpProc)) {
            unset($this->dados[0]->dadosEstab->aliqGilrat->procAdmJudFap);
        }

        /*if ($this->dados[0]->dadosEstab->infoTrab->infoApr->contApr == 0) {
            $this->dados[0]->dadosEstab->infoTrab->infoApr->nrProcJud = null;
            unset($this->dados[0]->dadosEstab->infoTrab->infoApr->infoEntEduc);
        }*/


        $oDadosAPI                          = new \stdClass;
        $oDadosAPI->evtTabEstab             = new \stdClass;
        $oDadosAPI->evtTabEstab->sequencial = 1;
        $oDadosAPI->evtTabEstab->tpInsc     = $this->tpInsc;
        $oDadosAPI->evtTabEstab->nrInsc     = $this->nrInsc;
        $oDadosAPI->evtTabEstab->iniValid   = $this->iniValid;
        if (!empty($this->fimValid)) {
            $oDadosAPI->evtTabEstab->fimvalid = $this->fimValid;
        }
        $oDadosAPI->evtTabEstab->modo       = "INC";
        $oDadosAPI->evtTabEstab->dadosEstab = $this->dados[0]->dadosEstab;

        return $oDadosAPI;
	}

}