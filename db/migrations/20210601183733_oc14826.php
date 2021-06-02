<?php

use Classes\PostgresMigration;

class Oc14826 extends PostgresMigration
{

  public function up()
  {
    $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        --  Cria os documentos 166 e 167, que ser�o utilizados para reconhecimento de perdas.
        
        INSERT INTO conhistdoctipo VALUES (166, 'RECONHECIMENTO DE GANHOS RPPS');
        INSERT INTO conhistdoctipo VALUES (167, 'RECONHECIMENTO DE GANHOS RPPS - ESTORNO');

        -- Inserindo o documento para cadastros das regras a seguir.
        INSERT INTO conhistdoc VALUES
        (166, 'RECONHECIMENTO DE GANHOS RPPS', 166),
        (167, 'RECONHECIMENTO DE GANHOS RPPS - ESTORNO', 167);

        INSERT INTO vinculoeventoscontabeis VALUES
        (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 166, 167);

        INSERT INTO conhistdocregra VALUES
        (nextval('conhistdocregra_c92_sequencial_seq'),
         166,
         'RECONHECIMENTO DE GANHOS RPPS',
         'SELECT 1 FROM conhistdoc WHERE c53_coddoc = 166',
         2021),
        (nextval('conhistdocregra_c92_sequencial_seq'),
         167,
         'RECONHECIMENTO DE GANHOS RPPS - ESTORNO',
         'SELECT 1 FROM conhistdoc WHERE c53_coddoc = 167',
         2021);

        -- Criando as transa��es, regras e vinculando as contas para os novos documentos 166 e 167
        
        --Cria fun��o tempor�ria para buscar institui��es
        
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
                      2021,
                      166,
                      r.inst;

                INSERT INTO contrans
                SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
                    2021,
                    167,
                    r.inst;

                    INSERT INTO contranslan
                      VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                            (SELECT c45_seqtrans FROM contrans
                              WHERE c45_coddoc = 166
                                AND c45_anousu = 2021
                                AND c45_instit = r.inst
                              LIMIT 1), 
                            9500,
                            'PRIMEIRO LANCAMENTO',
                            0,
                            FALSE,
                            0,
                            'PRIMEIRO LANCAMENTO',
                            1);

