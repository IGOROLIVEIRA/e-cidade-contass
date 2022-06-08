<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S2306 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS2306 extends EventoBase
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
        foreach ($this->dados as $oDados) {

            if (!empty($oDados->brasil) && empty($oDados->brasil->complemento)) {
                $oDados->brasil->complemento = null;
            }
            if (!empty($oDados->brasil) && empty($oDados->brasil->bairro)) {
                $oDados->brasil->bairro = null;
            }
            if (!empty($oDados->brasil) && empty($oDados->brasil->tpLograd)) {
                $oDados->brasil->tpLograd = null;
            }

            if (!empty($oDados->infoDeficiencia) && empty($oDados->infoDeficiencia->observacao)) {
                unset($oDados->infoDeficiencia->observacao);
            }

            if (!empty($oDados->contato)) {
                if (empty($oDados->contato->fonePrinc)) {
                    $oDados->contato->fonePrinc = null;
                }
                if (empty($oDados->contato->emailPrinc)) {
                    $oDados->contato->emailPrinc = null;
                }
            }

            $oDadosAPI                                   = new \stdClass;
            $oDadosAPI->evtTSVAltContr                    = new \stdClass;
            $oDadosAPI->evtTSVAltContr->sequencial = $iSequencial;
            $oDadosAPI->evtTSVAltContr->indRetif   = 1;
            $oDadosAPI->evtTSVAltContr->nrRecibo   = null;
            $oDadosAPI->evtTSVAltContr->trabsemvinculo->cpfTrab = $oDados->ideTrabSemVinculo->cpfTrab;
            $oDadosAPI->evtTSVAltContr->trabsemvinculo->matricula = empty($oDados->ideTrabSemVinculo->matricula) ? null : $oDados->ideTrabSemVinculo->matricula;
            $oDadosAPI->evtTSVAltContr->trabsemvinculo->codcateg = empty($oDados->ideTrabSemVinculo->codCateg) || !empty($oDados->ideTrabSemVinculo->matricula) ? null : $oDados->ideTrabSemVinculo->codCateg;

            $oDadosAPI->evtTSVAltContr->tsvalteracao->dtalteracao = date("Y-m-d", db_getsession('DB_datausu'));
            if (!empty($oDados->infoTSVAlteracao->natatividade)) {
                $oDadosAPI->evtTSVAltContr->tsvalteracao->natatividade = $oDados->infoTSVAlteracao->natatividade;
            }

            $oDadosAPI->evtTSVAltContr->cargofuncao->nmCargo = empty($oDados->cargoFuncao->nmCargo) ? null : $oDados->cargoFuncao->nmCargo;
            $oDadosAPI->evtTSVAltContr->cargofuncao->cboCargo = empty($oDados->cargoFuncao->CBOCargo) ? null : $oDados->cargoFuncao->CBOCargo;
            $oDadosAPI->evtTSVAltContr->cargofuncao->nmFuncao = empty($oDados->cargoFuncao->nmFuncao) ? null : $oDados->cargoFuncao->nmFuncao;
            $oDadosAPI->evtTSVAltContr->cargofuncao->cboFuncao = empty($oDados->cargoFuncao->cboFuncao) ? null : $oDados->infoContrato->cboFuncao;
            
            $oDadosAPI->evtTSVAltContr->remuneracao->vrSalFx = empty($oDados->remuneracao->vrSalFx) ? null : $oDados->remuneracao->vrSalFx;
            $oDadosAPI->evtTSVAltContr->remuneracao->undSalFixo = empty($oDados->remuneracao->undSalFixo) ? null : $oDados->remuneracao->undSalFixo;
            $oDadosAPI->evtTSVAltContr->remuneracao->dscSalVar = empty($oDados->remuneracao->dscSalVar) ? null : $oDados->remuneracao->dscSalVar;

            $oDadosAPI->evtTSVAltContr->dirigentesindical = null;
            if (!empty($oDados->infoDirigenteSindical->tpRegPrev)) {
                $oDadosAPI->evtTSVAltContr->dirigentesindical->tpRegPrev = $oDados->infoDirigenteSindical->tpRegPrev;
            }

            $oDadosAPI->evtTSVAltContr->trabcedido = null;
            if (!empty($oDados->infoTrabCedido->tpRegPrev)) {
                $oDadosAPI->evtTSVAltContr->trabcedido->tpRegPrev = $oDados->infoTrabCedido->tpRegPrev;
            }

            $oDadosAPI->evtTSVAltContr->mandelelt = null;
            if (!empty($oDados->infoMandElet->tpRegPrev)) {
                $oDadosAPI->evtTSVAltContr->mandelelt->indremuncargo = empty($oDados->infoMandElet->indRemunCargo) ? null : $oDados->infoMandElet->indRemunCargo;
                $oDadosAPI->evtTSVAltContr->mandelelt->tpregprev = empty($oDados->infoMandElet->tpRegPrev) ? null : $oDados->infoMandElet->tpRegPrev;
            }

            $oDadosAPI->evtTSVAltContr->estagiario = null;
            if (!empty($oDados->infoEstagiario->natEstagio)) {
                $oDadosAPI->evtTSVAltContr->estagiario->natEstagio = empty($oDados->infoEstagiario->natEstagio) ? null : $oDados->infoEstagiario->natEstagio;
                $oDadosAPI->evtTSVAltContr->estagiario->nivEstagio = empty($oDados->infoEstagiario->nivEstagio) ? null : $oDados->infoEstagiario->nivEstagio;
                $oDadosAPI->evtTSVAltContr->estagiario->areaAtuacao = empty($oDados->infoEstagiario->areaAtuacao) ? null : $oDados->infoEstagiario->areaAtuacao;
                $oDadosAPI->evtTSVAltContr->estagiario->nrApol = empty($oDados->infoEstagiario->nrApol) ? null : $oDados->infoEstagiario->nrApol;
                $oDadosAPI->evtTSVAltContr->estagiario->dtPrevTerm = empty($oDados->infoEstagiario->dtPrevTerm) ? null : $oDados->infoEstagiario->dtPrevTerm;

                $oDadosAPI->evtTSVAltContr->estagiario->instEnsino->cnpjInstEnsino = empty($oDados->instEnsino->cnpjInstEnsino) ? null : $oDados->instEnsino->cnpjInstEnsino;
                $oDadosAPI->evtTSVAltContr->estagiario->instensino->nmrazao = empty($oDados->instEnsino->nmrazao) ? null : $oDados->instEnsino->nmrazao;
                $oDadosAPI->evtTSVAltContr->estagiario->instensino->dscLograd = empty($oDados->instEnsino->dscLograd) ? null : $oDados->instEnsino->dscLograd;
                $oDadosAPI->evtTSVAltContr->estagiario->instensino->nrLograd = empty($oDados->instEnsino->nrLograd) ? null : $oDados->instEnsino->nrLograd;
                $oDadosAPI->evtTSVAltContr->estagiario->instensino->bairro = empty($oDados->instEnsino->bairro) ? null : $oDados->instEnsino->bairro;
                $oDadosAPI->evtTSVAltContr->estagiario->instensino->cep = empty($oDados->instEnsino->cep) ? null : $oDados->instEnsino->cep;
                $oDadosAPI->evtTSVAltContr->estagiario->instensino->codMunic = empty($oDados->instEnsino->codMunic) ? null : $oDados->instEnsino->codMunic;
                $oDadosAPI->evtTSVAltContr->estagiario->instensino->uf = empty($oDados->instEnsino->uf) ? null : $oDados->instEnsino->uf;

                $oDadosAPI->evtTSVAltContr->estagiario->ageintegracao->cnpjAgntInteg = empty($oDados->ageIntegracao->cnpjAgntInteg) ? null : $oDados->ageIntegracao->cnpjAgntInteg;

                $oDadosAPI->evtTSVAltContr->estagiario->supervisor->cpfSupervisor = empty($oDados->supervisorEstagio->cpfSupervisor) ? null : $oDados->supervisorEstagio->cpfSupervisor;
            }

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
        // echo '<pre>';
        // print_r($aDadosAPI);
        // exit;
        return $aDadosAPI;
    }

    /**
     * Retorna dados dos dependentes no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarDependentes($matricula)
    {

        $oDaorhdepend = \db_utils::getDao("rhdepend");
        $sqlDependentes = $oDaorhdepend->sql_query_file(null, "*", "rh31_codigo", "rh31_regist = {$matricula}");
        $rsDependentes = db_query($sqlDependentes);
        if (pg_num_rows($rsDependentes) == 0) {
            return null;
        }
        $aDependentes = array();
        for ($iCont = 0; $iCont < pg_num_rows($rsDependentes); $iCont++) {
            $oDependentes = \db_utils::fieldsMemory($rsDependentes, $iCont);
            $oDependFormatado = new \stdClass;
            switch ($oDependentes->rh31_gparen) {
                case 'C':
                    $oDependFormatado->tpdep = '01';
                    break;
                case 'F':
                    $oDependFormatado->tpdep = '03';
                    break;
                case 'P':
                case 'M':
                case 'A':
                    $oDependFormatado->tpdep = '09';
                    break;

                default:
                    $oDependFormatado->tpdep = '99';
                    break;
            }
            $oDependFormatado->nmdep = $oDependentes->rh31_nome;
            $oDependFormatado->dtnascto = $oDependentes->rh31_dtnasc;
            $oDependFormatado->cpfdep = empty($oDependentes->rh31_cpf) ? null : $oDependentes->rh31_cpf;
            $oDependFormatado->depirrf = ($oDependentes->rh31_irf == "0" ? "N" : "S");
            $oDependFormatado->depsf = ($oDependentes->rh31_depend == "N" ? "N" : "S");
            $oDependFormatado->inctrab = ($oDependentes->rh31_especi == "C" || $oDependentes->rh31_especi == "S" ? "S" : "N");

            $aDependentes[] = $oDependFormatado;
        }
        return $aDependentes;
    }
}
