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
    public function __construct($dados)
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
        // echo '<pre>';
        // print_r($this->dados);
        // exit;

        $iSequencial = 1;
        foreach ($this->dados as $oDados) {
            $oDadosAPI                                   = new \stdClass;
            $oDadosAPI->evtAdmissao                      = new \stdClass;
            $oDadosAPI->evtAdmissao->sequencial          = $iSequencial;
            $oDadosAPI->evtAdmissao->modo                = $this->modo;
            $oDadosAPI->evtAdmissao->indRetif            = 1;
            $oDadosAPI->evtAdmissao->nrRecibo            = null;
            $oDadosAPI->evtAdmissao->cpfTrab             = $oDados->cpftrab;
            $oDadosAPI->evtAdmissao->nisTrab             = $oDados->nistrab;
            $oDadosAPI->evtAdmissao->nmTrab              = $oDados->nmtrab;
            $oDadosAPI->evtAdmissao->sexo                = $oDados->sexo;
            $oDadosAPI->evtAdmissao->racaCor             = $oDados->racacor;
            $oDadosAPI->evtAdmissao->estCiv              = empty($oDados->estciv) ? null : $oDados->estciv;
            $oDadosAPI->evtAdmissao->grauInstr           = str_pad($oDados->grauinstr, 2, 0, STR_PAD_LEFT);
            $oDadosAPI->evtAdmissao->indPriEmpr          = $oDados->indpriEmpr;
            $oDadosAPI->evtAdmissao->nmSoc               = empty($oDados->nmsoc) ? null : $oDados->nmsoc;

            $oDadosAPI->evtAdmissao->dtNascto            = $oDados->dtnascto;
            $oDadosAPI->evtAdmissao->codMunic            = empty($oDados->codmunic) ? null : $oDados->codmunic;
            $oDadosAPI->evtAdmissao->uf                  = empty($oDados->uf) ? null : $oDados->uf;
            $oDadosAPI->evtAdmissao->paisNascto          = $oDados->paisnascto;
            $oDadosAPI->evtAdmissao->paisNac             = $oDados->paisnac;
            $oDadosAPI->evtAdmissao->nmMae               = empty($oDados->nmmae) ? null : $oDados->nmmae;
            $oDadosAPI->evtAdmissao->nmPai               = empty($oDados->nmpai) ? null : $oDados->nmpai;

            $oDadosAPI->evtAdmissao->CTPS                = empty($oDados->CTPS) ? null : $oDados->CTPS;

            $oDadosAPI->evtAdmissao->RIC                 = empty($oDados->RIC) ? null : $oDados->RIC;

            $oDadosAPI->evtAdmissao->OC                 = empty($oDados->OC) ? null : $oDados->OC;

            $oDadosAPI->evtAdmissao->CNH                 = empty($oDados->CNH->nrRegCnh) ? null : $oDados->CNH;

            //$oDadosAPI->evtAdmissao->endereco->brasil    = empty($oDados->brasil) ? null : $oDados->brasil;
            $oDadosAPI->evtAdmissao->endereco->brasil->tpLograd    = empty($oDados->tplograd) ? null : $oDados->tplograd;
            $oDadosAPI->evtAdmissao->endereco->brasil->dscLograd   = empty($oDados->dsclograd) ? null : $oDados->dsclograd;

            $oDadosAPI->evtAdmissao->endereco->brasil->nrLograd    =  $oDados->nrlograd;
            if (empty($oDados->nrlograd) || $oDados->nrlograd == 0) {
                $oDadosAPI->evtAdmissao->endereco->brasil->nrLograd   =  'S/N';
            }
            $oDadosAPI->evtAdmissao->endereco->brasil->uf    =  $oDados->uf;
            $oDadosAPI->evtAdmissao->endereco->brasil->complemento = empty($oDados->complemento) ? null : $oDados->complemento;
            $oDadosAPI->evtAdmissao->endereco->brasil->bairro      = empty($oDados->bairro) ? null : $oDados->bairro;
            $oDadosAPI->evtAdmissao->endereco->brasil->cep         = empty($oDados->cep) ? null : $oDados->cep;

            $oDadosAPI->evtAdmissao->endereco->brasil->codMunic    = empty($oDados->codmunic) ? null : $oDados->codmunic;

            //$oDadosAPI->evtAdmissao->endereco->exterior  = empty($oDados->exterior) ? null : $oDados->exterior;

            if (!empty($oDados->trabEstrangeiro)) {
                $oDadosAPI->evtAdmissao->trabEstrangeiro = $oDados->trabEstrangeiro;
            }
            //$oDadosAPI->evtAdmissao->deficiencia = empty($oDados->infoDeficiencia) ? null : $oDados->infoDeficiencia;
            $oDadosAPI->evtAdmissao->deficiencia->defFisica = empty($oDados->deffisica) ? null : $oDados->deffisica;
            $oDadosAPI->evtAdmissao->deficiencia->defVisual = empty($oDados->defvisual) ? null : $oDados->defvisual;
            $oDadosAPI->evtAdmissao->deficiencia->defAuditiva = empty($oDados->defauditiva) ? null : $oDados->defauditiva;
            $oDadosAPI->evtAdmissao->deficiencia->defMental = empty($oDados->defmental) ? null : $oDados->defmental;
            $oDadosAPI->evtAdmissao->deficiencia->defIntelectual = empty($oDados->defintelectual) ? null : $oDados->defintelectual;
            $oDadosAPI->evtAdmissao->deficiencia->reabReadap = empty($oDados->reabreadap) ? null : $oDados->reabreadap;
            $oDadosAPI->evtAdmissao->deficiencia->infoCota = empty($oDados->infocota) ? null : $oDados->infocota;
            $oDadosAPI->evtAdmissao->deficiencia->observacao = empty($oDados->observacao) ? null : $oDados->observacao;

            $oDadosAPI->evtAdmissao->dependente = $this->buscarDependentes($oDados->matricula, $oDados->tpregprev);

            if (empty($oDadosAPI->evtAdmissao->dependente)) {
                unset($oDadosAPI->evtAdmissao->dependente);
            }

            $oDadosAPI->evtAdmissao->aposentadoria = empty($oDados->aposentadoria) ? null : $oDados->aposentadoria;

            $oDadosAPI->evtAdmissao->contato = empty($oDados->contato) ? null : $oDados->contato;

            $oDadosAPI->evtAdmissao->vinculo->matricula = $oDados->matricula;
            $oDadosAPI->evtAdmissao->vinculo->tpRegTrab = $oDados->tpregtrab;
            $oDadosAPI->evtAdmissao->vinculo->tpRegPrev = $oDados->tpregprev;
            $oDadosAPI->evtAdmissao->vinculo->nrRecInfPrelim = $oDados->nrrecinfprelim;

            $oDadosAPI->evtAdmissao->vinculo->cadIni = $oDados->cadini;

            if (!empty($oDados->dtadm)) {
                //$oDadosAPI->evtAdmissao->vinculo->infoCeletista = $oDados->infoCeletista;
                $oDadosAPI->evtAdmissao->vinculo->infoCeletista->dtAdm             = $oDados->dtadm;
                $oDadosAPI->evtAdmissao->vinculo->infoCeletista->tpAdmissao        = $oDados->tpadmissao;
                $oDadosAPI->evtAdmissao->vinculo->infoCeletista->indAdmissao       = $oDados->indadmissao;
                $oDadosAPI->evtAdmissao->vinculo->infoCeletista->tpRegJor          = $oDados->tpregjor;
                $oDadosAPI->evtAdmissao->vinculo->infoCeletista->natAtividade      = $oDados->natatividade;
                //$oDadosAPI->evtAdmissao->vinculo->infoCeletista->dtBase            = $oDados->dtbase;
                $oDadosAPI->evtAdmissao->vinculo->infoCeletista->cnpjSindCategProf = $oDados->cnpjsindcategprof;

                $oDadosAPI->evtAdmissao->vinculo->infoCeletista->opcFGTS = $oDados->opcfgts;
                //$oDadosAPI->evtAdmissao->vinculo->infoCeletista->dtOpcFGTS = empty($oDados->dtopcfgts) ? null : $oDados->dtopcfgts;
                if (!empty($oDados->trabtemporario)) {
                    $oDadosAPI->evtAdmissao->vinculo->infoCeletista->trabTemporario = $oDados->trabtemporario;
                    $oDadosAPI->evtAdmissao->vinculo->infoCeletista->trabTemporario->ideTomadorServ = $oDados->idetomadorserv;
                    $oDadosAPI->evtAdmissao->vinculo->infoCeletista->trabTemporario->ideTomadorServ->ideEstabVinc = $oDados->ideestabvinc;
                    $oDadosAPI->evtAdmissao->vinculo->infoCeletista->trabTemporario->ideTrabSubstituido = $oDados->idetrabsubstituido;
                }
                $oDadosAPI->evtAdmissao->vinculo->infoCeletista->aprend = empty($oDados->aprend) ? null : $oDados->aprend;


                $oDadosAPI->evtAdmissao->vinculo->infoContrato->horContratual->qtdHrsSem = empty($oDados->qtdhrssem) ? null : $oDados->qtdhrssem;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->horContratual->tpJornada = empty($oDados->tpjornada) ? null : $oDados->tpjornada;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->horContratual->tmpParc = 0;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->horContratual->horNoturno = empty($oDados->hornoturno) ? null : $oDados->hornoturno;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->horContratual->dscJorn    = empty($oDados->dscjorn) ? null : $oDados->dscjorn;
            } else {
                //$oDadosAPI->evtAdmissao->vinculo->infoEstatutario = $oDados->infoEstatutario;
                $oDadosAPI->evtAdmissao->vinculo->infoEstatutario->tpProv       = $oDados->tpprov;
                $oDadosAPI->evtAdmissao->vinculo->infoEstatutario->dtExercicio  = $oDados->dtexercicio;
                if ($oDados->tpplanrp != 1) {
                    $oDadosAPI->evtAdmissao->vinculo->infoEstatutario->tpPlanRP     = $oDados->tpplanrp;
                }
                if ($oDados->indtetorgps == 'N') {
                    $oDadosAPI->evtAdmissao->vinculo->infoEstatutario->indTetoRGPS  = $oDados->indtetorgps;
                }
                if (!empty($oDados->indabonoperm)) {
                    $oDadosAPI->evtAdmissao->vinculo->infoEstatutario->indAbonoPerm = $oDados->indabonoperm;
                }
            }

            if (!empty($oDados->nmcargo)) {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->nmCargo = $oDados->nmcargo;
            }
            if (!empty($oDados->cbocargo)) {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->CBOCargo = $oDados->cbocargo;
            }
            if (!empty($oDados->dtingrcargo) && $oDados->cadIni == 'S') {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->dtIngrCargo = $oDados->dtingrcargo;
            }
            if (!empty($oDados->nmfuncao)) {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->nmFuncao = $oDados->nmfuncao;
            }
            if (!empty($oDados->nmfuncao)) {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->nmFuncao = $oDados->nmfuncao;
            }
            if (!empty($oDados->cbofuncao)) {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->CBOFuncao = $oDados->cbofuncao;
            }
            if (!empty($oDados->acumcargo)) {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->acumCargo = $oDados->acumcargo;
            }
            if (!empty($oDados->codcateg)) {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->codCateg = $oDados->codcateg;
            }


            if (!empty($oDados->vrsalfx) && !empty($oDados->undsalfixo)) {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->remuneracao->vrSalFx = number_format($oDados->vrsalfx, 2, ".", "");
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->remuneracao->undSalFixo = $oDados->undsalfixo;
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->remuneracao->dscSalVar = empty($oDados->dscsalvar) ? null : $oDados->dscsalvar;
            } else {
                //unset($oDadosAPI->evtAdmissao->vinculo->infoContrato->remuneracao);
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->remuneracao = null;
            }

            $oDadosAPI->evtAdmissao->vinculo->infoContrato->duracao = null;
            if ($oDados->tpregtrab != 2) {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->duracao->tpContr = $oDados->tpcontr;
                //$oDadosAPI->evtAdmissao->vinculo->infoContrato->duracao->dtTerm = empty($oDados->dtterm) ? null : $oDados->dtterm;
                //$oDadosAPI->evtAdmissao->vinculo->infoContrato->duracao->clauAssec = empty($oDados->clauassec) ? null : $oDados->clauassec;
                //$oDadosAPI->evtAdmissao->vinculo->infoContrato->duracao->objDet = empty($oDados->objdet) ? null : $oDados->objdet;
            }

            if (!empty($oDados->tpinsc_localtrabgeral)) {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->localTrabGeral->tpInsc = $oDados->tpinsc_localtrabgeral;
            }
            if (!empty($oDados->nrinsc_localtrabgeral)) {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->localTrabGeral->nrInsc = $oDados->nrinsc_localtrabgeral;
            }
            if (!empty($oDados->desccomp_localtrabgeral)) {
                $oDadosAPI->evtAdmissao->vinculo->infoContrato->localTrabGeral->descComp = $oDados->desccomp_localtrabgeral;
            }

            //$oDadosAPI->evtAdmissao->vinculo->infoContrato->localTrabDom = empty($oDados->localtrabdom) ? null : $oDados->localtrabdom;

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
    private function buscarDependentes($matricula, $tpRegPrev)
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
            if ($tpRegPrev == 2) {
                $oDependFormatado->sexodep = ($oDependentes->rh31_sexo == "M" ? "M" : "F");
            }
            $oDependFormatado->inctrab = ($oDependentes->rh31_especi == "C" || $oDependentes->rh31_especi == "S" ? "S" : "N");

            $aDependentes[] = $oDependFormatado;
        }
        return $aDependentes;
    }


    /**
     * Retorna dados dos horario no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarHorarios($matricula)
    {
        $aHorarios = array();
        $oDaoJornada = \db_utils::getDao("jornada");
        $rsHorarios = db_query($oDaoJornada->sqlQueryHorario($matricula));
        if (pg_num_rows($rsHorarios) == 0) {
            return null;
        }
        for ($iCont = 0; $iCont < pg_num_rows($rsHorarios); $iCont++) {
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
    private function buscarAfastamentos($matricula)
    {
        $acodMotAfastEsocial = array(
            'O1' => '01',
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
            'X' => '21'
        );

        $acodMotAfastEcidade = array('O1', 'O2', 'O3', 'P1', 'P2', 'Q1', 'Q2', 'Q3', 'Q4', 'Q5', 'Q6', 'R', 'U3', 'W', 'X');
        $aAfastamentos = array();
        $oDaoAfasta = \db_utils::getDao("afasta");
        $rsAfastamentos = db_query($oDaoAfasta->sql_query_file(null, "*", null, "r45_regist = {$matricula} AND r45_codafa IN ('" . implode("','", $acodMotAfastEcidade) . "')"));
        if (pg_num_rows($rsAfastamentos) == 0) {
            return null;
        }
        for ($iCont = 0; $iCont < pg_num_rows($rsAfastamentos); $iCont++) {
            $oAfastamentoFormatado = new \stdClass;
            $oAfastamento = \db_utils::fieldsMemory($rsAfastamentos, $iCont);
            $oAfastamentoFormatado->dtIniAfast = $oAfastamento->r45_dtafas;
            $oAfastamentoFormatado->codMotAfast = $acodMotAfastEsocial[$oAfastamento->r45_codafa];
            $aAfastamentos[] = $oAfastamentoFormatado;
        }
        return $aAfastamentos;
    }
}
