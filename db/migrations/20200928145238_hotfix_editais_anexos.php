<?php

use Phinx\Migration\AbstractMigration;

class HotfixEditaisAnexos extends AbstractMigration
{
    public function up(){
		$sql = "
		
				ALTER TABLE editaldocumentos ADD COLUMN l48_arquivo oid;
		
				CREATE TEMP TABLE arquivosedital(
					sequencial SERIAL,
					sequenciadocumento bigint,
					caminhoarquivo varchar(150)
				);
				
				insert into arquivosedital(sequenciadocumento, caminhoarquivo)  
					(SELECT DISTINCT l48_sequencial, l48_caminho
						FROM editaldocumentos
							WHERE l48_arquivo IS NULL AND l48_caminho IS NOT NULL);
				
				CREATE OR REPLACE FUNCTION setArquivo() RETURNS
				SETOF arquivosedital AS $$
				DECLARE
					r arquivosedital%rowtype;
				BEGIN
					FOR r IN SELECT * FROM arquivosedital
					LOOP
				
						UPDATE editaldocumentos SET l48_arquivo = (lo_import('/var/www/e-cidade/'||r.caminhoarquivo)) WHERE l48_sequencial = r.sequenciadocumento;
				
						RETURN NEXT r;
				
					END LOOP;
					RETURN;
				END
				$$ LANGUAGE plpgsql;
				
				SELECT *
				FROM setArquivo();

				ALTER TABLE editaldocumentos DROP COLUMN l48_caminho;
				
				ALTER TABLE ralic112020 ALTER COLUMN si181_codbempublico DROP NOT NULL;

				DROP FUNCTION setArquivo();
		";

		$this->execute($sql);
    }

    public function down(){
		$sql = " ALTER TABLE editaldocumentos ADD COLUMN l48_caminho varchar(150); ";
		$this->execute($sql);
	}
}
