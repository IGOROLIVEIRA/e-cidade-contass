<?php

use Phinx\Migration\AbstractMigration;

class Sigaf4 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            alter table unidades add column sd02_i_tipounidade int4;
        ";
        $this->execute($sql);
    }
}
