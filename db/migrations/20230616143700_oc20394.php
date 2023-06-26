<?php

use Phinx\Migration\AbstractMigration;

class Oc20394 extends AbstractMigration
{

    public function up()
    {
        $sSql = "
        BEGIN;
        UPDATE db_syscampo SET nulo = 'false' WHERE nomecam = 'pc60_dtreg';
        COMMIT;
        ";

        $this->execute($sSql);
    }
}
