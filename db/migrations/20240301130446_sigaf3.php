<?php

use Phinx\Migration\AbstractMigration;

class Sigaf3 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            alter table far_matersaude  column fa01_i_catmat int4;
        ";
        $this->execute($sql);
    }
}
