<?php

use Phinx\Migration\AbstractMigration;

class Oc12849PreencheHistorico extends AbstractMigration
{
    public function up(){
		$sql = "
			CREATE TEMP TABLE preencheHistorico(
				sequencial SERIAL,
				numcgm INT,
				cadast date
			);


			INSERT INTO preencheHistorico(numcgm, cadast) (SELECT DISTINCT z01_numcgm, (case WHEN z01_cadast is null then '2019-12-31' else z01_cadast END) as z01_cadast FROM cgm);

			CREATE OR REPLACE FUNCTION preencheCgm() RETURNS SETOF preencheHistorico AS
			$$
			DECLARE
				r preencheHistorico%rowtype;
			BEGIN
				FOR r IN SELECT * FROM preencheHistorico
				LOOP
			
					INSERT INTO historicocgm(z09_sequencial, z09_numcgm, z09_datacadastro) (select DISTINCT (select nextval('historicocgm_z09_sequencial_seq')) as sequencial, r.numcgm, r.cadast);
			
					RETURN NEXT r;
			
				END LOOP;
				RETURN;
			END
			$$
			LANGUAGE plpgsql;
			
			select * from preencheCgm();
			DROP FUNCTION preencheCgm();
		";
		$this->execute($sql);
    }

    public function down(){

	}
}
