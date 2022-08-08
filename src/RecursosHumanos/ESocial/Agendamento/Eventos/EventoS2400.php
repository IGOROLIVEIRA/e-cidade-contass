<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S2400 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS2400 extends EventoBase
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

            $oDadosAPI                                   = new \stdClass;
            $oDadosAPI->evtCdBenPrRP                    = new \stdClass;
            $oDadosAPI->evtCdBenPrRP->sequencial = $iSequencial;
            $oDadosAPI->evtCdBenPrRP->indretif   = 1;
            $oDadosAPI->evtCdBenPrRP->nrrecibo   = null;
            $oDadosAPI->evtCdBenPrRP->cpfbenef = $oDados->beneficiario->cpfBenef;
            $oDadosAPI->evtCdBenPrRP->nmbenefic = $oDados->beneficiario->nmBenefic;
            $oDadosAPI->evtCdBenPrRP->dtnascto = $oDados->beneficiario->dtNascto;
            $oDadosAPI->evtCdBenPrRP->dtinicio = $oDados->beneficiario->dtInicio;
            $oDadosAPI->evtCdBenPrRP->sexo = $oDados->beneficiario->sexo;
            $oDadosAPI->evtCdBenPrRP->racacor = $oDados->beneficiario->racaCor;
            $oDadosAPI->evtCdBenPrRP->estciv = $oDados->beneficiario->estCiv;
            $oDadosAPI->evtCdBenPrRP->incfismen = $oDados->beneficiario->incFisMen;
            $oDadosAPI->evtCdBenPrRP->incfismen = $oDados->beneficiario->incFisMen;
            $oDadosAPI->evtCdBenPrRP->dtincfismen = $oDados->beneficiario->incFisMen == 'S' ? $oDados->beneficiario->dtIncFisMen : null;

            $oDadosAPI->evtCdBenPrRP->endereco->brasil->tplograd = $oDados->brasil->tpLograd;
            $oDadosAPI->evtCdBenPrRP->endereco->brasil->dsclograd = $oDados->brasil->dscLograd;
            $oDadosAPI->evtCdBenPrRP->endereco->brasil->nrlograd = $oDados->brasil->nrLograd ?: 0;
            $oDadosAPI->evtCdBenPrRP->endereco->brasil->bairro = $oDados->brasil->bairro;
            $oDadosAPI->evtCdBenPrRP->endereco->brasil->cep = $oDados->brasil->cep;
            $oDadosAPI->evtCdBenPrRP->endereco->brasil->codMunic = $oDados->brasil->codMunic;
            $oDadosAPI->evtCdBenPrRP->endereco->brasil->uf = $oDados->brasil->uf;

            $oDadosAPI->evtCdBenPrRP->endereco->exterior = null;
            
            $oDadosAPI->evtCdBenPrRP->dependente = $this->buscarDependentes($oDados->beneficiario->cpfBenef);

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
