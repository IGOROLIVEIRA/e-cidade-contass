<?php

use Phinx\Migration\AbstractMigration;

class Oc12052 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        CREATE TEMP TABLE new_ctas_orc
        (estrut varchar(15),
         descr text,
         c60_codsis integer,
         c60_codcla integer,
         c60_consistemaconta integer,
         c60_identificadorfinanceiro character(1),
         c60_naturezasaldo integer);

        INSERT INTO new_ctas_orc VALUES
        ('333801400000000', 'Diarias - Civil', 0, 2, 0, 'N', 1),
        ('333939100000000', 'Sentenças Judiciais', 0, 2, 0, 'N', 1),
        ('344501400000000', 'Diarias - Civil', 0, 2, 0, 'N', 1),
        ('344900400000000', 'Contratação por Tempo Determinado', 0, 2, 0, 'N', 1),
        ('344901400000000', 'Diarias - Civil ', 0, 2, 0, 'N', 1),
        ('344901800000000', 'Auxilio Financeiro a Estudantes', 0, 2, 0, 'N', 1),
        ('344902000000000', 'Auxilio Financeiro a Pesquisadores', 0, 2, 0, 'N', 1),
        ('344909500000000', 'Indenizacao pela Execucao de Trabalhos de Campo', 0, 2, 0, 'N', 1),
        ('345902700000000', 'Encargos pela Honra de Avais, Garantias, Seguros e Similares', 0, 2, 0, 'N', 1);

        -- Inserindo novas contas do Plano Orçamentário

        INSERT INTO conplanoorcamento
        SELECT nextval('conplanoorcamento_c60_codcon_seq') AS c60_codcon,
               t1.c60_anousu,
               estrut,
               substr(descr,1,50),
               descr,
               new_ctas_orc.c60_codsis,
               new_ctas_orc.c60_codcla,
               new_ctas_orc.c60_consistemaconta,
               new_ctas_orc.c60_identificadorfinanceiro,
               new_ctas_orc.c60_naturezasaldo
        FROM new_ctas_orc
        JOIN conplanoorcamento t1 ON c60_estrut = '331901103000000'
        WHERE t1.c60_anousu = 2020
          AND estrut NOT IN 
          (SELECT c60_estrut FROM conplanoorcamento WHERE c60_anousu = 2020);

        INSERT INTO conplanoorcamento
        SELECT c60_codcon,
               2021,
               c60_estrut,
               c60_descr,
               c60_finali,
               c60_codsis,
               c60_codcla,
               c60_consistemaconta,
               c60_identificadorfinanceiro,
               c60_naturezasaldo,
               c60_funcao
        FROM conplanoorcamento
        WHERE c60_estrut NOT IN (SELECT c60_estrut FROM conplanoorcamento WHERE c60_anousu > 2020)
          AND c60_estrut IN (SELECT estrut FROM new_ctas_orc)
          AND c60_anousu = 2020;

        -- Atualizando nome das contas do Plano Orçamentário

        UPDATE conplanoorcamento t1
        SET c60_descr = substr(t2.descr,1,50),
            c60_finali = t2.descr
        FROM new_ctas_orc t2
        INNER JOIN conplanoorcamento t3 ON t3.c60_estrut = t2.estrut
        WHERE t1.c60_estrut = t2.estrut
          AND t1.c60_anousu >= 2020;

        -- Inserindo reduzidos para as novas contas do Plano Orçamentário

        CREATE TEMP TABLE temp_table ON COMMIT DROP AS
        SELECT c60_estrut, conplanoorcamentoanalitica.* FROM conplanoorcamento
        JOIN conplanoorcamentoanalitica ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
        WHERE c60_estrut = '331901103000000'
          AND c60_anousu = 2020
        ORDER BY c60_estrut;

        INSERT INTO conplanoorcamentoanalitica
        SELECT c60_codcon AS c61_codcon,
               c61_anousu,
               nextval('conplanoorcamentoanalitica_c61_reduz_seq') AS c61_reduz,
               c61_instit,
               100 AS c61_codigo
        FROM conplanoorcamento
        JOIN temp_table ON c61_anousu = c60_anousu
        WHERE conplanoorcamento.c60_estrut IN (SELECT estrut FROM new_ctas_orc)
          AND conplanoorcamento.c60_codcon NOT IN (SELECT c61_codcon FROM conplanoorcamentoanalitica WHERE c61_anousu >= 2020)
          AND conplanoorcamento.c60_anousu >= 2020;

        -- Inserindo vínculos com PCASP das novas contas do Plano Orçamentário

        INSERT INTO conplanoconplanoorcamento
        SELECT nextval ('conplanoconplanoorcamento_c72_sequencial_seq') AS c72_sequencial,
               (SELECT c60_codcon FROM conplano
                WHERE substr(c60_estrut,1,7) = '3321101'
                  AND c60_anousu = 2020
                ORDER BY c60_estrut
                LIMIT 1) AS c72_conplano,
               c60_codcon AS c72_conplanoorcamento,
               c60_anousu AS c72_anousu
        FROM conplanoorcamento
        WHERE c60_estrut IN ('333801400000000', '344501400000000', '344901400000000')
          AND c60_anousu = 2020;

        INSERT INTO conplanoconplanoorcamento
        SELECT nextval ('conplanoconplanoorcamento_c72_sequencial_seq') AS c72_sequencial,
               (SELECT c60_codcon FROM conplano
                WHERE substr(c60_estrut,1,7) = '3311198'
                  AND c60_anousu = 2020
                ORDER BY c60_estrut
                LIMIT 1) AS c72_conplano,
               c60_codcon AS c72_conplanoorcamento,
               c60_anousu AS c72_anousu
        FROM conplanoorcamento
        WHERE c60_estrut IN ('333939100000000')
          AND c60_anousu = 2020;

        INSERT INTO conplanoconplanoorcamento
        SELECT nextval ('conplanoconplanoorcamento_c72_sequencial_seq') AS c72_sequencial,
               (SELECT c60_codcon FROM conplano
                WHERE substr(c60_estrut,1,9) = '311210499'
                  AND c60_anousu = 2020
                ORDER BY c60_estrut
                LIMIT 1) AS c72_conplano,
               c60_codcon AS c72_conplanoorcamento,
               c60_anousu AS c72_anousu
        FROM conplanoorcamento
        WHERE c60_estrut IN ('344900400000000')
          AND c60_anousu = 2020;

        INSERT INTO conplanoconplanoorcamento
        SELECT nextval ('conplanoconplanoorcamento_c72_sequencial_seq') AS c72_sequencial,
               (SELECT c60_codcon FROM conplano
                WHERE substr(c60_estrut,1,7) = '3571407'
                  AND c60_anousu = 2020
                ORDER BY c60_estrut
                LIMIT 1) AS c72_conplano,
               c60_codcon AS c72_conplanoorcamento,
               c60_anousu AS c72_anousu
        FROM conplanoorcamento
        WHERE c60_estrut IN ('344901800000000', '344902000000000')
          AND c60_anousu = 2020;

        INSERT INTO conplanoconplanoorcamento
        SELECT nextval ('conplanoconplanoorcamento_c72_sequencial_seq') AS c72_sequencial,
               (SELECT c60_codcon FROM conplano
                WHERE substr(c60_estrut,1,5) = '39961'
                  AND c60_anousu = 2020
                ORDER BY c60_estrut
                LIMIT 1) AS c72_conplano,
               c60_codcon AS c72_conplanoorcamento,
               c60_anousu AS c72_anousu
        FROM conplanoorcamento
        WHERE c60_estrut IN ('344909500000000')
          AND c60_anousu = 2020;

        INSERT INTO conplanoconplanoorcamento
        SELECT nextval ('conplanoconplanoorcamento_c72_sequencial_seq') AS c72_sequencial,
               (SELECT c60_codcon FROM conplano
                WHERE substr(c60_estrut,1,7) = '3999102'
                  AND c60_anousu = 2020
                ORDER BY c60_estrut
                LIMIT 1) AS c72_conplano,
               c60_codcon AS c72_conplanoorcamento,
               c60_anousu AS c72_anousu
        FROM conplanoorcamento
        WHERE c60_estrut IN ('345902700000000')
          AND c60_anousu = 2020;

        -- Inserindo os novos estruturais para usar como dotações

        INSERT INTO orcelemento
        SELECT c60_codcon,
               c60_anousu,
               substr(c60_estrut,1,13),
               c60_descr,
               c60_finali,
               't' AS o56_orcado
        FROM conplanoorcamento
        WHERE c60_anousu >= 2020
            AND substr(c60_estrut,1,1) = '3'
            AND (c60_codcon, substr(c60_estrut,1,13)) NOT IN
                (SELECT o56_codele, o56_elemento FROM orcelemento
         WHERE o56_anousu = c60_anousu);

        COMMIT;

SQL;
      $this->execute($sql);

    }
}
