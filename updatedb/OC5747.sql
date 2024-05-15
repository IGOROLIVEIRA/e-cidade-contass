-- Function: fc_saldoextfonte(integer, integer, integer, integer, integer)

-- DROP FUNCTION fc_saldoextfonte(integer, integer, integer, integer, integer);

CREATE OR REPLACE FUNCTION fc_saldoextfonte(integer, integer, integer, integer, integer)
  RETURNS character varying AS
$BODY$

declare

  iAnousu             alias for $1;
  iConta              alias for $2;
  iFonte              alias for $3;
  iMes                alias for $4;
  iInstit              alias for $5;
  nSaldoInicialMes     FLOAT8;
  tCreditoAno          FLOAT8;
  tDebitoAno           FLOAT8;
  tDebitoMes           FLOAT8;
  tCreditoMes          FLOAT8;
  nSaldoExtInicialAno  FLOAT8;
  nSaldoFinalMes       FLOAT8;
  sinal_ant            CHAR(1);
  sinal_final        CHAR(1);

begin


  -- SALDO DA CONTA POR FONTE;
  select coalesce(
    (select coalesce(conextsaldo.ces01_valor,0)
     from conextsaldo
     where conextsaldo.ces01_reduz  = iConta
           and conextsaldo.ces01_anousu = iAnousu
           and conextsaldo.ces01_inst   = iInstit
           and conextsaldo.ces01_fonte  = iFonte),0)
  into nSaldoExtInicialAno;

  -- SOMA TOTAL DE CREDITO POR REDUZIDO E FONTE PARA SALDO INICIAL

  select coalesce(
    (select round(sum(conlancamval.c69_valor), 2) as vcredito
     from conlancamdoc
       inner join conlancamval on conlancamval.c69_codlan = conlancamdoc.c71_codlan
       inner join conplanoreduz on conlancamval.c69_debito = conplanoreduz.c61_reduz
                                   and conlancamval.c69_anousu = conplanoreduz.c61_anousu
       inner join orctiporec on  orctiporec.o15_codigo = conplanoreduz.c61_codigo
       inner join conlancaminstit on conlancaminstit.c02_codlan = conlancamval.c69_codlan
       inner join conlancamcorrente on conlancamcorrente.c86_conlancam = conlancamval.c69_codlan
       left join infocomplementaresinstit on infocomplementaresinstit.si09_instit = conlancaminstit.c02_instit
     where conlancamdoc.c71_coddoc in (120,121,130,131,150,151,152,153,160,161,162,163)
           and conlancamval.c69_credito in (iConta)
           and DATE_PART('YEAR',conlancamdoc.c71_data) = iAnousu
           and DATE_PART('MONTH',conlancamdoc.c71_data) <= iMes-1
           and conlancaminstit.c02_instit = iInstit
           and orctiporec.o15_codigo::int = iFonte),0)
  into tCreditoAno;

  -- SOMA TOTAL DE DEBITO POR REDUZIDO E FONTE PARA SALDO INICIAL

  select coalesce(
    (select  round(sum(conlancamval.c69_valor), 2) as vdebito
     from conlancamdoc
       inner join conlancamval on conlancamval.c69_codlan = conlancamdoc.c71_codlan
       inner join conplanoreduz on conlancamval.c69_credito = conplanoreduz.c61_reduz
                                   and conlancamval.c69_anousu = conplanoreduz.c61_anousu
       inner join orctiporec on  orctiporec.o15_codigo = conplanoreduz.c61_codigo
       inner join conlancaminstit on conlancaminstit.c02_codlan = conlancamval.c69_codlan
       inner join conlancamcorrente on conlancamcorrente.c86_conlancam = conlancamval.c69_codlan
       left join infocomplementaresinstit on infocomplementaresinstit.si09_instit = conlancaminstit.c02_instit
     where conlancamdoc.c71_coddoc in (120,121,130,131,150,151,152,153,160,161,162,163)
           and conlancamval.c69_debito in (iConta)
           and DATE_PART('YEAR',conlancamdoc.c71_data) = iAnousu
           and DATE_PART('MONTH',conlancamdoc.c71_data) <= iMes-1
           and conlancaminstit.c02_instit = iInstit
           and orctiporec.o15_codigo::int = iFonte),0)
  into tDebitoAno;

  nSaldoInicialMes := round(nSaldoExtInicialAno,2) + round(tDebitoAno,2) - round(tCreditoAno,2);

  -- SOMA TOTAL DE CREDITO POR REDUZIDO E FONTE PARA SALDO MES

  select coalesce(
    (select round(sum(conlancamval.c69_valor), 2) as vcredito
     from conlancamdoc
       inner join conlancamval on conlancamval.c69_codlan = conlancamdoc.c71_codlan
       inner join conplanoreduz on conlancamval.c69_debito = conplanoreduz.c61_reduz
                                   and conlancamval.c69_anousu = conplanoreduz.c61_anousu
       inner join orctiporec on  orctiporec.o15_codigo = conplanoreduz.c61_codigo
       inner join conlancaminstit on conlancaminstit.c02_codlan = conlancamval.c69_codlan
       inner join conlancamcorrente on conlancamcorrente.c86_conlancam = conlancamval.c69_codlan
       left join infocomplementaresinstit on infocomplementaresinstit.si09_instit = conlancaminstit.c02_instit
     where conlancamdoc.c71_coddoc in (120,121,130,131,150,151,152,153,160,161,162,163)
           and conlancamval.c69_credito in (iConta)
           and DATE_PART('YEAR',conlancamdoc.c71_data) = iAnousu
           and DATE_PART('MONTH',conlancamdoc.c71_data) = iMes
           and conlancaminstit.c02_instit = iInstit
           and orctiporec.o15_codigo::int = iFonte),0)
  into tCreditoMes;

  -- SOMA TOTAL DE DEBITO POR REDUZIDO E FONTE PARA SALDO MES

  select coalesce(
    (select  round(sum(conlancamval.c69_valor), 2) as vdebito
     from conlancamdoc
       inner join conlancamval on conlancamval.c69_codlan = conlancamdoc.c71_codlan
       inner join conplanoreduz on conlancamval.c69_credito = conplanoreduz.c61_reduz
                                   and conlancamval.c69_anousu = conplanoreduz.c61_anousu
       inner join orctiporec on  orctiporec.o15_codigo = conplanoreduz.c61_codigo
       inner join conlancaminstit on conlancaminstit.c02_codlan = conlancamval.c69_codlan
       inner join conlancamcorrente on conlancamcorrente.c86_conlancam = conlancamval.c69_codlan
       left join infocomplementaresinstit on infocomplementaresinstit.si09_instit = conlancaminstit.c02_instit
     where conlancamdoc.c71_coddoc in (120,121,130,131,150,151,152,153,160,161,162,163)
           and conlancamval.c69_debito in (iConta)
           and DATE_PART('YEAR',conlancamdoc.c71_data) = iAnousu
           and DATE_PART('MONTH',conlancamdoc.c71_data) = iMes
           and conlancaminstit.c02_instit = iInstit
           and orctiporec.o15_codigo::int = iFonte),0)
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
         ||TO_CHAR(ABS(iFonte),'999999999999')
         ||TO_CHAR(ABS(nSaldoInicialMes::float8),'9999999999.99')
         ||TO_CHAR(ABS(tDebitoMes),'9999999999.99')
         ||TO_CHAR(ABS(tCreditoMes),'9999999999.99')
         ||TO_CHAR(ABS(nSaldoFinalMes),'9999999999.99')
         ||sinal_ant
         ||'-'||sinal_final;
end;

$BODY$
LANGUAGE plpgsql VOLATILE
COST 100;
ALTER FUNCTION fc_saldoextfonte(integer, integer, integer, integer, integer)
OWNER TO dbportal;
