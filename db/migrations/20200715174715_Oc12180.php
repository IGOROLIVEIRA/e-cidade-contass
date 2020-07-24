<?php

use Phinx\Migration\AbstractMigration;

class Oc12180 extends AbstractMigration
{
    public function up(){

    $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

            CREATE OR REPLACE FUNCTION public.fc_removeslip(integer, integer, integer)
            RETURNS character varying
            LANGUAGE plpgsql
            AS
            $$
            DECLARE

                iSlip                alias for $1;
                iAnousu              alias for $2;
                iInstit              alias for $3;
                nSaldoIniCred        double precision[];
                nSaldoIniDeb         double precision[];
                nSaldoFimCred        double precision[];
                nSaldoFimDeb         double precision[];
                
                nSumSaldoIniCred     double precision;
                nSumSaldoIniDeb      double precision;
                nSumSaldoFimCred     double precision;
                nSumSaldoFimDeb      double precision;
                
                nReduz               integer[];
                nMes                 integer[];
                nConlancam           integer[];
                nIdCorrente          integer[];
                nDateCorrente        date[];
                nAutent              integer[];
                nResult              integer;


                    BEGIN


                    SELECT ARRAY_AGG(c68_reduz) AS c68_reduz,
                           ARRAY_AGG(c68_mes) AS c68_mes,
                           ARRAY_AGG(c68_debito) AS c68_debito,
                           ARRAY_AGG(c68_credito) AS c68_credito
                    INTO nReduz, nMes, nSaldoIniDeb, nSaldoIniCred
                    FROM conplanoexesaldo
                    WHERE c68_anousu = iAnousu
                        AND c68_mes IN (SELECT EXTRACT ( MONTH FROM c69_data ) AS c69_mes FROM conlancamval
                                        INNER JOIN conlancamslip ON c69_codlan = c84_conlancam AND c84_slip = iSlip)
                        AND c68_reduz IN (SELECT c69_credito FROM conlancamval
                                        INNER JOIN conlancamslip ON c69_codlan = c84_conlancam AND c84_slip = iSlip
                                        UNION ALL
                                        SELECT c69_debito FROM conlancamval
                                        INNER JOIN conlancamslip ON c69_codlan = c84_conlancam AND c84_slip = iSlip);

                    nSumSaldoIniDeb := (SELECT sum(s) FROM UNNEST(nSaldoIniDeb) s);
                    nSumSaldoIniCred := (SELECT sum(s) FROM UNNEST(nSaldoIniCred) s);

                    SELECT ARRAY_AGG(c84_conlancam)
                    INTO nConlancam
                    FROM conlancamslip
                    WHERE c84_slip = iSlip;

                    SELECT ARRAY_AGG(corlanc.k12_id),
                           ARRAY_AGG(corlanc.k12_autent),
                           ARRAY_AGG(corlanc.k12_data)
                    INTO nIdCorrente,
                         nAutent,
                         nDateCorrente
                    FROM corlanc
                    WHERE corlanc.k12_codigo = iSlip;


                    DELETE FROM corautent
                    WHERE corautent.k12_id IN (SELECT UNNEST(nIdCorrente))
                      AND corautent.k12_data IN (SELECT UNNEST(nDateCorrente))
                      AND corautent.k12_autent IN (SELECT UNNEST(nAutent));

                    DELETE FROM corlanc
                    WHERE corlanc.k12_id IN (SELECT UNNEST(nIdCorrente)) 
                      AND corlanc.k12_data IN (SELECT UNNEST(nDateCorrente))
                      AND corlanc.k12_autent IN (SELECT UNNEST(nAutent));

                    DELETE FROM corconf
                    WHERE corconf.k12_id IN (SELECT UNNEST(nIdCorrente))
                      AND corconf.k12_data IN (SELECT UNNEST(nDateCorrente))
                      AND corconf.k12_autent IN (SELECT UNNEST(nAutent));

                    DELETE FROM conlancamcorrente
                    WHERE c86_conlancam IN (SELECT UNNEST(nConlancam));
                    
                    DELETE FROM cornump 
                    WHERE cornump.k12_id IN (SELECT UNNEST(nIdCorrente))
                      AND cornump.k12_data IN (SELECT UNNEST(nDateCorrente))
                      AND cornump.k12_autent IN (SELECT UNNEST(nAutent));
                     
                   	DELETE FROM corplacaixa
                    WHERE corplacaixa.k82_id IN (SELECT UNNEST(nIdCorrente))
                      AND corplacaixa.k82_data IN (SELECT UNNEST(nDateCorrente))
                      AND corplacaixa.k82_autent IN (SELECT UNNEST(nAutent));
                     
                   	DELETE FROM corhist
                    WHERE corhist.k12_id IN (SELECT UNNEST(nIdCorrente))
                      AND corhist.k12_data IN (SELECT UNNEST(nDateCorrente))
                      AND corhist.k12_autent IN (SELECT UNNEST(nAutent));
                    
                    DELETE FROM corrente
                    WHERE corrente.k12_id IN (SELECT UNNEST(nIdCorrente))
                      AND corrente.k12_data IN (SELECT UNNEST(nDateCorrente))
                      AND corrente.k12_autent IN (SELECT UNNEST(nAutent));

                    DELETE FROM conlancamemp
                    WHERE c75_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancambol
                    WHERE c77_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancamcgm
                    WHERE c76_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancamdig
                    WHERE c78_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancamdoc
                    WHERE c71_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancamdot
                    WHERE c73_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancamord
                    WHERE c80_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancamrec
                    WHERE c74_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM contacorrentedetalheconlancamval
                    WHERE c28_conlancamval IN
                        (SELECT c69_sequen FROM conlancamval
                        WHERE c69_codlan IN (SELECT UNNEST(nConlancam)));

                    DELETE FROM conlancamval
                    WHERE c69_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancamcompl
                    WHERE c72_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancampag
                    WHERE c82_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancamslip
                    WHERE c84_conlancam IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancaminstit
                    WHERE c02_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancamordem
                    WHERE c03_codlan IN (SELECT UNNEST(nConlancam));

                    DELETE FROM conlancam
                    WHERE c70_codlan IN (SELECT UNNEST(nConlancam));

                    /* ACERTAR MOVIMENTAÇÃO DAS CONTAS */
                    DELETE FROM conplanoexesaldo
                    WHERE conplanoexesaldo.c68_reduz IN (SELECT UNNEST(nReduz))
                      AND conplanoexesaldo.c68_anousu = iAnousu
                      AND conplanoexesaldo.c68_mes IN (SELECT UNNEST(nMes));

                    CREATE TEMP TABLE landeb ON COMMIT DROP AS
                    SELECT c69_anousu,
                        c69_debito,
                        to_char(c69_data, 'MM')::integer,
                        sum(round(c69_valor, 2)),
                        0::float8
                    FROM conlancamval
                    WHERE c69_debito IN (SELECT UNNEST(nReduz))
                      AND c69_anousu = iAnousu
                      AND EXTRACT (MONTH FROM c69_data) IN (SELECT UNNEST(nMes))
                    GROUP BY c69_anousu, c69_debito, to_char(c69_data, 'MM')::integer;

                    CREATE TEMP TABLE lancre ON COMMIT DROP AS
                    SELECT c69_anousu,
                        c69_credito,
                        to_char(c69_data, 'MM')::integer,
                        0::float8,
                        sum(round(c69_valor, 2))
                    FROM conlancamval
                    WHERE c69_credito IN (SELECT UNNEST(nReduz))
                      AND c69_anousu = iAnousu
                      AND EXTRACT (MONTH FROM c69_data) IN (SELECT UNNEST(nMes))
                    GROUP BY c69_anousu, c69_credito, to_char(c69_data, 'MM')::integer;

                    INSERT INTO conplanoexesaldo
                    SELECT * FROM landeb;

                    UPDATE conplanoexesaldo
                    SET c68_credito = lancre.sum
                    FROM lancre
                    WHERE c68_anousu = lancre.c69_anousu
                    AND c68_reduz = lancre.c69_credito
                    AND c68_mes = lancre.to_char
                    AND c68_anousu = iAnousu;

                    DELETE FROM lancre
                    USING conplanoexesaldo
                    WHERE lancre.c69_anousu = conplanoexesaldo.c68_anousu
                    AND conplanoexesaldo.c68_reduz = lancre.c69_credito
                    AND conplanoexesaldo.c68_mes = lancre.to_char
                    AND c68_anousu = iAnousu;

                    INSERT INTO conplanoexesaldo
                    SELECT * FROM lancre
                    WHERE c69_anousu = iAnousu;

                    SELECT ARRAY_AGG(c68_debito) AS c68_debito,
                           ARRAY_AGG(c68_credito) AS c68_credito
                    INTO nSaldoFimDeb, nSaldoFimCred
                    FROM conplanoexesaldo
                    WHERE c68_anousu = iAnousu
                        AND c68_mes IN (SELECT EXTRACT ( MONTH FROM c69_data ) AS c69_mes FROM conlancamval
                                        INNER JOIN conlancamslip ON c69_codlan = c84_conlancam AND c84_slip = iSlip)
                        AND c68_reduz IN (SELECT c69_credito FROM conlancamval
                                        INNER JOIN conlancamslip ON c69_codlan = c84_conlancam AND c84_slip = iSlip
                                        UNION ALL
                                        SELECT c69_debito FROM conlancamval
                                        INNER JOIN conlancamslip ON c69_codlan = c84_conlancam AND c84_slip = iSlip);

                    nSumSaldoFimDeb := (SELECT sum(s) FROM UNNEST(nSaldoFimDeb) s);
                    nSumSaldoFimCred := (SELECT sum(s) FROM UNNEST(nSaldoFimCred) s);

                    IF ((nSumSaldoFimDeb < nSumSaldoIniDeb OR nSumSaldoFimDeb IS NULL) OR (nSumSaldoFimCred < nSumSaldoIniCred OR nSumSaldoFimCred IS NULL)) THEN
                        nResult := 1;
                    ELSE
                        nResult := 0;
                    END IF;

                    return nResult;

                    END;
                $$;
        COMMIT;

SQL;
    $this->execute($sql);
  }
}
