<?php

use Phinx\Migration\AbstractMigration;

class Oc17746 extends AbstractMigration
{

    public function up()
    {
        $sql = "ALTER TABLE acordo ADD ac16_datareferencia date null;
                ALTER TABLE apostilamento ADD si03_datareferencia date null;
                ALTER TABLE acordoposicaoaditamento ADD ac35_datareferencia date null;
                ALTER TABLE acordomovimentacao ADD ac10_datareferencia date null;";
        $this->execute($sql);
    }
}
