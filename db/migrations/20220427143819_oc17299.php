<?php

use Phinx\Migration\AbstractMigration;

class Oc17299 extends AbstractMigration
{


    public function up()
    {
        $sql = "
            alter table protparam add column p90_protocolosigiloso bool null default false;";
        $this->execute($sql);
    }
}
