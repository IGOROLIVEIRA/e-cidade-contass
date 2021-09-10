<?php

use Phinx\Migration\AbstractMigration;

class Oc15211 extends AbstractMigration
{
    public function up()
    {
        $sql = "ALTER TABLE veicmanut ADD column ve62_itensempenho int;";
        $this->execute($sql);
    }
}
