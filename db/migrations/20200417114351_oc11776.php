<?php

use Phinx\Migration\AbstractMigration;

class Oc11776 extends AbstractMigration
{
    public function up()
    {
    	$sql = <<<SQL
							BEGIN;
			
			SELECT fc_startsession();
			
			CREATE TEMP TABLE codigo_config( sequencial SERIAL, codigo integer, documento integer);
			
			
			INSERT INTO db_tipodoc(db08_codigo, db08_descr)
			VALUES (
						(SELECT max(db08_codigo)
						 FROM db_tipodoc)+1,
					'TEXTO PADRAO RELATORIO DE TRANSFERENCIA');
			
			
			INSERT INTO codigo_config(codigo)
				(SELECT codigo
				 FROM db_config);
			
			
			UPDATE codigo_config
			SET documento =
				(SELECT db08_codigo
				 FROM db_tipodoc
				 WHERE db08_descr = 'TEXTO PADRAO RELATORIO DE TRANSFERENCIA');
			
			
			CREATE OR REPLACE FUNCTION setAllCodigos() RETURNS
			SETOF codigo_config AS $$
			DECLARE
				r codigo_config%rowtype;
			BEGIN
				FOR r IN SELECT * FROM codigo_config
				LOOP
			
					insert into db_documentopadrao(db60_coddoc, db60_descr, db60_tipodoc, db60_instit) values ((select max(db60_coddoc) from db_documentopadrao)+1,
					'TEXTO PADRAO RELATORIO DE TRANSFERENCIA', r.documento, r.codigo);
			
					-- Cria Parágrafo para o Documento
			
					insert into db_paragrafopadrao (db61_codparag, db61_descr, db61_texto, db61_alinha, db61_inicia, db61_espaco, db61_alinhamento, db61_altura, db61_largura, db61_tipo)
					values ((select max(db61_codparag) from db_paragrafopadrao)+1, 'TEXTO PADRÃO RELATÓRIO DE TRANSFERÊNCIA', 'Assumo total responsabilidade pelos bens patrimoniais relacionados neste documento. Comprometo-me a informar de imediato à Seção de Patrimônio quaisquer alterações e/ou irregularidades ocorridas, bem como zelar pela guarda e o bom uso do patrimônio público.', 0, 20, 1, 'J', 84, 403, r.codigo);
			
					insert into db_docparagpadrao(db62_coddoc, db62_codparag, db62_ordem) values ((select max(db60_coddoc) from db_documentopadrao), (select max(db61_codparag) from db_paragrafopadrao), 1);
			
					RETURN NEXT r;
			
				END LOOP;
				RETURN;
			END
			$$ LANGUAGE plpgsql;
			
			
			SELECT *
			FROM setAllCodigos();
			
			DROP FUNCTION setAllCodigos();

			COMMIT;

SQL;
//    	$this->execute($sql);
    }

    public function down(){

	}
}
