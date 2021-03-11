<?php

use Classes\PostgresMigration;

class Oc14085 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        INSERT INTO conhistdoc VALUES (74, 'CREDITOS EXTRAORDINÁRIOS - SUPERÁVIT FINANCEIRO', 50);

		INSERT INTO vinculoeventoscontabeis VALUES (nextval('vinculoeventoscontabeis_c115_sequencial_seq'), 74, null);

		CREATE TEMP TABLE instituicoes(
					sequencial SERIAL,
					inst INT
				);

		INSERT INTO instituicoes(inst) (SELECT codigo FROM db_config);

		SELECT * FROM instituicoes;

		CREATE OR REPLACE FUNCTION criaTransacaoPorInstituicao() RETURNS SETOF instituicoes AS
				$$
				DECLARE
					r instituicoes%rowtype;
				BEGIN
					FOR r IN SELECT * FROM instituicoes
					LOOP

					INSERT INTO contrans
						SELECT nextval('contabilidade.contrans_c45_seqtrans_seq'),
							2021,
							74,
							r.inst;

					INSERT INTO contranslan
						VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
							(SELECT c45_seqtrans FROM contrans
								WHERE c45_coddoc = 74
								AND c45_anousu = 2021
								AND c45_instit = r.inst
								LIMIT 1), 
							9007,
							'PRIMEIRO LANCAMENTO',
							0,
							TRUE,
							0,
							'PRIMEIRO LANCAMENTO',
							1);

					INSERT INTO contranslan
						VALUES (nextval('contabilidade.contranslan_c46_seqtranslan_seq'),
							(SELECT c45_seqtrans FROM contrans
								WHERE c45_coddoc = 74
								AND c45_anousu = 2021
								AND c45_instit = r.inst
								LIMIT 1), 
							9007,
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
							WHERE c45_coddoc = 74
								AND c45_anousu = 2021
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
							WHERE c60_estrut = '522120301000000'
								AND c60_anousu = 2021
								AND c61_instit = r.inst 
							LIMIT 1) AS c47_debito,
						(SELECT 
								CASE 
									WHEN c61_reduz IS NULL THEN 0 
									ELSE c61_reduz 
								END c61_reduz 
							FROM conplano
								JOIN conplanoreduz ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu AND c61_instit = r.inst
							WHERE c60_estrut = '622110000000000'
								AND c60_anousu = 2021
								AND c61_instit = r.inst 
							LIMIT 1) AS c47_credito,       
						'' c47_obs,
						0 c47_ref,
						2021 AS c47_anousu,
						c45_instit,
						0 c47_compara,
						0 c47_tiporesto
					FROM contrans
					JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 1 AND c45_instit = r.inst
					WHERE c45_coddoc = 74
						AND c45_anousu = 2021
					LIMIT 1;

					INSERT INTO contranslr
					SELECT nextval('contranslr_c47_seqtranslr_seq'),
						(SELECT min(c46_seqtranslan) FROM contranslan
							JOIN contrans ON c46_seqtrans = c45_seqtrans
							WHERE c45_coddoc = 74
								AND c45_anousu = 2021
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
							WHERE c60_estrut = '522130100000000'
								AND c60_anousu = 2021
								AND c61_instit = r.inst 
							LIMIT 1) AS c47_debito,
						(SELECT 
								CASE 
									WHEN c61_reduz IS NULL THEN 0 
									ELSE c61_reduz 
								END c61_reduz 
							FROM conplano
								JOIN conplanoreduz ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu AND c61_instit = r.inst
							WHERE c60_estrut = '522139900000000'
								AND c60_anousu = 2021
								AND c61_instit = r.inst 
							LIMIT 1) AS c47_credito,       
						'' c47_obs,
						0 c47_ref,
						2021 AS c47_anousu,
						c45_instit,
						0 c47_compara,
						0 c47_tiporesto
					FROM contrans
					JOIN contranslan ON c45_seqtrans = c46_seqtrans AND c46_ordem = 2 AND c45_instit = r.inst
					WHERE c45_coddoc = 74
						AND c45_anousu = 2021
					LIMIT 1;

					END LOOP;
					RETURN;
				
				END
				$$
				LANGUAGE plpgsql;

				SELECT * FROM criaTransacaoPorInstituicao();

				INSERT INTO orcsuplemtipo
					SELECT 2026 AS o48_tiposup,
							'CREDITO EXTRAORDINARIO - SUPERAVIT FINANCEIRO' AS o48_descr,
							74 AS o48_coddocsup,
							0 AS o48_coddocred,
							0 AS o48_arrecadmaior,
							't' AS o48_superavit,
							74 AS o48_suplcreditoespecial,
                    0 AS o48_redcreditoespecial;
                
        COMMIT;

SQL;
    $this->execute($sql);
  }

}