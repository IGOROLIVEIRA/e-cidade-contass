<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use DBPessoal;
use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S1202 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Marcelo Hernane
 */
class EventoS1210 extends EventoBase
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
            $oDadosAPI                                = new \stdClass();
            $oDadosAPI->evtPgtos                      = new \stdClass();
            $oDadosAPI->evtPgtos->sequencial          = $iSequencial;
            $oDadosAPI->evtPgtos->modo                = $this->modo;
            $oDadosAPI->evtPgtos->indRetif            = 1;
            $oDadosAPI->evtPgtos->nrRecibo            = null;

            $oDadosAPI->evtPgtos->indapuracao         = $this->indapuracao;
            $oDadosAPI->evtPgtos->perapur             = date('Y-m');
            if ($oDados->indapuracao == 2) {
                $oDadosAPI->evtPgtos->perapur         = date('Y');
            }
            $oDadosAPI->evtPgtos->cpfbenef             = $oDados->cpftrab;

            $oDadosAPI->evtPgtos->infopgto  = $this->buscarInfopgto($oDados->matricula, $oDados->indapuracao);

            //$oDadosAPI->evtPgtos->dtAlteracao         = '2021-01-29'; //$oDados->altContratual->dtAlteracao;
            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
        // echo '<pre>';
        // print_r($aDadosAPI);
        // exit;
        return $aDadosAPI;
    }

    private function buscarInfopgto($matricula, $indapuracao)
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
                    $sTituloCalculo = 'Sal�rio';
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
                        case
                        when '{$arquivo}' = 'gerfsal' then 1
                        when '{$arquivo}' = 'gerfcom' then 3
                        when '{$arquivo}' = 'gerfs13' then 4
                        end as ideDmDev
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

                $oFormatado->dtpgto    = date('Y-m');
                if ($indapuracao == 2) {
                    $oFormatado->dtpgto = date('Y');
                }
                $oFormatado->tppgto     = $this->tppgto;
                $oFormatado->perref    = date('Y-m');
                if ($indapuracao == 2) {
                    $oFormatado->perref = date('Y');
                }
                $oFormatado->idedmdev = $oResult->idedmdev;
                $oFormatado->vrliq     = $oResult->valor;

                $aItens[] = $oFormatado;
            }
        }
        return $aItens;
    }
}
