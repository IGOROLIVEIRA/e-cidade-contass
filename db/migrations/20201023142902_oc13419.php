<?php

use Phinx\Migration\AbstractMigration;

class Oc13419 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {

      $sql = <<<SQL

      BEGIN;
      CREATE OR REPLACE FUNCTION public.fc_planosaldonovo(integer, integer, date, date, boolean)
           RETURNS character varying
           LANGUAGE plpgsql
          AS $$
          DECLARE
          ANOUSU   	ALIAS FOR $1;
            REDUZ   	ALIAS FOR $2;
            DATAINI	ALIAS FOR $3;
            DATAFIM	ALIAS FOR $4;
            ENCERRAMENTO	ALIAS FOR $5; -- se considera documentos de encerramento de exercicio : c53_tipo=1000

            CONTA		INTEGER ;
            VLRDEB	FLOAT8;
            VLRCRE	FLOAT8;
            SALDO_ANTERIOR	FLOAT8;
            SALDO_ANTERIOR_DEBITO	FLOAT8;
            SALDO_ANTERIOR_DEBITO_A	FLOAT8;
            SALDO_ANTERIOR_CREDITO	FLOAT8;
            SALDO_ANTERIOR_CREDITO_A	FLOAT8;
            SALDO_FINAL	FLOAT8;
            SINAL_ANT	CHAR(1);
            SINAL_FINAL	CHAR(1);

            MES_ANTERIOR  INTEGER;
            DATAINICIAL	DATE;
            DATA_FINAL	DATE;
            MES_DATA_INICIAL	INTEGER;

          BEGIN

            SELECT C62_REDUZ, C62_VLRDEB, C62_VLRCRE
            INTO CONTA, VLRDEB, VLRCRE
            FROM CONPLANOEXE
            WHERE C62_ANOUSU = ANOUSU AND C62_REDUZ = REDUZ;
            IF CONTA IS NULL THEN
               RETURN '0 CONTA NAO CADASTRADA';
            END IF;

            IF VLRDEB IS NULL THEN
               VLRDEB := 0;
            END IF;

            IF VLRCRE IS NULL THEN
               VLRCRE := 0;
            END IF;


            -- CALCULA VALOR DO DEBITO ANTERIOR A DATA INICIAL

            MES_ANTERIOR := TO_CHAR(DATAINI,'MM')::INTEGER - 1 ;

            SALDO_ANTERIOR_DEBITO_A := 0;
            IF MES_ANTERIOR > 0 THEN

               SELECT SUM(C68_DEBITO)
               INTO SALDO_ANTERIOR_DEBITO_A
               FROM CONPLANOEXESALDO
               WHERE C68_ANOUSU = ANOUSU AND
              C68_REDUZ  = REDUZ  AND
              C68_MES   <= MES_ANTERIOR;

               IF SALDO_ANTERIOR_DEBITO_A IS NULL THEN
                  SALDO_ANTERIOR_DEBITO_A = 0;
               END IF;

               DATAINICIAL := ANOUSU||'-'||TO_CHAR(DATAINI,'MM')||'-01';

            ELSE

               DATAINICIAL := ANOUSU||'-01-01';

            END IF;


            SELECT SUM(C69_VALOR) AS C69_VALOR
            INTO SALDO_ANTERIOR_DEBITO
            FROM CONLANCAMVAL
            WHERE C69_ANOUSU = ANOUSU AND
              C69_DEBITO = REDUZ  AND
              C69_DATA >= DATAINICIAL AND
              C69_DATA < DATAINI ;
            IF SALDO_ANTERIOR_DEBITO IS NULL THEN
               SALDO_ANTERIOR_DEBITO := 0;
            END IF;

            SALDO_ANTERIOR_DEBITO := SALDO_ANTERIOR_DEBITO + SALDO_ANTERIOR_DEBITO_A;

            -- CALCULA O VALOR DO CREDITO ANTERIOR A DATA INICIAL

            MES_ANTERIOR := TO_CHAR(DATAINI,'MM')::INTEGER - 1 ;

            SALDO_ANTERIOR_CREDITO_A := 0;
            IF MES_ANTERIOR > 0 THEN

