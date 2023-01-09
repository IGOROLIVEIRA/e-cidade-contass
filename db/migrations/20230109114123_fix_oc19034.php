<?php

use Phinx\Migration\AbstractMigration;

class FixOc19034 extends AbstractMigration
{
    public function up()
    {
        $sql = "BEGIN;

        UPDATE licitaparam set l12_numeracaomanual = true;
                
        COMMIT;";

        $this->execute($sql);
    }
}
