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

		if (empty($this->dados->dadosEstab->aliqGilrat->procAdmJudRat->tpProc)) {
            unset($this->dados->dadosEstab->aliqGilrat->procAdmJudRat);
        }
        if (empty($this->dados->dadosEstab->aliqGilrat->procAdmJudFap->tpProc)) {
            unset($this->dados->dadosEstab->aliqGilrat->procAdmJudFap);
        }

        if ($this->dados->dadosEstab->infoTrab->infoApr->contApr == 0) {
            $this->dados->dadosEstab->infoTrab->infoApr->nrProcJud = null;
            unset($this->dados->dadosEstab->infoTrab->infoApr->contEntEd);
            unset($this->dados->dadosEstab->infoTrab->infoApr->infoEntEduc);
        }

        if ($this->dados->dadosEstab->infoTrab->infoPCD->contPCD == 0) {
            $this->dados->dadosEstab->infoTrab->infoPCD->nrProcJud = null;
        }

        $oDadosAPI                          = new \stdClass;
        $oDadosAPI->evtTabEstab             = new \stdClass;
        $oDadosAPI->evtTabEstab->sequencial = 1;
        $oDadosAPI->evtTabEstab->tpInsc     = $this->dados->ideEstab->tpInsc;
        $oDadosAPI->evtTabEstab->nrInsc     = $this->dados->ideEstab->nrInsc;
        $oDadosAPI->evtTabEstab->iniValid   = $this->dados->ideEstab->iniValid;
        if (!empty($oDado->ideEstab->fimValid)) {
            $oDadosAPI->evtTabEstab->fimvalid = $oDado->ideEstab->fimValid;
        }
        $oDadosAPI->evtTabEstab->modo       = "INC";
        $oDadosAPI->evtTabEstab->dadosEstab = $this->dados->dadosEstab;

        return $oDadosAPI;
	}

}