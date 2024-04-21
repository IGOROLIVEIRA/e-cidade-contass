<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc11342 extends PostgresMigration
{

  public function up()
  {
    $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();
        
        INSERT INTO conhistdoctipo VALUES (1012, 'TRANSFERÊNCIA DE CRÉDITOS EMPENHADOS PARA RP');

        -- Inserindo o documento para cadastros das regras a seguir.
        INSERT INTO conhistdoc VALUES
        (1012, 'TRANSF. CREDITO EMP. A LIQUIDAR RPNP', 1012),
        (1013, 'TRANSF. CREDITO EMP. EM LIQUIDACAO RPNP', 1012),
        (1014, 'TRANSF. CREDITO EMP. LIQUIDADO RPNP', 1012);
        
        -- Seleciona as contas a serem utilizadas nas transações
        
        CREATE TEMP TABLE ctas_docs_1012_1017 ON COMMIT DROP AS
        SELECT
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('622130100000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc1012_regra1_cta1,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('622130500000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc1012_regra1_cta2,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('622130200000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc1013_regra1_cta1,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('622130600000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc1013_regra1_cta2,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('622130300000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc1014_regra1_cta1,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('622130700000000', 2019, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc1014_regra1_cta2;
        
        -- Inserindo vinculo entre os eventos de lançamento e estorno dos novos documentos
        
        INSERT INTO vinculoeventoscontabeis VALUES
        (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 1012, null),
        (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 1013, null),
        (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 1014, null);
        
        -- Criando as transações, regras e vinculando as contas para os novos documentos 1012 e 1015
        
        INSERT INTO contrans
        SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
               2019,
               1012,
               (SELECT codigo FROM db_config
                WHERE prefeitura = 't');
        
        INSERT INTO contranslan
        VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
               (SELECT c45_seqtrans FROM contrans
                WHERE c45_coddoc = 1012
                  AND c45_anousu = 2019
                LIMIT 1), 
               9600,
               'PRIMEIRO LANCAMENTO',
               0,
               FALSE,
               0,
               'PRIMEIRO LANCAMENTO',
               1);
        
        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT min(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 1012
                  AND c45_anousu = 2019
                  AND c46_ordem = 1
                LIMIT 1 ) AS c47_seqtranslan,
               (SELECT doc1012_regra1_cta1 FROM ctas_docs_1012_1017) AS c47_debito,
               (SELECT doc1012_regra1_cta2 FROM ctas_docs_1012_1017) AS c47_credito,       
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 1012
          AND c45_anousu = 2019
        LIMIT 1;
        
        -- Criando as transações, regras e vinculando as contas para os novos documentos 1013 e 1016
        
        INSERT INTO contrans
        SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
               2019,
               1013,
               (SELECT codigo FROM db_config
                WHERE prefeitura = 't');
        
        INSERT INTO contranslan
        VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
               (SELECT c45_seqtrans FROM contrans
                WHERE c45_coddoc = 1013
                  AND c45_anousu = 2019
                LIMIT 1), 
               9600,
               'PRIMEIRO LANCAMENTO',
               0,
               FALSE,
               0,
               'PRIMEIRO LANCAMENTO',
               1);
        
        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT min(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 1013
                  AND c45_anousu = 2019
                  AND c46_ordem = 1
                LIMIT 1 ) AS c47_seqtranslan,
               (SELECT doc1013_regra1_cta1 FROM ctas_docs_1012_1017) AS c47_debito,
               (SELECT doc1013_regra1_cta2 FROM ctas_docs_1012_1017) AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 1013
          AND c45_anousu = 2019
        LIMIT 1;
        
        -- Criando as transações, regras e vinculando as contas para os novos documentos 1014 e 1017
        
        INSERT INTO contrans
        SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
               2019,
               1014,
               (SELECT codigo FROM db_config
                WHERE prefeitura = 't');
        
        INSERT INTO contranslan
        VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
               (SELECT c45_seqtrans FROM contrans
                WHERE c45_coddoc = 1014
                  AND c45_anousu = 2019
                LIMIT 1), 
               9600,
               'PRIMEIRO LANCAMENTO',
               0,
               FALSE,
               0,
               'PRIMEIRO LANCAMENTO',
               1);
        
        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT min(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 1014
                  AND c45_anousu = 2019
                  AND c46_ordem = 1
                LIMIT 1 ) AS c47_seqtranslan,
               (SELECT doc1014_regra1_cta1 FROM ctas_docs_1012_1017) AS c47_debito,
               (SELECT doc1014_regra1_cta2 FROM ctas_docs_1012_1017) AS c47_credito,
               '' c47_obs,
               0 c47_ref,
               2019 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 1014
          AND c45_anousu = 2019
        LIMIT 1;

        COMMIT;

SQL;
    $this->execute($sql);
  }

}