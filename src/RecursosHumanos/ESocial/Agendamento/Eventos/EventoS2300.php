<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S2300 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS2300 extends EventoBase
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
            $oDadosAPI->evtTSVInicio                      = new \stdClass;
            $oDadosAPI->evtTSVInicio->sequencial          = $iSequencial;
            $oDadosAPI->evtTSVInicio->indRetif            = 1;
            $oDadosAPI->evtTSVInicio->nrRecibo            = null;
            $oDadosAPI->evtTSVInicio->cpfTrab             = $oDados->trabalhador->cpfTrab;
            $oDadosAPI->evtTSVInicio->nmTrab              = $oDados->trabalhador->nmTrab;
            $oDadosAPI->evtTSVInicio->sexo                = $oDados->trabalhador->sexo;
            $oDadosAPI->evtTSVInicio->racaCor             = $oDados->trabalhador->racaCor;
            $oDadosAPI->evtTSVInicio->estCiv              = empty($oDados->trabalhador->estCiv) ? null : $oDados->trabalhador->estCiv;
            $oDadosAPI->evtTSVInicio->grauInstr           = $oDados->trabalhador->grauInstr;
            $oDadosAPI->evtTSVInicio->nmSoc               = empty($oDados->trabalhador->nmSoc) ? null : $oDados->trabalhador->nmSoc;

            $oDadosAPI->evtTSVInicio->dtNascto            = $oDados->nascimento->dtNascto;
            $oDadosAPI->evtTSVInicio->paisNascto          = $oDados->nascimento->paisNascto;
            $oDadosAPI->evtTSVInicio->paisNac             = $oDados->nascimento->paisNac;

            $oDadosAPI->evtTSVInicio->endereco->brasil    = empty($oDados->brasil) ? null : $oDados->brasil;
            $oDadosAPI->evtTSVInicio->endereco->brasil->cep = str_pad($oDadosAPI->evtTSVInicio->endereco->brasil->cep, 8, "0", STR_PAD_RIGHT);

            $oDadosAPI->evtTSVInicio->infodeficiencia = empty($oDados->infoDeficiencia) ? null : $oDados->infoDeficiencia;

            $oDadosAPI->evtTSVInicio->dependente = $this->buscarDependentes($oDados->infoTSVInicio->matricula);
            if (empty($oDadosAPI->evtTSVInicio->dependente)) {
                unset($oDadosAPI->evtTSVInicio->dependente);
            }

            $oDadosAPI->evtTSVInicio->contato = empty($oDados->contato) ? null : $oDados->contato;

            $oDadosAPI->evtTSVInicio->cadini = empty($oDados->infoTSVInicio) ? null : $oDados->infoTSVInicio->cadIni;
            $oDadosAPI->evtTSVInicio->matricula = empty($oDados->infoTSVInicio) ? null : $oDados->infoTSVInicio->matricula;
            $oDadosAPI->evtTSVInicio->codcateg = empty($oDados->infoTSVInicio) ? null : $oDados->infoTSVInicio->codCateg;
            $oDadosAPI->evtTSVInicio->dtinicio = empty($oDados->infoTSVInicio) ? null : $oDados->infoTSVInicio->dtInicio;
            $oDadosAPI->evtTSVInicio->nrProcTrab = empty($oDados->infoTSVInicio) ? null : $oDados->infoTSVInicio->nrProcTrab;
            $oDadosAPI->evtTSVInicio->natatividade = null;

            $oDadosAPI->evtTSVInicio->cargofuncao->nmCargo = empty($oDados->cargoFuncao->nmCargo) ? null : $oDados->cargoFuncao->nmCargo;
            $oDadosAPI->evtTSVInicio->cargofuncao->cboCargo = empty($oDados->cargoFuncao->CBOCargo) ? null : $oDados->cargoFuncao->CBOCargo;
            $oDadosAPI->evtTSVInicio->cargofuncao->nmFuncao = empty($oDados->cargoFuncao->nmFuncao) ? null : $oDados->cargoFuncao->nmFuncao;
            $oDadosAPI->evtTSVInicio->cargofuncao->cboFuncao = empty($oDados->cargoFuncao->cboFuncao) ? null : $oDados->infoContrato->cboFuncao;
            
            $oDadosAPI->evtTSVInicio->remuneracao->vrSalFx = empty($oDados->remuneracao->vrSalFx) ? null : $oDados->remuneracao->vrSalFx;
            $oDadosAPI->evtTSVInicio->remuneracao->undSalFixo = empty($oDados->remuneracao->undSalFixo) ? null : $oDados->remuneracao->undSalFixo;
            $oDadosAPI->evtTSVInicio->remuneracao->dscSalVar = empty($oDados->remuneracao->dscSalVar) ? null : $oDados->remuneracao->dscSalVar;

            $oDadosAPI->evtTSVInicio->infotrabcedido = null;
            if (!empty($oDados->infoTrabCedido->categOrig)) {
                $oDadosAPI->evtTSVInicio->infotrabcedido->categorig = empty($oDados->infoTrabCedido->categOrig) ? null : $oDados->infoTrabCedido->categOrig;
                $oDadosAPI->evtTSVInicio->infotrabcedido->cnpjcednt = empty($oDados->infoTrabCedido->cnpjCednt) ? null : $oDados->infoTrabCedido->cnpjCednt;
                $oDadosAPI->evtTSVInicio->infotrabcedido->matricCed = empty($oDados->infoTrabCedido->matricCed) ? null : $oDados->infoTrabCedido->matricCed;
                $oDadosAPI->evtTSVInicio->infotrabcedido->dtAdmCed = empty($oDados->infoTrabCedido->dtAdmCed) ? null : $oDados->infoTrabCedido->dtAdmCed;
                $oDadosAPI->evtTSVInicio->infotrabcedido->tpRegTrab = empty($oDados->infoTrabCedido->tpRegTrab) ? null : $oDados->infoTrabCedido->tpRegTrab;
                $oDadosAPI->evtTSVInicio->infotrabcedido->tpRegPrev = empty($oDados->infoTrabCedido->tpRegPrev) ? null : $oDados->infoTrabCedido->tpRegPrev;
            }

            $oDadosAPI->evtTSVInicio->infoMandElet = null;
            if (!empty($oDados->infoMandElet->tpRegTrabInfoMandElet)) {
                $oDadosAPI->evtTSVInicio->infoMandElet->indRemunCargo = empty($oDados->infoMandElet->indRemunCargo) ? null : $oDados->infoMandElet->indRemunCargo;
                $oDadosAPI->evtTSVInicio->infoMandElet->tpRegTrab = empty($oDados->infoMandElet->tpRegTrabInfoMandElet) ? null : $oDados->infoMandElet->tpRegTrabInfoMandElet;
                $oDadosAPI->evtTSVInicio->infoMandElet->tpRegPrev = empty($oDados->infoMandElet->tpRegPrevInfoMandElet) ? null : $oDados->infoMandElet->tpRegPrevInfoMandElet;
            }

            $oDadosAPI->evtTSVInicio->infoEstagiario = null;
            if (!empty($oDados->infoEstagiario->natEstagio)) {
                $oDadosAPI->evtTSVInicio->infoEstagiario->natEstagio = empty($oDados->infoEstagiario->natEstagio) ? null : $oDados->infoEstagiario->natEstagio;
                $oDadosAPI->evtTSVInicio->infoEstagiario->nivEstagio = empty($oDados->infoEstagiario->nivEstagio) ? null : $oDados->infoEstagiario->nivEstagio;
                $oDadosAPI->evtTSVInicio->infoEstagiario->areaAtuacao = empty($oDados->infoEstagiario->areaAtuacao) ? null : $oDados->infoEstagiario->areaAtuacao;
                $oDadosAPI->evtTSVInicio->infoEstagiario->nrApol = empty($oDados->infoEstagiario->nrApol) ? null : $oDados->infoEstagiario->nrApol;
                $oDadosAPI->evtTSVInicio->infoEstagiario->dtPrevTerm = empty($oDados->infoEstagiario->dtPrevTerm) ? null : $oDados->infoEstagiario->dtPrevTerm;

                $oDadosAPI->evtTSVInicio->infoEstagiario->instEnsino->cnpjInstEnsino = empty($oDados->instEnsino->cnpjInstEnsino) ? null : $oDados->instEnsino->cnpjInstEnsino;
                $oDadosAPI->evtTSVInicio->infoEstagiario->cnpjAgntInteg = empty($oDados->ageIntegracao->cnpjAgntInteg) ? null : $oDados->ageIntegracao->cnpjAgntInteg;

                $oDadosAPI->evtTSVInicio->infoEstagiario->cpfSupervisor = empty($oDados->supervisorEstagio->cpfSupervisor) ? null : $oDados->supervisorEstagio->cpfSupervisor;
            }

            $oDadosAPI->evtTSVInicio->afastamento = null;
            if (!empty($oDados->afastamento->dtIniAfast)) {
                $oDadosAPI->evtTSVInicio->afastamento->dtIniAfast = empty($oDados->afastamento->dtIniAfast) ? null : $oDados->afastamento->dtIniAfast;
                $oDadosAPI->evtTSVInicio->afastamento->codMotAfast = empty($oDados->afastamento->codMotAfast) ? null : $oDados->afastamento->codMotAfast;
            }

            if (!empty($oDados->termino->dtTerm)) {
                $oDadosAPI->evtTSVInicio->termino->dtTerm = $oDados->termino->dtTerm;
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
