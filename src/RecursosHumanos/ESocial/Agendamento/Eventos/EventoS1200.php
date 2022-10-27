<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use cl_rubricasesocial;
use db_utils;
use DBPessoal;
use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsÃ¡vel por montar as informaÃ§Ãµes do evento S1200 Esocial
 *
 * @package  ECidade\RecursosHumanos\ESocial\Agendamento\Eventos
 * @author   Marcelo Hernane
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
        $ano = date("Y", db_getsession("DB_datausu"));
        $mes = date("m", db_getsession("DB_datausu"));
        $data = "$ano-$mes-01";
        $data = new \DateTime($data);
        $data->modify('last day of this month');
        $ultimoDiaDoMes = $data->format('d');

        $aDadosAPI = array();
        $iSequencial = 1;
        foreach ($this->dados as $oDados) {

            if ($this->tpevento == 1) {
                $aDadosPorMatriculas = $this->buscarDadosPorMatricula($oDados->z01_cgccpf);

                if ($aDadosPorMatriculas[0]->cpftrab == null) {
                    continue;
                }

                $oDadosAPI                                = new \stdClass();
                $oDadosAPI->evtRemun                      = new \stdClass();
                $oDadosAPI->evtRemun->sequencial          = $iSequencial;
                $oDadosAPI->evtRemun->modo                = $this->modo;
                $oDadosAPI->evtRemun->indRetif            = 1;
                $oDadosAPI->evtRemun->nrRecibo            = null;

                $oDadosAPI->evtRemun->indapuracao         = $this->indapuracao;
                $oDadosAPI->evtRemun->perapur             = $ano . '-' . $mes;
                if ($this->indapuracao == 2) {
                    $oDadosAPI->evtRemun->perapur         = $ano;
                }
                $oDadosAPI->evtRemun->cpftrab             = $aDadosPorMatriculas[0]->cpftrab;

                if (strlen($aDadosPorMatriculas[0]->indmv) > 0) {
                    $oDadosAPI->evtRemun->infomv->indmv       = $aDadosPorMatriculas[0]->indmv;

                    $oRemunoutrempr = new \stdClass();
                    $oRemunoutrempr->tpinsc      = 1;
                    $oRemunoutrempr->nrinsc      = $aDadosPorMatriculas[0]->rh51_cgcvinculo;
                    $oRemunoutrempr->codcateg    = $aDadosPorMatriculas[0]->codcateg;
                    if (strlen($aDadosPorMatriculas[0]->vlrremunoe) > 0) {
                        $oRemunoutrempr->vlrremunoe  = $aDadosPorMatriculas[0]->vlrremunoe;
                    }
                    $aRemunoutrempr[] = $oRemunoutrempr;

                    $oDadosAPI->evtRemun->infomv->remunoutrempr = $aRemunoutrempr;
                }

                $std = $this->dmDevRH($aDadosPorMatriculas);

                if ($std->dmdev == null)
                    continue;

                $oDadosAPI->evtRemun->dmdev = $std->dmdev;
                $aDadosAPI[] = $oDadosAPI;
                $iSequencial++;
            } else {

                //$aDadosContabilidade = $this->buscarDadosContabilidade($oDados->z01_cgccpf, $ultimoDiaDoMes, $mes, $ano);
                // var_dump($aDadosContabilidade);
                // exit;
                //foreach ($aDadosContabilidade as $aDadosPorCpf) {

                $oDadosAPI                                = new \stdClass();
                $oDadosAPI->evtRemun                      = new \stdClass();
                $oDadosAPI->evtRemun->sequencial          = $iSequencial;
                $oDadosAPI->evtRemun->modo                = $this->modo;
                $oDadosAPI->evtRemun->indRetif            = 1;
                $oDadosAPI->evtRemun->nrRecibo            = null;

                $oDadosAPI->evtRemun->indapuracao         = $this->indapuracao;
                $oDadosAPI->evtRemun->perapur             = $ano . '-' . $mes;
                if ($this->indapuracao == 2) {
                    $oDadosAPI->evtRemun->perapur         = $ano;
                }
                $oDadosAPI->evtRemun->cpftrab             = $oDados->cpftrab;

                if (strlen($oDados->indmv) > 0) {
                    $oDadosAPI->evtRemun->infomv->indmv       = $oDados->indmv;

                    $oRemunoutrempr = new \stdClass();
                    $oRemunoutrempr->tpinsc = (strlen($oDados->doc_empresa) != 11) ? "1" : "2";
                    $oRemunoutrempr->nrinsc      = $oDados->doc_empresa;
                    if (!empty($oDados->codcategremun)) {
                        $oRemunoutrempr->codcateg    = $oDados->codcategremun;
                    }
                    if (!empty($oDados->vlrremunoe)) {
                        $oRemunoutrempr->vlrremunoe  = $oDados->vlrremunoe;
                    }
                    $aRemunoutrempr[] = $oRemunoutrempr;

                    $oDadosAPI->evtRemun->infomv->remunoutrempr = $aRemunoutrempr;
                }

                $std = $this->dmDevContabilidade($oDados);

                $oDadosAPI->evtRemun->infocomplem = $std->infocomplem;
                $oDadosAPI->evtRemun->dmdev = $std->dmdev;
                $aDadosAPI[] = $oDadosAPI;
                $iSequencial++;
                //}
            }
        }
        // echo '<pre>';
        // var_dump($aDadosAPI);
        // exit;
        return $aDadosAPI;
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
            $opcao = null;

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
            case 'rescisao':
                $sigla          = 'r20_';
                $arquivo        = 'gerfres';
                $xtipo          = ' r20_tpp ';
                $sTituloCalculo = 'Rescis¬o';
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
        return $aItens;
    }

    /**
     * Retorna dados dos dependentes no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarIdentificador($matricula, $rh30_regime)
    {
        $iAnoUsu = date("Y", db_getsession("DB_datausu"));
        $iMesusu = date("m", db_getsession("DB_datausu"));
        if ($rh30_regime == 1 || $rh30_regime == 3)
            $aPontos = array('salario', 'complementar', 'rescisao');
        else
            $aPontos = array('salario', 'complementar');

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

    private function dmDevRH($aDadosPorMatriculas)
    {
        $std = new \stdClass();
        $seqdmdev = 0;
        for ($iCont = 0; $iCont < count($aDadosPorMatriculas); $iCont++) {
            $aIdentificador = $this->buscarIdentificador($aDadosPorMatriculas[$iCont]->matricula, $aDadosPorMatriculas[$iCont]->rh30_regime);

            for ($iCont2 = 0; $iCont2 < count($aIdentificador); $iCont2++) {
                $std->dmdev[$seqdmdev] = new \stdClass(); //Obrigatório
                //Identificação de cada um dos demonstrativos de valores devidos ao trabalhador.
                if ($aIdentificador[$iCont2]->idedmdev == 1) {
                    $std->dmdev[$seqdmdev]->idedmdev = $aDadosPorMatriculas[$iCont]->matricula . 'gerfsal'; //uniqid(); //$aIdentificador[$iCont2]->idedmdev; //Obrigatório
                }
                if ($aIdentificador[$iCont2]->idedmdev == 2) {
                    $std->dmdev[$seqdmdev]->idedmdev = $aDadosPorMatriculas[$iCont]->matricula . 'gerfres'; //uniqid(); //$aIdentificador[$iCont2]->idedmdev; //Obrigatório
                }
                if ($aIdentificador[$iCont2]->idedmdev == 3) {
                    $std->dmdev[$seqdmdev]->idedmdev = $aDadosPorMatriculas[$iCont]->matricula . 'gerfcom'; //uniqid(); //$aIdentificador[$iCont2]->idedmdev; //Obrigatório
                }
                if ($aIdentificador[$iCont2]->idedmdev == 4) {
                    $std->dmdev[$seqdmdev]->idedmdev = $aDadosPorMatriculas[$iCont]->matricula . 'gerfs13'; //uniqid(); //$aIdentificador[$iCont2]->idedmdev; //Obrigatório
                }
                $std->dmdev[$seqdmdev]->codcateg = $aDadosPorMatriculas[$iCont]->codcateg; //Obrigatório

                //Identificação do estabelecimento e da lotação nos quais o
                //trabalhador possui remuneração no período de apuração
                $std->dmdev[$seqdmdev]->ideestablot[0] = new \stdClass(); //Opcional
                $std->dmdev[$seqdmdev]->ideestablot[0]->tpinsc = "1"; //Obrigatório
                $std->dmdev[$seqdmdev]->ideestablot[0]->nrinsc = $aDadosPorMatriculas[$iCont]->nrinsc; //Obrigatório
                $std->dmdev[$seqdmdev]->ideestablot[0]->codlotacao = 'LOTA1'; //Obrigatório

                //Informações relativas à remuneração do trabalhador no período de apuração.
                $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0] = new \stdClass(); //Obrigatório
                $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->matricula = $aDadosPorMatriculas[$iCont]->matricula; //Opcional

                $aDadosValoreRubrica = $this->buscarValorRubrica($aDadosPorMatriculas[$iCont]->matricula, $aDadosPorMatriculas[$iCont]->rh30_regime, $aIdentificador[$iCont2]->idedmdev);

                if (count($aDadosValoreRubrica) == 0) {
                    continue;
                }

                for ($iCont4 = 0; $iCont4 < count($aDadosValoreRubrica); $iCont4++) {
                    //Rubricas que compõem a remuneração do trabalhador.
                    $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->itensremun[$iCont4] = new \stdClass(); //Obrigatório
                    $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->itensremun[$iCont4]->codrubr = $aDadosValoreRubrica[$iCont4]->codrubr; //Obrigatório
                    $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->itensremun[$iCont4]->idetabrubr = $aDadosValoreRubrica[$iCont4]->idetabrubr; //Obrigatório
                    $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->itensremun[$iCont4]->vrunit = $aDadosValoreRubrica[$iCont4]->vrrubr; //Obrigatório
                    $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->itensremun[$iCont4]->vrrubr = $aDadosValoreRubrica[$iCont4]->vrrubr; //Obrigatório
                    $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->itensremun[$iCont4]->indapurir = $aDadosValoreRubrica[$iCont4]->indapurir; //Opcional
                }

                if (!in_array($aDadosPorMatriculas[$iCont]->codcateg, array(701, 711, 712, 901, 771))) {
                    $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->infoagnocivo->grauexp = $aDadosPorMatriculas[$iCont]->grauexp;
                }
                $seqdmdev++;
            }
        }
        return $std;
    }

    private function dmDevContabilidade($aDadosPorCpf)
    {
        $std = new \stdClass();
        $seqitens = 0;

        $std->infocomplem = new \stdClass(); //Opcional
        $std->infocomplem->nmtrab = $aDadosPorCpf->nmtrab; ///Obrigatório
        $std->infocomplem->dtnascto = $aDadosPorCpf->dtnascto; //Obrigatório

        $std->dmdev[0] = new \stdClass(); //Obrigat?rio
        $std->dmdev[0]->idedmdev = $aDadosPorCpf->idedmdev; //Obrigat?rio
        $std->dmdev[0]->codcateg = $aDadosPorCpf->codcateg; //Obrigatório

        //Identificação do estabelecimento e da lotação nos quais o
        //trabalhador possui remuneração no período de apuração
        //if (!empty($aDadosPorCpf->e50_empresadesconto)) {
        $std->dmdev[0]->ideestablot[0] = new \stdClass(); //Opcional
        $std->dmdev[0]->ideestablot[0]->tpinsc = '1'; //Obrigatório
        $std->dmdev[0]->ideestablot[0]->nrinsc = $aDadosPorCpf->nrinsc; //Obrigatório
        $std->dmdev[0]->ideestablot[0]->codlotacao = 'LOTA1'; //Obrigatório
        //}
        //Informações relativas à remuneração do trabalhador no período de apuração.
        // $std->dmdev[0]->ideestablot[0]->remunperapur[0] = new \stdClass(); //Obrigatório
        // $std->dmdev[0]->ideestablot[0]->remunperapur[0]->matricula = $aDadosPorCpf->e60_numcgm; //Opcional


        //Rubricas que compõem a remuneração do trabalhador.
        if ($aDadosPorCpf->codcateg == 711) {
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->codrubr = 'R002'; //$aDadosPorCpf->codrubr; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->idetabrubr = 'TABRUB1';
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->vrrubr = $aDadosPorCpf->e70_vlrliq * 0.7; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->indapurir = 0; //Opcional
            $seqitens++;
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->codrubr = 'R003'; //$aDadosPorCpf->codrubr; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->idetabrubr = 'TABRUB1';
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->vrrubr = $aDadosPorCpf->e70_vlrliq * 0.2; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->indapurir = 0; //Opcional
            $seqitens++;
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->codrubr = 'R004'; //$aDadosPorCpf->codrubr; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->idetabrubr = 'TABRUB1';
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->vrrubr = $aDadosPorCpf->e70_vlrliq * 0.1; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->indapurir = 0; //Opcional
            $seqitens++;
        } elseif ($aDadosPorCpf->codcateg == 712) {
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->codrubr = 'R002'; //$aDadosPorCpf->codrubr; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->idetabrubr = 'TABRUB1';
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->vrrubr = $aDadosPorCpf->e70_vlrliq * 0.2; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->indapurir = 0; //Opcional
            $seqitens++;
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->codrubr = 'R003'; //$aDadosPorCpf->codrubr; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->idetabrubr = 'TABRUB1';
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->vrrubr = $aDadosPorCpf->e70_vlrliq * 0.2; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->indapurir = 0; //Opcional
            $seqitens++;
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->codrubr = 'R004'; //$aDadosPorCpf->codrubr; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->idetabrubr = 'TABRUB1';
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->vrrubr = $aDadosPorCpf->e70_vlrliq * 0.6; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->indapurir = 0; //Opcional
            $seqitens++;
        } else {
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->codrubr = 'R001'; //$aDadosPorCpf->codrubr; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->idetabrubr = 'TABRUB1';
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->vrrubr = $aDadosPorCpf->e70_vlrliq; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->indapurir = 0; //Opcional
            $seqitens++;
        }
        if ($aDadosPorCpf->valor_inss > 0) {
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->codrubr = 'R005'; //$aDadosPorCpf->codrubr; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->idetabrubr = 'TABRUB1';
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->vrrubr = $aDadosPorCpf->valor_inss; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->indapurir = 0; //Opcional
            $seqitens++;
        }

        if ($aDadosPorCpf->valor_irrf > 0) {
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->codrubr = 'R006'; //$aDadosPorCpf->codrubr; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->idetabrubr = 'TABRUB1';
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->vrrubr = $aDadosPorCpf->valor_irrf; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->indapurir = 0; //Opcional
            $seqitens++;
        }
        if ($aDadosPorCpf->outrasretencoes > 0) {
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->codrubr = 'R009'; //$aDadosPorCpf->codrubr; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->idetabrubr = 'TABRUB1';
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->vrrubr = $aDadosPorCpf->outrasretencoes; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->indapurir = 0; //Opcional
            $seqitens++;
        }
        if ($aDadosPorCpf->sest > 0) {
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->codrubr = 'R007'; //$aDadosPorCpf->codrubr; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->idetabrubr = 'TABRUB1';
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->vrrubr = $aDadosPorCpf->sest; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->indapurir = 0; //Opcional
            $seqitens++;
        }
        if ($aDadosPorCpf->senat > 0) {
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens] = new \stdClass(); //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->codrubr = 'R008'; //$aDadosPorCpf->codrubr; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->idetabrubr = 'TABRUB1';
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->vrrubr = $aDadosPorCpf->senat; //Obrigatório
            $std->dmdev[0]->ideestablot[0]->remunperapur[0]->itensremun[$seqitens]->indapurir = 0; //Opcional
            $seqitens++;
        }

        $std->dmdev[0]->infocomplcont = new \stdClass(); //Opcional
        $std->dmdev[0]->infocomplcont->codcbo = $aDadosPorCpf->codcbo; //Obrigatório
        //$std->dmdev[0]->infocomplcont->natatividade = 1; //Obrigatório

        return $std;
    }

    /**
     * Retorna os dados por matricula no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarDadosPorMatricula($cpf)
    {
        $anofolha = db_anofolha();
        $mesfolha = db_mesfolha();
        $sql = "SELECT
        distinct
        1 as tpInsc,
        cgc as nrInsc,
        z01_cgccpf as cpfTrab,
        rh51_indicadesconto as indMV,
        case when length(rh51_cgcvinculo) = 14 then 1
        when length(rh51_cgcvinculo) = 11 then 2
        end as tpInsc2,
        rh51_cgcvinculo as nrInsc2,
        rh51_basefo as vlrRemunOE,
        'LOTA1' as codLotacao,
        case when rh02_ocorre = '2' then 2
        when rh02_ocorre = '3' then 3
        when rh02_ocorre = '4' then 4
        else '1'
        end as grauExp,
        rh30_regime,
        rh51_cgcvinculo,
        rh01_regist as matricula,
        h13_categoria as codCateg
        from
            rhpessoal
            left join rhpessoalmov on
                rh02_anousu = fc_getsession('DB_anousu')::int
                and rh02_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
                and rh02_regist = rh01_regist
                and rh02_instit = fc_getsession('DB_instit')::int
            left join rhinssoutros on
                rh51_seqpes = rh02_seqpes
            left join rhlota on
                rhlota.r70_codigo = rhpessoalmov.rh02_lota
                and rhlota.r70_instit = rhpessoalmov.rh02_instit
            inner join cgm on
                cgm.z01_numcgm = rhpessoal.rh01_numcgm
            inner join db_config on
                db_config.codigo = rhpessoal.rh01_instit
            left join rhpesrescisao on
                rh02_seqpes = rh05_seqpes
            left join rhregime on
                rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
            inner join tpcontra on
                tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            left join rhcontratoemergencial on
                rh163_matricula = rh01_regist
            left join rhcontratoemergencialrenovacao on
                rh164_contratoemergencial = rh163_sequencial
            left join rescisao on
                rescisao.r59_anousu = rhpessoalmov.rh02_anousu
                and rescisao.r59_mesusu = rhpessoalmov.rh02_mesusu
                and rescisao.r59_regime = rhregime.rh30_regime
                and rescisao.r59_causa = rhpesrescisao.rh05_causa
                and rescisao.r59_caub = rhpesrescisao.rh05_caub::char(2)
            left outer join (
                select
                    distinct r33_codtab,
                    r33_nome,
                    r33_tiporegime
                from
                    inssirf
                where     r33_anousu = $anofolha
                                            and r33_mesusu = $mesfolha
                            and r33_instit = fc_getsession('DB_instit')::int ) as x on
                r33_codtab = rhpessoalmov.rh02_tbprev + 2
                where 1=1
                and (
                            (h13_categoria = '901' and rh30_vinculo = 'A')
                            or
                            (h13_categoria in ('101', '106', '111', '301', '302', '303', '305', '306', '309', '312', '313','410', '902','701','712','771','711')
                            and rh30_vinculo = 'A'
                            and r33_tiporegime = '1')
                        )
                and cgm.z01_cgccpf = '$cpf'
                and ((rh05_recis is not null
                    and date_part('month', rh05_recis) = date_part('month', fc_getsession('DB_datausu')::date)
                    and date_part('year', rh05_recis) = date_part('year', fc_getsession('DB_datausu')::date)
                    )
                    or
                    rh05_recis is null
                )";


        $rsValores = db_query($sql);
        // echo $sql;
        // db_criatabela($rsValores);
        // exit;
        if (pg_num_rows($rsValores) > 0) {
            for ($iCont = 0; $iCont < pg_num_rows($rsValores); $iCont++) {
                $oResult = \db_utils::fieldsMemory($rsValores, $iCont);
                $aItens[] = $oResult;
            }
        }
        return $aItens;
    }
}