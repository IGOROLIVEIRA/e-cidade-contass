<?php

use Phinx\Migration\AbstractMigration;

class Oc21527 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            alter table liclicita add column l20_horaaberturaprop varchar(8);
            alter table liclicita add column l20_horaencerramentoprop varchar(8);
        ";
        $this->execute($sql);
    }
}
