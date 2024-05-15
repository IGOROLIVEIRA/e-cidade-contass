<?php

use Phinx\Migration\AbstractMigration;

class Oc18673 extends AbstractMigration
{
    public function up()
    {
        $sql=" BEGIN;
        INSERT INTO retencaotipocalc VALUES(8,'SEST');
        INSERT INTO retencaotipocalc VALUES(9,'SENAT');
        COMMIT;
        ";
        $this->execute($sql);
    }
}
