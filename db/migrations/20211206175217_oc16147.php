<?php

use Classes\PostgresMigration;

class Oc16147 extends PostgresMigration
{

    public function up()
    {
        $sql =" 
            
                CREATE OR REPLACE FUNCTION fc_autenclass(
                    integer,
                    date,
                    date,
                    integer,
                    character varying,
                    integer)
                  RETURNS character varying AS
                \$BODY$
                        DECLARE
                            VCODCLA ALIAS FOR $1;
                            DTEMITE ALIAS FOR $2;
                            DTVENC  ALIAS FOR $3;
                            SUBDIR  ALIAS FOR $4;
                          IPTERM  ALIAS FOR $5;
                          INSTIT  ALIAS FOR $6;

                          CODAUT  INTEGER ;
                          IDTERM  INTEGER ;
                          HORA    CHAR(5) ;
                          IDENT1  CHAR(1);
                          IDENT2  CHAR(1);
                          IDENT3  CHAR(1);

                          VALOR     FLOAT8;
                          CONTA       INTEGER;
                          GRAVA_CORNUMP RECORD;
                          PROCESSA    BOOLEAN;
                          DTAUTENT    DATE;
                            AUTENTICACAO  TEXT;
                        BEGIN
                        --raise notice '%-%',numpre,numpar;

                        SELECT DISCLA.CODCLA, ROUND(SUM(VLRREC),2) AS SUM , K00_CONTA, DTAUTE
                        INTO CODAUT, VALOR, CONTA,DTAUTENT
                        FROM DISCLA
                             INNER JOIN DISARQ ON DISARQ.CODRET = DISCLA.CODRET
                             INNER JOIN DISREC ON DISREC.CODCLA = DISCLA.CODCLA
                        WHERE DISCLA.CODCLA = VCODCLA
                        GROUP BY DISCLA.CODCLA,K00_CONTA,DTAUTE;
                        IF CODAUT IS NULL THEN
                           RETURN '0 CLASSIFICACAO NAO ENCONTRADA.' ;
                        END IF;

                        IF NOT DTAUTENT IS NULL THEN
                           RETURN '0 CLASSIFICACAO AUTENTICADA EM : '|| TO_CHAR(DTAUTENT,'DD-MM-YYYY');
                        END IF;

                        SELECT K11_ID,K11_IDENT1,K11_IDENT2,K11_IDENT3
                        INTO IDTERM,IDENT1,IDENT2,IDENT3
                        FROM CFAUTENT WHERE K11_IPTERM = IPTERM and K11_INSTIT = INSTIT;
                        --raise notice '-%-',idterm;
                        IF NOT IDTERM IS NULL THEN
                           SELECT MAX(K12_AUTENT)
                           INTO CODAUT
                           FROM CORRENTE WHERE K12_ID = IDTERM AND K12_DATA = DTEMITE AND K12_INSTIT = INSTIT;
                           IF CODAUT IS NULL THEN
                              CODAUT := 1;
                           ELSE
                              CODAUT := CODAUT + 1;
                           END IF;
                           -- GRAVA AUTENTICACAO
                           hora := to_char(now(), 'HH24:MI');
                           INSERT INTO CORRENTE values (
                              IDTERM,
                              DTEMITE,
                              CODAUT,
                              hora,
                              conta,
                              valor,
                              false,
                              INSTIT
                              );
                           INSERT INTO CORCLA (K12_ID,K12_DATA,K12_AUTENT,K12_CODCLA) VALUES (IDTERM,DTEMITE,CODAUT,VCODCLA);
                           FOR GRAVA_CORNUMP IN SELECT K00_RECEIT,ROUND(SUM(SUM),2) AS SUM FROM ( 
                              SELECT K00_RECEIT,ROUND(SUM(VLRREC),2) AS SUM
                              FROM DISREC
                              WHERE CODCLA = VCODCLA
                              GROUP BY K00_RECEIT
                              UNION
                              SELECT K00_RECEIT,ROUND(SUM(VLRREC),2) AS SUM
                              FROM disrec_desconto_integral
                              WHERE CODCLA = VCODCLA
                              GROUP BY K00_RECEIT
                              ) AS X GROUP BY K00_RECEIT
                              LOOP
                              INSERT INTO CORNUMP VALUES (
                              IDTERM,
                              DTEMITE,
                              CODAUT,
                              0,
                              0,
                              0,
                              0,
                              GRAVA_CORNUMP.K00_RECEIT,
                              GRAVA_CORNUMP.SUM
                              );
                              PROCESSA := TRUE;
                           END LOOP;
                           UPDATE DISCLA SET DTAUTE = DTEMITE WHERE CODCLA = VCODCLA;
                        ELSE
                           -- ERRO QUANDO O TERMINAL NAO ESTA CADASTRADO
                           RETURN '2 TERMINAL NAO CADASTRADO';
                        END IF;

                        IF PROCESSA = TRUE THEN
                            -- AUTENTICACAO CORRETA
                            AUTENTICACAO:= TO_CHAR(CODAUT,'999999') || DTEMITE || IDENT1 || IDENT2 || IDENT3 || TO_CHAR(0,'99999999') || TO_CHAR(0,'999') || TO_CHAR(ABS(VALOR),'99999999.99')||'+';

                          INSERT INTO CORAUTENT (K12_ID,
                                                 K12_DATA,
                                                 K12_AUTENT,
                                                 K12_CODAUTENT)
                                 VALUES         (IDTERM,
                                           DTEMITE,
                                         CODAUT,
                                           AUTENTICACAO);

                          RETURN '1' || AUTENTICACAO ;

                        ELSE
                           -- NUMPRE NAO PROCESSADO
                           RETURN '3 CLASSIFICACAO NAO PROCESSADA';
                        END IF;
                        END;
                        \$BODY$
                  LANGUAGE plpgsql VOLATILE
                  COST 100;
                ALTER FUNCTION fc_autenclass(integer, date, date, integer, character varying, integer)
                  OWNER TO ecidade;
        ";

        $this->execute($sql);
    }

}
