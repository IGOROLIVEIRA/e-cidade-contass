<?php

use Phinx\Migration\AbstractMigration;

class Oc20254 extends AbstractMigration
{
    public function up()
    {
        $sql = "BEGIN;
            ALTER TABLE pessoal.rhvinculodotpatronais
            ADD COLUMN rh171_codtab int4 NOT NULL DEFAULT 1;
            COMMIT;
        ";
    
        $this->execute($sql);
    }
}
