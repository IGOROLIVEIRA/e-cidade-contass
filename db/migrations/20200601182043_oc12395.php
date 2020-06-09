<?php

use Classes\PostgresMigration;

class Oc12395 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        CREATE OR REPLACE FUNCTION public.fc_saldoctbfonte(integer, integer, character varying, integer, integer)
         RETURNS character varying
         AS 
        $$ 
          declare 
        
            iAnousu              alias for $1;
            iConta               alias for $2;
            iFonte               alias for $3;
            iMes                 alias for $4;
            iInstit              alias for $5;
            nSaldoInicialMes     FLOAT8;
            tCreditoAno          FLOAT8;
            tDebitoAno           FLOAT8;
            tDebitoMes           FLOAT8;
            tCreditoMes          FLOAT8;
            nSaldoCtbInicialAno  FLOAT8;
            nSaldoFinalMes       FLOAT8;
            sinal_ant            CHAR(1);
            sinal_final        CHAR(1);
            
           begin 
            
            
            -- SALDO DA CONTA POR FONTE;
            select coalesce(
            (select coalesce(conctbsaldo.ces02_valor,0)   
               from conctbsaldo 
                            join orctiporec on conctbsaldo.ces02_fonte = orctiporec.o15_codigo
              where conctbsaldo.ces02_reduz  = iConta 
                and conctbsaldo.ces02_anousu = iAnousu 
                and conctbsaldo.ces02_inst   = iInstit 
                and orctiporec.o15_codtri  = iFonte),
                (select case when c62_vlrcre > 0 then c62_vlrcre*-1 else c62_vlrdeb end as valor
                             from conplanoexe 
                             join orctiporec on conplanoexe.c62_codrec = orctiporec.o15_codigo
                             where c62_anousu = iAnousu
                             and c62_reduz = iConta
                             and c62_anousu < 2017
                             and orctiporec.o15_codtri = iFonte),0)
               into nSaldoCtbInicialAno;
            
            -- SOMA TOTAL DE CREDITO POR REDUZIDO E FONTE PARA SALDO INICIAL
            
              select coalesce((select round(sum(valorcredito), 2) as vcredito from (
                        select conlancamval.c69_valor as valorcredito,
                             case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
                              when c71_coddoc in (100,101,115,116) then fontereceita.o15_codtri
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
                         where DATE_PART('YEAR',conlancamdoc.c71_data) = iAnousu
                           and DATE_PART('MONTH',conlancamdoc.c71_data) < iMes
                           and conlancamval.c69_credito in (iConta)) as xx where fontemovimento = iFonte),0)
              into tCreditoAno;
            
            -- SOMA TOTAL DE DEBITO POR REDUZIDO E FONTE PARA SALDO INICIAL
             
              select coalesce((select round(sum(valordebito), 2) as vdebito from (
                        select conlancamval.c69_valor as valordebito,
                             case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
                              when c71_coddoc in (100,101,115,116) then fontereceita.o15_codtri
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
                         where DATE_PART('YEAR',conlancamdoc.c71_data) = iAnousu
                           and DATE_PART('MONTH',conlancamdoc.c71_data) < iMes
                           and conlancamval.c69_debito in (iConta)) as xx where fontemovimento = iFonte),0)
                into tDebitoAno;
            
            nSaldoInicialMes := round(nSaldoCtbInicialAno,2) + round(tDebitoAno,2) - round(tCreditoAno,2);
            
            -- SOMA TOTAL DE CREDITO POR REDUZIDO E FONTE PARA SALDO MES
            
              select coalesce((select round(sum(valorcredito), 2) as vcredito from (
                        select conlancamval.c69_valor as valorcredito,
                             case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
                              when c71_coddoc in (100,101,115,116) then fontereceita.o15_codtri
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
                         where DATE_PART('YEAR',conlancamdoc.c71_data) = iAnousu
                           and DATE_PART('MONTH',conlancamdoc.c71_data) = iMes
                           and conlancamval.c69_credito in (iConta)) as xx where fontemovimento = iFonte),0)
                           
                into tCreditoMes;
            
            -- SOMA TOTAL DE DEBITO POR REDUZIDO E FONTE PARA SALDO MES
             
             select coalesce((select round(sum(valordebito), 2) as vdebito from (
                        select conlancamval.c69_valor as valordebito,
                             case when c71_coddoc in (5,35,37,6,36,38) then fontempenho.o15_codtri
                              when c71_coddoc in (100,101,115,116) then fontereceita.o15_codtri
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
                         where DATE_PART('YEAR',conlancamdoc.c71_data) = iAnousu
                           and DATE_PART('MONTH',conlancamdoc.c71_data) = iMes
                           and conlancamval.c69_debito in (iConta)) as xx where fontemovimento = iFonte),0)
                into tDebitoMes;
            
            nSaldoFinalMes := nSaldoInicialMes + tDebitoMes - tCreditoMes;
            
            IF nSaldoInicialMes < 0 THEN
             sinal_ant := 'C';
            ELSE
             sinal_ant := 'D';
            END IF;
            
            IF nSaldoFinalMes < 0 THEN
             sinal_final := 'C';
            ELSE
             sinal_final := 'D';
            END IF;
        
            return TO_CHAR(ABS(iConta),'999999999999')
               ||TO_CHAR(iFonte::integer,'999999999999')
               ||replace(TO_CHAR(ABS(nSaldoInicialMes::float8),'99999999990D99'),',','.')
               ||replace(TO_CHAR(ABS(tDebitoMes),'99999999990D99'),',','.')
               ||replace(TO_CHAR(ABS(tCreditoMes),'99999999990D99'),',','.')
               ||replace(TO_CHAR(ABS(nSaldoFinalMes),'99999999990D99'),',','.')
               ||sinal_ant    
               ||'-'||sinal_final;
           end
          
        $$
        LANGUAGE plpgsql;

        COMMIT;

SQL;
        $this->execute($sql);
    }

}