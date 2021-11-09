<?php 

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S2200 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS2200 extends EventoBase
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

        foreach ($this->dados as $oDados) {

            if (!empty($oDados->RIC) && empty($oDados->RIC->dtExped)) {
                $oDados->RIC->dtExped = null;
            }

            if (!empty($oDados->RG) && empty($oDados->RG->dtExped)) {
                $oDados->RG->dtExped = null;
            }

            if (!empty($oDados->RNE) && empty($oDados->RNE->dtExped)) {
                $oDados->RNE->dtExped = null;
            }

            if (!empty($oDados->OC) && empty($oDados->OC->dtExped)) {
                $oDados->OC->dtExped = null;
            }
            if (!empty($oDados->OC) && empty($oDados->OC->dtValid)) {
                $oDados->OC->dtValid = null;
            }

            if (!empty($oDados->CNH->nrRegCnh) && empty($oDados->CNH->dtExped)) {
                $oDados->CNH->dtExped = null;
            }
            if (!empty($oDados->CNH->nrRegCnh) && empty($oDados->CNH->dtPriHab)) {
                $oDados->CNH->dtPriHab = null;
            }

            if (!empty($oDados->brasil) && empty($oDados->brasil->complemento)) {
                $oDados->brasil->complemento = null;
            }
            if (!empty($oDados->brasil) && empty($oDados->brasil->bairro)) {
                $oDados->brasil->bairro = null;
            }
            if (!empty($oDados->brasil) && empty($oDados->brasil->tpLograd)) {
                $oDados->brasil->tpLograd = null;
            }

            if (!empty($oDados->exterior)) {
                if (empty($oDados->exterior->complemento)) {
                    $oDados->exterior->complemento = null;
                }
                if (empty($oDados->exterior->bairro)) {
                    $oDados->exterior->bairro = null;
                }
                if (empty($oDados->exterior->codPostal)) {
                    $oDados->exterior->codPostal = null;
                }
            }

            if (!empty($oDados->trabEstrangeiro) && empty($oDados->trabEstrangeiro->dtChegada)) {
                $oDados->trabEstrangeiro->dtChegada = null;
            }

            if (!empty($oDados->infoDeficiencia) && empty($oDados->infoDeficiencia->observacao)) {
                unset($oDados->infoDeficiencia->observacao);
            }

            if (!empty($oDados->contato)) {
                if (empty($oDados->contato->fonePrinc)) {
                    $oDados->contato->fonePrinc = null;
                }
                if (empty($oDados->contato->foneAlternat)) {
                    $oDados->contato->foneAlternat = null;
                }
                if (empty($oDados->contato->emailPrinc)) {
                    $oDados->contato->emailPrinc = null;
                }
                if (empty($oDados->contato->emailAlternat)) {
                    $oDados->contato->emailAlternat = null;
                }
            }

            if (!empty($oDados->localTrabGeral) && empty($oDados->localTrabGeral->descComp)) {
                $oDados->localTrabGeral->descComp = null;
            }

            if (!empty($oDados->sucessaoVinc)) {
                if (empty($oDados->sucessaoVinc->matricAnt)) {
                    $oDados->sucessaoVinc->matricAnt = null;
                }
                if (empty($oDados->sucessaoVinc->observacao)) {
                    $oDados->sucessaoVinc->observacao = null;
                }
            }

            if (!empty($oDados->transfDom) && empty($oDados->transfDom->matricAnt)) {
                $oDados->transfDom->matricAnt = null;
            }

            $oDadosAPI                                   = new \stdClass;
            $oDadosAPI->evtAdmissao                      = new \stdClass;
            $oDadosAPI->evtAdmissao->sequencial          = 1;
            $oDadosAPI->evtAdmissao->indRetif            = 1;
            $oDadosAPI->evtAdmissao->nrRecibo            = null;
            $oDadosAPI->evtAdmissao->cpfTrab             = $oDados->trabalhador->cpfTrab;
            $oDadosAPI->evtAdmissao->nisTrab             = $oDados->trabalhador->nisTrab;
            $oDadosAPI->evtAdmissao->nmTrab              = $oDados->trabalhador->nmTrab;
            $oDadosAPI->evtAdmissao->sexo                = $oDados->trabalhador->sexo;
            $oDadosAPI->evtAdmissao->racaCor             = $oDados->trabalhador->racaCor;
            $oDadosAPI->evtAdmissao->estCiv              = empty($oDados->trabalhador->estCiv) ? null : $oDados->trabalhador->estCiv;
            $oDadosAPI->evtAdmissao->grauInstr           = $oDados->trabalhador->grauInstr;
            $oDadosAPI->evtAdmissao->indPriEmpr          = $oDados->trabalhador->indPriEmpr;
            $oDadosAPI->evtAdmissao->nmSoc               = empty($oDados->trabalhador->nmSoc) ? null : $oDados->trabalhador->nmSoc;

            $oDadosAPI->evtAdmissao->dtNascto            = $oDados->nascimento->dtNascto;
            $oDadosAPI->evtAdmissao->codMunic            = empty($oDados->nascimento->codMunic) ? null : $oDados->nascimento->codMunic;
            $oDadosAPI->evtAdmissao->uf                  = empty($oDados->nascimento->uf) ? null : $oDados->nascimento->uf;
            $oDadosAPI->evtAdmissao->paisNascto          = $oDados->nascimento->paisNascto;
            $oDadosAPI->evtAdmissao->paisNac             = $oDados->nascimento->paisNac;
            $oDadosAPI->evtAdmissao->nmMae               = empty($oDados->nascimento->nmMae) ? null : $oDados->nascimento->nmMae;
            $oDadosAPI->evtAdmissao->nmPai               = empty($oDados->nascimento->nmPai) ? null : $oDados->nascimento->nmPai;

            $oDadosAPI->evtAdmissao->CTPS                = empty($oDados->CTPS) ? null : $oDados->CTPS;

            $oDadosAPI->evtAdmissao->RIC                 = empty($oDados->RIC) ? null : $oDados->RIC;

            $oDadosAPI->evtAdmissao->OC                 = empty($oDados->OC) ? null : $oDados->OC;

            $oDadosAPI->evtAdmissao->CNH                 = empty($oDados->CNH->nrRegCnh) ? null : $oDados->CNH;

            $oDadosAPI->evtAdmissao->endereco->brasil    = empty($oDados->brasil) ? null : $oDados->brasil;

            $oDadosAPI->evtAdmissao->endereco->exterior  = empty($oDados->exterior) ? null : $oDados->exterior;

            if (!empty($oDados->trabEstrangeiro)) {
                $oDadosAPI->evtAdmissao->trabEstrangeiro = $oDados->trabEstrangeiro;
            }

            $oDadosAPI->evtAdmissao->deficiencia = empty($oDados->infoDeficiencia) ? null : $oDados->infoDeficiencia;

            $oDadosAPI->evtAdmissao->dependente = $this->buscarDependentes($oDados->vinculo->matricula);

            $oDadosAPI->evtAdmissao->aposentadoria = empty($oDados->aposentadoria) ? null : $oDados->aposentadoria;

            $oDadosAPI->evtAdmissao->contato = empty($oDados->contato) ? null : $oDados->contato;

            $oDadosAPI->evtAdmissao->vinculo = $oDados->vinculo;
            $oDadosAPI->evtAdmissao->vinculo->nrRecInfPrelim = null;

            if (!empty($oDados->infoCeletista)) {
                $oDadosAPI->evtAdmissao->vinculo->infoCeletista = $oDados->infoCeletista;
                $oDadosAPI->evtAdmissao->vinculo->infoCeletista->opcFGTS = $oDados->FGTS->opcFGTS;
                $oDadosAPI->evtAdmissao->vinculo->infoCeletista->dtOpcFGTS = empty($oDados->FGTS->dtOpcFGTS) ? null : $oDados->FGTS->dtOpcFGT;
                if (!empty($oDados->trabTemporario)) {

                    $oDadosAPI->evtAdmissao->vinculo->infoCeletista->trabTemporario = $oDados->trabTemporario;
                    $oDadosAPI->evtAdmissao->vinculo->infoCeletista->trabTemporario->ideTomadorServ = $oDados->ideTomadorServ;
                    $oDadosAPI->evtAdmissao->vinculo->infoCeletista->trabTemporario->ideTomadorServ->ideEstabVinc = $oDados->ideEstabVinc;
                    $oDadosAPI->evtAdmissao->vinculo->infoCeletista->trabTemporario->ideTrabSubstituido = $oDados->ideTrabSubstituido;
                }
                $oDadosAPI->evtAdmissao->vinculo->infoCeletista->aprend = empty($oDados->aprend) ? null : $oDados->aprend;
            } else {
                $oDadosAPI->evtAdmissao->vinculo->infoCeletista = null;
            }

            if (!empty($oDados->infoEstatutario->indProvim) || $oDados->infoEstatutario->indProvim != 0) {

                $oDadosAPI->evtAdmissao->vinculo->infoEstatutario = $oDados->infoEstatutario;
                $oDadosAPI->evtAdmissao->vinculo->infoEstatutario->infoDecJud = empty($oDados->infoDecJud) ? null : $oDados->infoDecJud;

            }

            if (!empty($oDados->infoContrato)) {

                $oDadosAPI->evtAdmissao->vinculo->infoContrato = $oDados->infoContrato;
                
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->codCargo = empty($oDados->infoContrato->codCargo) ? null : $oDados->codCargo;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->codFuncao = empty($oDados->infoContrato->codFuncao) ? null : $oDados->infoContrato->codFuncao;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->codCarreira = empty($oDados->infoContrato->codCarreira) ? null : $oDados->infoContrato->codCarreira;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->dtIngrCarr = empty($oDados->infoContrato->dtIngrCarr) ? null : $oDados->infoContrato->dtIngrCarr;

                $oDadosAPI->evtAdmissao->vinculo->infoContrato->vrSalFx = $oDados->remuneracao->vrSalFx;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->undSalFixo = $oDados->remuneracao->undSalFixo;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->dscSalVar = empty($oDados->remuneracao->dscSalVar) ? null : $oDados->remuneracao->dscSalVar;

                $oDadosAPI->evtAdmissao->vinculo->infoContrato->tpContr = $oDados->duracao->tpContr;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->dtTerm = empty($oDados->duracao->dtTerm) ? null : $oDados->duracao->dtTerm;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->clauAssec = empty($oDados->duracao->clauAssec) ? null : $oDados->duracao->clauAssec;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->objDet = empty($oDados->duracao->objDet) ? null : $oDados->duracao->objDet;

                $oDadosAPI->evtAdmissao->vinculo->infoContrato->localTrabGeral = empty($oDados->localTrabGeral) ? null : $oDados->localTrabGeral;

                $oDadosAPI->evtAdmissao->vinculo->infoContrato->localTrabDom = empty($oDados->localTrabDom) ? null : $oDados->localTrabDom;

                if (empty($oDados->horContratual)) {
                    
                    $oDadosAPI->evtAdmissao->vinculo->infoContrato->horContratual = $oDados->horContratual;
                    $oDadosAPI->evtAdmissao->vinculo->infoContrato->horContratual->horario = $this->buscarHorarios($oDados->vinculo->matricula);

                } else {
                    $oDadosAPI->evtAdmissao->vinculo->infoContrato->horContratual = null;
                }

                if (!empty($oDados->filiacaoSindical->cnpjSindTrab)) {
                    $oDadosAPI->evtAdmissao->vinculo->infoContrato->filiacaoSindical[0]->cnpjsindtrab = $oDados->filiacaoSindical->cnpjSindTrab;
                }

                
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->alvaraJudicial = empty($oDados->alvaraJudicial) ? null : $oDados->alvaraJudicial;

                $oDadosAPI->evtAdmissao->vinculo->infoContrato->observacoes = empty($oDados->observacoes) ? null : array($oDados->observacoes);

            }

            $oDadosAPI->evtAdmissao->vinculo->sucessaoVinc = empty($oDados->sucessaoVinc) ? null : $oDados->sucessaoVinc;

            $oDadosAPI->evtAdmissao->vinculo->transfDom = empty($oDados->transfDom) ? null : $oDados->transfDom;

            $oDadosAPI->evtAdmissao->vinculo->mudancaCPF = empty($oDados->mudancaCPF) ? null : $oDados->mudancaCPF;

            $oDadosAPI->evtAdmissao->vinculo->afastamento = empty($oDados->afastamento) ? null : $oDados->afastamento;

            $oDadosAPI->evtAdmissao->vinculo->desligamento = empty($oDados->desligamento) ? null : $oDados->desligamento;

            $aDadosAPI[] = $oDadosAPI;

        }

        return $aDadosAPI;
	}

    /**
     * Retorna dados dos dependentes no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarDependentes($matricula) {

        $oDaorhdepend = \db_utils::getDao("rhdepend");
        $sqlDependentes = $oDaorhdepend->sql_query_file(null,"*","rh31_codigo","rh31_regist = {$matricula}");
        $rsDependentes = db_query($sqlDependentes);
        if (pg_num_rows($rsDependentes) == 0) {
            return null;
        }
        $aDependentes = array();
        for ($iCont=0; $iCont < pg_num_rows($rsDependentes); $iCont++) {
            $oDependentes = \db_utils::fieldsMemory($rsDependentes, $iCont);
            $oDependFormatado = new \stdClass;
            switch ($oDependentes->rh31_gparen) {
                case 'C':
                    $oDependFormatado->tpDep = '01';
                    break;
                case 'F':
                    $oDependFormatado->tpDep = '03';
                    break;
                case 'P':
                case 'M':
                case 'A':
                    $oDependFormatado->tpDep = '09';
                    break;
                
                default:
                    $oDependFormatado->tpDep = '99';
                    break;
            }
            $oDependFormatado->nmDep = $oDependentes->rh31_nome;
            $oDependFormatado->dtNascto = $oDependentes->rh31_dtnasc;
            $oDependFormatado->cpfDep = empty($oDependentes->rh31_cpf) ? null : $oDependentes->rh31_cpf;
            $oDependFormatado->depIRRF = ($oDependentes->rh31_depirrf == "0" ? "N" : "S");
            $oDependFormatado->depSF = ($oDependentes->rh31_depend == "N" ? "N" : "S");
            $oDependFormatado->incTrab = ($oDependentes->rh31_depirrf == "N" ? "N" : "S");

            $aDependentes[] = $oDependFormatado;
        }
        return $aDependentes;
    }


    /**
     * Retorna dados dos horario no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarHorarios($matricula) {

        $aHorarios = array();
        $oDaoJornada = \db_utils::getDao("jornada");
        $rsHorarios = db_query($oDaoJornada->sqlQueryHorario($matricula));
        if (pg_num_rows($rsHorarios) == 0) {
            return null;
        }
        for ($iCont=0; $iCont < pg_num_rows($rsHorarios); $iCont++) { 
            $oHorarioFormatado = new \stdClass;
            $oHorario = \db_utils::fieldsMemory($rsHorarios, $iCont);
            $oHorarioFormatado->codHorContrat = $oHorario->rh188_sequencial;
            $oHorarioFormatado->dia = date('w', strtotime($oHorario->diatrabalho));
            $aHorarios[] = $oHorarioFormatado;
        }
        return $aHorarios;

    }

        /**
     * Retorna dados dos afastamentos no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarAfastamentos($matricula) {

          
        $acodMotAfastEsocial = array('O1' => '01',
                                     'O2' => '01',
                                     'O3' => '01',
                                     'P1' => '03',
                                     'P2' => '01',
                                     'Q1' => '17',
                                     'Q2' => '35',
                                     'Q3' => '19',
                                     'Q4' => '20',
                                     'Q5' => '20',
                                     'Q6' => '20',
                                     'R' => '29',
                                     'U3' => '06',
                                     'W' => '24',
                                     'X' => '21');

        $acodMotAfastEcidade = array('O1','O2','O3','P1','P2','Q1','Q2','Q3','Q4','Q5','Q6','R','U3','W','X'); 
        $aAfastamentos = array();
        $oDaoAfasta = \db_utils::getDao("afasta");
        $rsAfastamentos = db_query($oDaoAfasta->sql_query_file(null,"*",null,"r45_regist = {$matricula} AND r45_codafa IN ('".implode("','",$acodMotAfastEcidade)."')"));
        if (pg_num_rows($rsAfastamentos) == 0) {
            return null;
        }
        for ($iCont=0; $iCont < pg_num_rows($rsAfastamentos); $iCont++) { 
            $oAfastamentoFormatado = new \stdClass;
            $oAfastamento = \db_utils::fieldsMemory($rsAfastamentos, $iCont);
            $oAfastamentoFormatado->dtIniAfast = $oAfastamento->r45_dtafas;
            $oAfastamentoFormatado->codMotAfast = $acodMotAfastEsocial[$oAfastamento->r45_codafa];
            $aAfastamentos[] = $oAfastamentoFormatado;
        }
        return $aAfastamentos;

    }

}