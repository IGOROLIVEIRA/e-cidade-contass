<?php

use Phinx\Migration\AbstractMigration;

class Oc12770 extends AbstractMigration
{
    public function change(){
		$sql = "ALTER TABLE liclancedital ADD COLUMN l47_dataenviosicom DATE DEFAULT NULL;";
		$this->execute($sql);
	}

    public function down(){
		$sql = "ALTER TABLE liclancedital DROP COLUMN l47_dataenviosicom";
		$this->execute($sql);
	}
}
