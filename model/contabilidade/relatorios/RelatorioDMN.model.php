<?php

class RelatorioDMN
{

    public $iConta;

    public $sDescricao;

    public $iTipo;

    public $iFonte;

    public $fSaldoAnterior = 0;

    public $fValorReceitaOrcamentaria = 0;

    public $fValorReceitaExtra = 0;

    public $fValorTransferenciasDepositos = 0;

    public $fValorDespesaOrcamentaria = 0;

    public $fValorRP = 0;

    public $fValorDespesaExtra = 0;

    public $fValorTransferenciasRetiradas = 0;

    public $fSaldoFinal = 0;

    public $iInstit = 0;

    public $sOrigemDado;

    public $sContaBancaria;

    public $sDescTipoConta;

    public $iOrigem;

    /**
     * RelatorioDMN constructor.
     * @param $iConta
     * @param $iFonte
     * @param int $iInstit
     * @param int $iContaBancaria
     */
    public function __construct($iConta, $iFonte, $iInstit, $iContaBancaria)
    {
        $this->iConta = $iConta;
        $this->iFonte = $iFonte;
        $this->iInstit = $iInstit;
        $oContaBancaria = new ContaBancaria($iContaBancaria);
        $this->sContaBancaria = $oContaBancaria->getNumeroConta() . "-" . $oContaBancaria->getDVConta();
        $this->sDescTipoConta = $this->getDescTipoConta($oContaBancaria->getTipoConta());
        $this->sDescricao = $oContaBancaria->getDescricaoConta();

    }

