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
class EventoS1299 extends EventoBase
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
        //$iSequencial = 1;

                $oDadosAPI                                     = new \stdClass();
                $oDadosAPI->evtFechaEvPer                      = new \stdClass();
                $oDadosAPI->evtFechaEvPer->sequencial          = $iSequencial;
                $oDadosAPI->evtFechaEvPer->modo                = $this->modo;
                $oDadosAPI->evtFechaEvPer->indRetif            = 1;
                $oDadosAPI->evtFechaEvPer->nrRecibo            = null;

                $oDadosAPI->evtFechaEvPer->indapuracao         = $this->indapuracao;
                $oDadosAPI->evtFechaEvPer->perapur             = $ano . '-' . $mes;
                if ($this->indapuracao == 2) {
                    $oDadosAPI->evtFechaEvPer->perapur         = $ano;
                }
                //$oDadosAPI->evtFechaEvPer->indguia             = 1;

                $std = new \stdClass();
                
                $std->infofech->evtremun = 'S';  //obrigatorio
                //Possui informações relativas a remuneração de trabalhadores ou provento/pensão de
                //beneficiários no período de apuração?
                //Se for igual a [S], deve existir evento de remuneração (S-1200, S-1202, S-1207, S-2299 ou S-2399)
                //para o período de apuração. Caso contrário, não deve existir evento de remuneração.
                $std->infofech->evtpgtos = ($this->evtpgtos == 'S')? 'S' : 'N';  //obrigatorio
                //Possui informações relativas a remuneração de trabalhadores ou provento/pensão de beneficiários no período de apuração?
                //Se for igual a [S], deve existir evento de remuneração (S-1200, S-1202, S-1207, S-2299 ou S-2399) para o
                //período de apuração, considerando o campo {indGuia}(1299_ideEvento_indGuia). Caso contrário, não deve existir
                //evento de remuneração.

                $std->infofech->evtcomprod = 'N';  //obrigatorio
                //Possui informações de comercialização de produção?
                //Se for igual a [S], deve existir o evento S-1260 para o período de apuração. Caso contrário, não deve existir o evento.

                $std->infofech->evtcontratavnp = 'N';  //obrigatorio
                //Contratou, por intermédio de sindicato, serviços de trabalhadores avulsos não portuários?
                //Se for igual a [S], deve existir o evento S-1270 para o período de apuração. Caso contrário, não deve existir o evento.

                $std->infofech->evtinfocomplper = 'N'; //obrigatorio
                //Possui informações de desoneração de folha de
                //pagamento ou, sendo empresa enquadrada no Simples,
                //possui informações sobre a receita obtida em atividades
                //cuja contribuição previdenciária incidente sobre a folha de
                //pagamento é concomitantemente substituída e não
                //substituída?

                //$std->infofech->indexcapur1250 = 'S'; //opcional mas aceita somente NULL ou S
                //Indicativo de exclusão de apuração das aquisições de produção rural (eventos S-1250) do período de apuração.
                //Não informar se perApur >= [2021-05] ou se indApuracao = [2]. Preenchimento obrigatório caso o
                //campo tenha sido informado em fechamento anterior do mesmo período de apuração
                if($this->transDCTFWeb == 'S')
                    $std->infofech->transdctfweb = $this->transDCTFWeb; //opcional
                // Solicitação de transmissão imediata da DCTFWeb.
                // Não informar se perApur < [2021-10]. Preenchimento obrigatório se perApur >= [2021-10] e
                // (classTrib em S-1000 = [04] ou indGuia estiver informado).

                //$std->infofech->naovalid = 'S'; //opcional
                //Indicativo de não validação das regras de fechamento, para que os grandes contribuintes possam reduzir o tempo de processamento do evento.
                //O preenchimento deste campo implica a não execução da REGRA_VALIDA_FECHAMENTO_FOPAG.
                //Não informar se {procEmi}(1299_ideEvento_procEmi) for diferente de [1]

                $oDadosAPI->evtFechaEvPer->infofech = $std->infofech;
                $aDadosAPI[] = $oDadosAPI;
        
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
        rh01_esocial as matricula_esocial,
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
            $sql .= " and rh30_regime = '2'
            and rescisao.r59_mesusu = $mes
            and rescisao.r59_anousu = $ano ";
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

        $sql .= " and cgm.z01_cgccpf = '$cpf' ";
        //     and (exists (SELECT
        //     1
        // from
        //     gerfsal
        // where
        //     r14_anousu = fc_getsession('DB_anousu')::int
        //     and r14_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
        //     and r14_instit = fc_getsession('DB_instit')::int
        //     and r14_regist = rhpessoal.rh01_regist)
        //     or
        //     exists (SELECT
        //     1
        // from
        //     gerfcom
        // where
        //     r48_anousu = fc_getsession('DB_anousu')::int
        //     and r48_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
        //     and r48_instit = fc_getsession('DB_instit')::int
        //     and r48_regist = rhpessoal.rh01_regist)
        //     or
        //     exists (SELECT
        //     1
        // from
        //     gerfres
        // where
        //     r20_anousu = fc_getsession('DB_anousu')::int
        //     and r20_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
        //     and r20_instit = fc_getsession('DB_instit')::int
        //     and r20_regist = rhpessoal.rh01_regist))";


        $rsValores = db_query($sql);
        // echo $sql;
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

    public function buscarDadosContabilidade($cpf, $ultimoDiaDoMes, $mes, $ano)
    {
        $ano = date("Y", db_getsession("DB_datausu"));
        $mes = date("m", db_getsession("DB_datausu"));
        $sql = "SELECT *
            FROM (
                    select e60_numcgm as num_cgm,
                        z01_cgccpf as cpf_benef,
                        e50_codord as ide_dm_dev,
                        substr(e50_data::varchar, 1, 7) as per_ref,
                        (e53_valor - e53_vlranu) as valor_op,
                        corrente.k12_data as dt_pgto,
                        sum(
                            case
                                when corgrupotipo.k106_sequencial = 4 then corrente.k12_valor * -1
                                else corrente.k12_valor
                            end
                        ) as vr_liq
                    from pagordem
                        inner join empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
                        inner join cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
                        inner join empord on empord.e82_codord = pagordem.e50_codord
                        inner join empagemov on empagemov.e81_codmov = empord.e82_codmov
                        inner join corempagemov on corempagemov.k12_codmov = empagemov.e81_codmov
                        inner join corrente on (
                            corrente.k12_id,
                            corrente.k12_data,
                            corrente.k12_autent
                        ) = (
                            corempagemov.k12_id,
                            corempagemov.k12_data,
                            corempagemov.k12_autent
                        )
                        inner join corgrupocorrente on (
                            corrente.k12_id,
                            corrente.k12_data,
                            corrente.k12_autent
                        ) = (
                            corgrupocorrente.k105_id,
                            corgrupocorrente.k105_data,
                            corgrupocorrente.k105_autent
                        )
                        inner join corgrupo ON corgrupo.k104_sequencial = corgrupocorrente.k105_corgrupo
                        inner join corgrupotipo on corgrupotipo.k106_sequencial = corgrupocorrente.k105_corgrupotipo
                        inner join pagordemele on e50_codord = e53_codord
                    where e50_cattrabalhador is not null
                        and date_part('month',corrente.k12_data) = $mes
                        and date_part('year',corrente.k12_data) = $ano
                        and corgrupotipo.k106_sequencial in (1, 4)
                        and length(z01_cgccpf) = 11
                    group by 1,
                        2,
                        3,
                        4,
                        5,
                        6
                    order by e50_codord, corrente.k12_data
                ) AS pagamentos
            WHERE vr_liq > 0
            ";
        if ($cpf != null) {
            $sql .= " and cpf_benef in ('$cpf') ";
        }
        $rs = \db_query($sql);
        // echo $sql;
        // db_criatabela($rs);
        // exit;
        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos do S1210");
        }
        /**
         * @todo busca os empregadores da institui??o e adicona para cada rubriuca
         */
        return \db_utils::getCollectionByRecord($rs);
    }

    private function dmDevContabilidade($aDadosPorCpf)
    {
        $std = new \stdClass();

        for ($iCont = 0; $iCont < count($aDadosPorCpf); $iCont++) {
            $seqinfopag = 0;

            //$std->infopgto[$seqinfopag]->codcateg = $aDadosPorCpf[$iCont]->codcateg; //Obrigatï¿½rio

            $std->infopgto[$iCont] = new \stdClass(); //Obritatï¿½rio

            $std->infopgto[$iCont]->dtpgto = $aDadosPorCpf[$iCont]->dt_pgto;
            $std->infopgto[$iCont]->tppgto = $this->tppgto;
            $std->infopgto[$iCont]->perref = $aDadosPorCpf[$iCont]->per_ref;

            $std->infopgto[$iCont]->idedmdev = $aDadosPorCpf[$iCont]->ide_dm_dev; // . 'gerfsal'; //uniqid(); //$aIdentificador[$iCont2]->idedmdev; //Obrigat?rio

            $std->infopgto[$iCont]->vrliq = $aDadosPorCpf[$iCont]->vr_liq;
        }
        return $std;
    }
}
