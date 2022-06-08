<?php

use Phinx\Migration\AbstractMigration;

class Oc17096 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            alter table protparam add column p90_novatelaprotocolo bool null default false;";
        $this->execute($sql);
    }
}
