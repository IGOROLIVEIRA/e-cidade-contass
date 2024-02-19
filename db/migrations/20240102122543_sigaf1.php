<?php

use Phinx\Migration\AbstractMigration;

class Sigaf1 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            alter table far_parametros add column fa02_i_integracaosigaf bool;
        ";
        $this->execute($sql);
    }
}
