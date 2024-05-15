<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;
use ECidade\RecursosHumanos\ESocial\Model\Formulario\EventoCargaS2400;

/**
 * Classe responsável por montar as informações do evento S2400 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS2400 extends EventoBase
{

    private $eventoCarga;

    /**
     *
     * @param \stdClass $dados
     */
    public function __construct($dados)
    {
        parent::__construct($dados);
        $this->eventoCarga = new EventoCargaS2400();
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
            $oDadosAPI->evtCdBenefIn                    = new \stdClass;
            $oDadosAPI->evtCdBenefIn->sequencial = $iSequencial;
            $oDadosAPI->evtCdBenefIn->indretif   = 1;
            $oDadosAPI->evtCdBenefIn->nrrecibo   = null;
            $oDadosAPI->evtCdBenefIn->cpfbenef = $oDados->cpfbenef;
            $oDadosAPI->evtCdBenefIn->nmbenefic = $oDados->nmbenefic;
            $oDadosAPI->evtCdBenefIn->dtnascto = $oDados->dtnascto;
            $oDadosAPI->evtCdBenefIn->dtinicio = $oDados->dtinicio;
            $oDadosAPI->evtCdBenefIn->sexo = $oDados->sexo;
            $oDadosAPI->evtCdBenefIn->racacor = $oDados->racacor;
            $oDadosAPI->evtCdBenefIn->estciv = $oDados->estciv;
            $oDadosAPI->evtCdBenefIn->incfismen = $oDados->incfismen;
            $oDadosAPI->evtCdBenefIn->dtincfismen = $oDados->incfismen == 'S' ? $oDados->dtincfismen : null;

            $oDadosAPI->evtCdBenefIn->endereco->brasil->tplograd = $oDados->tplograd;
            $oDadosAPI->evtCdBenefIn->endereco->brasil->dsclograd = $oDados->dsclograd;
            $oDadosAPI->evtCdBenefIn->endereco->brasil->nrlograd = $oDados->nrlograd ?: 0;
            $oDadosAPI->evtCdBenefIn->endereco->brasil->bairro = $oDados->bairro;
            $oDadosAPI->evtCdBenefIn->endereco->brasil->cep = $oDados->cep;
            $oDadosAPI->evtCdBenefIn->endereco->brasil->codMunic = $oDados->codmunic;
            $oDadosAPI->evtCdBenefIn->endereco->brasil->uf = $oDados->uf;
            $oDadosAPI->evtCdBenefIn->endereco->brasil->complemento = empty($oDados->complemento) ? null : $oDados->complemento;
            $oDadosAPI->evtCdBenefIn->endereco->brasil->tpLograd = empty($oDados->tplograd) ? null : $oDados->tplograd;

            $oDadosAPI->evtCdBenefIn->endereco->exterior = null;

            $oDadosAPI->evtCdBenefIn->dependente = $this->buscarDependentes($oDados->cpfbenef);

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
    private function buscarDependentes($cpf)
    {

        $oDaorhdepend = \db_utils::getDao("rhdepend");
        $sqlDependentes = $oDaorhdepend->sql_query(null, "*", "rh31_codigo", "z01_cgccpf = '{$cpf}' and rh02_instit = " . db_getsession("DB_instit"));

        $rsDependentes = db_query($sqlDependentes);

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
            $oDependFormatado->sexodep = $oDependentes->rh31_sexo;
            $oDependFormatado->depirrf = ($oDependentes->rh31_irf == "0" ? "N" : "S");
            $oDependFormatado->incfismen = ($oDependentes->rh31_especi == "C" || $oDependentes->rh31_especi == "S" ? "S" : "N");

            $aDependentes[] = $oDependFormatado;
        }
        return empty($aDependentes) ? null : $aDependentes;
    }
}
