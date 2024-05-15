<?php

use Phinx\Migration\AbstractMigration;

class Addcamporeceita extends AbstractMigration
{

    public function up()
    {
        $sql = "alter table liclicita add column l20_receita bool;";
        $this->execute($sql);
    }
}