               SELECT SUM(C68_CREDITO)
               INTO SALDO_ANTERIOR_CREDITO_A
               FROM CONPLANOEXESALDO
               WHERE C68_ANOUSU = ANOUSU AND
              C68_REDUZ  = REDUZ  AND
              C68_MES   <= MES_ANTERIOR;

               IF SALDO_ANTERIOR_CREDITO_A IS NULL THEN
                  SALDO_ANTERIOR_CREDITO_A := 0;
               END IF;

               DATAINICIAL := ANOUSU||'-'||TO_CHAR(DATAINI,'MM')||'-01';

            ELSE

               DATAINICIAL := ANOUSU||'-01-01';

            END IF;


            SELECT SUM(C69_VALOR) AS C69_VALOR
            INTO SALDO_ANTERIOR_CREDITO
            FROM CONLANCAMVAL
            WHERE C69_ANOUSU = ANOUSU AND
              C69_CREDITO = REDUZ AND
              C69_DATA >= DATAINICIAL AND
              C69_DATA < DATAINI ;

            IF SALDO_ANTERIOR_CREDITO IS NULL THEN
               SALDO_ANTERIOR_CREDITO := 0;
            END IF;

            SALDO_ANTERIOR_CREDITO := SALDO_ANTERIOR_CREDITO + SALDO_ANTERIOR_CREDITO_A;

            -- CALCULA SALDO ANTERIOR E CRIA O SINAL PARA O SALDO

            SALDO_ANTERIOR := VLRDEB - VLRCRE;
            SALDO_ANTERIOR := SALDO_ANTERIOR + SALDO_ANTERIOR_DEBITO - SALDO_ANTERIOR_CREDITO;
            SINAL_ANT := 'D';
            IF SALDO_ANTERIOR > 0 THEN
               SINAL_ANT := 'D';
            END IF;
            IF SALDO_ANTERIOR < 0 THEN
               SINAL_ANT := 'C';
            END IF;
            SALDO_ANTERIOR_DEBITO  := 0;
            SALDO_ANTERIOR_CREDITO := 0;
            SALDO_ANTERIOR_DEBITO_A  := 0;
            SALDO_ANTERIOR_CREDITO_A := 0;


            -- raise notice 's%,d%,c%',saldo_anterior,saldo_anterior_debito,saldo_anterior_credito;

            -- CALCULA OS VALORES DO PERIODO

              --SE MES_DATA_INICIAL = MES_DATA_FINAL
            IF TO_CHAR(DATAINI,'MM')::INTEGER = TO_CHAR(DATAFIM,'MM')::INTEGER THEN
               IF TO_CHAR(DATAINI,'DD')::INTEGER = 1
                 AND TO_CHAR(DATAFIM,'DD')::INTEGER = FC_ULTIMODIAMES(ANOUSU,TO_CHAR(DATAFIM,'MM')::INTEGER)
                 AND ENCERRAMENTO = TRUE  THEN
               -- raise notice '00099';
                 -- calcula normal quando datafim = ultimo dia do mes saldo esta na conplanoexesaldo (saldo mensal)
                 SELECT C68_DEBITO,C68_CREDITO
                 INTO SALDO_ANTERIOR_DEBITO,SALDO_ANTERIOR_CREDITO
                 FROM CONPLANOEXESALDO
                 WHERE C68_ANOUSU = ANOUSU AND
              C68_REDUZ  = REDUZ  AND
              C68_MES    = TO_CHAR(DATAINI,'MM')::INTEGER;

                 IF SALDO_ANTERIOR_DEBITO IS NULL THEN
                    SALDO_ANTERIOR_DEBITO := 0;
                 END IF;

                 IF SALDO_ANTERIOR_CREDITO IS NULL THEN
                    SALDO_ANTERIOR_CREDITO := 0;
                 END IF;

                 -- raise notice '%-%',saldo_anterior_debito,saldo_anterior_credito;

