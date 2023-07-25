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
        exit(var_dump($this->dados));
        $aDadosAPI = array();
        $iSequencial = 1;
        foreach ($this->dados as $oDados) {

            $oDadosAPI                                    = new \stdClass;
            $oDadosAPI->evtTSVTermino                     = new \stdClass;
            $oDadosAPI->evtTSVTermino->sequencial          = $iSequencial;
            $oDadosAPI->evtTSVTermino->indRetif            = 1;
            $oDadosAPI->evtTSVTermino->nrRecibo            = null;
            $oDadosAPI->evtTSVTermino->cpfTrab             = $oDados->cpftrab;
            $oDadosAPI->evtTSVTermino->nmTrab              = $oDados->nmtrab;
            $oDadosAPI->evtTSVTermino->sexo                = $oDados->sexo;
            $oDadosAPI->evtTSVTermino->racaCor             = $oDados->racacor;
            $oDadosAPI->evtTSVTermino->estCiv              = empty($oDados->estciv) ? null : $oDados->estciv;
            $oDadosAPI->evtTSVTermino->grauInstr           = $oDados->grauinstr;
            $oDadosAPI->evtTSVTermino->nmSoc               = empty($oDados->nmsoc) ? null : $oDados->nmsoc;

            $oDadosAPI->evtTSVTermino->dtNascto            = $oDados->dtnascto;
            $oDadosAPI->evtTSVTermino->paisNascto          = $oDados->paisnascto;
            $oDadosAPI->evtTSVTermino->paisNac             = $oDados->paisnac;

            $oDadosAPI->evtTSVTermino->endereco->brasil->tplograd    = empty($oDados->tplograd) ? null : $oDados->tplograd;
            $oDadosAPI->evtTSVTermino->endereco->brasil->dsclograd   = empty($oDados->dsclograd) ? null : $oDados->dsclograd;
            $oDadosAPI->evtTSVTermino->endereco->brasil->nrlograd    = empty($oDados->nrlograd) ? null : $oDados->nrlograd;
            $oDadosAPI->evtTSVTermino->endereco->brasil->complemento = empty($oDados->complemento) ? null : $oDados->complemento;
            $oDadosAPI->evtTSVTermino->endereco->brasil->bairro      = empty($oDados->bairro) ? null : $oDados->bairro;
            $oDadosAPI->evtTSVTermino->endereco->brasil->codmunic    = empty($oDados->codmunic) ? null : $oDados->codmunic;
            $oDadosAPI->evtTSVTermino->endereco->brasil->uf    = empty($oDados->uf) ? null : $oDados->uf;
            $oDadosAPI->evtTSVTermino->endereco->brasil->cep = str_pad($oDados->cep, 8, "0", STR_PAD_RIGHT);

            $oDadosAPI->evtTSVTermino->infodeficiencia->observacao = empty($oDados->observacao) ? null : $oDados->observacao;
            empty($oDados->deffisica) ? null : $oDadosAPI->evtTSVTermino->infodeficiencia->deffisica = $oDados->deffisica;
            empty($oDados->defvisual) ? null : $oDadosAPI->evtTSVTermino->infodeficiencia->defvisual = $oDados->defvisual;
            empty($oDados->defauditiva) ? null : $oDadosAPI->evtTSVTermino->infodeficiencia->defauditiva = $oDados->defauditiva;
            empty($oDados->defmental) ? null : $oDadosAPI->evtTSVTermino->infodeficiencia->defmental = $oDados->defmental;
            empty($oDados->defintelectual) ? null : $oDadosAPI->evtTSVTermino->infodeficiencia->defintelectual = $oDados->defintelectual;
            empty($oDados->reabreadap) ? null : $oDadosAPI->evtTSVTermino->infodeficiencia->reabreadap = $oDados->reabreadap;

            $oDadosAPI->evtTSVTermino->dependente = $this->buscarDependentes($oDados->matricula);
            if (empty($oDadosAPI->evtTSVTermino->dependente)) {
                unset($oDadosAPI->evtTSVTermino->dependente);
            }

            $oDadosAPI->evtTSVTermino->contato->foneprinc = empty($oDados->foneprinc) ? null : $oDados->foneprinc;
            $oDadosAPI->evtTSVTermino->contato->emailprinc = empty($oDados->emailprinc) ? null : $oDados->emailprinc;

            $oDadosAPI->evtTSVTermino->cadini = empty($oDados->cadini) ? null : $oDados->cadini;
            $oDadosAPI->evtTSVTermino->matricula = empty($oDados->matricula) ? null : $oDados->matricula;
            $oDadosAPI->evtTSVTermino->codcateg = empty($oDados->codcateg) ? null : $oDados->codcateg;
            $oDadosAPI->evtTSVTermino->dtinicio = empty($oDados->dtinicio) ? null : $oDados->dtinicio;
            $oDadosAPI->evtTSVTermino->nrProcTrab = empty($oDados->nrproctrab) ? null : $oDados->nrproctrab;
            $oDadosAPI->evtTSVTermino->natatividade = null;

            $oDadosAPI->evtTSVTermino->cargofuncao->nmCargo = empty($oDados->nmcargo) ? null : $oDados->nmcargo;
            $oDadosAPI->evtTSVTermino->cargofuncao->cboCargo = empty($oDados->cbocargo) ? null : $oDados->cbocargo;
            $oDadosAPI->evtTSVTermino->cargofuncao->nmFuncao = empty($oDados->nmfuncao) ? null : $oDados->nmfuncao;
            $oDadosAPI->evtTSVTermino->cargofuncao->cboFuncao = empty($oDados->cbofuncao) ? null : $oDados->cbofuncao;
            
            $oDadosAPI->evtTSVTermino->remuneracao->vrSalFx = empty($oDados->vrsalfx) ? null : $oDados->vrsalfx;
            $oDadosAPI->evtTSVTermino->remuneracao->undSalFixo = empty($oDados->undsalfixo) ? null : $oDados->undsalfixo;
            $oDadosAPI->evtTSVTermino->remuneracao->dscSalVar = empty($oDados->dscsalvar) ? null : $oDados->dscsalvar;

            $oDadosAPI->evtTSVTermino->infotrabcedido = null;
            // if (!empty($oDados->categorig)) {
            //     $oDadosAPI->evtTSVTermino->infotrabcedido->categorig = empty($oDados->categorig) ? null : "301";
            //     $oDadosAPI->evtTSVTermino->infotrabcedido->cnpjcednt = empty($oDados->cnpjcednt) ? null : $oDados->cnpjcednt;
            //     $oDadosAPI->evtTSVTermino->infotrabcedido->matricCed = empty($oDados->matricced) ? null : $oDados->matricced;
            //     $oDadosAPI->evtTSVTermino->infotrabcedido->dtAdmCed = empty($oDados->dtadmced) ? null : $oDados->dtadmced;
            //     $oDadosAPI->evtTSVTermino->infotrabcedido->tpRegTrab = empty($oDados->tpregtrab) ? null : $oDados->tpregtrab;
            //     $oDadosAPI->evtTSVTermino->infotrabcedido->tpRegPrev = empty($oDados->tpregprev) ? null : $oDados->tpregprev;
            // }

            // $oDadosAPI->evtTSVTermino->infoMandElet = null;
            // if (!empty($oDados->tpregtrabinfomandelet)) {
            //     $oDadosAPI->evtTSVTermino->infoMandElet->indRemunCargo = empty($oDados->indremuncargo) ? null : $oDados->indremuncargo;
            //     $oDadosAPI->evtTSVTermino->infoMandElet->tpRegTrab = empty($oDados->tpregtrabinfomandelet) ? null : $oDados->tpregtrabinfomandelet;
            //     $oDadosAPI->evtTSVTermino->infoMandElet->tpRegPrev = empty($oDados->tpregprevinfomandelet) ? null : $oDados->tpregprevinfomandelet;
            // }

            // $oDadosAPI->evtTSVTermino->infoEstagiario = null;
            // if (!empty($oDados->natestagio)) {
            //     $oDadosAPI->evtTSVTermino->infoEstagiario->natEstagio = empty($oDados->natestagio) ? null : $oDados->natestagio;
            //     $oDadosAPI->evtTSVTermino->infoEstagiario->nivEstagio = empty($oDados->nivestagio) ? null : $oDados->nivestagio;
            //     $oDadosAPI->evtTSVTermino->infoEstagiario->areaAtuacao = empty($oDados->areaatuacao) ? null : $oDados->areaatuacao;
            //     $oDadosAPI->evtTSVTermino->infoEstagiario->nrApol = empty($oDados->nrapol) ? null : $oDados->nrapol;
            //     $oDadosAPI->evtTSVTermino->infoEstagiario->dtPrevTerm = empty($oDados->dtprevterm) ? null : $oDados->dtprevterm;

            //     $oDadosAPI->evtTSVTermino->infoEstagiario->instEnsino->cnpjInstEnsino = empty($oDados->cnpjinstensino) ? null : $oDados->cnpjinstensino;
            //     $oDadosAPI->evtTSVTermino->infoEstagiario->cnpjAgntInteg = empty($oDados->cnpjagntinteg) ? null : $oDados->cnpjagntinteg;

            //     $oDadosAPI->evtTSVTermino->infoEstagiario->cpfSupervisor = empty($oDados->cpfsupervisor) ? null : $oDados->cpfsupervisor;
            // }

            // $oDadosAPI->evtTSVTermino->afastamento = null;
            // if (!empty($oDados->dtiniafast)) {
            //     $oDadosAPI->evtTSVTermino->afastamento->dtIniAfast = empty($oDados->dtiniafast) ? null : $oDados->dtiniafast;
            //     $oDadosAPI->evtTSVTermino->afastamento->codMotAfast = empty($oDados->codmotafast) ? null : $oDados->codmotafast;
            // }

            if (!empty($oDados->dtterm)) {
                $oDadosAPI->evtTSVTermino->termino->dtTerm = $oDados->dtterm;
            }

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
        echo '<pre>';
        var_dump($aDadosAPI);exit;
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
