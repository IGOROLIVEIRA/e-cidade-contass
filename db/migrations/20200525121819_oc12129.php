<?php

use Classes\PostgresMigration;

class Oc12129 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        UPDATE conhistdoc SET c53_descr = 'LIQUIDACAO RP MATERIAL ALMOX/PERMANENTE' WHERE c53_coddoc = 39;

        -- Inserindo o documento para cadastros das regras a seguir.
        INSERT INTO conhistdoc VALUES
        (214, 'REG. DE ENTRADA DE MP VIA RP', 200),
        (215, 'REG. DE ENTRADA DE MP VIA RP - ESTORNO', 200);
        
        -- Seleciona as contas a serem utilizadas nas transações
        
        CREATE TEMP TABLE ctas_docs_214_215 ON COMMIT DROP AS
        SELECT
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ((SELECT c60_estrut FROM contranslr JOIN conplanoreduz ON (c61_anousu, c61_instit, c61_reduz) = (c47_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'), c47_credito) JOIN conplano ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't')) WHERE c47_seqtranslan = (SELECT c46_seqtranslan FROM contranslan JOIN contrans ON c46_seqtrans = c45_seqtrans WHERE c45_coddoc = 208 AND c45_anousu = 2020 AND c46_ordem = 1 LIMIT 1) LIMIT 1), 2020, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc214_regra1_cta1,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('631100000000000', 2020, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc214_regra2_cta1,
            (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
             JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, (SELECT codigo FROM db_config WHERE prefeitura = 't'))
             WHERE (c60_estrut, c60_anousu, c61_instit) = ('631200000000000', 2020, (SELECT codigo FROM db_config WHERE prefeitura = 't')) LIMIT 1) doc214_regra2_cta2;
        
        -- Inserindo vinculo entre os eventos de lançamento e estorno dos novos documentos
        
        INSERT INTO vinculoeventoscontabeis VALUES
        (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 214, null),
        (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 215, null);

        INSERT INTO conhistdocregra VALUES
        (nextval('conhistdocregra_c92_sequencial_seq'),
         214,
         'CONTROLE DE DESPESA EM LIQUIDACAO - MP',
         'SELECT 1 FROM conplanoorcamentogrupo WHERE c21_codcon = [desdobramento] AND c21_congrupo = 9',
         2020),
        (nextval('conhistdocregra_c92_sequencial_seq'),
         215,
         'CONTROLE DE DESPESA EM LIQUIDACAO - MP - ESTORNO',
         'SELECT 1 FROM conplanoorcamentogrupo WHERE c21_codcon = [desdobramento] AND c21_congrupo = 9',
         2020);
        
        -- Criando as transações, regras e vinculando as contas para os novos documentos 214 e 215
        
        INSERT INTO contrans
        SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
               2020,
               214,
               (SELECT codigo FROM db_config
                WHERE prefeitura = 't');

        INSERT INTO contrans
        SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
               2020,
               215,
               (SELECT codigo FROM db_config
                WHERE prefeitura = 't');
        
        INSERT INTO contranslan
        VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
               (SELECT c45_seqtrans FROM contrans
                WHERE c45_coddoc = 214
                  AND c45_anousu = 2020
                LIMIT 1), 
               9003,
               'PRIMEIRO LANCAMENTO',
               0,
               FALSE,
               0,
               'PRIMEIRO LANCAMENTO',
               1);

        INSERT INTO contranslan
        VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
               (SELECT c45_seqtrans FROM contrans
                WHERE c45_coddoc = 214
                  AND c45_anousu = 2020
                LIMIT 1), 
               9003,
               'SEGUNDO LANCAMENTO',
               0,
               FALSE,
               0,
               'SEGUNDO LANCAMENTO',
               2);

        INSERT INTO contranslan
        VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
               (SELECT c45_seqtrans FROM contrans
                WHERE c45_coddoc = 215
                  AND c45_anousu = 2020
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
                WHERE c45_coddoc = 215
                  AND c45_anousu = 2020
                LIMIT 1), 
               9004,
               'SEGUNDO LANCAMENTO',
               0,
               FALSE,
               0,
               'SEGUNDO LANCAMENTO',
               2);
        
        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT min(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 214
                  AND c45_anousu = 2020
                  AND c46_ordem = 1
                LIMIT 1 ) AS c47_seqtranslan,
               0 AS c47_debito,
               (SELECT doc214_regra1_cta1 FROM ctas_docs_214_215) AS c47_credito,       
               '' c47_obs,
               0 c47_ref,
               2020 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 214
          AND c45_anousu = 2020
        LIMIT 1;

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT min(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 215
                  AND c45_anousu = 2020
                  AND c46_ordem = 1
                LIMIT 1 ) AS c47_seqtranslan,
               (SELECT doc214_regra1_cta1 FROM ctas_docs_214_215) AS c47_debito,
               0 AS c47_credito,       
               '' c47_obs,
               0 c47_ref,
               2020 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 215
          AND c45_anousu = 2020
        LIMIT 1;        

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT min(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 214
                  AND c45_anousu = 2020
                  AND c46_ordem = 2
                LIMIT 1 ) AS c47_seqtranslan,
               (SELECT doc214_regra2_cta1 FROM ctas_docs_214_215) AS c47_debito,
               (SELECT doc214_regra2_cta2 FROM ctas_docs_214_215) AS c47_credito,       
               '' c47_obs,
               0 c47_ref,
               2020 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 214
          AND c45_anousu = 2020
        LIMIT 1;

        INSERT INTO contranslr
        SELECT nextval('contranslr_c47_seqtranslr_seq'),
               (SELECT min(c46_seqtranslan) FROM contranslan
                JOIN contrans ON c46_seqtrans = c45_seqtrans
                WHERE c45_coddoc = 215
                  AND c45_anousu = 2020
                  AND c46_ordem = 2
                LIMIT 1 ) AS c47_seqtranslan,
               (SELECT doc214_regra2_cta2 FROM ctas_docs_214_215) AS c47_debito,
               (SELECT doc214_regra2_cta1 FROM ctas_docs_214_215) AS c47_credito,      
               '' c47_obs,
               0 c47_ref,
               2020 AS c47_anousu,
               c45_instit,
               0 c47_compara,
               0 c47_tiporesto
        FROM contrans
        JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1
        WHERE c45_coddoc = 215
          AND c45_anousu = 2020
        LIMIT 1;

        COMMIT;

SQL;
        $this->execute($sql);
    }

}