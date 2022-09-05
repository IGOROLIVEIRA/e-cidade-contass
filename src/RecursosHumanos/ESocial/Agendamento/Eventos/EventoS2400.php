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

            if (!empty($oDados->brasil) && empty($oDados->brasil->complemento)) {
                $oDados->brasil->complemento = null;
            }
            if (!empty($oDados->brasil) && empty($oDados->brasil->bairro)) {
                $oDados->brasil->bairro = null;
            }
            if (!empty($oDados->brasil) && empty($oDados->brasil->tpLograd)) {
                $oDados->brasil->tpLograd = null;
            }

            $oDadosAPI                                   = new \stdClass;
            $oDadosAPI->evtCdBenPrRP                    = new \stdClass;
            $oDadosAPI->evtCdBenPrRP->sequencial = $iSequencial;
            $oDadosAPI->evtCdBenPrRP->indretif   = 1;
            $oDadosAPI->evtCdBenPrRP->nrrecibo   = null;
            $oDadosAPI->evtCdBenPrRP->cpfbenef = $oDados->cpfbenef;
            $oDadosAPI->evtCdBenPrRP->nmbenefic = $oDados->nmbenefic;
            $oDadosAPI->evtCdBenPrRP->dtnascto = $oDados->dtnascto;
            $oDadosAPI->evtCdBenPrRP->dtinicio = $oDados->dtinicio;
            $oDadosAPI->evtCdBenPrRP->sexo = $oDados->sexo;
            $oDadosAPI->evtCdBenPrRP->racacor = $oDados->racacor;
            $oDadosAPI->evtCdBenPrRP->estciv = $oDados->estciv;
            $oDadosAPI->evtCdBenPrRP->incfismen = $oDados->incfismen;
            $oDadosAPI->evtCdBenPrRP->dtincfismen = $oDados->incfismen == 'S' ? $oDados->dtIncFisMen : null;

            $oDadosAPI->evtCdBenPrRP->endereco->brasil->tplograd = $oDados->tplograd;
            $oDadosAPI->evtCdBenPrRP->endereco->brasil->dsclograd = $oDados->dsclograd;
            $oDadosAPI->evtCdBenPrRP->endereco->brasil->nrlograd = $oDados->nrlograd ?: 0;
            $oDadosAPI->evtCdBenPrRP->endereco->brasil->bairro = $oDados->bairro;
            $oDadosAPI->evtCdBenPrRP->endereco->brasil->cep = $oDados->cep;
            $oDadosAPI->evtCdBenPrRP->endereco->brasil->codMunic = $oDados->codmunic;
            $oDadosAPI->evtCdBenPrRP->endereco->brasil->uf = $oDados->uf;

            $oDadosAPI->evtCdBenPrRP->endereco->exterior = null;

            $oDadosAPI->evtCdBenPrRP->dependente = $this->buscarDependentes($oDados->cpfbenef);

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
        // var_dump($aDadosAPI);
        // exit;
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
        $sqlDependentes = $oDaorhdepend->sql_query_file(null, "*", "rh31_codigo", "rh31_regist = (SELECT rh01_regist FROM cgm JOIN rhpessoal ON z01_numcgm = rh01_numcgm WHERE z01_cgccpf = '{$cpf}' LIMIT 1)");
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
        return $aDependentes;
    }
}
