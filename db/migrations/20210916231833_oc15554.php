<?php

use Classes\PostgresMigration;

class Oc15554 extends PostgresMigration
{

  public function up()
  {
    $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        --  Cria os documentos 128 e 129
        INSERT INTO conhistdoc VALUES
            (128, 'RESTITUIÇÕES DA RECEITA', 101),
            (129, 'ESTORNO DE RESTITUIÇÕES DA RECEITA', 100);

        -- Inserindo vinculo entre os eventos de lançamento e estorno dos novos documentos
        INSERT INTO vinculoeventoscontabeis VALUES
        (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 128, 129);

        -- Inserindo o novo Grupo do Plano Orçamentário
        INSERT INTO congrupo VALUES (25004, 'RESTITUIÇÕES DA RECEITA', 1);

        -- Inserindo Regras dos novos documentos.
        SELECT setval('conhistdocregra_c92_sequencial_seq',
                          (SELECT max(c92_sequencial)+1
                           FROM conhistdocregra));

        INSERT INTO conhistdocregra VALUES
        (nextval('conhistdocregra_c92_sequencial_seq'),
         128,
         'RESTITUIÇÕES DA RECEITA',
         'SELECT 1 FROM orcreceita INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu INNER JOIN conplanoorcamento ON o57_codfon = conplanoorcamento.c60_codcon AND o57_anousu = conplanoorcamento.c60_anousu INNER JOIN conplanoorcamentogrupo ON c21_codcon = conplanoorcamento.c60_codcon AND c21_anousu = conplanoorcamento.c60_anousu WHERE o70_codrec = [codigoreceita] AND o70_anousu = [anousureceita] AND c21_congrupo = 25004 AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]',
         2021),
        (nextval('conhistdocregra_c92_sequencial_seq'),
         129,
         'ESTORNO DE RESTITUIÇÕES DA RECEITA',
         'SELECT 1 FROM orcreceita INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu INNER JOIN conplanoorcamento ON o57_codfon = conplanoorcamento.c60_codcon AND o57_anousu = conplanoorcamento.c60_anousu INNER JOIN conplanoorcamentogrupo ON c21_codcon = conplanoorcamento.c60_codcon AND c21_anousu = conplanoorcamento.c60_anousu WHERE o70_codrec = [codigoreceita] AND o70_anousu = [anousureceita] AND c21_congrupo = 25004 AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]',
         2021);

         --Cria função temporária para buscar instituições
        
        CREATE TEMP TABLE instituicoes(
            sequencial SERIAL,
            inst INT
        );

        INSERT INTO instituicoes(inst) (SELECT codigo FROM db_config);

        SELECT * FROM instituicoes;

        CREATE OR REPLACE FUNCTION getAllCodigos() RETURNS SETOF instituicoes AS
        $$
        DECLARE
            r instituicoes%rowtype;
        BEGIN
            FOR r IN SELECT * FROM instituicoes
            LOOP

                -- Vinculando os estruturais das receitas específicos para as novas regras dos novos documentos.
                INSERT INTO conplanoorcamentogrupo 
                SELECT DISTINCT ON (c60_codcon)
                 nextval('conplanoorcamentogrupo_c21_sequencial_seq'),
                 c60_anousu,
                 c60_codcon,
                 25004,
                 r.inst
                 FROM conplanoorcamento
                 JOIN conhistdocregra ON c92_conhistdoc = 418
                 LEFT JOIN conplanoorcamentoanalitica ON (c61_codcon, c61_anousu) = (c60_codcon, c60_anousu)
                 WHERE c60_estrut LIKE '492%'
                  AND c60_anousu = 2021;

                -- Criando as transações, regras e vinculando as contas para os novos documentos 128 e 129

                INSERT INTO contrans
                SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
                       2021,
                       128,
                       r.inst;

                INSERT INTO contrans
                SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
                       2021,
                       129,
                       r.inst;

                INSERT INTO contranslan
                VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                       (SELECT c45_seqtrans FROM contrans
                        WHERE c45_coddoc = 128
                          AND c45_anousu = 2021
                          AND c45_instit = r.inst
                        LIMIT 1), 
                       101,
                       'PRIMEIRO LANCAMENTO',
                       0,
                       FALSE,
                       0,
                       'PRIMEIRO LANCAMENTO',
                       1);