               ELSE
                 -- quando nao e o ultimo dia do mes calcula periodo pela conlancamval
                 IF ENCERRAMENTO = TRUE THEN
                    SELECT SUM(C69_VALOR) AS C69_VALOR
                    INTO SALDO_ANTERIOR_DEBITO
                    FROM CONLANCAMVAL
                    WHERE C69_ANOUSU = ANOUSU AND
              C69_DEBITO = REDUZ AND
              C69_DATA >= DATAINI AND
              C69_DATA <= DATAFIM ;
                    IF SALDO_ANTERIOR_DEBITO IS NULL THEN
                        SALDO_ANTERIOR_DEBITO := 0;
                    END IF;
                    SELECT SUM(C69_VALOR) AS C69_VALOR
                    INTO SALDO_ANTERIOR_CREDITO
                    FROM CONLANCAMVAL
                    WHERE C69_ANOUSU = ANOUSU AND
              C69_CREDITO = REDUZ AND
              C69_DATA >= DATAINI AND
              C69_DATA <= DATAFIM;
                 ELSE
                    -- lançamentos sem encerramento de exercicio,sem tipo de documento 1000
                    SELECT SUM(C69_VALOR) AS C69_VALOR
              INTO SALDO_ANTERIOR_DEBITO
                    FROM CONLANCAMVAL
                 LEFT JOIN CONLANCAMDOC ON C71_CODLAN=C69_CODLAN
                 LEFT JOIN CONHISTDOC ON C53_CODDOC = C71_CODDOC

                 WHERE C69_ANOUSU = ANOUSU AND
              C69_DEBITO = REDUZ AND
              C69_DATA >= DATAINI AND
              C69_DATA <= DATAFIM AND
              ( C53_TIPO NOT IN (1000) OR  C53_TIPO IS NULL ) ;
                    IF SALDO_ANTERIOR_DEBITO IS NULL THEN
                        SALDO_ANTERIOR_DEBITO := 0;
                    END IF;
                    SELECT SUM(C69_VALOR) AS C69_VALOR
                    INTO SALDO_ANTERIOR_CREDITO
                    FROM CONLANCAMVAL
                       LEFT JOIN CONLANCAMDOC ON C71_CODLAN=C69_CODLAN
                 LEFT JOIN CONHISTDOC ON C53_CODDOC = C71_CODDOC
                    WHERE C69_ANOUSU = ANOUSU AND
              C69_CREDITO = REDUZ AND
              C69_DATA >= DATAINI AND
              C69_DATA <= DATAFIM AND
              ( C53_TIPO NOT IN (1000) OR C53_TIPO IS NULL );
                 END IF;

                 IF SALDO_ANTERIOR_CREDITO IS NULL THEN
                    SALDO_ANTERIOR_CREDITO := 0;
                 END IF;

               END IF;
              ELSE

                --SE MES_DATA_INICIAL + 1 < MES_DATA_FINAL
               IF TO_CHAR(DATAINI,'MM')::INTEGER + 1 <= TO_CHAR(DATAFIM,'MM')::INTEGER THEN

               --PAGAR O ULTIMO DO DO MES INICIAL E CALCULAR O PERIODO
              --raise notice 'ppp%',dataini;
            DATA_FINAL := ANOUSU||'-'||TO_CHAR(DATAINI,'MM')||'-'||SUBSTR(TO_CHAR(FC_ULTIMODIAMES(ANOUSU,TO_CHAR(DATAINI,'MM')::INTEGER),'99'),2,2);
                  MES_DATA_INICIAL := TO_CHAR(DATAINI,'MM')::INTEGER;

