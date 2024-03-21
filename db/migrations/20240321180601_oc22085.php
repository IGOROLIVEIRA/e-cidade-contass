<?php

use Phinx\Migration\AbstractMigration;

class Oc22085 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            alter table acocontroletermospncp add column l214_tipotermocontratoid int4;
        ";
        $this->execute($sql);
    }
}
