<?php

use Phinx\Migration\AbstractMigration;

class Oc13101 extends AbstractMigration
{

    public function up()
    {
		$sql = 'update acordo set ac16_tipocadastro = 1 where ac16_tipocadastro is null;';
		$this->execute($sql);
    }
}