          --        SELECT SUM(C69_VALOR) AS C69_VALOR
              --        INTO SALDO_ANTERIOR_DEBITO_A
              --        FROM CONLANCAMVAL
              --        WHERE C69_ANOUSU = ANOUSU AND C69_DEBITO = REDUZ AND  C69_DATA > DATAINICIAL AND C69_DATA <= DATA_FINAL;
          --        IF SALDO_ANTERIOR_DEBITO_A IS NULL THEN
              --           SALDO_ANTERIOR_DEBITO_A = 0;
          --        END IF;
          --        SELECT SUM(C69_VALOR) AS C69_VALOR
              --        INTO SALDO_ANTERIOR_CREDITO_A
              --        FROM CONLANCAMVAL
              --        WHERE C69_ANOUSU = ANOUSU AND C69_CREDITO = REDUZ AND  C69_DATA > DATAINICIAL AND C69_DATA <= DATA_FINAL;
          --        IF SALDO_ANTERIOR_CREDITO_A IS NULL THEN
              --           SALDO_ANTERIOR_CREDITO_A = 0;
          --        END IF;
          --raise notice '--111';
                  LOOP
                  --BUSCA PROXIMO MES NORMAL
                   SELECT C68_DEBITO,C68_CREDITO
                         INTO SALDO_ANTERIOR_DEBITO,SALDO_ANTERIOR_CREDITO
                         FROM CONPLANOEXESALDO
                         WHERE C68_ANOUSU = ANOUSU AND
              C68_REDUZ  = REDUZ  AND
              C68_MES    = MES_DATA_INICIAL;
                         IF SALDO_ANTERIOR_DEBITO IS NULL THEN
                   SALDO_ANTERIOR_DEBITO := 0;
                 END IF;
                         IF SALDO_ANTERIOR_CREDITO IS NULL THEN
                            SALDO_ANTERIOR_CREDITO := 0;
                         END IF;
                         SALDO_ANTERIOR_CREDITO_A := SALDO_ANTERIOR_CREDITO_A + SALDO_ANTERIOR_CREDITO;
                         SALDO_ANTERIOR_DEBITO_A := SALDO_ANTERIOR_DEBITO_A + SALDO_ANTERIOR_DEBITO;
                         --SOMA 1 NO MES
                     MES_DATA_INICIAL := MES_DATA_INICIAL + 1;
                   --VER SE IGUAL AO FINAL
                   IF MES_DATA_INICIAL = TO_CHAR(DATAFIM,'MM')::INTEGER THEN
                     EXIT;
                         END IF;
                  END LOOP;

                  --CALCULA FINAL POR PERIODO
                  --SE DIA FOR ULTIMO DO MES
            IF TO_CHAR(DATAFIM,'DD')::INTEGER = FC_ULTIMODIAMES(ANOUSU,TO_CHAR(DATAFIM,'MM')::INTEGER)
              AND ENCERRAMENTO =TRUE
            THEN
            -- CALCULA NORMAL
              -- raise notice 'asdfasdf';
                     SELECT C68_DEBITO,C68_CREDITO
                     INTO SALDO_ANTERIOR_DEBITO,SALDO_ANTERIOR_CREDITO
                     FROM CONPLANOEXESALDO
                     WHERE C68_ANOUSU = ANOUSU AND
              C68_REDUZ  = REDUZ  AND
              C68_MES    = TO_CHAR(DATAFIM,'MM')::INTEGER;

                     IF SALDO_ANTERIOR_DEBITO IS NULL THEN
                        SALDO_ANTERIOR_DEBITO := 0;
                     END IF;

                     IF SALDO_ANTERIOR_CREDITO IS NULL THEN
                       SALDO_ANTERIOR_CREDITO := 0;
                     END IF;

                     SALDO_ANTERIOR_CREDITO_A := SALDO_ANTERIOR_CREDITO_A + SALDO_ANTERIOR_CREDITO;
                     SALDO_ANTERIOR_DEBITO_A := SALDO_ANTERIOR_DEBITO_A + SALDO_ANTERIOR_DEBITO;