    /**
     * Busca a movimentação da conta por fonte de recurso
     * @param $iAnousu
     * @param $iConta
     * @param $iFonte
     * @param $sDtini
     * @param $sDtFim
     * @param $iInstit
     * @return stdClass
     * @throws Exception
     */
    static function getSaldoCtbFonte($iAnousu, $iConta, $iFonte, $sDtini, $sDtFim, $iInstit)
    {

        $oRetorno = new stdClass();
        try {
            /*
             * SALDO DA CONTA POR FONTE
             */
            $sSqlSaldoContaPorFonte = "select coalesce(
                                        (select coalesce(conctbsaldo.ces02_valor,0)
                                           from conctbsaldo
                                                    join orctiporec on conctbsaldo.ces02_fonte = orctiporec.o15_codigo
                                          where conctbsaldo.ces02_reduz  = $iConta
                                            and conctbsaldo.ces02_anousu = $iAnousu
                                            and conctbsaldo.ces02_inst   = $iInstit
                                            and orctiporec.o15_codtri  = '{$iFonte}'),
                                            (select case when c62_vlrcre > 0 then c62_vlrcre*-1 else c62_vlrdeb end as valor
                                                     from conplanoexe
                                                     join orctiporec on conplanoexe.c62_codrec = orctiporec.o15_codigo
                                                     where c62_anousu = $iAnousu
                                                     and c62_reduz = $iConta
                                                     and orctiporec.o15_codtri = '{$iFonte}'),0) as fSaldoCtbInicialAno";

            $oRetorno->fSaldoCtbInicialAno = db_utils::fieldsMemory(db_query($sSqlSaldoContaPorFonte), 0)->fsaldoctbinicialano;

            /*
             * SOMA TOTAL DE CREDITO POR REDUZIDO E FONTE PARA SALDO INICIAL
             *
             */

            $sSqlCreditoAno = "select coalesce((select round(sum(valorcredito), 2) as vcredito from (
								select conlancamval.c69_valor as valorcredito,
									   case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
											when c71_coddoc in (100,101) then fontereceita.o15_codtri
											else  contacreditofonte.o15_codtri
									   end as fontemovimento
								  from conlancamdoc
							inner join conlancamval on conlancamval.c69_codlan  = conlancamdoc.c71_codlan
							inner join conplanoreduz contadebito on  contadebito.c61_reduz = conlancamval.c69_debito
							       and contadebito.c61_anousu = conlancamval.c69_anousu
							inner join conplanoreduz contacredito on  contacredito.c61_reduz = conlancamval.c69_credito
							       and contacredito.c61_anousu = conlancamval.c69_anousu
							 left join conlancamemp on conlancamemp.c75_codlan = conlancamdoc.c71_codlan
							 left join empempenho on empempenho.e60_numemp = conlancamemp.c75_numemp
							 left join orcdotacao on orcdotacao.o58_anousu = empempenho.e60_anousu
							       and orcdotacao.o58_coddot = empempenho.e60_coddot
							 left join orctiporec fontempenho on fontempenho.o15_codigo = orcdotacao.o58_codigo
							 left join orctiporec contacreditofonte on contacreditofonte.o15_codigo = contacredito.c61_codigo
							 left join orctiporec contadebitofonte on contadebitofonte.o15_codigo = contadebito.c61_codigo
							 left join conlancamrec on conlancamrec.c74_codlan = conlancamdoc.c71_codlan
							 left join orcreceita on orcreceita.o70_codrec = conlancamrec.c74_codrec
							       and orcreceita.o70_anousu = conlancamrec.c74_anousu
							 left join orcfontes receita on receita.o57_codfon  = orcreceita.o70_codfon
							       and receita.o57_anousu  = orcreceita.o70_anousu
							 left join orctiporec fontereceita on fontereceita.o15_codigo = orcreceita.o70_codigo
								 where DATE_PART('YEAR',conlancamdoc.c71_data) = $iAnousu
								   and conlancamdoc.c71_data < '{$sDtini}'
								   and conlancamval.c69_credito in ($iConta)) as xx where fontemovimento = '{$iFonte}'),0) as tCreditoAno";

            $oRetorno->fCreditoAno = db_utils::fieldsMemory(db_query($sSqlCreditoAno), 0)->tcreditoano;

            /*
             * SOMA TOTAL DE DEBITO POR REDUZIDO E FONTE PARA SALDO INICIAL
             */

            $sSqlDebitoAno = "select coalesce((select round(sum(valordebito), 2) as vdebito from (
								select conlancamval.c69_valor as valordebito,
									   case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
											when c71_coddoc in (100,101) then fontereceita.o15_codtri
											when c71_coddoc in (140,141) then contacreditofonte.o15_codtri
											else  contadebitofonte.o15_codtri
									   end as fontemovimento
								  from conlancamdoc
							inner join conlancamval on conlancamval.c69_codlan  = conlancamdoc.c71_codlan
							inner join conplanoreduz contadebito on  contadebito.c61_reduz = conlancamval.c69_debito and contadebito.c61_anousu = conlancamval.c69_anousu
							inner join conplanoreduz contacredito on  contacredito.c61_reduz = conlancamval.c69_credito and contacredito.c61_anousu = conlancamval.c69_anousu
							 left join conlancamemp on conlancamemp.c75_codlan = conlancamdoc.c71_codlan
							 left join empempenho on empempenho.e60_numemp = conlancamemp.c75_numemp
							 left join orcdotacao on orcdotacao.o58_anousu = empempenho.e60_anousu and orcdotacao.o58_coddot = empempenho.e60_coddot
							 left join orctiporec fontempenho on fontempenho.o15_codigo = orcdotacao.o58_codigo
							 left join orctiporec contacreditofonte on contacreditofonte.o15_codigo = contacredito.c61_codigo
							 left join orctiporec contadebitofonte on contadebitofonte.o15_codigo = contadebito.c61_codigo
							 left join conlancamrec on conlancamrec.c74_codlan = conlancamdoc.c71_codlan
							 left join orcreceita on orcreceita.o70_codrec = conlancamrec.c74_codrec and orcreceita.o70_anousu = conlancamrec.c74_anousu
							 left join orcfontes receita on receita.o57_codfon  = orcreceita.o70_codfon  and receita.o57_anousu  = orcreceita.o70_anousu
							 left join orctiporec fontereceita on fontereceita.o15_codigo = orcreceita.o70_codigo
								 where DATE_PART('YEAR',conlancamdoc.c71_data) = $iAnousu
								   and conlancamdoc.c71_data < '{$sDtini}'
								   and conlancamval.c69_debito in ($iConta)) as xx where fontemovimento = '{$iFonte}'),0) as tDebitoAno";

            $oRetorno->fDebitoAno = db_utils::fieldsMemory(db_query($sSqlDebitoAno), 0)->tdebitoano;

            $oRetorno->fSaldoInicialMes = round($oRetorno->fSaldoCtbInicialAno, 2) + round($oRetorno->fDebitoAno, 2) - round($oRetorno->fCreditoAno, 2);

            /*
             * SOMA TOTAL DE CREDITO POR REDUZIDO E FONTE PARA SALDO NO PERIODO
             */

            $sSqlCreditoPeriodo = "select coalesce((select round(sum(valorcredito), 2) as vcredito from (
								select conlancamval.c69_valor as valorcredito,
									   case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
											when c71_coddoc in (100,101) then fontereceita.o15_codtri
											else  contacreditofonte.o15_codtri
										end as fontemovimento
								  from conlancamdoc
							inner join conlancamval on conlancamval.c69_codlan  = conlancamdoc.c71_codlan
							inner join conplanoreduz contadebito on  contadebito.c61_reduz = conlancamval.c69_debito and contadebito.c61_anousu = conlancamval.c69_anousu
							inner join conplanoreduz contacredito on  contacredito.c61_reduz = conlancamval.c69_credito and contacredito.c61_anousu = conlancamval.c69_anousu
							 left join conlancamemp on conlancamemp.c75_codlan = conlancamdoc.c71_codlan
							 left join empempenho on empempenho.e60_numemp = conlancamemp.c75_numemp
							 left join orcdotacao on orcdotacao.o58_anousu = empempenho.e60_anousu and orcdotacao.o58_coddot = empempenho.e60_coddot
							 left join orctiporec fontempenho on fontempenho.o15_codigo = orcdotacao.o58_codigo
							 left join orctiporec contacreditofonte on contacreditofonte.o15_codigo = contacredito.c61_codigo
							 left join orctiporec contadebitofonte on contadebitofonte.o15_codigo = contadebito.c61_codigo
							 left join conlancamrec on conlancamrec.c74_codlan = conlancamdoc.c71_codlan
							 left join orcreceita on orcreceita.o70_codrec = conlancamrec.c74_codrec and orcreceita.o70_anousu = conlancamrec.c74_anousu
							 left join orcfontes receita on receita.o57_codfon  = orcreceita.o70_codfon  and receita.o57_anousu  = orcreceita.o70_anousu
							 left join orctiporec fontereceita on fontereceita.o15_codigo = orcreceita.o70_codigo
								 where DATE_PART('YEAR',conlancamdoc.c71_data) = $iAnousu
								   and conlancamdoc.c71_data between '{$sDtini}' and '{$sDtFim}'
								   and conlancamval.c69_credito in ($iConta)) as xx where fontemovimento = '{$iFonte}'),0) as tCreditoPeriodo";

            $oRetorno->fCreditoPeriodo = db_utils::fieldsMemory(db_query($sSqlCreditoPeriodo), 0)->tcreditoperiodo;

            /*
             * SOMA TOTAL DE DEBITO POR REDUZIDO E FONTE PARA SALDO NO PERIODO
             */

            $sSqlDebitoPeriodo = "select coalesce((select round(sum(valordebito), 2) as vdebito from (
								select conlancamval.c69_valor as valordebito,
									   case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
											when c71_coddoc in (100,101) then fontereceita.o15_codtri
											when c71_coddoc in (140,141) then contacreditofonte.o15_codtri
											else  contadebitofonte.o15_codtri
									   end as fontemovimento
								  from conlancamdoc
							inner join conlancamval on conlancamval.c69_codlan  = conlancamdoc.c71_codlan
							inner join conplanoreduz contadebito on  contadebito.c61_reduz = conlancamval.c69_debito and contadebito.c61_anousu = conlancamval.c69_anousu
							inner join conplanoreduz contacredito on  contacredito.c61_reduz = conlancamval.c69_credito and contacredito.c61_anousu = conlancamval.c69_anousu
							 left join conlancamemp on conlancamemp.c75_codlan = conlancamdoc.c71_codlan
							 left join empempenho on empempenho.e60_numemp = conlancamemp.c75_numemp
							 left join orcdotacao on orcdotacao.o58_anousu = empempenho.e60_anousu and orcdotacao.o58_coddot = empempenho.e60_coddot
							 left join orctiporec fontempenho on fontempenho.o15_codigo = orcdotacao.o58_codigo
							 left join orctiporec contacreditofonte on contacreditofonte.o15_codigo = contacredito.c61_codigo
							 left join orctiporec contadebitofonte on contadebitofonte.o15_codigo = contadebito.c61_codigo
							 left join conlancamrec on conlancamrec.c74_codlan = conlancamdoc.c71_codlan
							 left join orcreceita on orcreceita.o70_codrec = conlancamrec.c74_codrec and orcreceita.o70_anousu = conlancamrec.c74_anousu
							 left join orcfontes receita on receita.o57_codfon  = orcreceita.o70_codfon  and receita.o57_anousu  = orcreceita.o70_anousu
							 left join orctiporec fontereceita on fontereceita.o15_codigo = orcreceita.o70_codigo
								 where DATE_PART('YEAR',conlancamdoc.c71_data) = $iAnousu
								   and conlancamdoc.c71_data between '{$sDtini}' and '{$sDtFim}'
								   and conlancamval.c69_debito in ($iConta)) as xx where fontemovimento = '{$iFonte}'),0) as tDebitoPeriodo";

            $oRetorno->fDebitoPeriodo = db_utils::fieldsMemory(db_query($sSqlDebitoPeriodo), 0)->tdebitoperiodo;

            $oRetorno->fSaldoFinal = $oRetorno->fSaldoInicialMes + $oRetorno->fDebitoPeriodo - $oRetorno->fCreditoPeriodo;
            $oRetorno->sSinalAnt = $oRetorno->fSaldoInicialMes < 0 ? 'C' : 'D';
            $oRetorno->sSinalFinal = $oRetorno->fSaldoFinal < 0 ? 'C' : 'D';

            return $oRetorno;
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * Função que retorna a descrição do tipo da conta
     * @param $iTipo
     * @return string
     */
    public function getDescTipoConta($iTipo)
    {
        switch ($iTipo) {
            case 1:
                return "C/C";
                break;
            case 2:
                return "POUP";
                break;
            case 3:
                return "APLIC";
                break;
            default:
                return "C/C";
                break;
        }
    }

    /**
     * Busca a movimentação da receita Orçamentária
     * @param $iAnousu
     * @param $iInstit
     * @param $sDtIni
     * @param $sDtFim
     * @param $iConta
     * @param $sFonte
     * @return array|stdClass[]
     */
    static function getDadosReceitaOrcamentaria($iAnousu, $iInstit, $sDtIni, $sDtFim, $iConta, $sFonte)
    {
        $sqlReceitaOrcamentaria = "select sum(valor + estorno) as valor from (
            select k12_conta,
                   c60_descr,
                   k12_receit,
                   o15_codtri,
                   k02_tipo,
                   k02_drecei,
                   k12_instit,
                   c56_contabancaria,
                   sum(case when k12_estorn = 'f' then round(valor,2) else 0 end) as valor,
                   sum(case when k12_estorn = 't' then round(valor,2) else 0 end) as estorno
            from
            (select c60_codsis,
                   k12_estorn,
                   k12_conta,
                   o15_codtri,
                   c60_descr,
                   k12_receit,
                   tabrec.k02_tipo,
                   tabrec.k02_drecei,
                   corrente.k12_instit,
                   c56_contabancaria,
                   sum(round(cornump.k12_valor,2)) as valor
            from corrente
                          inner join cornump  on corrente.k12_id      = cornump.k12_id
                             and corrente.k12_data   = cornump.k12_data
                             and corrente.k12_autent = cornump.k12_autent
                          inner join tabrec  on k12_receit = k02_codigo
                          inner join taborc on tabrec.k02_codigo = taborc.k02_codigo and taborc.k02_anousu = {$iAnousu}
                      inner join orcreceita on taborc.k02_codrec = o70_codrec and taborc.k02_anousu = o70_anousu
                      inner join orctiporec on orctiporec.o15_codigo = o70_codigo
                      inner join conplanoexe on k12_conta = c62_reduz
                                            and c62_anousu = {$iAnousu}
                      inner join conplanoreduz on c62_reduz = c61_reduz and c61_anousu=c62_anousu
                      inner join conplano on c60_codcon = c61_codcon and c60_anousu=c61_anousu
                      inner join conplanocontabancaria on c56_codcon = c60_codcon and c56_anousu = c60_anousu
                     where corrente.k12_instit in ({$iInstit}) and
                       corrente.k12_data between '{$sDtIni}' and '{$sDtFim}' and k02_tipo = 'O'
            group by c60_codsis,
                     k12_estorn,
                     k12_conta,
                     o15_codtri,
                     c60_descr,
                     k12_receit,
                     tabrec.k02_tipo,
                     corrente.k12_instit,
                     c56_contabancaria,
                     tabrec.k02_drecei) as x where k12_conta = {$iConta} and o15_codtri = '{$sFonte}'
            group by k12_conta,
                     o15_codtri,
                     c60_descr,
                     k12_receit,
                     k02_tipo,
                     k02_drecei,
                     k12_instit,
                     c56_contabancaria
            order by k12_conta,o15_codtri) as x
            ";

        return db_utils::fieldsMemory(db_query($sqlReceitaOrcamentaria), 0)->valor;
    }

    static function getDadosReceitaExtra($iAnousu, $iInstit, $sDtIni, $sDtFim, $iConta, $sFonte)
    {

        $sqlReceitaExtra = "";
        $sqlReceitaExtra .= "select sum(valor) as valor from (SELECT * ";
        $sqlReceitaExtra .= "FROM   (SELECT g.k02_codigo, ";
        $sqlReceitaExtra .= "               g.k02_tipo, ";
        $sqlReceitaExtra .= "               g.k02_drecei, ";
        $sqlReceitaExtra .= "               CASE ";
        $sqlReceitaExtra .= "                 WHEN o.k02_codrec IS NOT NULL THEN o.k02_codrec ";
        $sqlReceitaExtra .= "                 ELSE p.k02_reduz ";
        $sqlReceitaExtra .= "               end         AS codrec, ";
        $sqlReceitaExtra .= "               CASE ";
        $sqlReceitaExtra .= "                 WHEN p.k02_codigo IS NULL THEN o.k02_estorc ";
        $sqlReceitaExtra .= "                 ELSE p.k02_estpla ";
        $sqlReceitaExtra .= "               end         AS estrutural, ";
        $sqlReceitaExtra .= "               k12_histcor AS k00_histtxt, ";
        $sqlReceitaExtra .= "               f.k12_data, ";
        $sqlReceitaExtra .= "               f.k12_numpre, ";
        $sqlReceitaExtra .= "               f.k12_numpar, ";
        $sqlReceitaExtra .= "               c61_reduz, ";
        $sqlReceitaExtra .= "               o15_codtri, ";
        $sqlReceitaExtra .= "               k12_instit, ";
        $sqlReceitaExtra .= "               c56_contabancaria, ";
        $sqlReceitaExtra .= "               c60_descr, ";
        $sqlReceitaExtra .= "               Round(f.k12_valor - Coalesce ((SELECT CASE ";
        $sqlReceitaExtra .= "                                                       WHEN r.k12_estorn IS TRUE ";
        $sqlReceitaExtra .= "                                                     THEN ";
        $sqlReceitaExtra .= "                                                       Sum(d.k12_valor) ";
        $sqlReceitaExtra .= "                                                       ELSE Sum(d.k12_valor) ";
        $sqlReceitaExtra .= "                                                     end ";
        $sqlReceitaExtra .= "                                              FROM   cornumpdesconto d ";
        $sqlReceitaExtra .= "                                              WHERE  d.k12_id = f.k12_id ";
        $sqlReceitaExtra .= "                                                     AND d.k12_data = f.k12_data ";
        $sqlReceitaExtra .= "                                                     AND d.k12_autent = ";
        $sqlReceitaExtra .= "                                                         f.k12_autent ";
        $sqlReceitaExtra .= "                                                     AND d.k12_numpre = ";
        $sqlReceitaExtra .= "                                                         f.k12_numpre ";
        $sqlReceitaExtra .= "                                                     AND d.k12_numpar = ";
        $sqlReceitaExtra .= "                                                         f.k12_numpar ";
        $sqlReceitaExtra .= "                                                     AND d.k12_receitaprincipal ";
        $sqlReceitaExtra .= "                                                         = ";
        $sqlReceitaExtra .= "                                                         f.k12_receit ";
        $sqlReceitaExtra .= "                                                     AND d.k12_numnov = ";
        $sqlReceitaExtra .= "                                                         f.k12_numnov), ";
        $sqlReceitaExtra .= "                                   0 ";
        $sqlReceitaExtra .= "                                   ), 2) ";
        $sqlReceitaExtra .= "                           AS valor ";
        $sqlReceitaExtra .= "        FROM   cornump f ";
        $sqlReceitaExtra .= "               INNER JOIN corrente r ";
        $sqlReceitaExtra .= "                       ON r.k12_id = f.k12_id ";
        $sqlReceitaExtra .= "                          AND r.k12_data = f.k12_data ";
        $sqlReceitaExtra .= "                          AND r.k12_autent = f.k12_autent ";
        $sqlReceitaExtra .= "               INNER JOIN conplanoreduz c1 ";
        $sqlReceitaExtra .= "                       ON r.k12_conta = c1.c61_reduz ";
        $sqlReceitaExtra .= "                          AND c1.c61_anousu = Extract (year FROM r.k12_data) ";
        $sqlReceitaExtra .= "               INNER JOIN orctiporec on c1.c61_codigo = o15_codigo";
        $sqlReceitaExtra .= "               INNER JOIN conplano ";
        $sqlReceitaExtra .= "                       ON c1.c61_codcon = c60_codcon ";
        $sqlReceitaExtra .= "                          AND c60_anousu = Extract (year FROM r.k12_data) ";
        $sqlReceitaExtra .= "               inner join conplanocontabancaria on c56_codcon = c60_codcon and c56_anousu = c60_anousu";
        $sqlReceitaExtra .= "               INNER JOIN tabrec g ";
        $sqlReceitaExtra .= "                       ON g.k02_codigo = f.k12_receit ";
        $sqlReceitaExtra .= "               LEFT OUTER JOIN taborc o ";
        $sqlReceitaExtra .= "                            ON o.k02_codigo = g.k02_codigo ";
        $sqlReceitaExtra .= "                               AND o.k02_anousu = Extract (year FROM r.k12_data) ";
        $sqlReceitaExtra .= "               LEFT OUTER JOIN tabplan p ";
        $sqlReceitaExtra .= "                            ON p.k02_codigo = g.k02_codigo ";
        $sqlReceitaExtra .= "                               AND p.k02_anousu = Extract (year FROM r.k12_data) ";
        $sqlReceitaExtra .= "               LEFT JOIN corhist hist ";
        $sqlReceitaExtra .= "                      ON hist.k12_id = f.k12_id ";
        $sqlReceitaExtra .= "                         AND hist.k12_data = f.k12_data ";
        $sqlReceitaExtra .= "                         AND hist.k12_autent = f.k12_autent ";
        $sqlReceitaExtra .= "        WHERE  f.k12_data BETWEEN '{$sDtIni}' and '{$sDtFim}' ";
        $sqlReceitaExtra .= "               AND r.k12_instit = {$iInstit} ";
        $sqlReceitaExtra .= "        UNION ALL ";
        $sqlReceitaExtra .= "        SELECT g.k02_codigo, ";
        $sqlReceitaExtra .= "               g.k02_tipo, ";
        $sqlReceitaExtra .= "               g.k02_drecei, ";
        $sqlReceitaExtra .= "               CASE ";
        $sqlReceitaExtra .= "                 WHEN o.k02_codrec IS NOT NULL THEN o.k02_codrec ";
        $sqlReceitaExtra .= "                 ELSE p.k02_reduz ";
        $sqlReceitaExtra .= "               end                   AS codrec, ";
        $sqlReceitaExtra .= "               CASE ";
        $sqlReceitaExtra .= "                 WHEN p.k02_codigo IS NULL THEN o.k02_estorc ";
        $sqlReceitaExtra .= "                 ELSE p.k02_estpla ";
        $sqlReceitaExtra .= "               end                   AS estrutural, ";
        $sqlReceitaExtra .= "               k12_histcor           AS k00_histtxt, ";
        $sqlReceitaExtra .= "               f.k12_data, ";
        $sqlReceitaExtra .= "               f.k12_numpre, ";
        $sqlReceitaExtra .= "               f.k12_numpar, ";
        $sqlReceitaExtra .= "               c61_reduz, ";
        $sqlReceitaExtra .= "               o15_codtri, ";
        $sqlReceitaExtra .= "               k12_instit, ";
        $sqlReceitaExtra .= "               c56_contabancaria, ";
        $sqlReceitaExtra .= "               c60_descr, ";
        $sqlReceitaExtra .= "               Round(f.k12_valor, 2) AS valor ";
        $sqlReceitaExtra .= "        FROM   cornumpdesconto f ";
        $sqlReceitaExtra .= "               INNER JOIN corrente r ";
        $sqlReceitaExtra .= "                       ON r.k12_id = f.k12_id ";
        $sqlReceitaExtra .= "                          AND r.k12_data = f.k12_data ";
        $sqlReceitaExtra .= "                          AND r.k12_autent = f.k12_autent ";
        $sqlReceitaExtra .= "               INNER JOIN conplanoreduz c1 ";
        $sqlReceitaExtra .= "                       ON r.k12_conta = c1.c61_reduz ";
        $sqlReceitaExtra .= "                          AND c1.c61_anousu = Extract (year FROM r.k12_data) ";
        $sqlReceitaExtra .= "               INNER JOIN orctiporec on c1.c61_codigo = o15_codigo";
        $sqlReceitaExtra .= "               INNER JOIN conplano ";
        $sqlReceitaExtra .= "                       ON c1.c61_codcon = c60_codcon ";
        $sqlReceitaExtra .= "                          AND c60_anousu = Extract (year FROM r.k12_data) ";
        $sqlReceitaExtra .= "               inner join conplanocontabancaria on c56_codcon = c60_codcon and c56_anousu = c60_anousu";
        $sqlReceitaExtra .= "               INNER JOIN tabrec g ";
        $sqlReceitaExtra .= "                       ON g.k02_codigo = f.k12_receit ";
        $sqlReceitaExtra .= "               LEFT OUTER JOIN taborc o ";
        $sqlReceitaExtra .= "                            ON o.k02_codigo = g.k02_codigo ";
        $sqlReceitaExtra .= "                               AND o.k02_anousu = Extract (year FROM r.k12_data) ";
        $sqlReceitaExtra .= "               LEFT OUTER JOIN tabplan p ";
        $sqlReceitaExtra .= "                            ON p.k02_codigo = g.k02_codigo ";
        $sqlReceitaExtra .= "                               AND p.k02_anousu = Extract (year FROM r.k12_data) ";
        $sqlReceitaExtra .= "               LEFT JOIN corhist hist ";
        $sqlReceitaExtra .= "                      ON hist.k12_id = f.k12_id ";
        $sqlReceitaExtra .= "                         AND hist.k12_data = f.k12_data ";
        $sqlReceitaExtra .= "                         AND hist.k12_autent = f.k12_autent ";
        $sqlReceitaExtra .= "        WHERE  f.k12_data BETWEEN '{$sDtIni}' and '{$sDtFim}' ";
        $sqlReceitaExtra .= "               AND r.k12_instit = {$iInstit}) AS xxx ";
        $sqlReceitaExtra .= "WHERE  1 = 1 ";
        $sqlReceitaExtra .= "       AND valor <> 0 ";
        $sqlReceitaExtra .= "       AND c61_reduz IN ( $iConta ) and o15_codtri = '{$sFonte}'";
        $sqlReceitaExtra .= "       AND k02_tipo = 'E' ";
        $sqlReceitaExtra .= "ORDER  BY k12_data, ";
        $sqlReceitaExtra .= "          k02_tipo, ";
        $sqlReceitaExtra .= "          k02_codigo) as y";

        return db_utils::fieldsMemory(db_query($sqlReceitaExtra), 0)->valor;
    }

    static function getDadosDespesaExtra($iAnousu, $iInstit, $sDtIni, $sDtFim, $iConta, $sFonte)
    {

        $sSqlDepesaExtra = "select sum(k12_valor) as valor from (SELECT k12_id,
                               k12_autent,
                               k12_data,
                               k12_valor,
                               CASE
                                   WHEN (h.c60_codsis = 6
                                         AND f.c60_codsis = 6) THEN 'tran'
                                   WHEN (h.c60_codsis = 6
                                         AND f.c60_codsis = 5) THEN 'tran'
                                   WHEN (h.c60_codsis = 5
                                         AND f.c60_codsis = 6) THEN 'tran'
                                   ELSE 'desp'
                               END AS tipo,
                               k12_empen,
                               k12_codord,
                               k12_cheque,
                               entrou AS debito,
                               f.c60_descr AS descr_debito,
                               f.c60_codsis AS sis_debito,
                               saiu AS credito,
                               o15_codtri,
                               h.c60_descr AS descr_credito,
                               h.c60_codsis AS sis_credito,
                               sl AS k17_codigo,
                               corhi AS k12_histcor,
                               sl_txt AS k17_texto
                        FROM
                          (SELECT k12_id,
                                  k12_autent,
                                  k12_data,
                                  k12_valor,
                                  tipo,
                                  k12_empen,
                                  k12_codord,
                                  k12_cheque,
                                  corlanc AS entrou,
                                  corrente AS saiu,
                                  slp AS sl,
                                  corh AS corhi,
                                  slp_txt AS sl_txt
                           FROM
                             (SELECT *,
                                     CASE
                                         WHEN coalesce(corl_saltes,0) = 0 THEN 'desp'
                                         ELSE 'tran'
                                     END AS tipo
                              FROM
                                (SELECT corrente.k12_id,
                                        corrente.k12_autent,
                                        corrente.k12_data,
                                        corrente.k12_valor,
                                        corrente.k12_conta AS corrente,
                                        c.k13_conta AS corr_saltes,
                                        b.k12_conta AS corlanc,
                                        d.k13_conta AS corl_saltes,
                                        p.k12_empen,
                                        p.k12_codord,
                                        p.k12_cheque,
                                        slip.k17_codigo AS slp,
                                        corhist.k12_histcor AS corh,
                                        slip.k17_texto AS slp_txt
                                 FROM corrente
                                 INNER JOIN corlanc b ON corrente.k12_id = b.k12_id
                                 AND corrente.k12_autent = b.k12_autent
                                 AND corrente.k12_data = b.k12_data
                                 INNER JOIN slip ON slip.k17_codigo = b.k12_codigo
                                 LEFT JOIN corhist ON corhist.k12_id = b.k12_id
                                 AND corhist.k12_data = b.k12_data
                                 AND corhist.k12_autent = b.k12_autent
                                 LEFT JOIN coremp p ON corrente.k12_id = p.k12_id
                                 AND corrente.k12_autent=p.k12_autent
                                 AND corrente.k12_data = p.k12_data
                                 LEFT JOIN saltes c ON c.k13_conta = corrente.k12_conta
                                 LEFT JOIN saltes d ON d.k13_conta = b.k12_conta
                                 WHERE corrente.k12_data BETWEEN '{$sDtIni}' and '{$sDtFim}'
                                   AND corrente.k12_instit = {$iInstit}
                                   AND corrente.k12_instit = {$iInstit}) AS x) AS xx) AS xxx
                        INNER JOIN conplanoexe e ON entrou = e.c62_reduz
                        AND e.c62_anousu = {$iAnousu}
                        INNER JOIN conplanoreduz i ON e.c62_reduz = i.c61_reduz
                        AND i.c61_anousu={$iAnousu}
                        AND i.c61_instit = {$iInstit}
                        inner join orctiporec  l on i.c61_codigo = l.o15_codigo
                        INNER JOIN conplano f ON i.c61_codcon = f.c60_codcon
                        AND i.c61_anousu = f.c60_anousu
                        INNER JOIN conplanoexe g ON saiu = g.c62_reduz
                        AND g.c62_anousu = {$iAnousu}
                        INNER JOIN conplanoreduz j ON g.c62_reduz = j.c61_reduz
                        AND j.c61_anousu={$iAnousu}
                        INNER JOIN conplano h ON j.c61_codcon = h.c60_codcon
                        AND j.c61_anousu = h.c60_anousu
                        ORDER BY tipo,
                                 credito,
                                 k12_data,
                                 k12_autent) as yy where tipo = 'desp' and credito = {$iConta} and o15_codtri = '{$sFonte}'
                                    ";

        return db_utils::fieldsMemory(db_query($sSqlDepesaExtra), 0)->valor;
    }

    static function getDadosDespesaOrcamentaria($iAnousu, $iInstit, $sDtIni, $sDtFim, $iConta, $sFonte)
    {

        $sqlDespesaOrcamentaria = "
        select sum(valor+estorno) as valor
                        from (
             select c60_codsis,
                        corrente.k12_conta,
                        o15_codtri,
                        c60_descr,
                        case when corrente.k12_estorn = 'f' then sum(round(k12_valor,2)) else 0 end as valor,
                        case when corrente.k12_estorn = 't' then sum(round(k12_valor,2)) else 0 end as estorno,
                        corrente.k12_instit,
                        c56_contabancaria
             from corrente
                          inner join coremp b       on corrente.k12_autent = b.k12_autent
                                                   and corrente.k12_id = b.k12_id
                                                   and corrente.k12_data = b.k12_data
                          left join corlanc c       on c.k12_autent = b.k12_autent
                                               and c.k12_id = b.k12_id
                                               and c.k12_data = b.k12_data
                          inner join empempenho e   on e60_numemp = b.k12_empen
                          inner join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
                          inner join orctiporec on o58_codigo = o15_codigo
                          inner join conplanoreduz on c61_reduz = corrente.k12_conta and c61_anousu= e.e60_anousu
                          inner join conplano on c61_codcon = c60_codcon and c60_anousu=c61_anousu
                          inner join conplanocontabancaria on c56_codcon = c60_codcon and c56_anousu = c60_anousu
             where corrente.k12_instit = {$iInstit} and
                    c.k12_codigo is null and
                    e.e60_anousu = {$iAnousu} and
                    corrente.k12_data between '{$sDtIni}' and '{$sDtFim}'
             group by c60_codsis,corrente.k12_conta,o15_codtri,c60_descr,k12_estorn,k12_instit,c56_contabancaria
             order by c60_codsis,corrente.k12_conta) as xx where k12_conta = {$iConta} and o15_codtri = '{$sFonte}'";

        return db_utils::fieldsMemory(db_query($sqlDespesaOrcamentaria), 0)->valor;
    }

    static function getDadosRP($iAnousu, $iInstit, $sDtIni, $sDtFim, $iConta, $sFonte)
    {
        $sqlRestos = "SELECT sum(k12_valor) as valor
                        FROM
                          (SELECT coremp.k12_empen,
                                  e60_numemp,
                                  e60_codemp,
                                  CASE
                                      WHEN e49_numcgm IS NULL THEN e60_numcgm
                                      ELSE e49_numcgm
                                  END AS e60_numcgm,
                                  k12_codord AS e50_codord,
                                  CASE
                                      WHEN e49_numcgm IS NULL THEN cgm.z01_nome
                                      ELSE cgmordem.z01_nome
                                  END AS z01_nome,
                                  k12_valor,
                                  k12_cheque,
                                  e60_anousu,
                                  coremp.k12_autent,
                                  coremp.k12_data,
                                  k13_conta,
                                  o15_codtri,
                                  k13_descr,
                                  k106_sequencial
                           FROM coremp
                           INNER JOIN empempenho ON e60_numemp = k12_empen
                           AND e60_instit = {$iInstit}
                           INNER JOIN orcdotacao ON e60_coddot = o58_coddot
                           AND e60_anousu = o58_anousu
                           inner join orctiporec on o58_codigo = o15_codigo
                           INNER JOIN pagordem ON e50_codord = k12_codord
                           LEFT JOIN pagordemconta ON e50_codord = e49_codord
                           INNER JOIN corrente ON corrente.k12_id = coremp.k12_id
                           AND corrente.k12_data = coremp.k12_data
                           AND corrente.k12_autent = coremp.k12_autent
                           INNER JOIN cgm ON cgm.z01_numcgm = e60_numcgm
                           LEFT JOIN cgm cgmordem ON cgmordem.z01_numcgm = e49_numcgm
                           INNER JOIN saltes ON saltes.k13_conta = corrente.k12_conta
                           LEFT JOIN corgrupocorrente ON k105_id = corrente.k12_id
                           AND k105_data = corrente.k12_data
                           AND k105_autent = corrente.k12_autent
                           LEFT JOIN corgrupotipo ON k106_sequencial = k105_corgrupotipo
                           WHERE k13_conta = {$iConta} and o15_codtri = '{$sFonte}' and e60_anousu < {$iAnousu}
                             AND coremp.k12_data BETWEEN '{$sDtIni}' and '{$sDtFim}'
                           ORDER BY
                                    k13_conta,
                                    o15_codtri,
                                    e60_codemp) AS xxx";

        return db_utils::fieldsMemory(db_query($sqlRestos), 0)->valor;
    }

    static function getDadosTransferenciasRetiradas($iAnousu, $iInstit, $sDtIni, $sDtFim, $iConta, $sFonte)
    {

        $sSqlTransferencias = "select sum(valor+estorno) as valor from (
                                select k12_data,
                                       case when k12_estorn =  'f' then valor else 0 end as valor,
                                       case when k12_estorn <> 'f' then valor else 0 end as estorno,
                                       corrente,
                                       o15_codtri,
                                       fontecorlanc,
                                       descr_conta,
                                       corr_saltes,
                                       corlanc,
                                       case when (sisdebito = 6 and siscredito = 6) then 'tran'
                                            when (sisdebito = 6 and siscredito = 5) then 'tran'
                                            when (sisdebito = 5 and siscredito = 6) then 'tran'
                                            when (sisdebito = 5 and siscredito = 5) then 'tran'
                                       else 'desp' end as  tipo,
                                       descr_receita,
                                       corl_saltes,
                                       k12_instit,
                                       c56_contabancaria
                                from (
                                select corrente.k12_id,
                                       corrente.k12_data,
                                       sum(round(corrente.k12_valor,2)) as valor,
                                       corrente.k12_conta as corrente,
                                       l.o15_codtri,
                                       j.o15_codtri as fontecorlanc,
                                       p2.c60_descr as descr_conta,
                                       coalesce(c.k13_conta,0) as corr_saltes,
                                       b.k12_conta as corlanc,
                                       p1.c60_descr as descr_receita,
                                       p1.c60_codsis as sisdebito,
                                       p2.c60_codsis as siscredito,
                                       coalesce(d.k13_conta,0) as corl_saltes,
                                       k12_estorn,
                                       corrente.k12_instit,
                                       c56_contabancaria
                                from corrente
                                     inner join corlanc b on corrente.k12_id = b.k12_id
                                                          and corrente.k12_autent=b.k12_autent
                                                          and corrente.k12_data = b.k12_data
                                     left join sliptipooperacaovinculo on b.k12_codigo = k153_slip
                                                    and k153_slipoperacaotipo in (1,2,5,6,9,10,13,14)
                                     left join saltes c   on c.k13_conta = corrente.k12_conta
                                     left join saltes d   on d.k13_conta = b.k12_conta
                                     inner join conplanoreduz r1 on b.k12_conta = r1.c61_reduz and r1.c61_anousu={$iAnousu}
                                     inner join orctiporec    j on r1.c61_codigo = j.o15_codigo
                                     inner join conplano      p1 on r1.c61_codcon = p1.c60_codcon and r1.c61_anousu=p1.c60_anousu
                                     inner join conplanoreduz r2 on corrente.k12_conta = r2.c61_reduz and r2.c61_anousu={$iAnousu}
                                     inner join orctiporec    l on r2.c61_codigo = l.o15_codigo
                                     inner join conplano      p2 on r2.c61_codcon = p2.c60_codcon and r2.c61_anousu=p2.c60_anousu
                                     inner join conplanocontabancaria on c56_codcon = p2.c60_codcon and c56_anousu = p2.c60_anousu
                                where corrente.k12_instit = {$iInstit} and
                                      corrente.k12_data between '{$sDtIni}' and '{$sDtFim}'
                                group by corrente.k12_id,
                                       corrente.k12_data,
                                       corrente.k12_conta,
                                       l.o15_codtri,
                                       j.o15_codtri,
                                       p2.c60_descr,
                                       c.k13_conta,
                                       b.k12_conta,
                                       p1.c60_descr,
                                       p1.c60_codsis,
                                       p2.c60_codsis,
                                       d.k13_conta,
                                       k12_estorn,
                                       corrente.k12_instit,
                                       c56_contabancaria
                                order by corrente.k12_conta,
                                         p2.c60_descr,
                                     b.k12_conta,
                                     p1.c60_descr
                                ) as x ) as xx where tipo = 'tran' and corrente = {$iConta} and o15_codtri = '{$sFonte}'";
        return db_utils::fieldsMemory(db_query($sSqlTransferencias), 0)->valor;

    }

    static function getDadosTransferenciasDepositos($iAnousu, $iInstit, $sDtIni, $sDtFim, $iConta, $sFonte)
    {

        $sSqlTransferencias = "select sum(valor+estorno) as valor from (
                                select k12_data,
                                       case when k12_estorn =  'f' then valor else 0 end as valor,
                                       case when k12_estorn <> 'f' then valor else 0 end as estorno,
                                       corrente,
                                       o15_codtri,
                                       fontecorlanc,
                                       descr_conta,
                                       corr_saltes,
                                       corlanc,
                                       case when (sisdebito = 6 and siscredito = 6) then 'tran'
                                            when (sisdebito = 6 and siscredito = 5) then 'tran'
                                            when (sisdebito = 5 and siscredito = 6) then 'tran'
                                            when (sisdebito = 5 and siscredito = 5) then 'tran'
                                       else 'desp' end as  tipo,
                                       descr_receita,
                                       corl_saltes,
                                       k12_instit,
                                       c56_contabancaria
                                from (
                                select corrente.k12_id,
                                       corrente.k12_data,
                                       sum(round(corrente.k12_valor,2)) as valor,
                                       corrente.k12_conta as corrente,
                                       l.o15_codtri,
                                       j.o15_codtri as fontecorlanc,
                                       p2.c60_descr as descr_conta,
                                       coalesce(c.k13_conta,0) as corr_saltes,
                                       b.k12_conta as corlanc,
                                       p1.c60_descr as descr_receita,
                                       p1.c60_codsis as sisdebito,
                                       p2.c60_codsis as siscredito,
                                       coalesce(d.k13_conta,0) as corl_saltes,
                                       k12_estorn,
                                       corrente.k12_instit,
                                       c56_contabancaria
                                from corrente
                                     inner join corlanc b on corrente.k12_id = b.k12_id
                                                          and corrente.k12_autent=b.k12_autent
                                                          and corrente.k12_data = b.k12_data
                                     left join sliptipooperacaovinculo on b.k12_codigo = k153_slip
                                                    and k153_slipoperacaotipo in (1,2,5,6,9,10,13,14)
                                     left join saltes c   on c.k13_conta = corrente.k12_conta
                                     left join saltes d   on d.k13_conta = b.k12_conta
                                     inner join conplanoreduz r1 on b.k12_conta = r1.c61_reduz and r1.c61_anousu={$iAnousu}
                                     inner join orctiporec    j on r1.c61_codigo = j.o15_codigo
                                     inner join conplano      p1 on r1.c61_codcon = p1.c60_codcon and r1.c61_anousu=p1.c60_anousu
                                     inner join conplanoreduz r2 on corrente.k12_conta = r2.c61_reduz and r2.c61_anousu={$iAnousu}
                                     inner join orctiporec    l on r2.c61_codigo = l.o15_codigo
                                     inner join conplano      p2 on r2.c61_codcon = p2.c60_codcon and r2.c61_anousu=p2.c60_anousu
                                     inner join conplanocontabancaria on c56_codcon = p2.c60_codcon and c56_anousu = p2.c60_anousu
                                where corrente.k12_instit = {$iInstit} and
                                      corrente.k12_data between '{$sDtIni}' and '{$sDtFim}'
                                group by corrente.k12_id,
                                       corrente.k12_data,
                                       corrente.k12_conta,
                                       l.o15_codtri,
                                       j.o15_codtri,
                                       p2.c60_descr,
                                       c.k13_conta,
                                       b.k12_conta,
                                       p1.c60_descr,
                                       p1.c60_codsis,
                                       p2.c60_codsis,
                                       d.k13_conta,
                                       k12_estorn,
                                       corrente.k12_instit,
                                       c56_contabancaria
                                order by corrente.k12_conta,
                                         p2.c60_descr,
                                     b.k12_conta,
                                     p1.c60_descr
                                ) as x ) as xx where tipo = 'tran' and corlanc = {$iConta} and fontecorlanc = '{$sFonte}'";

        return db_utils::fieldsMemory(db_query($sSqlTransferencias), 0)->valor;

    }

    static function getDadosInscricaoRP($aInstit)
    {
        $sSqlInscricaoRP = "select sum(valor_nao_processado+valor_processado) as valor from (select
                       e60_numemp,
                       (vlremp - vlranu - vlrliq) as valor_nao_processado,
                       (vlrliq - vlrpag) as valor_processado
                 from (select
                        e60_numemp,
                        sum(case when c71_coddoc IN (select c53_coddoc from conhistdoc where c53_tipo = 10) then round(c70_valor,2) else 0 end) as vlremp,
                        sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 11) then round(c70_valor,2) else 0 end) as vlranu,
                        sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 20) then round(c70_valor,2)
                        when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 21) then round(c70_valor,2) *-1
                        else 0 end) as vlrliq,
                        sum(case when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 30) then round(c70_valor,2)
                        when c71_coddoc in (select c53_coddoc from conhistdoc where c53_tipo = 31) then round(c70_valor,2) *-1
                        else 0 end) as vlrpag
                       from     empempenho
                                inner join conlancamemp on e60_numemp = c75_numemp
                                inner join conlancamcgm on c75_codlan = c76_codlan
                                inner join cgm          on c76_numcgm = z01_numcgm
                                inner join conlancamdoc on c75_codlan = c71_codlan
                                inner join conlancam    on c75_codlan = c70_codlan
                                inner join orcdotacao   on e60_coddot = o58_coddot
                                                       and e60_anousu = o58_anousu
                                inner join orcelemento  on o58_codele = o56_codele
                                                       and o58_anousu = o56_anousu
                                inner join orctiporec on o58_codigo = o15_codigo
                                inner join db_config on codigo = e60_instit
                                inner join orcunidade on o58_orgao = o41_orgao and o58_unidade = o41_unidade and o41_anousu = o58_anousu
                                inner JOIN orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                                left join infocomplementaresinstit on codigo = si09_instit
                       where    e60_anousu = ".db_getsession("DB_anousu")." and e60_instit in (".implode(',',$aInstit).")
                            and c70_data between '".db_getsession("DB_anousu")."-01-01' and '".db_getsession("DB_anousu")."-12-31'
                     group by   e60_numemp
                                ) as restos) as x
                                where valor_nao_processado > 0 or valor_processado > 0";

        return db_utils::fieldsMemory(db_query($sSqlInscricaoRP), 0)->valor;
    }

    /**
     * Função que retorna todas as contas que serão listadas no relatório
     * @param $iAnousu
     * @param $aInstit
     * @param $sDtIni
     * @param $sDtFim
     * @param $aContas
     * @param $sFonte
     * @return array|stdClass[]
     */
    static function getContas($iAnousu, $aInstit, $sDtIni, $sDtFim, $aContas, $sFonte)
    {
        $sWhereContas = is_array($aContas) ? " and k13_reduz in (".implode(',',$aContas).")": "";
        $sWhereFontes = !empty($sFonte) ? " where fontemovimento = '$sFonte'" : "";
        $aRetorno = array();
        $sSqlGeral = "select k13_reduz as codctb,
					         c56_contabancaria,
					         c60_descr,
				             c61_instit
				       from saltes
				       join conplanoreduz on k13_reduz = c61_reduz and c61_anousu = {$iAnousu}
				       inner join conplano on c61_codcon = c60_codcon and c61_anousu = c60_anousu
				       join conplanoconta on c63_codcon = c61_codcon and c63_anousu = c61_anousu
				       join orctiporec on c61_codigo = o15_codigo
				       left join conplanocontabancaria on c56_codcon = c61_codcon and c56_anousu = c61_anousu
				       left join contabancaria on c56_contabancaria = db83_sequencial
				       where (k13_limite is null
				       or k13_limite >= '$sDtFim')
				       and (k13_dtimplantacao <= '$sDtFim' or date_part('YEAR',k13_dtimplantacao) < {$iAnousu})
    				   and c61_instit in (" . implode(',', $aInstit) . ") {$sWhereContas} order by k13_reduz ";

        $aContasGeral = db_utils::getColectionByRecord(db_query($sSqlGeral));

        foreach ($aContasGeral as $oConta) {

            $sSqlFonte = "select distinct codctb as conta, fontemovimento as fonte from (
									select c61_reduz  as codctb, o15_codtri  as fontemovimento
									  from conplano
								inner join conplanoreduz on conplanoreduz.c61_codcon = conplano.c60_codcon and conplanoreduz.c61_anousu = conplano.c60_anousu
								inner join orctiporec on o15_codigo = c61_codigo
									 where conplanoreduz.c61_reduz  in ({$oConta->codctb})
									   and conplanoreduz.c61_anousu = {$iAnousu}
								 union all
								select c61_reduz  as codctb, ces02_fonte::varchar  as fontemovimento
									  from conctbsaldo
								inner join conplanoreduz on conctbsaldo.ces02_reduz = conplanoreduz.c61_reduz and conplanoreduz.c61_anousu = conctbsaldo.ces02_anousu
								inner join orctiporec on o15_codigo = c61_codigo
									 where conctbsaldo.ces02_reduz  in ({$oConta->codctb})
									   and conctbsaldo.ces02_anousu = {$iAnousu}
								 union all
								select contacredito.c61_reduz as codctb,
									   case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
											when c71_coddoc in (100,101) then fontereceita.o15_codtri
											when c71_coddoc in (140,141) then contadebitofonte.o15_codtri
											else  contacreditofonte.o15_codtri
										end as fontemovimento
								  from conlancamdoc
							inner join conlancamval on conlancamval.c69_codlan  = conlancamdoc.c71_codlan
							inner join conplanoreduz contadebito on  contadebito.c61_reduz = conlancamval.c69_debito and contadebito.c61_anousu = conlancamval.c69_anousu
							inner join conplanoreduz contacredito on  contacredito.c61_reduz = conlancamval.c69_credito and contacredito.c61_anousu = conlancamval.c69_anousu
							 left join conlancamemp on conlancamemp.c75_codlan = conlancamdoc.c71_codlan
							 left join empempenho on empempenho.e60_numemp = conlancamemp.c75_numemp
							 left join orcdotacao on orcdotacao.o58_anousu = empempenho.e60_anousu and orcdotacao.o58_coddot = empempenho.e60_coddot
							 left join orctiporec fontempenho on fontempenho.o15_codigo = orcdotacao.o58_codigo
							 left join orctiporec contacreditofonte on contacreditofonte.o15_codigo = contacredito.c61_codigo
							 left join orctiporec contadebitofonte on contadebitofonte.o15_codigo = contadebito.c61_codigo
							 left join conlancamrec on conlancamrec.c74_codlan = conlancamdoc.c71_codlan
							 left join orcreceita on orcreceita.o70_codrec = conlancamrec.c74_codrec and orcreceita.o70_anousu = conlancamrec.c74_anousu
							 left join orcfontes receita on receita.o57_codfon  = orcreceita.o70_codfon  and receita.o57_anousu  = orcreceita.o70_anousu
							 left join orctiporec fontereceita on fontereceita.o15_codigo = orcreceita.o70_codigo
								 where DATE_PART('YEAR',conlancamdoc.c71_data) = {$iAnousu}
								   and conlancamdoc.c71_data <= '{$sDtFim}'
								   and conlancamval.c69_credito in ({$oConta->codctb})
							 union all
								select contadebito.c61_reduz as codctb,
									   case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
											when c71_coddoc in (100,101) then fontereceita.o15_codtri
											when c71_coddoc in (140,141) then contacreditofonte.o15_codtri
											else  contadebitofonte.o15_codtri
									   end as fontemovimento
								  from conlancamdoc
							inner join conlancamval on conlancamval.c69_codlan  = conlancamdoc.c71_codlan
							inner join conplanoreduz contadebito on  contadebito.c61_reduz = conlancamval.c69_debito and contadebito.c61_anousu = conlancamval.c69_anousu
							inner join conplanoreduz contacredito on  contacredito.c61_reduz = conlancamval.c69_credito and contacredito.c61_anousu = conlancamval.c69_anousu
							 left join conlancamemp on conlancamemp.c75_codlan = conlancamdoc.c71_codlan
							 left join empempenho on empempenho.e60_numemp = conlancamemp.c75_numemp
							 left join orcdotacao on orcdotacao.o58_anousu = empempenho.e60_anousu and orcdotacao.o58_coddot = empempenho.e60_coddot
							 left join orctiporec fontempenho on fontempenho.o15_codigo = orcdotacao.o58_codigo
							 left join orctiporec contacreditofonte on contacreditofonte.o15_codigo = contacredito.c61_codigo
							 left join orctiporec contadebitofonte on contadebitofonte.o15_codigo = contadebito.c61_codigo
							 left join conlancamrec on conlancamrec.c74_codlan = conlancamdoc.c71_codlan
							 left join orcreceita on orcreceita.o70_codrec = conlancamrec.c74_codrec and orcreceita.o70_anousu = conlancamrec.c74_anousu
							 left join orcfontes receita on receita.o57_codfon  = orcreceita.o70_codfon  and receita.o57_anousu  = orcreceita.o70_anousu
							 left join orctiporec fontereceita on fontereceita.o15_codigo = orcreceita.o70_codigo
								 where DATE_PART('YEAR',conlancamdoc.c71_data) = {$iAnousu}
								   and conlancamdoc.c71_data <= '{$sDtFim}'
								   and conlancamval.c69_debito in ({$oConta->codctb})
							) as xx $sWhereFontes";
            $aFontes = db_utils::getColectionByRecord(db_query($sSqlFonte));

            $oRetorno = new stdClass();
            $oRetorno->iConta = $oConta->codctb;
            $oRetorno->iInstit = $oConta->c61_instit;
            $oRetorno->iContaBancaria = $oConta->c56_contabancaria;
            $oRetorno->sDescricaoConta = $oConta->c60_descr;
            $oRetorno->sDescrTipo = RelatorioDMN::getDescTipoConta($oConta->db83_tipoconta);
            $oRetorno->aFontes = $aFontes;
            $oRetorno->aDadosAgrupados = array();
            $oRetorno->fSubTotalSaldoAnterior = 0;
            $oRetorno->fSubTotalSaldoFinal = 0;
            $oRetorno->fSubTotalReceitaOrcamentaria = 0;
            $oRetorno->fSubTotalReceitaExtra = 0;
            $oRetorno->fSubTotalRP = 0;
            $oRetorno->fSubTotalInscricaoRP = 0;
            $oRetorno->fSubTotalTransferenciasDepositos = 0;
            $oRetorno->fSubTotalTransferenciasRetiradas = 0;
            $oRetorno->fSubTotalDespesaOrcamentaria = 0;
            $oRetorno->fSubTotalDespesaExtra = 0;
            $aRetorno[$oConta->codctb] = $oRetorno;

        }
        return $aRetorno;
    }

    static function getTotalReceitaOrcamentaria($aDados)
    {
        $fTotalReceitaOrcamentaria = 0;
        foreach ($aDados as $oConta) {
            $fTotalReceitaOrcamentaria += $oConta->fSubTotalReceitaOrcamentaria;
        }
        return $fTotalReceitaOrcamentaria;
    }

    static function getTotalSaldoAnterior($aDados)
    {
        $fTotalSaldoAnterior = 0;
        foreach ($aDados as $oConta) {
            $fTotalSaldoAnterior += $oConta->fSubTotalSaldoAnterior;
        }
        return $fTotalSaldoAnterior;
    }

    static function getTotalSaldoFinal($aDados)
    {
        $fTotalSaldoFinal = 0;
        foreach ($aDados as $oConta) {
            $fTotalSaldoFinal += $oConta->fSubTotalSaldoFinal;
        }
        return $fTotalSaldoFinal;
    }

    static function getTotalReceitaExtra($aDados)
    {
        $fTotalReceitaExtra = 0;
        foreach ($aDados as $oConta) {
            $fTotalReceitaExtra += $oConta->fSubTotalReceitaExtra;
        }
        return $fTotalReceitaExtra;
    }

    static function getTotalRP($aDados)
    {
        $fTotalRP = 0;
        foreach ($aDados as $oConta) {
            $fTotalRP += $oConta->fSubTotalRP;
        }
        return $fTotalRP;
    }

    static function getTotalTransferenciasDepositos($aDados)
    {
        $fTotalTransferenciasDepositos = 0;
        foreach ($aDados as $oConta) {
            $fTotalTransferenciasDepositos += $oConta->fSubTotalTransferenciasDepositos;
        }
        return $fTotalTransferenciasDepositos;
    }

    static function getTotalDespesaOrcamentaria($aDados)
    {
        $fTotalDespesaOrcamentaria = 0;
        foreach ($aDados as $oConta) {
            $fTotalDespesaOrcamentaria += $oConta->fSubTotalDespesaOrcamentaria;
        }
        return $fTotalDespesaOrcamentaria;
    }

    static function getTotalDespesaExtra($aDados)
    {
        $fTotalDespesaExtra = 0;
        foreach ($aDados as $oConta) {
            $fTotalDespesaExtra += $oConta->fSubTotalDespesaExtra;
        }
        return $fTotalDespesaExtra;
    }

    static function getTotalTransferenciasRetiradas($aDados)
    {
        $fTotalTransferenciasRetiradas = 0;
        foreach ($aDados as $oConta) {
            $fTotalTransferenciasRetiradas += $oConta->fSubTotalTransferenciasRetiradas;
        }
        return $fTotalTransferenciasRetiradas;
    }

    static function getTotalPorFonte($aDados)
    {

        $aDadosAgrupados = array();

        foreach ($aDados as $oDadosPorFonte) {

            foreach ($oDadosPorFonte->aDadosAgrupados as $oConta) {

                if (!isset($aDadosAgrupados[$oConta->iFonte])) {
                    $oDados = new stdClass();
                    $oDados->iFonte = $oConta->iFonte;
                    $oDados->fSaldoInicial = $oConta->fSaldoAnterior;
                    $oDados->fTotalEntradas = $oConta->fValorReceitaOrcamentaria + $oConta->fValorReceitaExtra + $oConta->fValorTransferenciasDepositos;
                    $oDados->fTotalSaidas = $oConta->fValorDespesaOrcamentaria + $oConta->fValorDespesaExtra + $oConta->fValorTransferenciasRetiradas + $oConta->fValorRP;
                    $oDados->fSaldoAtual = $oConta->fSaldoFinal;
                    $aDadosAgrupados[$oConta->iFonte] = $oDados;
                } else {
                    $aDadosAgrupados[$oConta->iFonte]->fSaldoInicial += $oConta->fSaldoAnterior;
                    $aDadosAgrupados[$oConta->iFonte]->fTotalEntradas += $oConta->fValorReceitaOrcamentaria + $oConta->fValorReceitaExtra + $oConta->fValorTransferenciasDepositos;
                    $aDadosAgrupados[$oConta->iFonte]->fTotalSaidas += $oConta->fValorDespesaOrcamentaria + $oConta->fValorDespesaExtra + $oConta->fValorTransferenciasRetiradas + $oConta->fValorRP;
                    $aDadosAgrupados[$oConta->iFonte]->fSaldoAtual += $oConta->fSaldoFinal;
                }

            }
        }
        return $aDadosAgrupados;
    }

    static function getTotalPorTipoConta($aDados)
    {
        $oRetorno = new stdClass();
        $oRetorno->fValorAnteriorContaCorrente = 0;
        $oRetorno->fValorFinalContaCorrente = 0;
        $oRetorno->fValorAnteriorContaAplic = 0;
        $oRetorno->fValorFinalContaAplic = 0;
        foreach ($aDados as $oDadosContaCorrente) {
            if ($oDadosContaCorrente->sDescrTipo == 'C/C') {
                $oRetorno->fValorAnteriorContaCorrente += $oDadosContaCorrente->fSubTotalSaldoAnterior;
                $oRetorno->fValorFinalContaCorrente += $oDadosContaCorrente->fSubTotalSaldoFinal;
            } elseif ($oDadosContaCorrente->sDescrTipo == 'C/I') {
                $oRetorno->fValorAnteriorContaAplic += $oDadosContaCorrente->fSubTotalSaldoAnterior;
                $oRetorno->fValorFinalContaAplic += $oDadosContaCorrente->fSubTotalSaldoFinal;
            }
        }
        return $oRetorno;
    }
}