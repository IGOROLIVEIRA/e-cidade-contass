<?php

use Classes\PostgresMigration;

class Oc12836 extends PostgresMigration
{

  public function up()
  {
    $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        DELETE FROM conhistdoc WHERE c53_coddoc = 25;

        INSERT INTO conhistdoc VALUES (25, 'DESCONTO OBTIDO', 21);

        INSERT INTO vinculoeventoscontabeis VALUES
        (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 25, null);

        INSERT INTO conplano VALUES ((SELECT MAX(c60_codcon)+1 FROM conplano), 2020, '491100000000000', 'VARIAÇÃO PATRIMON. AUMENTATIVA BRUTA A CLASSIFICAR', '', 0, 1, 0, 'N', 2, null, null, null, null, 1, null, null, 1);
        
        INSERT INTO conplano VALUES ((SELECT MAX(c60_codcon)+1 FROM conplano), 2020, '491110000000000', 'VARIAÇÃO PAT. AUMENTAT. A CLASSIFICAR CONSOLIDACAO', '', 0, 1, 0, 'N', 2, null, null, null, null, 1, null, null, 1);

        INSERT INTO conplano VALUES ((SELECT MAX(c60_codcon)+1 FROM conplano), 2020, '491110100000000', 'VARIAÇÃO PATRIMON. AUMENTATIVA BRUTA A CLASSIFICAR', '', 0, 1, 0, 'N', 2, null, null, null, null, 1, null, null, 1);

        --Cria função temporária para buscar instituições
        
        CREATE TEMP TABLE instituicoes(
            sequencial SERIAL,
            inst INT,
            tipo INT
        );

        INSERT INTO instituicoes(inst, tipo) (SELECT codigo, si09_tipoinstit FROM db_config INNER JOIN infocomplementaresinstit ON codigo = si09_instit);

        SELECT * FROM instituicoes;

        CREATE OR REPLACE FUNCTION criaContaTransacaoPorInstituicao() RETURNS SETOF instituicoes AS
        $$
        DECLARE
            r instituicoes%rowtype;
        BEGIN
            FOR r IN SELECT * FROM instituicoes
            LOOP

            INSERT INTO conplanoreduz VALUES ((SELECT MAX(c60_codcon) FROM conplano), 2020, (SELECT MAX(c61_reduz)+1 FROM conplanoreduz), r.inst, 1, 0, null);

            INSERT INTO conplanoexe VALUES(2020, (SELECT c61_reduz FROM conplanoreduz INNER JOIN conplano ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu WHERE c60_estrut = '491110000000000' AND c61_instit = r.inst AND c61_anousu = 2020 LIMIT 1), 100, 0, 0);

            INSERT INTO contrans
                SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
                      2020,
                      25,
                      r.inst;

            INSERT INTO contranslan
                VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                    (SELECT c45_seqtrans FROM contrans
                        WHERE c45_coddoc = 25
                        AND c45_anousu = 2020
                        AND c45_instit = r.inst
                        LIMIT 1), 
                    9004,
                    'PRIMEIRO LANCAMENTO',
                    0,
                    FALSE,
                    0,
                    'PRIMEIRO LANCAMENTO',
                    1);