            ELSE
               -- SENAO CALCULA PERIODO - DATA_FINAL SO PARA APROVEITAR A VARIAVEL
               IF ENCERRAMENTO=TRUE THEN
                     DATA_FINAL := ANOUSU||'-'||TO_CHAR(DATAFIM,'MM')||'-01';
                   SELECT SUM(C69_VALOR) AS C69_VALOR
                         INTO SALDO_ANTERIOR_DEBITO
                         FROM CONLANCAMVAL
                         WHERE C69_ANOUSU = ANOUSU AND
              C69_DEBITO = REDUZ AND
              C69_DATA >= DATA_FINAL AND
              C69_DATA <= DATAFIM;
                         IF SALDO_ANTERIOR_DEBITO IS NULL THEN
                            SALDO_ANTERIOR_DEBITO := 0;
                         END IF;
                         SELECT SUM(C69_VALOR) AS C69_VALOR
                         INTO SALDO_ANTERIOR_CREDITO
                         FROM CONLANCAMVAL
                         WHERE C69_ANOUSU = ANOUSU AND
              C69_CREDITO = REDUZ AND
              C69_DATA >= DATA_FINAL AND
              C69_DATA <= DATAFIM;
                          IF SALDO_ANTERIOR_CREDITO IS NULL THEN
                             SALDO_ANTERIOR_CREDITO := 0;
                          END IF;
                    SALDO_ANTERIOR_CREDITO_A := SALDO_ANTERIOR_CREDITO_A + SALDO_ANTERIOR_CREDITO;
                          SALDO_ANTERIOR_DEBITO_A := SALDO_ANTERIOR_DEBITO_A + SALDO_ANTERIOR_DEBITO;
                     ELSE
                   -- sem encerramento
                     DATA_FINAL := ANOUSU||'-'||TO_CHAR(DATAFIM,'MM')||'-01';
                   SELECT SUM(C69_VALOR) AS C69_VALOR
                         INTO SALDO_ANTERIOR_DEBITO
                         FROM CONLANCAMVAL
                        LEFT JOIN CONLANCAMDOC ON C71_CODLAN=C69_CODLAN
                              LEFT JOIN CONHISTDOC ON C53_CODDOC = C71_CODDOC
                   WHERE C69_ANOUSU = ANOUSU AND
              C69_DEBITO = REDUZ AND
              C69_DATA >= DATA_FINAL AND
              C69_DATA <= DATAFIM AND
              ( C53_TIPO not in (1000) or C53_TIPO IS NULL );
                         IF SALDO_ANTERIOR_DEBITO IS NULL THEN
                            SALDO_ANTERIOR_DEBITO := 0;
                         END IF;
                         SELECT SUM(C69_VALOR) AS C69_VALOR
                         INTO SALDO_ANTERIOR_CREDITO
                         FROM CONLANCAMVAL
                       LEFT JOIN CONLANCAMDOC ON C71_CODLAN=C69_CODLAN
                             LEFT JOIN CONHISTDOC ON C53_CODDOC = C71_CODDOC
                         WHERE C69_ANOUSU = ANOUSU AND
              C69_CREDITO = REDUZ AND
              C69_DATA >= DATA_FINAL AND
              C69_DATA <= DATAFIM AND
              ( C53_TIPO not in (1000) or C53_TIPO IS NULL );
                          IF SALDO_ANTERIOR_CREDITO IS NULL THEN
                             SALDO_ANTERIOR_CREDITO := 0;
                          END IF;
                    SALDO_ANTERIOR_CREDITO_A := SALDO_ANTERIOR_CREDITO_A + SALDO_ANTERIOR_CREDITO;
                          SALDO_ANTERIOR_DEBITO_A := SALDO_ANTERIOR_DEBITO_A + SALDO_ANTERIOR_DEBITO;
                 END IF;
            END IF;

                  SALDO_ANTERIOR_DEBITO  := SALDO_ANTERIOR_DEBITO_A ;
                  SALDO_ANTERIOR_CREDITO := SALDO_ANTERIOR_CREDITO_A;

               END IF;

            END IF;

            SALDO_FINAL := SALDO_ANTERIOR + SALDO_ANTERIOR_DEBITO - SALDO_ANTERIOR_CREDITO;
            SINAL_FINAL := ' ';

            IF SALDO_FINAL < 0 THEN
               SINAL_FINAL := 'C';
            elsif
               SALDO_FINAL = 0 then
               SINAL_FINAL := SINAL_ANT;
            ELSE
               IF SALDO_FINAL > 0 THEN
                  SINAL_FINAL := 'D';
               END IF;
            END IF;

            RETURN '1 '||TO_CHAR(ABS(SALDO_ANTERIOR),'9999999999.99')||TO_CHAR(ABS(SALDO_ANTERIOR_DEBITO),'9999999999.99')||TO_CHAR(ABS(SALDO_ANTERIOR_CREDITO),'9999999999.99')||TO_CHAR(ABS(SALDO_FINAL),'9999999999.99')||SINAL_ANT||SINAL_FINAL;

          END;
          $$
          ;
          COMMIT;
SQL;
      $this->execute($sql);
    }
}
