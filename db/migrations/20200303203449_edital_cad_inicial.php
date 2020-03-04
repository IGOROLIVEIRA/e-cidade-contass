<?php

use Phinx\Migration\AbstractMigration;

class EditalCadInicial extends AbstractMigration
{
    public function up()
    {
		$sql = <<<SQL
				create temp table insereCadInicial(
				  sequencial SERIAL,
				  codigo INT
				);
				
				insert into insereCadInicial(codigo) (select l20_codigo from liclicita where l20_anousu >= 2020 and l20_cadinicial is null);
				
				CREATE OR REPLACE FUNCTION getAllCodigos() RETURNS SETOF insereCadInicial AS
				$$
				DECLARE
					r insereCadInicial%rowtype;
				BEGIN
					FOR r IN SELECT * FROM insereCadInicial
					LOOP
				
						UPDATE liclicita set l20_cadinicial = 1, l20_exercicioedital = 2020 where l20_codigo = r.codigo;
				
						RETURN NEXT r;
				
					END LOOP;
					RETURN;
				END
				$$
				LANGUAGE plpgsql;
				
				select * from getAllCodigos();
				DROP FUNCTION getAllCodigos();
		
SQL;
		$this->execute($sql);
    }

    public function down(){

	}
}
