<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;
use stdClass;

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

            $oDadosAPI                                   = new \stdClass;
            $oDadosAPI->evtTSVInicio                      = new \stdClass;
            $oDadosAPI->evtTSVInicio->sequencial          = $iSequencial;
            $oDadosAPI->evtTSVInicio->indRetif            = 1;
            $oDadosAPI->evtTSVInicio->nrRecibo            = null;
            $oDadosAPI->evtTSVInicio->cpfTrab             = $oDados->cpftrab;
            $oDadosAPI->evtTSVInicio->nmTrab              = $oDados->nmtrab;
            $oDadosAPI->evtTSVInicio->sexo                = $oDados->sexo;
            $oDadosAPI->evtTSVInicio->racaCor             = $oDados->racacor;
            $oDadosAPI->evtTSVInicio->estCiv              = empty($oDados->estciv) ? null : $oDados->estciv;
            $oDadosAPI->evtTSVInicio->grauInstr           = $oDados->grauinstr;
            $oDadosAPI->evtTSVInicio->nmSoc               = empty($oDados->nmsoc) ? null : $oDados->nmsoc;

            $oDadosAPI->evtTSVInicio->dtNascto            = $oDados->dtnascto;
            $oDadosAPI->evtTSVInicio->paisNascto          = $oDados->paisnascto;
            $oDadosAPI->evtTSVInicio->paisNac             = $oDados->paisnac;

            $oDadosAPI->evtTSVInicio->endereco->brasil->tplograd    = empty($oDados->tplograd) ? null : $oDados->tplograd;
            $oDadosAPI->evtTSVInicio->endereco->brasil->dsclograd   = empty($oDados->dsclograd) ? null : $oDados->dsclograd;
            $oDadosAPI->evtTSVInicio->endereco->brasil->nrlograd    = empty($oDados->nrlograd) ? null : $oDados->nrlograd;
            $oDadosAPI->evtTSVInicio->endereco->brasil->complemento = empty($oDados->complemento) ? null : $oDados->complemento;
            $oDadosAPI->evtTSVInicio->endereco->brasil->bairro      = empty($oDados->bairro) ? null : $oDados->bairro;
            $oDadosAPI->evtTSVInicio->endereco->brasil->codmunic    = empty($oDados->codmunic) ? null : $oDados->codmunic;
            $oDadosAPI->evtTSVInicio->endereco->brasil->uf    = empty($oDados->uf) ? null : $oDados->uf;
            $oDadosAPI->evtTSVInicio->endereco->brasil->cep = str_pad($oDados->cep, 8, "0", STR_PAD_RIGHT);

            $oDadosAPI->evtTSVInicio->infodeficiencia->observacao = empty($oDados->observacao) ? null : $oDados->observacao;
            empty($oDados->deffisica) ? null : $oDadosAPI->evtTSVInicio->infodeficiencia->deffisica = $oDados->deffisica;
            empty($oDados->defvisual) ? null : $oDadosAPI->evtTSVInicio->infodeficiencia->defvisual = $oDados->defvisual;
            empty($oDados->defauditiva) ? null : $oDadosAPI->evtTSVInicio->infodeficiencia->defauditiva = $oDados->defauditiva;
            empty($oDados->defmental) ? null : $oDadosAPI->evtTSVInicio->infodeficiencia->defmental = $oDados->defmental;
            empty($oDados->defintelectual) ? null : $oDadosAPI->evtTSVInicio->infodeficiencia->defintelectual = $oDados->defintelectual;
            empty($oDados->reabreadap) ? null : $oDadosAPI->evtTSVInicio->infodeficiencia->reabreadap = $oDados->reabreadap;

            $oDadosAPI->evtTSVInicio->dependente = $this->buscarDependentes($oDados->matricula);
            if (empty($oDadosAPI->evtTSVInicio->dependente)) {
                unset($oDadosAPI->evtTSVInicio->dependente);
            }

            $oDadosAPI->evtTSVInicio->contato->foneprinc = empty($oDados->foneprinc) ? null : $oDados->foneprinc;
            $oDadosAPI->evtTSVInicio->contato->emailprinc = empty($oDados->emailprinc) ? null : $oDados->emailprinc;

            $oDadosAPI->evtTSVInicio->cadini = empty($oDados->cadini) ? null : $oDados->cadini;
            $oDadosAPI->evtTSVInicio->matricula = empty($oDados->matricula) ? null : $oDados->matricula;
            $oDadosAPI->evtTSVInicio->codcateg = empty($oDados->codcateg) ? null : $oDados->codcateg;
            $oDadosAPI->evtTSVInicio->dtinicio = empty($oDados->dtinicio) ? null : $oDados->dtinicio;
            $oDadosAPI->evtTSVInicio->nrProcTrab = empty($oDados->nrproctrab) ? null : $oDados->nrproctrab;
            $oDadosAPI->evtTSVInicio->natatividade = null;

            $oDadosAPI->evtTSVInicio->cargofuncao->nmCargo = empty($oDados->nmcargo) ? null : $oDados->nmcargo;
            $oDadosAPI->evtTSVInicio->cargofuncao->cboCargo = empty($oDados->cbocargo) ? null : $oDados->cbocargo;
            $oDadosAPI->evtTSVInicio->cargofuncao->nmFuncao = empty($oDados->nmfuncao) ? null : $oDados->nmfuncao;
            $oDadosAPI->evtTSVInicio->cargofuncao->cboFuncao = empty($oDados->cbofuncao) ? null : $oDados->cbofuncao;

            $oDadosAPI->evtTSVInicio->remuneracao->vrSalFx = empty($oDados->vrsalfx) ? null : $oDados->vrsalfx;
            $oDadosAPI->evtTSVInicio->remuneracao->undSalFixo = empty($oDados->undsalfixo) ? null : $oDados->undsalfixo;
            $oDadosAPI->evtTSVInicio->remuneracao->dscSalVar = empty($oDados->dscsalvar) ? null : $oDados->dscsalvar;

            $oDadosAPI->evtTSVInicio->infotrabcedido = null;
            if (!empty($oDados->categorig)) {
                $oDadosAPI->evtTSVInicio->infotrabcedido = new stdClass();
                $oDadosAPI->evtTSVInicio->infotrabcedido->categorig = empty($oDados->categorig) ? null : "301";
                $oDadosAPI->evtTSVInicio->infotrabcedido->cnpjcednt = empty($oDados->cnpjcednt) ? null : $oDados->cnpjcednt;
                $oDadosAPI->evtTSVInicio->infotrabcedido->matricCed = empty($oDados->matricced) ? null : $oDados->matricced;
                $oDadosAPI->evtTSVInicio->infotrabcedido->dtAdmCed = empty($oDados->dtadmced) ? null : $oDados->dtadmced;
                $oDadosAPI->evtTSVInicio->infotrabcedido->tpRegTrab = empty($oDados->tpregtrab) ? null : $oDados->tpregtrab;
                $oDadosAPI->evtTSVInicio->infotrabcedido->tpRegPrev = empty($oDados->tpregprev) ? null : $oDados->tpregprev;
            }

            $oDadosAPI->evtTSVInicio->infoMandElet = null;
            if (!empty($oDados->tpregtrabinfomandelet)) {
                $oDadosAPI->evtTSVInicio->infoMandElet = new stdClass();
                $oDadosAPI->evtTSVInicio->infoMandElet->indRemunCargo = empty($oDados->indremuncargo) ? null : $oDados->indremuncargo;
                $oDadosAPI->evtTSVInicio->infoMandElet->tpRegTrab = empty($oDados->tpregtrabinfomandelet) ? null : $oDados->tpregtrabinfomandelet;
                $oDadosAPI->evtTSVInicio->infoMandElet->tpRegPrev = empty($oDados->tpregprevinfomandelet) ? null : $oDados->tpregprevinfomandelet;
            }

            $oDadosAPI->evtTSVInicio->infoEstagiario = null;
            if (!empty($oDados->natestagio)) {
                $oDadosAPI->evtTSVInicio->infoEstagiario = new stdClass();
                $oDadosAPI->evtTSVInicio->infoEstagiario->natEstagio = empty($oDados->natestagio) ? null : $oDados->natestagio;
                $oDadosAPI->evtTSVInicio->infoEstagiario->nivEstagio = empty($oDados->nivestagio) ? null : $oDados->nivestagio;
                $oDadosAPI->evtTSVInicio->infoEstagiario->areaAtuacao = empty($oDados->areaatuacao) ? null : $oDados->areaatuacao;
                $oDadosAPI->evtTSVInicio->infoEstagiario->nrApol = empty($oDados->nrapol) ? null : $oDados->nrapol;
                $oDadosAPI->evtTSVInicio->infoEstagiario->dtPrevTerm = empty($oDados->dtprevterm) ? null : $oDados->dtprevterm;

                $oDadosAPI->evtTSVInicio->infoEstagiario->instEnsino->cnpjInstEnsino = empty($oDados->cnpjinstensino) ? null : $oDados->cnpjinstensino;
                $oDadosAPI->evtTSVInicio->infoEstagiario->cnpjAgntInteg = empty($oDados->cnpjagntinteg) ? null : $oDados->cnpjagntinteg;

                $oDadosAPI->evtTSVInicio->infoEstagiario->cpfSupervisor = empty($oDados->cpfsupervisor) ? null : $oDados->cpfsupervisor;
            }

            $oDadosAPI->evtTSVInicio->localTrabGeral->tpinsc   = 1;
            $oDadosAPI->evtTSVInicio->localTrabGeral->nrinsc   = $oDados->nrinsc_localtrabgeral;
            $oDadosAPI->evtTSVInicio->localTrabGeral->desccomp = $oDados->desccomp_localtrabgeral;

            $oDadosAPI->evtTSVInicio->afastamento = null;
            if (!empty($oDados->dtiniafast)) {
                $oDadosAPI->evtTSVInicio->afastamento = new stdClass();
                $oDadosAPI->evtTSVInicio->afastamento->dtIniAfast = empty($oDados->dtiniafast) ? null : $oDados->dtiniafast;
                $oDadosAPI->evtTSVInicio->afastamento->codMotAfast = empty($oDados->codmotafast) ? null : $oDados->codmotafast;
            }

            if (!empty($oDados->dtterm)) {
                $oDadosAPI->evtTSVInicio->termino->dtTerm = $oDados->dtterm;
            }

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
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