                      INSERT INTO contranslan
                      VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                            (SELECT c45_seqtrans FROM contrans
                              WHERE c45_coddoc = 166
                                AND c45_anousu = 2021
                                AND c45_instit = r.inst
                              LIMIT 1), 
                            9500,
                            'SEGUNDO LANCAMENTO',
                            0,
                            FALSE,
                            0,
                            'SEGUNDO LANCAMENTO',
                            2);

                      INSERT INTO contranslan
                      VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                            (SELECT c45_seqtrans FROM contrans
                              WHERE c45_coddoc = 167
                                AND c45_anousu = 2021
                                AND c45_instit = r.inst
                              LIMIT 1), 
                            9009,
                            'PRIMEIRO LANCAMENTO',
                            0,
                            FALSE,
                            0,
                            'PRIMEIRO LANCAMENTO',
                            1);

                      INSERT INTO contranslan
                      VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
                            (SELECT c45_seqtrans FROM contrans
                              WHERE c45_coddoc = 167
                                AND c45_anousu = 2021
                                AND c45_instit = r.inst
                              LIMIT 1), 
                            9009,
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
                        WHERE c45_coddoc = 166
                          AND c45_anousu = 2021
                          AND c46_ordem = 1
                          AND c45_instit = r.inst
                        LIMIT 1 ) AS c47_seqtranslan,
                      0 AS c47_debito,
                      (SELECT COALESCE((SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                        JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                        WHERE (c60_estrut, c60_anousu, c61_instit) = ('461910000000000', 2021, r.inst) LIMIT 1),0)) AS c47_credito,       
                      '' c47_obs,
                      0 c47_ref,
                      2021 AS c47_anousu,
                      c45_instit,
                      0 c47_compara,
                      0 c47_tiporesto
                FROM contrans
                JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1 AND c45_instit = r.inst
                WHERE c45_coddoc = 166
                  AND c45_anousu = 2021
                LIMIT 1;

                INSERT INTO contranslr
                  SELECT nextval('contranslr_c47_seqtranslr_seq'),
                        (SELECT min(c46_seqtranslan) FROM contranslan
                          JOIN contrans ON c46_seqtrans = c45_seqtrans
                          WHERE c45_coddoc = 166
                            AND c45_anousu = 2021
                            AND c46_ordem = 2
                            AND c45_instit = r.inst
                          LIMIT 1 ) AS c47_seqtranslan,
                        (SELECT COALESCE((SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                          JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                          WHERE (c60_estrut, c60_anousu, c61_instit) = ('721110000000000', 2021, r.inst) LIMIT 1),0)) AS c47_debito,       
                        (SELECT COALESCE((SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                          JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                          WHERE (c60_estrut, c60_anousu, c61_instit) = ('821110100000000', 2021, r.inst) LIMIT 1),0)) AS c47_credito,       
                        '' c47_obs,
                        0 c47_ref,
                        2021 AS c47_anousu,
                        c45_instit,
                        0 c47_compara,
                        0 c47_tiporesto
                  FROM contrans
                  JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 2 AND c45_instit = r.inst
                  WHERE c45_coddoc = 166
                    AND c45_anousu = 2021
                  LIMIT 1;  

                  INSERT INTO contranslr
                    SELECT nextval('contranslr_c47_seqtranslr_seq'),
                          (SELECT min(c46_seqtranslan) FROM contranslan
                            JOIN contrans ON c46_seqtrans = c45_seqtrans
                            WHERE c45_coddoc = 167
                              AND c45_anousu = 2021
                              AND c46_ordem = 1
                              AND c45_instit = r.inst
                            LIMIT 1 ) AS c47_seqtranslan,
                          (SELECT COALESCE((SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                            JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                            WHERE (c60_estrut, c60_anousu, c61_instit) = ('461910000000000', 2021, r.inst) LIMIT 1),0)) AS c47_debito,       
                          0 AS c47_credito,
                          '' c47_obs,
                          0 c47_ref,
                          2021 AS c47_anousu,
                          c45_instit,
                          0 c47_compara,
                          0 c47_tiporesto
                    FROM contrans
                    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1 AND c45_instit = r.inst
                    WHERE c45_coddoc = 167
                      AND c45_anousu = 2021
                    LIMIT 1;   

                    INSERT INTO contranslr
                    SELECT nextval('contranslr_c47_seqtranslr_seq'),
                          (SELECT min(c46_seqtranslan) FROM contranslan
                            JOIN contrans ON c46_seqtrans = c45_seqtrans
                            WHERE c45_coddoc = 167
                              AND c45_anousu = 2021
                              AND c46_ordem = 2
                              AND c45_instit = r.inst
                            LIMIT 1 ) AS c47_seqtranslan,
                          (SELECT COALESCE((SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                            JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                            WHERE (c60_estrut, c60_anousu, c61_instit) = ('821110100000000', 2021, r.inst) LIMIT 1),0)) AS c47_debito,
                          (SELECT COALESCE((SELECT CASE WHEN c61_reduz IS NULL THEN 0 ELSE c61_reduz END c61_reduz FROM conplano
                            JOIN conplanoreduz ON (c61_codcon, c61_anousu, c61_instit) = (c60_codcon, c60_anousu, r.inst)
                            WHERE (c60_estrut, c60_anousu, c61_instit) = ('721110000000000', 2021, r.inst) LIMIT 1),0)) AS c47_credito,      
                          '' c47_obs,
                          0 c47_ref,
                          2021 AS c47_anousu,
                          c45_instit,
                          0 c47_compara,
                          0 c47_tiporesto
                    FROM contrans
                    JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 2 AND c45_instit = r.inst
                    WHERE c45_coddoc = 167
                      AND c45_anousu = 2021
                    LIMIT 1;   

                RETURN NEXT r;

            END LOOP;
            RETURN;
        
        END
        $$
        LANGUAGE plpgsql;

        SELECT * FROM getAllCodigos();
 
        DROP FUNCTION getAllCodigos();

        select * from contrans where c45_coddoc in (166,167) and c45_instit = 1;

        select * from contranslan where c46_seqtrans in (select c45_seqtrans from contrans where c45_coddoc in (166,167) and c45_instit = 1) order by c46_seqtranslan;


		SELECT contranslr.*, ccred.c60_estrut as estcred, cdeb.c60_estrut as estdeb
		FROM contranslr
		left join conplanoreduz rcred on c47_credito = rcred.c61_reduz and c47_anousu = rcred.c61_anousu
		left join conplano ccred on rcred.c61_codcon = ccred.c60_codcon and rcred.c61_anousu = ccred.c60_anousu
		left join conplanoreduz rdeb on c47_debito = rdeb.c61_reduz and c47_anousu = rdeb.c61_anousu
		left join conplano cdeb on rdeb.c61_codcon = cdeb.c60_codcon and rdeb.c61_anousu = cdeb.c60_anousu
		WHERE c47_seqtranslan IN
		        (SELECT c46_seqtranslan
		         FROM contranslan
		         WHERE c46_seqtrans IN
		                 (SELECT c45_seqtrans
		                  FROM contrans
		                  WHERE c45_coddoc IN (166,
		                                       167)
		                      AND c45_instit = 1));

		-- --Cria itens do menu
        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),'Reconhecimento de Ganhos RPPS', 'Reconhecimento de Ganhos RPPS','',1,1,'Reconhecimento de Ganhos RPPS','t');

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Opera��o Financeira Extra Or�ament�ria' LIMIT 1), (SELECT MAX(id_item) FROM db_itensmenu),  (SELECT MAX(menusequencia)+1 FROM db_menu JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho WHERE db_menu.id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Opera��o Financeira Extra Or�ament�ria' LIMIT 1)), (SELECT modulo FROM db_menu JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho WHERE db_menu.id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Opera��o Financeira Extra Or�ament�ria' LIMIT 1) LIMIT 1));

        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),'Inclus�o', 'Inclus�o','cai4_reconhecimentodeganhosrpps001.php',1,1,'Inclus�o','t');

        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),'Estorno', 'Estorno','cai4_reconhecimentodeganhosrpps002.php',1,1,'Estorno','t');

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Reconhecimento de Ganhos RPPS' LIMIT 1), (SELECT MAX(id_item)-1 FROM db_itensmenu), 1, (SELECT modulo FROM db_menu JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho WHERE db_menu.id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Opera��o Financeira Extra Or�ament�ria' LIMIT 1) LIMIT 1));

        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Reconhecimento de Ganhos RPPS' LIMIT 1), (SELECT MAX(id_item) FROM db_itensmenu), 2, (SELECT modulo FROM db_menu JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho WHERE db_menu.id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Opera��o Financeira Extra Or�ament�ria' LIMIT 1) LIMIT 1));

        -- -- Cria tipo opera��o slip
        INSERT INTO sliptipooperacao VALUES ((SELECT MAX(k152_sequencial)+1 FROM sliptipooperacao), 'RECONHECIMENTO DE GANHOS RPPS');
          
        INSERT INTO sliptipooperacao VALUES ((SELECT MAX(k152_sequencial)+1 FROM sliptipooperacao), 'RECONHECIMENTO DE GANHOS RPPS - ESTORNO');

        --Atualiza menu do reconhecimento de perdas
        UPDATE db_itensmenu SET descricao = 'Reconhecimento de Perdas RPPS', help = 'Reconhecimento de Perdas RPPS', desctec = 'Reconhecimento de Perdas RPPS' WHERE descricao = 'Reconhecimento de Perdas';

        UPDATE conhistdoctipo SET c57_descricao = 'RECONHECIMENTO DE PERDAS RPPS' WHERE c57_sequencial = 164;
		UPDATE conhistdoctipo SET c57_descricao = 'RECONHECIMENTO DE PERDAS RPPS - ESTORNO' WHERE c57_sequencial = 165;

		UPDATE conhistdoc SET c53_descr = 'RECONHECIMENTO DE PERDAS RPPS' WHERE c53_coddoc = 164;
		UPDATE conhistdoc SET c53_descr = 'RECONHECIMENTO DE PERDAS RPPS - ESTORNO' WHERE c53_coddoc = 165;

        COMMIT;

SQL;

    $this->execute($sql);

  }

}