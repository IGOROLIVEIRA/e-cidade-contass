<?php

use Phinx\Migration\AbstractMigration;

class Oc13518 extends AbstractMigration
{
    public function up(){
		$sql = "
			insert into db_tipodoc(db08_codigo, db08_descr) 
				values ((select max(db08_codigo) from db_tipodoc)+1, 'ASSINATURA RESPONSÁVEL PELA COTAÇÃO');
			
			create temp table instituicoes(
			  sequencial SERIAL,
			  inst INT
			);

			insert into instituicoes(inst) (select codigo from db_config);

			CREATE OR REPLACE FUNCTION getAllCodigos() RETURNS SETOF instituicoes AS $$
			DECLARE
    			r instituicoes%rowtype;
			BEGIN
				FOR r IN SELECT * FROM instituicoes
				LOOP

					insert into db_documento(db03_docum, db03_descr, db03_tipodoc, db03_instit)
						values ((select max(db03_docum) from db_documento)+1,
					'ASSINATURA PADRÃO PREÇO REFERÊNCIA',
					 (select db08_codigo from db_tipodoc where db08_descr = 'ASSINATURA RESPONSÁVEL PELA COTAÇÃO'), r.inst);
	
	
					insert into db_paragrafo (db02_idparag, db02_descr, db02_texto, db02_alinha, db02_inicia, db02_espaca, db02_altura, db02_largura, db02_alinhamento, db02_tipo, db02_instit)
					values ((select max(db02_idparag) from db_paragrafo)+1, 'RESPONSÁVEL PELA COTAÇÃO', 'RESPONSÁVEL PELA COTAÇÃO', 20, 0, 1, 0, 0, 'C', 1, r.inst);
	
					RETURN NEXT r;

    			END LOOP;
    			RETURN;
			END
			$$
			LANGUAGE plpgsql;

			select * from getAllCodigos();
			 
			DROP FUNCTION getAllCodigos();

			insert into db_docparag(db04_docum, db04_idparag, db04_ordem)
				(SELECT db_documento.db03_docum, db_paragrafo.db02_idparag, 1 as ordem
					FROM db_documento,db_paragrafo
					WHERE db_documento.db03_instit = db_paragrafo.db02_instit
					AND db_documento.db03_descr LIKE 'ASSINATURA PADRÃO PREÇO REFERÊNCIA'
					AND db_paragrafo.db02_descr LIKE 'RESPONSÁVEL PELA COTAÇÃO');";

		$this->execute($sql);


    }

    public function down(){
		$sql = "
				DELETE FROM db_docparag
				WHERE db04_docum in
						(SELECT db03_docum
						 FROM db_documento
						 WHERE db_documento.db03_descr LIKE 'ASSINATURA PADRÃO PREÇO REFERÊNCIA')
						and db04_idparag in (select db02_idparag from db_paragrafo where db02_descr = 'RESPONSÁVEL PELA COTAÇÃO');
				
				
				DELETE FROM db_paragrafo
				WHERE db02_descr = 'RESPONSÁVEL PELA COTAÇÃO';
				
				
				DELETE FROM db_documento
				WHERE db03_tipodoc =
						(SELECT db08_codigo
						 FROM db_tipodoc
						 WHERE db08_descr = 'ASSINATURA RESPONSÁVEL PELA COTAÇÃO');
				
				
				DELETE FROM db_tipodoc
				WHERE db08_descr = 'ASSINATURA RESPONSÁVEL PELA COTAÇÃO';
		";
		$this->execute($sql);
	}
}
