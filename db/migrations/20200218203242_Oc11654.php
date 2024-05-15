<?php

use Phinx\Migration\AbstractMigration;

class Oc11654 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        -- Inserindo as novas contas do Plano Orçamentário

        INSERT INTO conplanoorcamento
        SELECT nextval('conplanoorcamento_c60_codcon_seq') AS c60_codcon,
               c60_anousu,
               '331901150000000' AS c60_estrut,
               'SALÁRIO MATERNIDADE' AS c60_descr,
               '' AS c60_finali,
               c60_codsis,
               c60_codcla,
               c60_consistemaconta,
               c60_identificadorfinanceiro,
               1 AS c60_naturezasaldo,
               c60_funcao
        FROM conplanoorcamento
        JOIN conplanoorcamentoanalitica ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
        WHERE c60_estrut = '331901103000000'
          AND c60_anousu >= 2020
          AND c60_codcon NOT IN
              (SELECT c60_codcon FROM conplanoorcamento
               WHERE (c60_anousu, c60_estrut) = (2020, '331901150000000'))
        LIMIT 1;


        INSERT INTO conplanoorcamento
        SELECT nextval('conplanoorcamento_c60_codcon_seq') AS c60_codcon,
               c60_anousu,
               '331901152000000' AS c60_estrut,
               'SALÁRIO FAMÍLIA' AS c60_descr,
               '' AS c60_finali,
               c60_codsis,
               c60_codcla,
               c60_consistemaconta,
               c60_identificadorfinanceiro,
               1 AS c60_naturezasaldo,
               c60_funcao
        FROM conplanoorcamento
        JOIN conplanoorcamentoanalitica ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
        WHERE c60_estrut = '331901103000000'
          AND c60_anousu >= 2020
          AND c60_codcon NOT IN
              (SELECT c60_codcon FROM conplanoorcamento
               WHERE (c60_anousu, c60_estrut) = (2020, '331901152000000'))
        LIMIT 1;


        INSERT INTO conplanoorcamento
        SELECT nextval('conplanoorcamento_c60_codcon_seq') AS c60_codcon,
               c60_anousu,
               '331951150000000' AS c60_estrut,
               'SALÁRIO MATERNIDADE' AS c60_descr,
               '' AS c60_finali,
               c60_codsis,
               c60_codcla,
               c60_consistemaconta,
               c60_identificadorfinanceiro,
               1 AS c60_naturezasaldo,
               c60_funcao
        FROM conplanoorcamento
        JOIN conplanoorcamentoanalitica ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
        WHERE c60_estrut = '331901103000000'
          AND c60_anousu >= 2020
          AND c60_codcon NOT IN
              (SELECT c60_codcon FROM conplanoorcamento
               WHERE (c60_anousu, c60_estrut) = (2020, '331951150000000'))
        LIMIT 1;


        INSERT INTO conplanoorcamento
        SELECT nextval('conplanoorcamento_c60_codcon_seq') AS c60_codcon,
               c60_anousu,
               '331951152000000' AS c60_estrut,
               'SALÁRIO FAMÍLIA' AS c60_descr,
               '' AS c60_finali,
               c60_codsis,
               c60_codcla,
               c60_consistemaconta,
               c60_identificadorfinanceiro,
               1 AS c60_naturezasaldo,
               c60_funcao
        FROM conplanoorcamento
        JOIN conplanoorcamentoanalitica ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
        WHERE c60_estrut = '331901103000000'
          AND c60_anousu >= 2020
          AND c60_codcon NOT IN
              (SELECT c60_codcon FROM conplanoorcamento
               WHERE (c60_anousu, c60_estrut) = (2020, '331951152000000'))
        LIMIT 1;


        INSERT INTO conplanoorcamento
        SELECT nextval('conplanoorcamento_c60_codcon_seq') AS c60_codcon,
               c60_anousu,
               '331961150000000' AS c60_estrut,
               'SALÁRIO MATERNIDADE' AS c60_descr,
               '' AS c60_finali,
               c60_codsis,
               c60_codcla,
               c60_consistemaconta,
               c60_identificadorfinanceiro,
               1 AS c60_naturezasaldo,
               c60_funcao
        FROM conplanoorcamento
        JOIN conplanoorcamentoanalitica ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
        WHERE c60_estrut = '331901103000000'
          AND c60_anousu >= 2020
          AND c60_codcon NOT IN
              (SELECT c60_codcon FROM conplanoorcamento
               WHERE (c60_anousu, c60_estrut) = (2020, '331961150000000'))
        LIMIT 1;


        INSERT INTO conplanoorcamento
        SELECT nextval('conplanoorcamento_c60_codcon_seq') AS c60_codcon,
               c60_anousu,
               '331961152000000' AS c60_estrut,
               'SALÁRIO FAMÍLIA' AS c60_descr,
               '' AS c60_finali,
               c60_codsis,
               c60_codcla,
               c60_consistemaconta,
               c60_identificadorfinanceiro,
               1 AS c60_naturezasaldo,
               c60_funcao
        FROM conplanoorcamento
        JOIN conplanoorcamentoanalitica ON (c60_codcon, c60_anousu) = (c61_codcon, c61_anousu)
        WHERE c60_estrut = '331901103000000'
          AND c60_anousu >= 2020
          AND c60_codcon NOT IN
              (SELECT c60_codcon FROM conplanoorcamento
               WHERE (c60_anousu, c60_estrut) = (2020, '331961152000000'))
        LIMIT 1;

        -- Criando reduzidos para as contas

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
        WHERE conplanoorcamento.c60_estrut IN ('331901150000000', '331901152000000', '331951150000000', '331951152000000', '331961150000000', '331961152000000')
          AND conplanoorcamento.c60_anousu >= 2020;

        -- Inserindo vínculos com PCASP das novas contas do Plano Orçamentário

        INSERT INTO conplanoconplanoorcamento
        SELECT nextval ('conplanoconplanoorcamento_c72_sequencial_seq') AS c72_sequencial,
               (SELECT c60_codcon FROM conplano
                WHERE substr(c60_estrut,1,9) = '311110199'
                  AND c60_anousu = 2020
                ORDER BY c60_estrut
                LIMIT 1) AS c72_conplano,
               c60_codcon AS c72_conplanoorcamento,
               c60_anousu AS c72_anousu
        FROM conplanoorcamento
        WHERE c60_estrut IN ('331901150000000', '331901152000000', '331951150000000', '331951152000000', '331961150000000', '331961152000000')
          AND c60_anousu >= 2020;

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

    }
}
