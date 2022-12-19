<?php

use Phinx\Migration\AbstractMigration;

class Oc19180 extends AbstractMigration
{
    
    public function up()
    {
        $sql = "BEGIN;

        INSERT INTO db_viradacaditem (c33_sequencial,c33_descricao) VALUES (35,'AJUSTES DE NUMERAÇÃO - PATRIMONIAL');

        COMMIT;
        ";

        $this->execute($sql);
    }
}
