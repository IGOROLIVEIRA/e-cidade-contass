<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use DBPessoal;
use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsÃ¡vel por montar as informaÃ§Ãµes do evento S1202 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1202 extends EventoBase
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
        $iSequencial = 1;
        foreach ($this->dados as $oDados) {
            $oDadosAPI                                   = new \stdClass();
            $oDadosAPI->evtEvtRmnRPPS                      = new \stdClass();
            $oDadosAPI->evtEvtRmnRPPS->sequencial          = $iSequencial;
            $oDadosAPI->evtEvtRmnRPPS->modo                = $this->modo;
            $oDadosAPI->evtEvtRmnRPPS->indRetif            = 1;
            $oDadosAPI->evtEvtRmnRPPS->nrRecibo            = null;

            $oDadosAPI->evtEvtRmnRPPS->indapuracao         = $this->indapuracao;
            $oDadosAPI->evtEvtRmnRPPS->perapur             = date('Y-m');
            if ($oDados->indapuracao == 2) {
                $oDadosAPI->evtEvtRmnRPPS->perapur         = date('Y');
            }
            $oDadosAPI->evtEvtRmnRPPS->cpftrab             = $oDados->cpftrab;

            $oIdeestab = new \stdClass();
            $oIdeestab->idedmdev  = $this->buscarIdentificador($oDados->matricula);
            $oIdeestab->idedmdev  = $oIdeestab->codcateg;
            $oIdeestab->remumperant->matricula   = $oDados->matricula;
            $oIdeestab->remumperant->itensremun  = $this->buscarValorRubrica($oDados->matricula);

            $oDadosAPI->evtEvtRmnRPPS->dmdev->idedmdev  = $this->buscarIdentificador($oDados->matricula);

            $oIdeestab->tpinsc = 1;
            $oIdeestab->nrinsc = $oDados->nrinsc;

            $aIdeestab[] = $oIdeestab;
            $oDadosAPI->evtEvtRmnRPPS->dmdev->infoperant->ideperiodo = $aIdeestab;

            //$oDadosAPI->evtEvtRmnRPPS->dtAlteracao         = '2021-01-29'; //$oDados->altContratual->dtAlteracao;
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
    private function buscarIdentificador($matricula)
    {
        $iAnoUsu           = db_getsession('DB_anousu');
        $iMesusu           = DBPessoal::getMesFolha();
        $aPontos = array('salario', 'complementar', '13salario');
        $aIdentificadores = array();
        foreach ($aPontos as $opcao) {
            switch ($opcao) {
                case 'salario':
                    $sigla          = 'r14_';
                    $arquivo        = 'gerfsal';
                    $sTituloCalculo = 'Salário';
                    break;

                case 'complementar':
                    $sigla          = 'r48_';
                    $arquivo        = 'gerfcom';
                    $sTituloCalculo = 'Complementar';
                    break;

                case '13salario':
                    $sigla          = 'r35_';
                    $arquivo        = 'gerfs13';
                    $sTituloCalculo = '13? Sal?rio';
                    break;

                default:
                    continue;
                    break;
            }
            if ($opcao) {
                $sql = "  select distinct
                        case
                        when '{$arquivo}' = 'gerfsal' then 1
                        when '{$arquivo}' = 'gerfcom' then 3
                        when '{$arquivo}' = 'gerfs13' then 4
                        end as ideDmDev
                        from {$arquivo}
                        where " . $sigla . "anousu = '" . $iAnoUsu . "'
                        and  " . $sigla . "mesusu = '" . $iMesusu . "'
                        and  " . $sigla . "instit = " . db_getsession("DB_instit") . "
                        and  " . $sigla . "pd <> 3
                        and  " . $sigla . "rubric not in ('R985','R993','R981')
                        and {$sigla}regist = $matricula";
            }

            $rsIdentificadores = db_query($sql);
            if ($rsIdentificadores) {
                $oIdentificadores = \db_utils::fieldsMemory($rsIdentificadores, 0);
                // if (!empty($oIdentificadores->idedmdev)) {
                //     $aIdentificadores[] = $oIdentificadores->idedmdev;
                // }
                return $oIdentificadores->idedmdev;
            }
        }
        //return $aIdentificadores;
    }

    private function buscarValorRubrica($matricula)
    {
        $iAnoUsu           = db_getsession('DB_anousu');
        $iMesusu           = DBPessoal::getMesFolha();
        $aPontos = array('salario', 'complementar', '13salario');
        $aIdentificadores = array();
        foreach ($aPontos as $opcao) {
            switch ($opcao) {
                case 'salario':
                    $sigla          = 'r14_';
                    $arquivo        = 'gerfsal';
                    $sTituloCalculo = 'Salário';
                    break;

                case 'complementar':
                    $sigla          = 'r48_';
                    $arquivo        = 'gerfcom';
                    $sTituloCalculo = 'Complementar';
                    break;

                case '13salario':
                    $sigla          = 'r35_';
                    $arquivo        = 'gerfs13';
                    $sTituloCalculo = '13? Sal?rio';
                    break;

                default:
                    continue;
                    break;
            }
            if ($opcao) {
                $sql = "  select distinct
                        {$sigla}valor as valor,
                        {$sigla}rubric as rubrica
                        from {$arquivo}
                        where " . $sigla . "anousu = '" . $iAnoUsu . "'
                        and  " . $sigla . "mesusu = '" . $iMesusu . "'
                        and  " . $sigla . "instit = " . db_getsession("DB_instit") . "
                        and {$sigla}regist = $matricula
                        and not exists (select 1 from rhrubricas where rh27_rubric = {$sigla}rubric and rh27_pd = 3)";
            }

            $rsValores = db_query($sql);
            // echo $sql;
            // db_criatabela($rsValores);
            // exit;
            for ($iCont = 0; $iCont < pg_num_rows($rsValores); $iCont++) {
                $oResult = \db_utils::fieldsMemory($rsValores, $iCont);
                $oFormatado = new \stdClass();
                $oFormatado->codrubr    = $oResult->rubrica;
                $oFormatado->idetabrubr = 'tabrub1';
                $oFormatado->vrrubr     = $oResult->valor;
                $oFormatado->indapurir  = 0;

                $aItens[] = $oFormatado;
            }
        }
        return $aItens;
    }
}
