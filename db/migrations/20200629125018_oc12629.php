<?php

use Classes\PostgresMigration;

class Oc12629 extends PostgresMigration
{

  public function up()
  {
    $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        --  Cria os documentos 164 e 165, que serão utilizados para reconhecimento de perdas.
        
        INSERT INTO conhistdoctipo VALUES (164, 'RECONHECIMENTO DE PERDAS');
        INSERT INTO conhistdoctipo VALUES (165, 'RECONHECIMENTO DE PERDAS - ESTORNO');

        -- Inserindo o documento para cadastros das regras a seguir.
        INSERT INTO conhistdoc VALUES
        (164, 'RECONHECIMENTO DE PERDAS', 164),
        (165, 'RECONHECIMENTO DE PERDAS - ESTORNO', 165);

        INSERT INTO vinculoeventoscontabeis VALUES
        (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 164, 165);

        INSERT INTO conhistdocregra VALUES
        (nextval('conhistdocregra_c92_sequencial_seq'),
         164,
         'RECONHECIMENTO DE PERDAS',
         'SELECT 1 FROM conhistdoc WHERE c53_coddoc = 164',
         2020),
        (nextval('conhistdocregra_c92_sequencial_seq'),
         165,
         'RECONHECIMENTO DE PERDAS - ESTORNO',
         'SELECT 1 FROM conhistdoc WHERE c53_coddoc = 165',
         2020);

        -- Criando as transações, regras e vinculando as contas para os novos documentos 164 e 165
        
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

              INSERT INTO contrans
                SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
                      2020,
                      164,
                      r.inst;

                INSERT INTO contrans
                SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
                    2020,
                    165,
                    r.inst;

                    INSERT INTO contranslan
                      VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                            (SELECT c45_seqtrans FROM contrans
                              WHERE c45_coddoc = 164
                                AND c45_anousu = 2020
                                AND c45_instit = r.inst
                              LIMIT 1), 
                            9030,
                            'PRIMEIRO LANCAMENTO',
                            0,
                            FALSE,
                            0,
                            'PRIMEIRO LANCAMENTO',
                            1);

