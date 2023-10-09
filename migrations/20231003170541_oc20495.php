<?php

use Phinx\Migration\AbstractMigration;

class Oc20495 extends AbstractMigration
{

    public function up()
    {
        $sql = " BEGIN;

        INSERT INTO solicitacaotipo VALUES (8,'Normal juntos');

        COMMIT;";

        $this->execute($sql);
    }
}