            INSERT INTO contranslan
                VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                    (SELECT c45_seqtrans FROM contrans
                        WHERE c45_coddoc = 25
                        AND c45_anousu = 2020
                        AND c45_instit = r.inst
                        LIMIT 1), 
                    9004,
                    'SEGUNDO LANCAMENTO',
                    0,
                    FALSE,
                    0,
                    'SEGUNDO LANCAMENTO',
                    2);

            INSERT INTO contranslan
                VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                    (SELECT c45_seqtrans FROM contrans
                        WHERE c45_coddoc = 25
                        AND c45_anousu = 2020
                        AND c45_instit = r.inst
                        LIMIT 1), 
                    9004,
                    'TERCEIRO LANCAMENTO',
                    0,
                    FALSE,
                    0,
                    'TERCEIRO LANCAMENTO',
                    3);

            INSERT INTO contranslr
                SELECT nextval('contranslr_c47_seqtranslr_seq'),
                    (SELECT min(c46_seqtranslan) FROM contranslan
                        JOIN contrans ON c46_seqtrans = c45_seqtrans
                        WHERE c45_coddoc = 25
                            AND c45_anousu = 2020
                            AND c46_ordem = 1
                            AND c45_instit = r.inst
                        LIMIT 1) AS c47_seqtranslan,
                        (SELECT 
                            CASE 
                                WHEN c61_reduz IS NULL THEN 0 
                                ELSE c61_reduz 
                            END c61_reduz 
                        FROM conplano
                            JOIN conplanoreduz ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu AND c61_instit = r.inst
                        WHERE c60_estrut = CASE
                                                WHEN r.tipo = 2 THEN '213110101010101' -- Tipo instituição = 2 - Prefeitura
                                                WHEN r.tipo = 1 THEN '213110101020101' -- Tipo instituição = 1 - Camara
                                                WHEN r.tipo = 5 THEN '213110101030101' -- Tipo instituição = 5 - RPPS
                                                WHEN r.tipo = 3 THEN '213110101040101' -- Tipo instituição = 3 - Autarquia
                                                WHEN r.tipo = 51 THEN '213110101500101' -- Tipo instituição = 51 - Consorcio
                                                ELSE ''
                                            END
                            AND c60_anousu = 2020
                            AND c61_instit = r.inst 
                        LIMIT 1) AS c47_debito,
                    (SELECT 
                            CASE 
                                WHEN c61_reduz IS NULL THEN 0 
                                ELSE c61_reduz 
                            END c61_reduz 
                        FROM conplano
                            JOIN conplanoreduz ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu AND c61_instit = r.inst
                        WHERE c60_estrut = '491110100000000'
                            AND c60_anousu = 2020
                            AND c61_instit = r.inst 
                        LIMIT 1) AS c47_credito,       
                    '' c47_obs,
                    0 c47_ref,
                    2020 AS c47_anousu,
                    c45_instit,
                    0 c47_compara,
                    0 c47_tiporesto
                FROM contrans
                JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1 AND c45_instit = r.inst
                WHERE c45_coddoc = 25
                  AND c45_anousu = 2020
                LIMIT 1;

            INSERT INTO contranslr
            SELECT nextval('contranslr_c47_seqtranslr_seq'),
                (SELECT min(c46_seqtranslan) FROM contranslan
                    JOIN contrans ON c46_seqtrans = c45_seqtrans
                    WHERE c45_coddoc = 25
                        AND c45_anousu = 2020
                        AND c46_ordem = 2
                        AND c45_instit = r.inst
                    LIMIT 1) AS c47_seqtranslan,
                    (SELECT 
                        CASE 
                            WHEN c61_reduz IS NULL THEN 0 
                            ELSE c61_reduz 
                        END c61_reduz 
                    FROM conplano
                        JOIN conplanoreduz ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu AND c61_instit = r.inst
                    WHERE c60_estrut = '622130300000000'
                        AND c60_anousu = 2020
                        AND c61_instit = r.inst 
                    LIMIT 1) AS c47_debito,
                (SELECT 
                        CASE 
                            WHEN c61_reduz IS NULL THEN 0 
                            ELSE c61_reduz 
                        END c61_reduz 
                    FROM conplano
                        JOIN conplanoreduz ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu AND c61_instit = r.inst
                    WHERE c60_estrut = '622130100000000'
                        AND c60_anousu = 2020
                        AND c61_instit = r.inst 
                    LIMIT 1) AS c47_credito,       
                '' c47_obs,
                0 c47_ref,
                2020 AS c47_anousu,
                c45_instit,
                0 c47_compara,
                0 c47_tiporesto
            FROM contrans
            JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1 AND c45_instit = r.inst
            WHERE c45_coddoc = 25
                AND c45_anousu = 2020
            LIMIT 1;

            INSERT INTO contranslr
            SELECT nextval('contranslr_c47_seqtranslr_seq'),
                (SELECT min(c46_seqtranslan) FROM contranslan
                    JOIN contrans ON c46_seqtrans = c45_seqtrans
                    WHERE c45_coddoc = 25
                        AND c45_anousu = 2020
                        AND c46_ordem = 3
                        AND c45_instit = r.inst
                    LIMIT 1) AS c47_seqtranslan,
                    (SELECT 
                        CASE 
                            WHEN c61_reduz IS NULL THEN 0 
                            ELSE c61_reduz 
                        END c61_reduz 
                    FROM conplano
                        JOIN conplanoreduz ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu AND c61_instit = r.inst
                    WHERE c60_estrut = '821130100000000'
                        AND c60_anousu = 2020
                        AND c61_instit = r.inst 
                    LIMIT 1) AS c47_debito,
                (SELECT 
                        CASE 
                            WHEN c61_reduz IS NULL THEN 0 
                            ELSE c61_reduz 
                        END c61_reduz 
                    FROM conplano
                        JOIN conplanoreduz ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu AND c61_instit = r.inst
                    WHERE c60_estrut = '821120100000000'
                        AND c60_anousu = 2020
                        AND c61_instit = r.inst 
                    LIMIT 1) AS c47_credito,       
                '' c47_obs,
                0 c47_ref,
                2020 AS c47_anousu,
                c45_instit,
                0 c47_compara,
                0 c47_tiporesto
            FROM contrans
            JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1 AND c45_instit = r.inst
            WHERE c45_coddoc = 25
                AND c45_anousu = 2020
            LIMIT 1;

            RETURN NEXT r;

            END LOOP;
            RETURN;
        
        END
        $$
        LANGUAGE plpgsql;

        SELECT * FROM criaContaTransacaoPorInstituicao();
 
        DROP FUNCTION criaContaTransacaoPorInstituicao();

        COMMIT;

SQL;

    $this->execute($sql);

  }

}