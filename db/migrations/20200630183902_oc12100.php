<?php

use Phinx\Migration\AbstractMigration;

class Oc12100 extends AbstractMigration
{
    public function up()
    {
		$sql = "
			update db_syscampo set rotulo = 'Cód. Acordo', rotulorel = 'Cód. Acordo' where nomecam = 'ac16_sequencial';
		";
		$this->execute($sql);
    }

    public function down(){
    	$sql = "
    		update db_syscampo set rotulo = 'Código Acordo', rotulorel = 'Código Acordo' where nomecam = 'ac16_sequencial';
    	";
    	$this->execute($sql);
	}
}
