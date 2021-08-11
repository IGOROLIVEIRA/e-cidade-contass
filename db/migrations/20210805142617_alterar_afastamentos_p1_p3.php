<?php

use Phinx\Migration\AbstractMigration;

class AlterarAfastamentosP1P3 extends AbstractMigration
{

    public function up()
    {
        $sql = "UPDATE afasta SET r45_codret = 'Z5' WHERE r45_codafa IN ('P1','P3') AND r45_codret = 'Z3' AND r45_dtafas >= '2021-06-01';";
        $this->execute($sql);
    }

    public function down() {

    }
}
