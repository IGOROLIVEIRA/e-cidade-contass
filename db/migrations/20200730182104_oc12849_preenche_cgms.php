<?php

use Phinx\Migration\AbstractMigration;

class Oc12849PreencheCgms extends AbstractMigration
{
    public function up(){
		$sql = "
			UPDATE cgm SET z01_cadast = '2019-12-31' WHERE z01_cadast IS NULL;
		";
		$this->execute($sql);
    }

    public function down(){

	}
}
