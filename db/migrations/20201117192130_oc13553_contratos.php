<?php

use Phinx\Migration\AbstractMigration;

class Oc13553Contratos extends AbstractMigration
{
    public function up(){
		$sql = "
			ALTER TABLE sicom2021.contratos132021 ADD COLUMN si86_tipodocrepresentante bigint NOT NULL;
			ALTER TABLE sicom2021.contratos132021 RENAME COLUMN si86_cpfrepresentantelegal TO si86_nrodocrepresentantelegal;
			ALTER TABLE sicom2021.contratos132021 ALTER COLUMN si86_nrodocrepresentantelegal TYPE character varying(14);			
		";
		$this->execute($sql);
    }

    public function down(){
		$sql = "
			ALTER TABLE sicom2021.contratos132021 DROP COLUMN si86_tipodocrepresentante;
			ALTER TABLE sicom2021.contratos132021 RENAME COLUMN si86_nrodocrepresentantelegal TO si86_cpfrepresentantelegal;
			ALTER TABLE sicom2021.contratos132021 ALTER COLUMN si86_cpfrepresentantelegal TYPE character varying(11);
		";
		$this->execute($sql);
	}
}
