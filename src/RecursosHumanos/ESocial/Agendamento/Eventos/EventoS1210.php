<?php

namespace ECidade\RecursosHumanos\ESocial\Agendamento\Eventos;

use cl_rubricasesocial;
use db_utils;
use DBPessoal;
use ECidade\RecursosHumanos\ESocial\Agendamento\Eventos\EventoBase;

/**
 * Classe responsÃ¡vel por montar as informaÃ§Ãµes do evento S1210 Esocial
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
        $ano = date("Y", db_getsession("DB_datausu"));
        $mes = date("m", db_getsession("DB_datausu"));
        $dia = date("d", db_getsession("DB_datausu"));
        $data = "$ano-$mes-01";
        $data = new \DateTime($data);
        $data->modify('last day of this month');
        $ultimoDiaDoMes = $data->format('d');

        $aDadosAPI = array();
        $iSequencial = 1;

        foreach ($this->dados as $oDados) {

            if ($this->tpevento == 1) {
                $aDadosPorMatriculas = $this->buscarDadosPorMatricula($oDados->z01_cgccpf, $this->tppgto);
                if ($aDadosPorMatriculas[0]->cpftrab == null) {
                    continue;
                }
                $oDadosAPI                                = new \stdClass();
                $oDadosAPI->evtPgtos                      = new \stdClass();
                $oDadosAPI->evtPgtos->sequencial          = $iSequencial;
                $oDadosAPI->evtPgtos->modo                = $this->modo;
                $oDadosAPI->evtPgtos->indRetif            = 1;
                $oDadosAPI->evtPgtos->nrRecibo            = null;

                $oDadosAPI->evtPgtos->indapuracao         = $this->indapuracao;
                $oDadosAPI->evtPgtos->perapur             = $ano . '-' . $mes;
                if ($this->indapuracao == 2) {
                    $oDadosAPI->evtPgtos->perapur         = $ano;
                }
                $oDadosAPI->evtPgtos->cpfbenef             = $aDadosPorMatriculas[0]->cpftrab;

                $std = new \stdClass();
                $seqinfopag = 0;
                for ($iCont = 0; $iCont < count($aDadosPorMatriculas); $iCont++) {
                    $aIdentificador = $this->buscarIdentificador($aDadosPorMatriculas[$iCont]->matricula, $aDadosPorMatriculas[$iCont]->rh30_regime);
                    for ($iCont2 = 0; $iCont2 < count($aIdentificador); $iCont2++) {
                        $std->infopgto[$seqinfopag]->codcateg = $oDados->codcateg; //Obrigatório

                        $std->infopgto[$seqinfopag] = new \stdClass(); //Obritatório

                        $std->infopgto[$seqinfopag]->dtpgto = "$ano-$mes-$dia";
                        $std->infopgto[$seqinfopag]->tppgto = $this->tppgto;
                        $std->infopgto[$seqinfopag]->perref = "$ano-$mes";

                        if ($aIdentificador[$iCont2]->idedmdev == 1) {
                            $std->infopgto[$seqinfopag]->idedmdev = $aDadosPorMatriculas[$iCont]->matricula . 'gerfsal'; //uniqid(); //$aIdentificador[$iCont2]->idedmdev; //Obrigat?rio
                        }
                        if ($aIdentificador[$iCont2]->idedmdev == 2) {
                            $std->infopgto[$seqinfopag]->idedmdev = $aDadosPorMatriculas[$iCont]->matricula . 'gerfres'; //uniqid(); //$aIdentificador[$iCont2]->idedmdev; //Obrigat?rio
                        }
                        if ($aIdentificador[$iCont2]->idedmdev == 3) {
                            $std->infopgto[$seqinfopag]->idedmdev = $aDadosPorMatriculas[$iCont]->matricula . 'gerfcom'; //uniqid(); //$aIdentificador[$iCont2]->idedmdev; //Obrigat?rio
                        }
                        if ($aIdentificador[$iCont2]->idedmdev == 4) {
                            $std->infopgto[$seqinfopag]->idedmdev = $aDadosPorMatriculas[$iCont]->matricula . 'gerfs13'; //uniqid(); //$aIdentificador[$iCont2]->idedmdev; //Obrigat?rio
                        }

                        //$std->infopgto[$seqinfopag]->idedmdev = '1';

                        $std->infopgto[$seqinfopag]->vrliq = $this->buscarValorLiquido($aDadosPorMatriculas[$iCont]->matricula, $aDadosPorMatriculas[$iCont]->rh30_regime, $aIdentificador[$iCont2]->idedmdev);
                        // echo $std->infopgto[$seqinfopag]->vrliq;
                        // exit;
                        //$std->infopgto[$seqinfopag]->vrliq = (float) number_format($std->infopgto[$seqinfopag]->vrliq, 2, ',', '.');

                        $seqinfopag++;
                    }
                }
                $oDadosAPI->evtPgtos->infopgto = $std->infopgto;
                $aDadosAPI[] = $oDadosAPI;
                $iSequencial++;
            } else {
                // $aDadosContabilidade = $this->buscarDadosContabilidade($oDados->z01_cgccpf, $ultimoDiaDoMes, $mes, $ano);

                $oDadosAPI                                = new \stdClass();
                $oDadosAPI->evtPgtos                      = new \stdClass();
                $oDadosAPI->evtPgtos->sequencial          = $iSequencial;
                $oDadosAPI->evtPgtos->modo                = $this->modo;
                $oDadosAPI->evtPgtos->indRetif            = 1;
                $oDadosAPI->evtPgtos->nrRecibo            = null;

                $oDadosAPI->evtPgtos->indapuracao         = $this->indapuracao;
                $oDadosAPI->evtPgtos->perapur             = $ano . '-' . $mes;
                if ($this->indapuracao == 2) {
                    $oDadosAPI->evtPgtos->perapur         = $ano;
                }
                $oDadosAPI->evtPgtos->cpfbenef             = $oDados->cpf_benef;

                $std = new \stdClass();
                $seqinfopag = 0;

                $std->infopgto[$seqinfopag]->codcateg = $oDados->codcateg; //Obrigatório

                $std->infopgto[$seqinfopag] = new \stdClass(); //Obritatório

                $std->infopgto[$seqinfopag]->dtpgto = $oDados->dt_pgto;
                $std->infopgto[$seqinfopag]->tppgto = $this->tppgto;
                $std->infopgto[$seqinfopag]->perref = $oDados->per_ref;

                $std->infopgto[$seqinfopag]->idedmdev = $oDados->ide_dm_dev; // . 'gerfsal'; //uniqid(); //$aIdentificador[$iCont2]->idedmdev; //Obrigat?rio

                $std->infopgto[$seqinfopag]->vrliq = $oDados->vr_liq;

                $oDadosAPI->evtPgtos->infopgto = $std->infopgto;
                $aDadosAPI[] = $oDadosAPI;
                $iSequencial++;
            }
        }
        // echo '<pre>';
        // var_dump($aDadosAPI);
        // exit;
        return $aDadosAPI;
    }

    /**
     * Retorna dados por matricula no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarDadosPorMatricula($cpf, $tppgto)
    {
        $ano = date("Y", db_getsession("DB_datausu"));
        $mes = date("m", db_getsession("DB_datausu"));

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
        left join rhinssoutros    on rh51_seqpes                 = rh02_seqpes
        left join rhlota on
            rhlota.r70_codigo = rhpessoalmov.rh02_lota
            and rhlota.r70_instit = rhpessoalmov.rh02_instit
        inner join cgm on
            cgm.z01_numcgm = rhpessoal.rh01_numcgm
        inner join db_config on
            db_config.codigo = rhpessoal.rh01_instit
        inner join rhestcivil on
            rhestcivil.rh08_estciv = rhpessoal.rh01_estciv
        inner join rhraca on
            rhraca.rh18_raca = rhpessoal.rh01_raca
        left join rhfuncao on
            rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
            and rhfuncao.rh37_instit = rhpessoalmov.rh02_instit
        left join rhpescargo on
            rhpescargo.rh20_seqpes = rhpessoalmov.rh02_seqpes
        left join rhcargo on
            rhcargo.rh04_codigo = rhpescargo.rh20_cargo
            and rhcargo.rh04_instit = rhpessoalmov.rh02_instit
        inner join rhinstrucao on
            rhinstrucao.rh21_instru = rhpessoal.rh01_instru
        inner join rhnacionalidade on
            rhnacionalidade.rh06_nacionalidade = rhpessoal.rh01_nacion
        left join rhpesrescisao on
            rh02_seqpes = rh05_seqpes
        left join rhsindicato on
            rh01_rhsindicato = rh116_sequencial
        inner join rhreajusteparidade on
            rhreajusteparidade.rh148_sequencial = rhpessoal.rh01_reajusteparidade
        left join rhpesdoc on
            rhpesdoc.rh16_regist = rhpessoal.rh01_regist
        left join rhdepend on
            rhdepend.rh31_regist = rhpessoal.rh01_regist
        left join rhregime on
            rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
        left join rhpesfgts on
            rhpesfgts.rh15_regist = rhpessoal.rh01_regist
        inner join tpcontra on
            tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
        left join rhcontratoemergencial on
            rh163_matricula = rh01_regist
        left join rhcontratoemergencialrenovacao on
            rh164_contratoemergencial = rh163_sequencial
        left join jornadadetrabalho on
            jt_sequencial = rh02_jornadadetrabalho
        left join db_cgmbairro on
            cgm.z01_numcgm = db_cgmbairro.z01_numcgm
        left join bairro on
            bairro.j13_codi = db_cgmbairro.j13_codi
        left join db_cgmruas on
            cgm.z01_numcgm = db_cgmruas.z01_numcgm
        left join ruas on
            ruas.j14_codigo = db_cgmruas.j14_codigo
        left join rescisao on
            rescisao.r59_anousu = rhpessoalmov.rh02_anousu
            and rescisao.r59_mesusu = rhpessoalmov.rh02_mesusu
            and rescisao.r59_regime = rhregime.rh30_regime
            and rescisao.r59_causa = rhpesrescisao.rh05_causa
            and rescisao.r59_caub = rhpesrescisao.rh05_caub::char(2)
        left  outer join (
                SELECT distinct r33_codtab,r33_nome,r33_tiporegime
                                    from inssirf
                                    where     r33_anousu = $anofolha
                                            and r33_mesusu = $mesfolha
                                        and r33_instit = fc_getsession('DB_instit')::int
                                ) as x on r33_codtab = rhpessoalmov.rh02_tbprev+2
        where 1=1
        and ((rh05_recis is not null
            and date_part('month', rh05_recis) = date_part('month', fc_getsession('DB_datausu')::date)
            and date_part('year', rh05_recis) = date_part('year', fc_getsession('DB_datausu')::date)
            )
            or
            rh05_recis is null
        ) ";
        //1200
        if ($tppgto == 1) {
            $sql .= " and (
                (h13_categoria = '901' and rh30_vinculo = 'A')
                or
                (h13_categoria in ('101', '106', '111', '301', '302', '303', '305', '306', '309', '312', '313','410', '902','701','712','771','711')
                and rh30_vinculo = 'A'
                and r33_tiporegime = '1')
            )
            ";
        }
        //2299
        if ($tppgto == 2) {
            $sql .= " and r33_tiporegime = '2'
            and rescisao.r59_mesusu = $mes
            and rescisao.r59_mesusu = $ano ";
        }
        //2399
        if ($tppgto == 3) {
            $sql .= "";
        }
        //1202
        if ($tppgto == 4) {
            $sql .= " and h13_categoria in ('301', '302', '303', '305', '306', '309', '410')
            and rh30_vinculo = 'A'
            and r33_tiporegime = '2' ";
        }
        //1207
        if ($tppgto == 5) {
            $sql .= " and rh30_vinculo in ('I','P') ";
        }

        $sql .= " and cgm.z01_cgccpf = '$cpf'
            and (exists (SELECT
            1
        from
            gerfsal
        where
            r14_anousu = fc_getsession('DB_anousu')::int
            and r14_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
            and r14_instit = fc_getsession('DB_instit')::int
            and r14_regist = rhpessoal.rh01_regist)
            or
            exists (SELECT
            1
        from
            gerfcom
        where
            r48_anousu = fc_getsession('DB_anousu')::int
            and r48_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
            and r48_instit = fc_getsession('DB_instit')::int
            and r48_regist = rhpessoal.rh01_regist)
            or
            exists (SELECT
            1
        from
            gerfres
        where
            r20_anousu = fc_getsession('DB_anousu')::int
            and r20_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
            and r20_instit = fc_getsession('DB_instit')::int
            and r20_regist = rhpessoal.rh01_regist))";


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
     * Retorna o valor liquido no formato necessario para envio
     * pela API sped-esocial
     * @return array stdClass
     */
    private function buscarValorLiquido($matricula, $rh30_regime, $ponto)
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
        // exit;
        if ($opcao != 'rescisao') {
            for ($iCont = 0; $iCont < pg_num_rows($rsValores); $iCont++) {
                $oResult = \db_utils::fieldsMemory($rsValores, $iCont);
                $proventos  += ($oResult->provdesc == 'Provento') ? $oResult->provento : 0;
                $descontos  += ($oResult->provdesc == 'Desconto') ? $oResult->desconto : 0;
            }
            $vrliq = $proventos - $descontos;
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
                $proventos  += ($oResult->provdesc == 'Provento') ? $oResult->provento : 0;
                $descontos  += ($oResult->provdesc == 'Desconto') ? $oResult->desconto : 0;
            }
            $vrliq = $proventos - $descontos;
        }
        return $vrliq;
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
}