<?php

use Phinx\Migration\AbstractMigration;

class Oc21527 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            alter table liclicita add column l20_horaaberturaprop varchar(8);
            alter table liclicita add column l20_horaencerramentoprop varchar(8);

            update liclicita set l20_horaaberturaprop='08:00';
            update liclicita set l20_horaencerramentoprop='08:30';

            ";
        $this->execute($sql);
    }
}
