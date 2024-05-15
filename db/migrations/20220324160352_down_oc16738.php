<?php

use Phinx\Migration\AbstractMigration;

class DownOc16738 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            ALTER TABLE empempenho DROP COLUMN e60_vlrutilizado;
        ";

        $this->execute($sql);
    }
}
