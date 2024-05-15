<?php

use Phinx\Migration\AbstractMigration;

class Oc10263 extends AbstractMigration
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

        --  Cria os documentos 124 a 127, que serão utilizados na contabilização das deduções das receitas.
        BEGIN;
        SELECT fc_startsession();
        -- Inserindo o documento para cadastros das regras a seguir.
        INSERT INTO conhistdoc VALUES
        (124, 'RETIFICAÇÕES', 101),
        (125, 'RETIFICAÇÕES - ESTORNO', 100),
        (126, 'OUTRAS DEDUÇÕES DA RECEITA', 101),
        (127, 'OUTRAS DEDUÇÕES DA RECEITA - ESTORNO', 100);

        -- Seleciona as contas a serem utilizadas nas transações

        CREATE TEMP TABLE ctas_docs_124_125 ON COMMIT DROP AS
        SELECT
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('621360000000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc124_regra2_cta1,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('621100000000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc124_regra2_cta2,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('821110100000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc124_regra3_cta1,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('721110000000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc124_regra3_cta2;


        CREATE TEMP TABLE ctas_docs_126_127 ON COMMIT DROP AS
        SELECT
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('621390000000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc126_regra2_cta1,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('621100000000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc126_regra2_cta2,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('821110100000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc126_regra3_cta1,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('721110000000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc126_regra3_cta2;

        -- Inserindo os novos Grupos do Plano Orçamentário e Regras dos novos documentos.

        INSERT INTO congrupo VALUES 
        (25001, 'RETIFICACOES', 1),
        (25002, 'OUTRAS DEDUÇÕES DA RECEITA', 1),
        (25003, 'DESCONTOS CONCEDIDOS', 1);

        SELECT setval('conhistdocregra_c92_sequencial_seq',
                          (SELECT max(c92_sequencial)+1
                           FROM conhistdocregra));

        INSERT INTO conhistdocregra VALUES
        (nextval('conhistdocregra_c92_sequencial_seq'),
         124,
         'RETIFICACOES',
         'SELECT 1 FROM orcreceita INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu INNER JOIN conplanoorcamento ON o57_codfon = conplanoorcamento.c60_codcon AND o57_anousu = conplanoorcamento.c60_anousu INNER JOIN conplanoorcamentogrupo ON c21_codcon = conplanoorcamento.c60_codcon AND c21_anousu = conplanoorcamento.c60_anousu WHERE o70_codrec = [codigoreceita] AND o70_anousu = [anousureceita] AND c21_congrupo = 25001 AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]',
         2019),
        (nextval('conhistdocregra_c92_sequencial_seq'),
         125,
         'RETIFICACOES - ESTORNO',
         'SELECT 1 FROM orcreceita INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu INNER JOIN conplanoorcamento ON o57_codfon = conplanoorcamento.c60_codcon AND o57_anousu = conplanoorcamento.c60_anousu INNER JOIN conplanoorcamentogrupo ON c21_codcon = conplanoorcamento.c60_codcon AND c21_anousu = conplanoorcamento.c60_anousu WHERE o70_codrec = [codigoreceita] AND o70_anousu = [anousureceita] AND c21_congrupo = 25001 AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]',
         2019),
        (nextval('conhistdocregra_c92_sequencial_seq'),
         126,
         'OUTRAS DEDUCOES DA RECEITA',
         'SELECT 1 FROM orcreceita INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu INNER JOIN conplanoorcamento ON o57_codfon = conplanoorcamento.c60_codcon AND o57_anousu = conplanoorcamento.c60_anousu INNER JOIN conplanoorcamentogrupo ON c21_codcon = conplanoorcamento.c60_codcon AND c21_anousu = conplanoorcamento.c60_anousu WHERE o70_codrec = [codigoreceita] AND o70_anousu = [anousureceita] AND c21_congrupo = 25002 AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]',
         2019),
        (nextval('conhistdocregra_c92_sequencial_seq'),
         127,
         'OUTRAS DEDUCOES DA RECEITA - ESTORNO',
         'SELECT 1 FROM orcreceita INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu INNER JOIN conplanoorcamento ON o57_codfon = conplanoorcamento.c60_codcon AND o57_anousu = conplanoorcamento.c60_anousu INNER JOIN conplanoorcamentogrupo ON c21_codcon = conplanoorcamento.c60_codcon AND c21_anousu = conplanoorcamento.c60_anousu WHERE o70_codrec = [codigoreceita] AND o70_anousu = [anousureceita] AND c21_congrupo = 25002 AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]',
         2019),
        (nextval('conhistdocregra_c92_sequencial_seq'),
         418,
         'DESCONTOS CONCEDIDOS',
         'SELECT 1 FROM orcreceita INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu INNER JOIN conplanoorcamento ON o57_codfon = conplanoorcamento.c60_codcon AND o57_anousu = conplanoorcamento.c60_anousu INNER JOIN conplanoorcamentogrupo ON c21_codcon = conplanoorcamento.c60_codcon AND c21_anousu = conplanoorcamento.c60_anousu WHERE o70_codrec = [codigoreceita] AND o70_anousu = [anousureceita] AND c21_congrupo = 25003 AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]',
         2019),
        (nextval('conhistdocregra_c92_sequencial_seq'),
         419,
         'ESTORNO DESCONTOS CONCEDIDOS',
         'SELECT 1 FROM orcreceita INNER JOIN orcfontes ON o70_codfon = o57_codfon AND o70_anousu = o57_anousu INNER JOIN conplanoorcamento ON o57_codfon = conplanoorcamento.c60_codcon AND o57_anousu = conplanoorcamento.c60_anousu INNER JOIN conplanoorcamentogrupo ON c21_codcon = conplanoorcamento.c60_codcon AND c21_anousu = conplanoorcamento.c60_anousu WHERE o70_codrec = [codigoreceita] AND o70_anousu = [anousureceita] AND c21_congrupo = 25003 AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]',
         2019);

        -- Vinculando os estruturais das receitas específicos para as novas regras dos novos documentos.

        INSERT INTO conplanoorcamentogrupo 
        SELECT DISTINCT ON (c60_codcon)
         nextval('conplanoorcamentogrupo_c21_sequencial_seq'),
         c60_anousu,
         c60_codcon,
         25003,
         (SELECT codigo FROM db_config WHERE prefeitura = 't' LIMIT 1)
         FROM conplanoorcamento
         JOIN conhistdocregra ON c92_conhistdoc = 418
         LEFT JOIN conplanoorcamentoanalitica ON (c61_codcon, c61_anousu) = (c60_codcon, c60_anousu)
         WHERE c60_estrut LIKE '493%'
          AND c60_anousu = 2019;

        INSERT INTO conplanoorcamentogrupo 
        SELECT DISTINCT ON (c60_codcon) 
         nextval('conplanoorcamentogrupo_c21_sequencial_seq'),
         c60_anousu,
         c60_codcon,
         25001,
         (SELECT codigo FROM db_config WHERE prefeitura = 't' LIMIT 1)
         FROM conplanoorcamento
         JOIN conhistdocregra ON c92_conhistdoc = 124
         LEFT JOIN conplanoorcamentoanalitica ON (c61_codcon, c61_anousu) = (c60_codcon, c60_anousu)
         WHERE c60_estrut LIKE '498%'
          AND c60_anousu = 2019;

        INSERT INTO conplanoorcamentogrupo 
        SELECT DISTINCT ON (c60_codcon)
         nextval('conplanoorcamentogrupo_c21_sequencial_seq'),
         c60_anousu,
         c60_codcon,
         25002,
         (SELECT codigo FROM db_config WHERE prefeitura = 't' LIMIT 1)
         FROM conplanoorcamento
         JOIN conhistdocregra ON c92_conhistdoc = 126
         LEFT JOIN conplanoorcamentoanalitica ON (c61_codcon, c61_anousu) = (c60_codcon, c60_anousu)
         WHERE c60_estrut LIKE '499%'
          AND c60_anousu = 2019;

        -- Inserindo vinculo entre os eventos de lançamento e estorno dos novos documentos

        INSERT INTO vinculoeventoscontabeis VALUES
        (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 124, 125),
        (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 126, 127);

        -- Criando as transações, regras e vinculando as contas para os novos documentos 124 e 125

        INSERT INTO contrans
        SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
               2019,
               124,
               (SELECT codigo FROM db_config
                WHERE prefeitura = 't');

        INSERT INTO contrans
        SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
               2019,
               125,
               (SELECT codigo FROM db_config
                WHERE prefeitura = 't');

        INSERT INTO contranslan
        VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
               (SELECT c45_seqtrans FROM contrans
                WHERE c45_coddoc = 124
                  AND c45_anousu = 2019
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
                WHERE c45_coddoc = 124
                  AND c45_anousu = 2019
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
                WHERE c45_coddoc = 124
                  AND c45_anousu = 2019
                LIMIT 1), 
               100,
               'TERCEIRO LANCAMENTO',
               0,
               FALSE,
               0,
               'TERCEIRO LANCAMENTO',
               3);

        INSERT INTO contranslan
        VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
               (SELECT c45_seqtrans FROM contrans
                WHERE c45_coddoc = 125
                  AND c45_anousu = 2019
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
                WHERE c45_coddoc = 125
                  AND c45_anousu = 2019
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
                WHERE c45_coddoc = 125
                  AND c45_anousu = 2019
                LIMIT 1), 
               101,
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
                WHERE c45_coddoc = 124
                  AND c45_anousu = 2019
                  AND c46_ordem = 1
                LIMIT 1 ) AS c47_seqtranslan,
               0 AS c47_debito,
               0 AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 124
          AND c45_anousu = 2019
        LIMIT 1;

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT max(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 124
                  AND c45_anousu = 2019
                  AND c46_ordem = 2
                LIMIT 1) AS c47_seqtranslan,
               (SELECT doc124_regra2_cta1 FROM ctas_docs_124_125) AS c47_debito,
               (SELECT doc124_regra2_cta2 FROM ctas_docs_124_125) AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 124
          AND c45_anousu = 2019
        LIMIT 1;

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT max(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 124
                  AND c45_anousu = 2019
                  AND c46_ordem = 3
                LIMIT 1) AS c47_seqtranslan,
               (SELECT doc124_regra3_cta1 FROM ctas_docs_124_125) AS c47_debito,
               (SELECT doc124_regra3_cta2 FROM ctas_docs_124_125) AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 124
          AND c45_anousu = 2019
        LIMIT 1;

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT min(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 125
                  AND c45_anousu = 2019
                  AND c46_ordem = 1
                LIMIT 1 ) AS c47_seqtranslan,
               0 AS c47_debito,
               0 AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 125
          AND c45_anousu = 2019
        LIMIT 1;

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT max(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 125
                  AND c45_anousu = 2019
                  AND c46_ordem = 2
                LIMIT 1) AS c47_seqtranslan,
               (SELECT doc124_regra2_cta2 FROM ctas_docs_124_125) AS c47_debito,
               (SELECT doc124_regra2_cta1 FROM ctas_docs_124_125) AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 125
          AND c45_anousu = 2019
        LIMIT 1;

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT max(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 125
                  AND c45_anousu = 2019
                  AND c46_ordem = 3
                LIMIT 1) AS c47_seqtranslan,
               (SELECT doc124_regra3_cta2 FROM ctas_docs_124_125) AS c47_debito,
               (SELECT doc124_regra3_cta1 FROM ctas_docs_124_125) AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 125
          AND c45_anousu = 2019
        LIMIT 1;

        -- Criando as transações, regras e vinculando as contas para os novos documentos 126 e 127

        INSERT INTO contrans
        SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
               2019,
               126,
               (SELECT codigo FROM db_config
                WHERE prefeitura = 't');

        INSERT INTO contrans
        SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
               2019,
               127,
               (SELECT codigo FROM db_config
                WHERE prefeitura = 't');

        INSERT INTO contranslan
        VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
               (SELECT c45_seqtrans FROM contrans
                WHERE c45_coddoc = 126
                  AND c45_anousu = 2019
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
                WHERE c45_coddoc = 126
                  AND c45_anousu = 2019
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
                WHERE c45_coddoc = 126
                  AND c45_anousu = 2019
                LIMIT 1), 
               100,
               'TERCEIRO LANCAMENTO',
               0,
               FALSE,
               0,
               'TERCEIRO LANCAMENTO',
               3);

        INSERT INTO contranslan
        VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
               (SELECT c45_seqtrans FROM contrans
                WHERE c45_coddoc = 127
                  AND c45_anousu = 2019
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
                WHERE c45_coddoc = 127
                  AND c45_anousu = 2019
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
                WHERE c45_coddoc = 127
                  AND c45_anousu = 2019
                LIMIT 1), 
               101,
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
                WHERE c45_coddoc = 126
                  AND c45_anousu = 2019
                  AND c46_ordem = 1
                LIMIT 1 ) AS c47_seqtranslan,
               0 AS c47_debito,
               0 AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 126
          AND c45_anousu = 2019
        LIMIT 1;

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT max(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 126
                  AND c45_anousu = 2019
                  AND c46_ordem = 2
                LIMIT 1) AS c47_seqtranslan,
               (SELECT doc126_regra2_cta1 FROM ctas_docs_126_127) AS c47_debito,
               (SELECT doc126_regra2_cta2 FROM ctas_docs_126_127) AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 126
          AND c45_anousu = 2019
        LIMIT 1;

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT max(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 126
                  AND c45_anousu = 2019
                  AND c46_ordem = 3
                LIMIT 1) AS c47_seqtranslan,
               (SELECT doc126_regra3_cta1 FROM ctas_docs_126_127) AS c47_debito,
               (SELECT doc126_regra3_cta2 FROM ctas_docs_126_127) AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 126
          AND c45_anousu = 2019
        LIMIT 1;

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT min(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 127
                  AND c45_anousu = 2019
                  AND c46_ordem = 1
                LIMIT 1 ) AS c47_seqtranslan,
               0 AS c47_debito,
               0 AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 127
          AND c45_anousu = 2019
        LIMIT 1;

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT max(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 127
                  AND c45_anousu = 2019
                  AND c46_ordem = 2
                LIMIT 1) AS c47_seqtranslan,
               (SELECT doc126_regra2_cta2 FROM ctas_docs_126_127) AS c47_debito,
               (SELECT doc126_regra2_cta1 FROM ctas_docs_126_127) AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 127
          AND c45_anousu = 2019
        LIMIT 1;

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT max(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 127
                  AND c45_anousu = 2019
                  AND c46_ordem = 3
                LIMIT 1) AS c47_seqtranslan,
               (SELECT doc126_regra3_cta2 FROM ctas_docs_126_127) AS c47_debito,
               (SELECT doc126_regra3_cta1 FROM ctas_docs_126_127) AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 127
          AND c45_anousu = 2019
        LIMIT 1;

        COMMIT;
        
SQL;
    
        $this->execute($sql);
    }
}
