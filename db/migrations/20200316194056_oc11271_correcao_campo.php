<?php

use Phinx\Migration\AbstractMigration;

class Oc11271CorrecaoCampo extends AbstractMigration
{
    public function up()
    {
		$sql = "
				ALTER TABLE obrasdadoscomplementares ALTER COLUMN db150_segundolatitude TYPE numeric,
				ALTER COLUMN db150_segundolongitude TYPE numeric,
				ALTER COLUMN db150_bdi TYPE numeric;
				
				ALTER TABLE ralic122020 ALTER COLUMN si182_segundolatitude TYPE NUMERIC, 
										ALTER COLUMN si182_segundolongitude TYPE NUMERIC;
		";
		$this->execute($sql);
    }

    public function down(){
		$sql = "
				ALTER TABLE obrasdadoscomplementares ALTER COLUMN db150_segundolatitude TYPE float,
				ALTER COLUMN db150_segundolongitude TYPE float,
				ALTER COLUMN db150_bdi TYPE float;
				
				ALTER TABLE ralic122020 ALTER COLUMN si182_segundolatitude TYPE FLOAT, 
										ALTER COLUMN si182_segundolongitude TYPE FLOAT;
		";
		$this->execute($sql);
	}
}
