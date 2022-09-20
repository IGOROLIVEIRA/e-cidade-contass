<?php

use Phinx\Migration\AbstractMigration;

class Oc18302 extends AbstractMigration
{

    public function up()
    {
        $sql = "alter table atolegal add ed05_i_aparecerelatorio bool default false; ";
        $this->execute($sql);
    }
}
