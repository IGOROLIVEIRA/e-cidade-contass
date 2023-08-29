<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use cl_rubricasesocial;
use db_utils;
use DBPessoal;
use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsável por montar as informações do evento S2399 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Marcelo Hernane
 */
class EventoS2399 extends EventoBase
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
        //exit(var_dump($this->dados));
        $aDadosAPI = array();
        $iSequencial = 1;
        foreach ($this->dados as $oDados) {

            $oDadosAPI                                    = new \stdClass;
            $oDadosAPI->evtTSVTermino                     = new \stdClass;
            $oDadosAPI->evtTSVTermino->sequencial          = $iSequencial;
            $oDadosAPI->evtTSVTermino->indRetif            = 1;
            $oDadosAPI->evtTSVTermino->nrRecibo            = null;
            $oDadosAPI->evtTSVTermino->cpfTrab             = $oDados->cpftrab;
            $oDadosAPI->evtTSVTermino->matricula           = $oDados->matricula;
            //$oDadosAPI->evtTSVTermino->codcateg          = ;
            $oDadosAPI->evtTSVTermino->dtTerm              = $oDados->rh05_recis;
            //$oDadosAPI->evtTSVTermino->mtvdesligtsv      = ;
            $oDadosAPI->evtTSVTermino->pensalim            = 0;
            //$oDadosAPI->evtTSVTermino->percaliment       = ;
            //$oDadosAPI->evtTSVTermino->vralim            = ;
            //$oDadosAPI->evtTSVTermino->nrproctrab        = ;
            //$oDadosAPI->novocpf                          = ;
            
            $std = $this->dmDevRH($oDados);

            if ($std->verbasresc->dmdev == null)
                continue;

            $oDadosAPI->evtTSVTermino->dmdev = $std->verbasresc->dmdev;

            $aDadosAPI[] = $oDadosAPI;
            $iSequencial++;
        }
        // echo '<pre>';
        // var_dump($aDadosAPI);exit;
        return $aDadosAPI;
    }

    private function dmDevRH($aDadosPorMatriculas)
    {
        $std = new \stdClass();
        $seqdmdev = 0;
        // for ($iCont = 0; $iCont < count($aDadosPorMatriculas); $iCont++) {
            $aIdentificador = $this->buscarIdentificador($aDadosPorMatriculas->matricula, $aDadosPorMatriculas->rh30_regime);

            for ($iCont2 = 0; $iCont2 < count($aIdentificador); $iCont2++) {
                $std->verbasresc->dmdev[$seqdmdev] = new \stdClass();
                
                if ($aIdentificador[$iCont2]->idedmdev == 1) {
                    $std->verbasresc->dmdev[$seqdmdev]->idedmdev = $aDadosPorMatriculas->matricula . 'gerfsal';
                }
                if ($aIdentificador[$iCont2]->idedmdev == 2) {
                    $std->verbasresc->dmdev[$seqdmdev]->idedmdev = $aDadosPorMatriculas->matricula . 'gerfres';
                }
                if ($aIdentificador[$iCont2]->idedmdev == 3) {
                    $std->verbasresc->dmdev[$seqdmdev]->idedmdev = $aDadosPorMatriculas->matricula . 'gerfcom';
                }
                if ($aIdentificador[$iCont2]->idedmdev == 4) {
                    $std->verbasresc->dmdev[$seqdmdev]->idedmdev = $aDadosPorMatriculas->matricula . 'gerfs13';
                }
                //$std->verbasresc->dmdev[$seqdmdev]->codcateg = $aDadosPorMatriculas->codcateg;

                $std->verbasresc->dmdev[$seqdmdev]->ideestablot[0] = new \stdClass();
                $std->verbasresc->dmdev[$seqdmdev]->ideestablot[0]->tpinsc = "1";
                $std->verbasresc->dmdev[$seqdmdev]->ideestablot[0]->nrinsc = $aDadosPorMatriculas->nrinsc;
                $std->verbasresc->dmdev[$seqdmdev]->ideestablot[0]->codlotacao = $aDadosPorMatriculas->codlotacao;

                $aDadosValoreRubrica = $this->buscarValorRubrica($aDadosPorMatriculas->matricula, $aDadosPorMatriculas->rh30_regime, $aIdentificador[$iCont2]->idedmdev);

                if (count($aDadosValoreRubrica) == 0) {
                    continue;
                }

                for ($iCont4 = 0; $iCont4 < count($aDadosValoreRubrica); $iCont4++) {
                    $std->verbasresc->dmdev[$seqdmdev]->ideestablot[0]->detverbas[$iCont4] = new \stdClass(); 
                    $std->verbasresc->dmdev[$seqdmdev]->ideestablot[0]->detverbas[$iCont4]->codrubr = $aDadosValoreRubrica[$iCont4]->codrubr; 
                    $std->verbasresc->dmdev[$seqdmdev]->ideestablot[0]->detverbas[$iCont4]->idetabrubr = 'TABRUB1';//$aDadosValoreRubrica[$iCont4]->idetabrubr; 
                    //$std->verbasresc->dmdev[$seqdmdev]->ideestablot[0]->detverbas[$iCont4]->vrunit = $aDadosValoreRubrica[$iCont4]->vrrubr; 
                    $std->verbasresc->dmdev[$seqdmdev]->ideestablot[0]->detverbas[$iCont4]->vrrubr = $aDadosValoreRubrica[$iCont4]->vrrubr; 
                    $std->verbasresc->dmdev[$seqdmdev]->ideestablot[0]->detverbas[$iCont4]->indapurir = 0;//$aDadosValoreRubrica[$iCont4]->indapurir; 
                }

                $seqdmdev++;
            }
        // }

            $std->verbasresc->infomv = new \stdClass();
            $std->verbasresc->infomv->indmv = $aDadosPorMatriculas->indmv;

            $std->verbasresc->infomv->remunoutrempr[1] = new \stdClass();
            $std->verbasresc->infomv->remunoutrempr[1]->tpinsc = 1;
            $std->verbasresc->infomv->remunoutrempr[1]->nrinsc = $aDadosPorMatriculas->nrInscremunOutrEmpr;
            $std->verbasresc->infomv->remunoutrempr[1]->codcateg = $aDadosPorMatriculas->rh51_categoria;
            $std->verbasresc->infomv->remunoutrempr[1]->vlrremunoe = $aDadosPorMatriculas->rh51_basefo;

        return $std;
    }

    private function buscarIdentificador($matricula, $rh30_regime)
    {
        $iAnoUsu = date("Y", db_getsession("DB_datausu"));
        $iMesusu = date("m", db_getsession("DB_datausu"));
        if ($rh30_regime == 1 || $rh30_regime == 3) {
            $aPontos = array('13salario');
            if ($this->indapuracao != 2)
                $aPontos = array('salario', 'complementar', 'rescisao');
        } else {
            $aPontos = array('13salario');
            if ($this->indapuracao != 2)
                $aPontos = array('salario', 'complementar');
        }

        foreach ($aPontos as $opcao) {
            switch ($opcao) {
                case 'salario':
                    $sigla          = 'r14_';
                    $arquivo        = 'gerfsal';
                    break;

                case 'complementar':
                    $sigla          = 'r48_';
                    $arquivo        = 'gerfcom';
                    break;

                case '13salario':
                    $sigla          = 'r35_';
                    $arquivo        = 'gerfs13';
                    break;

                case 'rescisao':
                    $sigla          = 'r20_';
                    $arquivo        = 'gerfres';
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
                        when '{$arquivo}' = 'gerfres' then 2
                        end as ideDmDev
                        from {$arquivo}
                        where " . $sigla . "anousu = '" . $iAnoUsu . "'
                        and  " . $sigla . "mesusu = '" . $iMesusu . "'
                        and  " . $sigla . "instit = " . db_getsession("DB_instit") . "
                        and {$sigla}regist = $matricula";
            }

            $rsIdentificadores = db_query($sql);
            // echo $sql;
            // db_criatabela($rsIdentificadores);
            // exit;
            if (pg_num_rows($rsIdentificadores) > 0) {
                for ($iCont = 0; $iCont < pg_num_rows($rsIdentificadores); $iCont++) {
                    $oIdentificadores = \db_utils::fieldsMemory($rsIdentificadores, $iCont);

                    $aItens[] = $oIdentificadores;
                }
            }
        }
        return $aItens;
    }

    /**
     * Retorna os valores por rubrica no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarValorRubrica($matricula, $rh30_regime, $ponto)
    {
        require_once 'libs/db_libpessoal.php';

        $clrubricasesocial = new cl_rubricasesocial;

        $iAnoUsu = date("Y", db_getsession("DB_datausu"));
        $iMesusu = date("m", db_getsession("DB_datausu"));
        $xtipo = "'x'";

        if ($ponto == 1)
            $opcao = 'salario';
        if ($ponto == 2)
            $opcao = 'rescisao';
        if ($ponto == 3)
            $opcao = 'complementar';
        if ($ponto == 4)
            $opcao = '13salario';

        switch ($opcao) {
            case 'salario':
                $sigla          = 'r14_';
                $arquivo        = 'gerfsal';
                $sTituloCalculo = 'Sal?rio';
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
            case 'rescisao':
                $sigla          = 'r20_';
                $arquivo        = 'gerfres';
                $xtipo          = ' r20_tpp ';
                $sTituloCalculo = 'Rescis?o';
                break;

            default:
                continue;
                break;
        }
        if ($opcao) {

            $sql = "  select '1' as ordem ,
                               {$sigla}rubric as rubrica,
                               case
                                 when rh27_pd = 3 then 0
                                 else case
                                        when {$sigla}pd = 1 then {$sigla}valor
                                        else 0
                                      end
                               end as Provento,
                               case
                                 when rh27_pd = 3 then 0
                                 else case
                                        when {$sigla}pd = 2 then {$sigla}valor
                                        else 0
                                      end
                               end as Desconto,
                               {$sigla}quant as quant,
                               rh27_descr,
                               {$xtipo} as tipo ,
                               case
                                 when rh27_pd = 3 then 'Base'
                                 else case
                                        when {$sigla}pd = 1 then 'Provento'
                                        else 'Desconto'
                                      end
                               end as provdesc,
                               case
                                when '{$arquivo}' = 'gerfsal' then 1
                                when '{$arquivo}' = 'gerfcom' then 3
                                when '{$arquivo}' = 'gerfs13' then 4
                                when '{$arquivo}' = 'gerfres' then 2
                                end as ideDmDev
                          from {$arquivo}
                               inner join rhrubricas on rh27_rubric = {$sigla}rubric
                                                    and rh27_instit = " . db_getsession("DB_instit") . "
                          " . bb_condicaosubpesproc($sigla, $iAnoUsu . "/" . $iMesusu) . "
                           and {$sigla}regist = $matricula
                           and {$sigla}pd != 3
                           and {$sigla}rubric not in ('R985','R993','R981')
                           order by {$sigla}pd,{$sigla}rubric";
        }
        $rsValores = db_query($sql);
        // echo $sql;
        // db_criatabela($rsValores);
        if ($opcao != 'rescisao') {
            for ($iCont = 0; $iCont < pg_num_rows($rsValores); $iCont++) {
                $oResult = \db_utils::fieldsMemory($rsValores, $iCont);
                $oFormatado = new \stdClass();
                $oFormatado->codrubr    = $oResult->rubrica;
                $oFormatado->idetabrubr = 'tabrub1';
                $oFormatado->vrrubr     = ($oResult->provdesc == 'Provento') ? $oResult->provento : $oResult->desconto;
                $oFormatado->indapurir  = 0;
                $oFormatado->idedmdev   = $oResult->idedmdev;

                $aItens[] = $oFormatado;
            }
        } else {
            for ($iCont2 = 0; $iCont2 < pg_num_rows($rsValores); $iCont2++) {
                $oResult = \db_utils::fieldsMemory($rsValores, $iCont2);
                $rsRubEspeciais = db_query($clrubricasesocial->sql_query(null, "e990_sequencial,e990_descricao", null, "baserubricasesocial.e991_rubricas = '{$oResult->rubrica}' AND e990_sequencial IN ('1000','5001','1020')"));
                $rubrica = $oResult->rubrica;
                if (pg_num_rows($rsRubEspeciais) > 0) {
                    $oRubEspeciais = db_utils::fieldsMemory($rsRubEspeciais);
                    switch ($oRubEspeciais->e990_sequencial) {
                        case '1000':
                            $rubrica = '9000';
                            $rh27_descr = 'Saldo de Sal?rio na Rescis?o';
                            break;
                        case '5001':
                            $rubrica = '9001';
                            $rh27_descr = '13? Sal?rio na Rescis?o';
                            break;
                        case '1020':
                            $rubrica = '9002';
                            $rh27_descr = 'F?rias Proporcional na Rescis?o';
                            break;
                        case '1020':
                            $rubrica = '9003';
                            $rh27_descr = 'F?rias Vencidas na Rescis?o';
                            break;

                        default:
                            break;
                    }
                }
                $oFormatado = new \stdClass();
                $oFormatado->codrubr    = $rubrica;
                $oFormatado->idetabrubr = 'tabrub1';
                $oFormatado->vrrubr     = ($oResult->provdesc == 'Provento') ? $oResult->provento : $oResult->desconto;
                $oFormatado->indapurir  = 0;
                $oFormatado->idedmdev   = $oResult->idedmdev;

                $aItens[] = $oFormatado;
            }
        }
        // echo '<pre>';
        // var_dump($aItens);exit;
        return $aItens;
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
