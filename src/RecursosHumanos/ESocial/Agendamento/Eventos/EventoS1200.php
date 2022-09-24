<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use cl_rubricasesocial;
use db_utils;
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

                $oDadosAPI->evtRemun->dmdev = $std->dmdev;
                $aDadosAPI[] = $oDadosAPI;
                $iSequencial++;
            } else {

                $aDadosContabilidade = $this->buscarDadosContabilidade($oDados->z01_cgccpf, $ultimoDiaDoMes, $mes, $ano);

                foreach ($aDadosContabilidade as $aDadosPorCpf) {

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
                    $oDadosAPI->evtRemun->cpftrab             = $aDadosPorCpf->cpftrab;

                    if (strlen($aDadosPorCpf->indmv) > 0) {
                        $oDadosAPI->evtRemun->infomv->indmv       = $aDadosPorCpf->indmv;

                        $oRemunoutrempr = new \stdClass();
                        $oRemunoutrempr->tpinsc      = 1;
                        $oRemunoutrempr->nrinsc      = $aDadosPorCpf->rh51_cgcvinculo;
                        $oRemunoutrempr->codcateg    = $aDadosPorCpf->codcateg;
                        if (strlen($aDadosPorCpf->vlrremunoe) > 0) {
                            $oRemunoutrempr->vlrremunoe  = $aDadosPorCpf->vlrremunoe;
                        }
                        $aRemunoutrempr[] = $oRemunoutrempr;

                        $oDadosAPI->evtRemun->infomv->remunoutrempr = $aRemunoutrempr;
                    }

                    $std = $this->dmDevContabilidade($aDadosPorCpf);

                    $oDadosAPI->evtRemun->dmdev = $std->dmdev;
                    $aDadosAPI[] = $oDadosAPI;
                    $iSequencial++;
                }
            }
        }
        // echo '<pre>';
        // var_dump($aDadosAPI);
        // exit;
        return $aDadosAPI;
    }

    /**
     * Retorna os dados por matricula no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarDadosPorMatricula($cpf)
    {
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
        where
            r33_anousu = fc_getsession('DB_anousu')::int
                and r33_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
                    and r33_instit = fc_getsession('DB_instit')::int ) as x on
        r33_codtab = rhpessoalmov.rh02_tbprev + 2
        where h13_categoria in ('101', '106', '111', '301', '302', '303', '305', '306', '309', '312', '313', '902','701','712','771','901','711','410')
        and rh30_vinculo = 'A'
        and r33_tiporegime = '1'
        and cgm.z01_cgccpf = '$cpf'";


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

    private function buscarDadosContabilidade($cpf, $ultimoDiaDoMes, $mes, $ano)
    {

        $sql = "SELECT distinct e50_codord as ideDmDev,
        e60_numcgm,
        e70_vlrliq,
        e50_data,
        e50_empresadesconto,
        e50_cattrabalhador as codCateg,
        e50_contribuicaoprev as indMV,
        e50_valorremuneracao as vlrRemunOE,
        e50_valordesconto,
        e50_datacompetencia,
        e50_cattrabalhadorremurenacao as codCateg,
        case
            when retencaotiporec.e21_retencaotipocalc in (3, 4, 7) then (coalesce(e23_valorretencao, 0))
            else 0
        end as valor_inss,
        case
            when retencaotiporec.e21_retencaotipocalc in (1, 2) then (coalesce(e23_valorretencao, 0))
            else 0
        end as valor_irrf,
        cgm.z01_cgccpf as cpfTrab,
        cgm.z01_nome as nmTrab,
        z04_rhcbo as codCBO,
        cgm.z01_nasc as dtNascto
        from empnota
            inner join empempenho on e69_numemp = e60_numemp
            inner join cgm as cgm on e60_numcgm = cgm.z01_numcgm
            inner join empnotaele on e69_codnota = e70_codnota
            inner join orcelemento on empnotaele.e70_codele = orcelemento.o56_codele
            inner join cgmfisico on z04_numcgm = cgm.z01_numcgm
            left join conlancamemp on c75_numemp = e60_numemp
            left join conlancamdoc on c71_codlan = c75_codlan
            and c71_coddoc = 904
            left join pagordemnota on e71_codnota = e69_codnota
            and e71_anulado is false
            left join pagordem on e71_codord = e50_codord
            left join pagordemele on e53_codord = e50_codord
            left join cgm as empresa on empresa.z01_numcgm = e50_empresadesconto
            left join categoriatrabalhador as cattrabalhador on cattrabalhador.ct01_codcategoria = e50_cattrabalhador
            left join categoriatrabalhador as catremuneracao on catremuneracao.ct01_codcategoria = e50_cattrabalhadorremurenacao
            left join retencaopagordem on pagordem.e50_codord = retencaopagordem.e20_pagordem
            left join retencaoreceitas on retencaoreceitas.e23_retencaopagordem = retencaopagordem.e20_sequencial
            left join retencaotiporec on retencaotiporec.e21_sequencial = retencaoreceitas.e23_retencaotiporec
        where e50_data BETWEEN '$ano-$mes-01' AND '$ano-$mes-$ultimoDiaDoMes'
            and Length(cgm.z01_cgccpf) like '11'
            and e50_cattrabalhador is not null
        ";


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
        $seqdmdev = 0;

        // $std->infocomplem = new \stdClass(); //Opcional
        // $std->infocomplem->nmtrab = $aDadosPorCpf->nmtrab; ///Obrigatório
        // $std->infocomplem->dtnascto = $aDadosPorCpf->dtnascto; //Obrigatório

        $std->dmdev[$seqdmdev] = new \stdClass(); //Obrigat?rio
        $std->dmdev[$seqdmdev]->idedmdev = $aDadosPorCpf->idedmdev; //Obrigat?rio
        $std->dmdev[$seqdmdev]->codcateg = $aDadosPorCpf->codcateg; //Obrigatório

        //Identificação do estabelecimento e da lotação nos quais o
        //trabalhador possui remuneração no período de apuração
        $std->dmdev[$seqdmdev]->ideestablot[0] = new \stdClass(); //Opcional
        $std->dmdev[$seqdmdev]->ideestablot[0]->tpinsc = "1"; //Obrigatório
        $std->dmdev[$seqdmdev]->ideestablot[0]->nrinsc = $aDadosPorCpf->nrinsc; //Obrigatório
        $std->dmdev[$seqdmdev]->ideestablot[0]->codlotacao = 'LOTA1'; //Obrigatório

        //Informações relativas à remuneração do trabalhador no período de apuração.
        $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0] = new \stdClass(); //Obrigatório
        $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->matricula = $aDadosPorCpf->matricula; //Opcional


        //Rubricas que compõem a remuneração do trabalhador.
        // $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->itensremun[0] = new \stdClass(); //Obrigatório
        // $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->itensremun[0]->codrubr = $aDadosPorCpf->codrubr; //Obrigatório
        // $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->itensremun[0]->idetabrubr = $aDadosPorCpf->idetabrubr; //Obrigatório
        // $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->itensremun[0]->vrunit = $aDadosPorCpf->vrrubr; //Obrigatório
        // $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->itensremun[0]->vrrubr = $aDadosPorCpf->vrrubr; //Obrigatório
        // $std->dmdev[$seqdmdev]->ideestablot[0]->remunperapur[0]->itensremun[0]->indapurir = $aDadosPorCpf->indapurir; //Opcional

        return $std;
    }
}