                      INSERT INTO contranslan
                      VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                            (SELECT c45_seqtrans FROM contrans
                              WHERE c45_coddoc = 164
                                AND c45_anousu = 2020
                                AND c45_instit = r.inst
                              LIMIT 1), 
                            9030,
                            'SEGUNDO LANCAMENTO',
                            0,
                            FALSE,
                            0,
                            'SEGUNDO LANCAMENTO',
                            2);

                      INSERT INTO contranslan
                      VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                            (SELECT c45_seqtrans FROM contrans
                              WHERE c45_coddoc = 165
                                AND c45_anousu = 2020
                                AND c45_instit = r.inst
                              LIMIT 1), 
                            9006,
                            'PRIMEIRO LANCAMENTO',
                            0,
                            FALSE,
                            0,
                            'PRIMEIRO LANCAMENTO',
                            1);

                      INSERT INTO contranslan
                      VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                            (SELECT c45_seqtrans FROM contrans
                              WHERE c45_coddoc = 165
                                AND c45_anousu = 2020
                                AND c45_instit = r.inst
                              LIMIT 1), 
                            9006,
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
                        WHERE c45_coddoc = 164
                          AND c45_anousu = 2020
                          AND c46_ordem = 1
                          AND c45_instit = r.inst
                        LIMIT 1 ) AS c47_seqtranslan,
                      (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                        JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                        WHERE (c60_estrut, c60_anousu, c61_instit) = ('362110300000000', 2020, r.inst) LIMIT 1) AS c47_debito,
                      0 AS c47_credito,       
                      '' c47_obs,
                      0 c47_ref,
                      2020 AS c47_anousu,
                      c45_instit,
                      0 c47_compara,
                      0 c47_tiporesto
                FROM contrans
                JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1 AND c45_instit = r.inst
                WHERE c45_coddoc = 164
                  AND c45_anousu = 2020
                LIMIT 1;

                INSERT INTO contranslr
                  SELECT nextval('contranslr_c47_seqtranslr_seq'),
                        (SELECT min(c46_seqtranslan) FROM contranslan
                          JOIN contrans ON c46_seqtrans = c45_seqtrans
                          WHERE c45_coddoc = 164
                            AND c45_anousu = 2020
                            AND c46_ordem = 2
                            AND c45_instit = r.inst
                          LIMIT 1 ) AS c47_seqtranslan,
                        (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                          JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                          WHERE (c60_estrut, c60_anousu, c61_instit) = ('821110100000000', 2020, r.inst) LIMIT 1) AS c47_debito,       
                        (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                          JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                          WHERE (c60_estrut, c60_anousu, c61_instit) = ('821140000000000', 2020, r.inst) LIMIT 1) AS c47_credito,       
                        '' c47_obs,
                        0 c47_ref,
                        2020 AS c47_anousu,
                        c45_instit,
                        0 c47_compara,
                        0 c47_tiporesto
                  FROM contrans
                  JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 2 AND c45_instit = r.inst
                  WHERE c45_coddoc = 164
                    AND c45_anousu = 2020
                  LIMIT 1;  

                  INSERT INTO contranslr
                    SELECT nextval('contranslr_c47_seqtranslr_seq'),
                          (SELECT min(c46_seqtranslan) FROM contranslan
                            JOIN contrans ON c46_seqtrans = c45_seqtrans
                            WHERE c45_coddoc = 165
                              AND c45_anousu = 2020
                              AND c46_ordem = 1
                              AND c45_instit = r.inst
                            LIMIT 1 ) AS c47_seqtranslan,
                          0 AS c47_debito,
                          (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                            JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                            WHERE (c60_estrut, c60_anousu, c61_instit) = ('362110300000000', 2020, r.inst) LIMIT 1) AS c47_credito,       
                          '' c47_obs,
                          0 c47_ref,
                          2020 AS c47_anousu,
                          c45_instit,
                          0 c47_compara,
                          0 c47_tiporesto
                    FROM contrans
                    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1 AND c45_instit = r.inst
                    WHERE c45_coddoc = 165
                      AND c45_anousu = 2020
                    LIMIT 1;   

                    INSERT INTO contranslr
                    SELECT nextval('contranslr_c47_seqtranslr_seq'),
                          (SELECT min(c46_seqtranslan) FROM contranslan
                            JOIN contrans ON c46_seqtrans = c45_seqtrans
                            WHERE c45_coddoc = 165
                              AND c45_anousu = 2020
                              AND c46_ordem = 2
                              AND c45_instit = r.inst
                            LIMIT 1 ) AS c47_seqtranslan,
                          (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                            JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                            WHERE (c60_estrut, c60_anousu, c61_instit) = ('821140000000000', 2020, r.inst) LIMIT 1) AS c47_debito,
                          (SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                            JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                            WHERE (c60_estrut, c60_anousu, c61_instit) = ('821110100000000', 2020, r.inst) LIMIT 1) AS c47_credito,      
                          '' c47_obs,
                          0 c47_ref,
                          2020 AS c47_anousu,
                          c45_instit,
                          0 c47_compara,
                          0 c47_tiporesto
                    FROM contrans
                    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 2 AND c45_instit = r.inst
                    WHERE c45_coddoc = 165
                      AND c45_anousu = 2020
                    LIMIT 1;   

                RETURN NEXT r;

            END LOOP;
            RETURN;
        
        END
        $$
        LANGUAGE plpgsql;

        SELECT * FROM getAllCodigos();
 
        DROP FUNCTION getAllCodigos();

        --Cria itens do menu
        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),'Reconhecimento de Perdas', 'Reconhecimento de Perdas','',1,1,'Reconhecimento de Perdas','t');

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Operação Financeira Extra Orçamentária' LIMIT 1), (SELECT MAX(id_item) FROM db_itensmenu),  (SELECT MAX(menusequencia)+1 FROM db_menu JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho WHERE db_menu.id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Operação Financeira Extra Orçamentária' LIMIT 1)), (SELECT modulo FROM db_menu JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho WHERE db_menu.id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Operação Financeira Extra Orçamentária' LIMIT 1) LIMIT 1));

        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),'Inclusão', 'Inclusão','cai4_reconhecimentodeperdas001.php',1,1,'Inclusão','t');

        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),'Estorno', 'Estorno','cai4_reconhecimentodeperdas002.php',1,1,'Estorno','t');

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Reconhecimento de Perdas' LIMIT 1), (SELECT MAX(id_item)-1 FROM db_itensmenu), 1, (SELECT modulo FROM db_menu JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho WHERE db_menu.id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Operação Financeira Extra Orçamentária' LIMIT 1) LIMIT 1));

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Reconhecimento de Perdas' LIMIT 1), (SELECT MAX(id_item) FROM db_itensmenu), 2, (SELECT modulo FROM db_menu JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho WHERE db_menu.id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Operação Financeira Extra Orçamentária' LIMIT 1) LIMIT 1));

        -- Cria tipo operação slip
        INSERT INTO sliptipooperacao VALUES ((SELECT MAX(k152_sequencial)+1 FROM sliptipooperacao), 'RECONHECIMENTO DE PERDAS');
          
        INSERT INTO sliptipooperacao VALUES ((SELECT MAX(k152_sequencial)+1 FROM sliptipooperacao), 'RECONHECIMENTO DE PERDAS - ESTORNO');

        COMMIT;

SQL;

    $this->execute($sql);

  }

}