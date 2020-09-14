<?php

use Phinx\Migration\AbstractMigration;

class Oc13038 extends AbstractMigration{
    public function up()
    {
		$sql = "
			ALTER TABLE pcparam ADD COLUMN pc30_emitedpsolicitante BOOLEAN DEFAULT FALSE,
								ADD COLUMN pc30_emitedpcompras BOOLEAN DEFAULT FALSE;
		";
		$this->execute($sql);
    }

    public function down(){
		$sql = "
			ALTER TABLE pcparam DROP COLUMN pc30_emitedpsolicitante,
								DROP COLUMN pc30_emitedpcompras;
		";
		$this->execute($sql);
	}
}