                INSERT INTO contranslan
                VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                       (SELECT c45_seqtrans FROM contrans
                        WHERE c45_coddoc = 128
                          AND c45_anousu = 2021
                          AND c45_instit = r.inst
                        LIMIT 1), 
                       101,
                       'SEGUNDO LANCAMENTO',
                       0,
                       FALSE,
                       0,
                       'SEGUNDO LANCAMENTO',
                       2);

                INSERT INTO contranslan
                VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                       (SELECT c45_seqtrans FROM contrans
                        WHERE c45_coddoc = 128
                          AND c45_anousu = 2021
                          AND c45_instit = r.inst
                        LIMIT 1), 
                       101,
                       'TERCEIRO LANCAMENTO',
                       0,
                       FALSE,
                       0,
                       'TERCEIRO LANCAMENTO',
                       3);

                INSERT INTO contranslan
                VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                       (SELECT c45_seqtrans FROM contrans
                        WHERE c45_coddoc = 129
                          AND c45_anousu = 2021
                          AND c45_instit = r.inst
                        LIMIT 1), 
                       100,
                       'PRIMEIRO LANCAMENTO',
                       0,
                       FALSE,
                       0,
                       'PRIMEIRO LANCAMENTO',
                       1);

                INSERT INTO contranslan
                VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                       (SELECT c45_seqtrans FROM contrans
                        WHERE c45_coddoc = 129
                          AND c45_anousu = 2021
                          AND c45_instit = r.inst
                        LIMIT 1), 
                       100,
                       'SEGUNDO LANCAMENTO',
                       0,
                       FALSE,
                       0,
                       'SEGUNDO LANCAMENTO',
                       2);

                INSERT INTO contranslan
                VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                       (SELECT c45_seqtrans FROM contrans
                        WHERE c45_coddoc = 129
                          AND c45_anousu = 2021
                          AND c45_instit = r.inst
                        LIMIT 1), 
                       100,
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
                        WHERE c45_coddoc = 128
                          AND c45_anousu = 2021
                          AND c46_ordem = 1
                          AND c45_instit = r.inst
                        LIMIT 1 ) AS c47_seqtranslan,
                       0 AS c47_debito,
                       0 AS c47_credito,
                       '' c47_obs,
                       0 c47_ref,
                       2021 AS c47_anousu,
                       c45_instit,
                       0 c47_compara,
                       0 c47_tiporesto
                FROM contrans
                JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1 AND c45_instit = r.inst
                WHERE c45_coddoc = 128
                  AND c45_anousu = 2021
                  AND c45_instit = r.inst
                LIMIT 1;

                 -- Seleciona as contas a serem utilizadas nas transações

                INSERT INTO contranslr
                SELECT nextval('contranslr_c47_seqtranslr_seq'),
                       (SELECT max(c46_seqtranslan) FROM contranslan
                        JOIN contrans ON c46_seqtrans = c45_seqtrans
                        WHERE c45_coddoc = 128
                          AND c45_anousu = 2021
                          AND c46_ordem = 2
                          AND c45_instit = r.inst
                        LIMIT 1) AS c47_seqtranslan,
                       (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                            JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                            WHERE (c60_estrut, c60_anousu, c61_instit) = ('621330000000000', 2021, r.inst) LIMIT 1) AS c47_debito,
                       (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                            JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                            WHERE (c60_estrut, c60_anousu, c61_instit) = ('621100000000000', 2021, r.inst) LIMIT 1) AS c47_credito,
                       '' c47_obs,
                       0 c47_ref,
                       2021 AS c47_anousu,
                       c45_instit,
                       0 c47_compara,
                       0 c47_tiporesto
                FROM contrans
                JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 2 AND c45_instit = r.inst
                WHERE c45_coddoc = 128
                  AND c45_anousu = 2021
                  AND c45_instit = r.inst
                LIMIT 1;

                INSERT INTO contranslr
                SELECT nextval('contranslr_c47_seqtranslr_seq'),
                       (SELECT max(c46_seqtranslan) FROM contranslan
                        JOIN contrans ON c46_seqtrans = c45_seqtrans
                        WHERE c45_coddoc = 128
                          AND c45_anousu = 2021
                          AND c46_ordem = 3
                          AND c45_instit = r.inst
                        LIMIT 1) AS c47_seqtranslan,
                       (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                            JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                            WHERE (c60_estrut, c60_anousu, c61_instit) = ('821110100000000', 2021, r.inst) LIMIT 1) AS c47_debito,
                       (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                            JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                            WHERE (c60_estrut, c60_anousu, c61_instit) = ('721110000000000', 2021, r.inst) LIMIT 1) AS c47_credito,
                       '' c47_obs,
                       0 c47_ref,
                       2021 AS c47_anousu,
                       c45_instit,
                       0 c47_compara,
                       0 c47_tiporesto
                FROM contrans
                JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 3 AND c45_instit = r.inst
                WHERE c45_coddoc = 128
                  AND c45_anousu = 2021
                  AND c45_instit = r.inst
                LIMIT 1;

                INSERT INTO contranslr
                SELECT nextval('contranslr_c47_seqtranslr_seq'),
                       (SELECT min(c46_seqtranslan) FROM contranslan
                        JOIN contrans ON c46_seqtrans = c45_seqtrans
                        WHERE c45_coddoc = 129
                          AND c45_anousu = 2021
                          AND c46_ordem = 1
                          AND c45_instit = r.inst
                        LIMIT 1 ) AS c47_seqtranslan,
                       0 AS c47_debito,
                       0 AS c47_credito,
                       '' c47_obs,
                       0 c47_ref,
                       2021 AS c47_anousu,
                       c45_instit,
                       0 c47_compara,
                       0 c47_tiporesto
                FROM contrans
                JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1 AND c45_instit = r.inst
                WHERE c45_coddoc = 129
                  AND c45_anousu = 2021
                  AND c45_instit = r.inst
                LIMIT 1;

                INSERT INTO contranslr
                SELECT nextval('contranslr_c47_seqtranslr_seq'),
                       (SELECT max(c46_seqtranslan) FROM contranslan
                        JOIN contrans ON c46_seqtrans = c45_seqtrans
                        WHERE c45_coddoc = 129
                          AND c45_anousu = 2021
                          AND c46_ordem = 2
                          AND c45_instit = r.inst
                        LIMIT 1) AS c47_seqtranslan,
                       (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                                JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                                WHERE (c60_estrut, c60_anousu, c61_instit) = ('621100000000000', 2021, r.inst) LIMIT 1) AS c47_debito,
                       (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                                JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                                WHERE (c60_estrut, c60_anousu, c61_instit) = ('621330000000000', 2021, r.inst) LIMIT 1) AS c47_credito,
                       '' c47_obs,
                       0 c47_ref,
                       2021 AS c47_anousu,
                       c45_instit,
                       0 c47_compara,
                       0 c47_tiporesto
                FROM contrans
                JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 2 AND c45_instit = r.inst
                WHERE c45_coddoc = 129
                  AND c45_anousu = 2021
                  AND c45_instit = r.inst
                LIMIT 1;

                INSERT INTO contranslr
                SELECT nextval('contranslr_c47_seqtranslr_seq'),
                       (SELECT max(c46_seqtranslan) FROM contranslan
                        JOIN contrans ON c46_seqtrans = c45_seqtrans
                        WHERE c45_coddoc = 129
                          AND c45_anousu = 2021
                          AND c46_ordem = 3
                          AND c45_instit = r.inst
                        LIMIT 1) AS c47_seqtranslan,
                       (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                                JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                                WHERE (c60_estrut, c60_anousu, c61_instit) = ('721110000000000', 2021, r.inst) LIMIT 1) AS c47_debito,
                       (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                                JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                                WHERE (c60_estrut, c60_anousu, c61_instit) = ('821110100000000', 2021, r.inst) LIMIT 1) AS c47_credito,
                       '' c47_obs,
                       0 c47_ref,
                       2021 AS c47_anousu,
                       c45_instit,
                       0 c47_compara,
                       0 c47_tiporesto
                FROM contrans
                JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 3 AND c45_instit = r.inst
                WHERE c45_coddoc = 129
                  AND c45_anousu = 2021
                  AND c45_instit = r.inst
                LIMIT 1;

                RETURN NEXT r;

            END LOOP;
            RETURN;
            
        END
        $$
        LANGUAGE plpgsql;

        SELECT * FROM getAllCodigos();

        DROP FUNCTION getAllCodigos();

        COMMIT;

SQL;

    $this->execute($sql);

  }

}