<?php

use Phinx\Migration\AbstractMigration;

class Oc19135 extends AbstractMigration
{
    public function up()
    {
        $sql = "select fc_startsession();
                begin;
                alter table flpgo102023 drop column si195_dscnatcargo;
                commit;"
                ;

        $this->execute($sql);
    }
}
