<?php

use Phinx\Migration\AbstractMigration;

class Oc14432 extends AbstractMigration
{
    public function up(){
        $sql = "
            ALTER TABLE ralic102021 ADD COLUMN si180_qtdlotes integer DEFAULT NULL;
        ";
        $this->execute($sql);
    }

    public function down(){
        $sql = "
            ALTER TABLE ralic102021 DROP COLUMN si180_qtdlotes;
        ";
        $this->execute($sql);
    }
}
