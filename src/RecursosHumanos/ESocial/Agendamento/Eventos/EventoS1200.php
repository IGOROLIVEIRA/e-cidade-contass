<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use DBPessoal;
use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsÃ¡vel por montar as informaÃ§Ãµes do evento S2200 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Robson de Jesus
 */
class EventoS1200 extends EventoBase
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
            $oDadosAPI                                   = new \stdClass;
            $oDadosAPI->evtRemun                      = new \stdClass;
            $oDadosAPI->evtRemun->sequencial          = $iSequencial;
            $oDadosAPI->evtRemun->modo                = $this->modo;
            $oDadosAPI->evtRemun->indRetif            = 1;
            $oDadosAPI->evtRemun->nrRecibo            = null;

            $oDadosAPI->evtRemun->indapuracao         = $this->indapuracao;
            $oDadosAPI->evtRemun->perapur             = date('Y-m');
            if ($oDados->indapuracao == 2) {
                $oDadosAPI->evtRemun->perapur         = date('Y');
            }
            $oDadosAPI->evtRemun->cpftrab             = $oDados->cpftrab;
            $oDadosAPI->evtRemun->infomv->indmv       = $oDados->indmv;
            $oDadosAPI->evtRemun->infomv->remunoutrempr->tpinsc = 1;
            $oDadosAPI->evtRemun->infomv->remunoutrempr->nrinsc  = $oDados->cgc;
            $oDadosAPI->evtRemun->infomv->remunoutrempr->codcateg  = $oDados->codcateg;
            $oDadosAPI->evtRemun->infomv->remunoutrempr->vlrremunoe  = $oDados->vlrremunoe;

            $oDadosAPI->evtRemun->dmdev->idedmdev  = $this->buscarIdentificador($oDados->matricula);
            $oDadosAPI->evtRemun->dmdev->codcateg  = $oDados->codcateg;

            $oDadosAPI->evtRemun->dmdev->remunperapur->matricula   = $oDados->matricula;

            $oDadosAPI->evtRemun->dmdev->remunperapur->itensremun->codrubr     =
            $oDadosAPI->evtRemun->dmdev->remunperapur->itensremun->idetabrubr  = 'tabrub1';
            $oDadosAPI->evtRemun->dmdev->remunperapur->itensremun->vrrubr      = $this->buscarValorRubrica($oDados->matricula);
            $oDadosAPI->evtRemun->dmdev->remunperapur->itensremun->indapurir   = 0;

            if (!empty($oDados->grauExp)) {
                $oDadosAPI->evtRemun->dmdev->remunperapur->infoagnocivo->grauexp = $oDados->grauExp;
            }
            //$oDadosAPI->evtRemun->dtAlteracao         = '2021-01-29'; //$oDados->altContratual->dtAlteracao;
        }

        $aDadosAPI[] = $oDadosAPI;
        $iSequencial++;

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
        $aPontos = array('salario','complementar','13salario');
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
                        where ".$sigla."anousu = '".$iAnoUsu."'
                        and  ".$sigla."mesusu = '".$iMesusu."'
                        and  ".$sigla."instit = ".db_getsession("DB_instit")."
                        and {$sigla}regist = $matricula";
            }

            $rsIdentificadores = db_query($sql);
            if ($rsIdentificadores) {
                $oIdentificadores = \db_utils::fieldsMemory($rsIdentificadores, 0);
                if (!empty($oIdentificadores->idedmdev)) {
                    $aIdentificadores[] = $oIdentificadores->idedmdev;
                }
            }
        }
        return $aIdentificadores;
    }

    private function buscarValorRubrica($matricula)
    {
        $iAnoUsu           = db_getsession('DB_anousu');
        $iMesusu           = DBPessoal::getMesFolha();
        $aPontos = array('salario','complementar','13salario');
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
                        {$sigla}valor as valor
                        from {$arquivo}
                        where ".$sigla."anousu = '".$iAnoUsu."'
                        and  ".$sigla."mesusu = '".$iMesusu."'
                        and  ".$sigla."instit = ".db_getsession("DB_instit")."
                        and {$sigla}regist = $matricula";
            }

            $rsValores = db_query($sql);
            for ($iCont = 0; $iCont < pg_num_rows($rsValores); $iCont++) {
                $oValor = \db_utils::fieldsMemory($rsValores, $iCont);
                $aValor[] = $oValor->valor;
            }
        }
        return $aValor;
    }
}
