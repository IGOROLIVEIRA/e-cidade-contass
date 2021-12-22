<?php

use Phinx\Migration\AbstractMigration;

class Oc15701 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            BEGIN;
            ALTER TABLE licitaparam ADD COLUMN l12_validacadfornecedor BOOLEAN;
            UPDATE licitaparam set l12_validacadfornecedor = 'f';
            COMMIT;
        ";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        BEGIN;
        ALTER TABLE licitaparam DROP COLUMN l12_validacadfornecedor;
        COMMIT;
    ";
        $this->execute($sql);
    }
}
