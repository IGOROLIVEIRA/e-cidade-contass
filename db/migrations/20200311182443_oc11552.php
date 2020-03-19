<?php

use Classes\PostgresMigration;

class Oc11552 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL
        
        SELECT fc_startsession();

        BEGIN;

        CREATE OR REPLACE FUNCTION public.fc_movencerramentomsc(date, date, integer) 
            RETURNS CHARACTER VARYING AS
        $$
	    DECLARE 

	    dDataIni        alias for $1;
	    dDataFim    	alias for $2;
	    iReduz          alias for $3;
	    nTotalDebitos   FLOAT8;
	    nTotalCreditos  FLOAT8;
        
        BEGIN
	    -- total debitos mês
	  	SELECT coalesce((SELECT sum(c69_valor) AS debito FROM conlancamval
	  	    INNER JOIN conlancam ON c70_codlan=c69_codlan 
		    INNER JOIN conlancamdoc ON c71_codlan= c70_codlan 
		    INNER JOIN conhistdoc ON c71_coddoc=c53_coddoc
	  	    WHERE c53_tipo = 1000 
		       AND  c69_data BETWEEN dDataIni AND dDataFim
               AND c69_debito=iReduz), 0::double precision)
		INTO nTotalDebitos;
		-- total creditos mês
	  	SELECT coalesce((SELECT sum(c69_valor) AS debito FROM conlancamval 
		INNER JOIN conlancam ON c70_codlan=c69_codlan 
		INNER JOIN conlancamdoc ON c71_codlan= c70_codlan 
		INNER JOIN conhistdoc ON c71_coddoc=c53_coddoc 
		     WHERE c53_tipo = 1000 
		       AND  c69_data between dDataIni AND dDataFim
               AND c69_credito=iReduz),0)
		INTO nTotalCreditos;  

	    return REPLACE(TO_CHAR(ABS(nTotalDebitos::float8),'99999999990D99'),',','.')
		   ||';'||REPLACE(TO_CHAR(ABS(nTotalCreditos),'99999999990D99'),',','.');
	    END;
        $$
        LANGUAGE plpgsql VOLATILE
        COST 100;
        ALTER FUNCTION public.fc_movencerramentomsc(date, date, integer)
        OWNER TO dbportal;

        CREATE OR REPLACE FUNCTION public.fc_saldocontacorrente(integer, integer, integer, integer, integer) 
            RETURNS CHARACTER VARYING
        LANGUAGE plpgsql
        AS 
        $$
        DECLARE
        
            iAnousu              alias for $1; 
            iSequencia           alias for $2; 
            iCC                  alias for $3;
            iMes                 alias for $4;
            iInstit              alias for $5;
            nSaldoInicialMes     FLOAT8;
            tCreditoAno          FLOAT8;
            tDebitoAno           FLOAT8;
            tDebitoMes           FLOAT8;
            tCreditoMes          FLOAT8;
            nSaldoInicialAno     FLOAT8;
            nSaldoFinalMes       FLOAT8;
            nSaldoInicialMesEnc       FLOAT8;
            tCreditoMesEncerramento   FLOAT8;
            tDebitoMesEncerramento    FLOAT8;
            nSaldoFinalMesEnc         FLOAT8;
            nFonte               FLOAT8;
            sinal_ant            CHAR(1);
            sinal_final          CHAR(1);
            sinal_ant_enc          CHAR(1);
            sinal_final_enc          CHAR(1);
        
        BEGIN 
        -- FONTE;
        
        SELECT DISTINCT c19_orctiporec FROM contacorrente
        INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
        INNER JOIN contacorrentedetalheconlancamval ON c28_contacorrentedetalhe = c19_sequencial
        INNER JOIN conlancamval ON c28_conlancamval = c69_sequen
        INNER JOIN conlancamdoc ON c71_codlan = c69_codlan
        INNER JOIN conhistdoc ON c53_coddoc = c71_coddoc
        WHERE contacorrentedetalhe.c19_sequencial = iSequencia
          AND contacorrentedetalhe.c19_instit = iInstit
          AND contacorrentedetalhe.c19_conplanoreduzanousu = iAnousu
          AND contacorrente.c17_sequencial = iCC
          AND c53_tipo != 1000
          
        INTO nFonte;
        
        -- SALDO DA CONTA POR FONTE;
        
        SELECT coalesce((SELECT CASE WHEN c29_debito > 0 THEN c29_debito
                                   WHEN c29_credito > 0 THEN -1 * c29_credito
                                ELSE 0 END AS saldoanterior
                         FROM contacorrente
                         INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                         INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial AND contacorrentesaldo.c29_mesusu = 0 AND contacorrentesaldo.c29_anousu = iAnousu
                         WHERE contacorrentedetalhe.c19_sequencial = iSequencia
                           AND contacorrentedetalhe.c19_instit = iInstit
                           AND contacorrente.c17_sequencial = iCC) ,0)
        
        INTO nSaldoInicialAno;
        
        -- SOMA TOTAL DE CREDITO POR REDUZIDO E FONTE PARA SALDO INICIAL
        
        SELECT coalesce((SELECT sum(c69_valor) AS credito FROM conlancamval
                         INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan AND conlancam.c70_anousu = conlancamval.c69_anousu
                         INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                         INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                         INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                         INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                         WHERE c28_tipo = 'C'
                           AND DATE_PART('MONTH',c69_data) < iMes
                           AND DATE_PART('YEAR',c69_data) = iAnousu
                           AND c19_contacorrente = iCC
                           AND contacorrentedetalhe.c19_sequencial = iSequencia
                           AND c19_instit = iInstit
                           AND c53_tipo != 1000
                         GROUP BY c28_tipo),0)
        
        INTO tCreditoAno;
        
        -- SOMA TOTAL DE DEBITO POR REDUZIDO E FONTE PARA SALDO INICIAL
        
        SELECT coalesce((SELECT sum(c69_valor) AS debito FROM conlancamval
                         INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan AND conlancam.c70_anousu = conlancamval.c69_anousu
                         INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                         INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                         INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                         INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                         WHERE c28_tipo = 'D'
                           AND DATE_PART('MONTH',c69_data) < iMes
                           AND DATE_PART('YEAR',c69_data) = iAnousu
                           AND c19_contacorrente = iCC
                           AND contacorrentedetalhe.c19_sequencial = iSequencia
                           AND c19_instit = iInstit
                           AND c53_tipo != 1000
                         GROUP BY c28_tipo),0) 
        
        INTO tDebitoAno;
        
        nSaldoInicialMes := round(nSaldoInicialAno,2) + round(tDebitoAno,2) - round(tCreditoAno,2);
        
        -- SOMA TOTAL DE CREDITO POR REDUZIDO E FONTE PARA SALDO MES
        
        SELECT coalesce((SELECT sum(c69_valor) FROM conlancamval
                         INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan AND conlancam.c70_anousu = conlancamval.c69_anousu
                         INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                         INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                         INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                         INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                         WHERE c28_tipo = 'C'
                           AND DATE_PART('MONTH',c69_data) = iMes
                           AND DATE_PART('YEAR',c69_data) = iAnousu
                           AND c19_contacorrente = iCC
                           AND contacorrentedetalhe.c19_sequencial = iSequencia
                           AND c19_instit = iInstit
                           AND c53_tipo != 1000
                         GROUP BY c28_tipo),0)
        
        INTO tCreditoMes;

        -- SOMA TOTAL DE CREDITO POR REDUZIDO E FONTE PARA SALDO MES SOMENTE ENCERRAMENTO
        
        SELECT coalesce((SELECT sum(c69_valor) FROM conlancamval
                         INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan AND conlancam.c70_anousu = conlancamval.c69_anousu
                         INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                         INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                         INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                         INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                         WHERE c28_tipo = 'C'
                           AND DATE_PART('MONTH',c69_data) = iMes
                           AND DATE_PART('YEAR',c69_data) = iAnousu
                           AND c19_contacorrente = iCC
                           AND contacorrentedetalhe.c19_sequencial = iSequencia
                           AND c19_instit = iInstit
                           AND c53_tipo = 1000
                         GROUP BY c28_tipo),0)
        
        INTO tCreditoMesEncerramento;
        
        -- SOMA TOTAL DE DEBITO POR REDUZIDO E FONTE PARA SALDO MES
        
        SELECT coalesce((SELECT sum(c69_valor) FROM conlancamval
                         INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan AND conlancam.c70_anousu = conlancamval.c69_anousu
                         INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                         INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                         INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                         INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                         WHERE c28_tipo = 'D'
                           AND DATE_PART('MONTH',c69_data) = iMes
                           AND DATE_PART('YEAR',c69_data) = iAnousu
                           AND c19_contacorrente = iCC
                           AND c19_sequencial = iSequencia
                           AND c19_instit = iInstit
                           AND c53_tipo != 1000
                         GROUP BY c28_tipo),0) 
        
        INTO tDebitoMes;

         -- SOMA TOTAL DE DEBITO POR REDUZIDO E FONTE PARA SALDO MES
        
        SELECT coalesce((SELECT sum(c69_valor) FROM conlancamval
                         INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan AND conlancam.c70_anousu = conlancamval.c69_anousu
                         INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                         INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                         INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                         INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                         WHERE c28_tipo = 'D'
                           AND DATE_PART('MONTH',c69_data) = iMes
                           AND DATE_PART('YEAR',c69_data) = iAnousu
                           AND c19_contacorrente = iCC
                           AND c19_sequencial = iSequencia
                           AND c19_instit = iInstit
                           AND c53_tipo = 1000
                         GROUP BY c28_tipo),0) 
        
        INTO tDebitoMesEncerramento;
        
        nSaldoFinalMes := nSaldoInicialMes + tDebitoMes - tCreditoMes;


        nSaldoFinalMes := nSaldoInicialMes + tDebitoMes - tCreditoMes;

        nSaldoFinalMesEnc :=  nSaldoFinalMes + tDebitoMesEncerramento - tCreditoMesEncerramento;
        
        IF nSaldoInicialMes < 0 
          THEN sinal_ant := 'C';
          ELSE sinal_ant := 'D';
        END IF;
        
        IF nSaldoFinalMes < 0 
          THEN sinal_final := 'C';
          ELSE sinal_final := 'D';
        END IF;

        IF nSaldoFinalMesEnc < 0 
          THEN sinal_final_enc := 'C';
          ELSE sinal_final_enc := 'D';
        END IF;

        
        IF nFonte IS NULL 
          THEN nFonte := 0;
        END IF;
        
        sinal_ant_enc := sinal_final;

        nSaldoInicialMesEnc := nSaldoFinalMes::float8;

        return TO_CHAR(ABS(iSequencia),'999999999999')
           ||';'||TO_CHAR(iCC::integer,'999999999999')
           ||';'||TO_CHAR(nFonte::integer,'999999999999')
           ||';'||replace(TO_CHAR(ABS(nSaldoInicialMes::float8),'99999999990D99'),',','.')
           ||';'||replace(TO_CHAR(ABS(tDebitoMes),'99999999990D99'),',','.')
           ||';'||replace(TO_CHAR(ABS(tCreditoMes),'99999999990D99'),',','.')
           ||';'||replace(TO_CHAR(ABS(nSaldoFinalMes),'99999999990D99'),',','.')
           ||';'||sinal_ant
           ||';'||'-'||';'||sinal_final
           ||';'||replace(TO_CHAR(ABS(nSaldoInicialMesEnc::float8),'99999999990D99'),',','.')
           ||';'||replace(TO_CHAR(ABS(tDebitoMesEncerramento),'99999999990D99'),',','.')
           ||';'||replace(TO_CHAR(ABS(tCreditoMesEncerramento),'99999999990D99'),',','.')
           ||';'||replace(TO_CHAR(ABS(nSaldoFinalMesEnc),'99999999990D99'),',','.')
           ||';'||sinal_ant_enc
           ||';'||'-'||';'||sinal_final_enc;
        end;
        $$;

        COMMIT;

SQL;
        $this->execute($sql);
    }
}