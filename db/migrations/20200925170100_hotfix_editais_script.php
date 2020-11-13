<?php

use Phinx\Migration\AbstractMigration;

class HotfixEditaisScript extends AbstractMigration
{

    public function up(){
		$sql = "
		
						CREATE TEMP TABLE alteraLicitacao( sequencial serial, licitacao integer NOT NULL);
						
						INSERT INTO alteraLicitacao(licitacao)
							(SELECT l47_liclicita
							 FROM liclancedital
							 JOIN liclicita ON l47_liclicita = l20_codigo
							 WHERE l20_cadinicial = 2
								 AND l47_dataenvio IS NOT NULL);
						
						CREATE OR REPLACE FUNCTION setLicitacao() RETURNS SETOF alteraLicitacao AS $$
							DECLARE
								r alteraLicitacao%rowtype;
							BEGIN
								FOR r IN SELECT * FROM alteraLicitacao
								LOOP
							
									UPDATE liclicita SET l20_cadinicial = 3 WHERE l20_codigo = r.licitacao;
							
									RETURN NEXT r;
							
								END LOOP;
								RETURN;
							END
						$$ LANGUAGE plpgsql;
						
						SELECT * FROM setLicitacao();
						
						DROP FUNCTION setLicitacao();
		";
		$this->execute($sql);
    }

    public function down(){

	}
}
