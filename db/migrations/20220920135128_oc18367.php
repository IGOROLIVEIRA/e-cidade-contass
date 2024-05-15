<?php

use Phinx\Migration\AbstractMigration;

class Oc18367 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            alter table credenciamentosaldo add column l213_valorcontratado double precision;
        ";
        $this->execute($sql);
    }
}
