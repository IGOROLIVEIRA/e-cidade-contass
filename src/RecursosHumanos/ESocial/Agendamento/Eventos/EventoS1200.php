<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use DBPessoal;
use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S2200 Esocial
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

            if (strlen($oDados->indmv) > 0) {
                $oDadosAPI->evtRemun->infomv->indmv       = $oDados->indmv;

                $oRemunoutrempr = new \stdClass;
                $oRemunoutrempr->tpinsc      = 1;
                $oRemunoutrempr->nrinsc      = $oDados->nrinsc;
                $oRemunoutrempr->codcateg    = $oDados->codcateg;
                if (strlen($oDados->vlrremunoe) > 0) {
                    $oRemunoutrempr->vlrremunoe  = $oDados->vlrremunoe;
                }
                $aRemunoutrempr[] = $oRemunoutrempr;

                $oDadosAPI->evtRemun->infomv->remunoutrempr = $aRemunoutrempr;
            }

            // $oDmdev = new \stdClass;
            // $oDmdev->idedmdev  = $this->buscarIdentificador($oDados->matricula);

            // $oDmdev->codcateg  = $oDados->codcateg;

            // $oIdeestablot = new \stdClass;
            // $oIdeestablot->tpinsc = 1;
            // $oIdeestablot->nrinsc = $oDados->nrinsc;
            // $oIdeestablot->codlotacao = 'LOTA1';

            // $oRemunperapur = new \stdClass;
            // $oRemunperapur->matricula = $oDados->matricula;

            // $oRemunperapur->itensremun = $this->buscarValorRubrica($oDados->matricula);

            // $aRemunperapur[] = $oRemunperapur;

            // $oIdeestablot->remunperapur = $aRemunperapur;

            // $aIdeestablot[] = $oIdeestablot;

            // $oDmdev->infoperapur->ideestablot = $aIdeestablot;

            // if (!empty($oDados->grauExp)) {
            //     $oDmdev->infoperapur->ideestablot->remunperapur->infoagnocivo->grauexp = $oDados->grauExp;
            // }

            // $aDmdev[] = $oDmdev;




            $std = new \stdClass();

            //Identifica��o de cada um dos demonstrativos de valores devidos ao trabalhador.
            $std->dmdev[0] = new \stdClass(); //Obrigat�rio
            $std->dmdev[0]->idedmdev = $this->buscarIdentificador($oDados->matricula); //Obrigat�rio
            $std->dmdev[0]->codcateg = $oDados->codcateg; //Obrigat�rio

            //Identifica��o do estabelecimento e da lota��o nos quais o
            //trabalhador possui remunera��o no per�odo de apura��o
            $std->dmdev[0]->ideestablot[0] = new \stdClass(); //Opcional
            $std->dmdev[0]->ideestablot[0]->tpinsc = "1"; //Obrigat�rio
            $std->dmdev[0]->ideestablot[0]->nrinsc = $oDados->nrinsc; //Obrigat�rio
            $std->dmdev[0]->ideestablot[0]->codlotacao = 'LOTA1'; //Obrigat�rio
            //$std->dmdev[0]->ideestablot[0]->qtddiasav = 20; //Opcional

            //Informa��es relativas � remunera��o do trabalhador no per�odo de apura��o.
            $std->dmdev[0]->ideestablot[0]->remunperapur[0] = new \stdClass(); //Obrigat�rio
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->matricula = $oDados->matricula; //Opcional
            //$std->dmdev[0]->ideestablot[0]->remunperapur[0]->indsimples = 1; //Opcional

            //Rubricas que comp�em a remunera��o do trabalhador.
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun = $this->buscarValorRubrica($oDados->matricula);
            // $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[0]->codrubr = 'ksksksks'; //Obrigat�rio
            // $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[0]->idetabrubr = 'j2j2j'; //Obrigat�rio
            // $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[0]->qtdrubr = 150.30; //Opcional
            // $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[0]->fatorrubr = 1.20; //Opcional
            // $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[0]->vrunit = 123.90; //Obrigat�rio
            // $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[0]->vrrubr = 123.90; //Obrigat�rio
            // $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[0]->indapurir = 0; //Opcional

            //Grupo referente ao detalhamento do grau de exposi��o do trabalhador aos agentes nocivos que ensejam a cobran�a
            //da contribui��o adicional para financiamento dos benef�cios de aposentadoria especial.
            //$std->dmdev[0]->ideestablot[0]->remunperapur[0]->infoagnocivo = new \stdClass(); //Opcional
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->infoagnocivo->grauexp = $oDados->grauexp; //Obrigat�rio

            $oDadosAPI->evtRemun->dmdev = $std->dmdev;

            //$oDadosAPI->evtRemun->dtAlteracao         = '2021-01-29'; //$oDados->altContratual->dtAlteracao;
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
                        case
                        when '{$arquivo}' = 'gerfsal' then 1
                        when '{$arquivo}' = 'gerfcom' then 3
                        when '{$arquivo}' = 'gerfs13' then 4
                        end as ideDmDev
                        from {$arquivo}
                        where " . $sigla . "anousu = '" . $iAnoUsu . "'
                        and  " . $sigla . "mesusu = '" . $iMesusu . "'
                        and  " . $sigla . "instit = " . db_getsession("DB_instit") . "
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
                        {$sigla}rubric as rubrica
                        from {$arquivo}
                        where " . $sigla . "anousu = '" . $iAnoUsu . "'
                        and  " . $sigla . "mesusu = '" . $iMesusu . "'
                        and  " . $sigla . "instit = " . db_getsession("DB_instit") . "
                        and  " . $sigla . "mesusu = '" . $iMesusu . "'
                        and  " . $sigla . "pd <> 3
                        and  " . $sigla . "rubric not in ('R985','R993','R981')
                        and {$sigla}regist = $matricula";
            }
            // echo $sql;
            // db_criatabela($rsValores);
            // exit;

            $rsValores = db_query($sql);

            for ($iCont = 0; $iCont < pg_num_rows($rsValores); $iCont++) {
                $oResult = \db_utils::fieldsMemory($rsValores, $iCont);
                $oFormatado = new \stdClass;
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
