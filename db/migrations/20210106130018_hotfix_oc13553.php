<?php

use Phinx\Migration\AbstractMigration;

class HotfixOc13553 extends AbstractMigration
{
    public function up(){
        $sql = "
                ALTER TABLE contratos102021 RENAME COLUMN si83_unidadedemedidaprazoexex TO si83_unidadedemedidaprazoexec;
        ";
        $this->execute($sql);
    }

    public function down(){
        $sql = "
                ALTER TABLE contratos102021 RENAME COLUMN si83_unidadedemedidaprazoexec TO si83_unidadedemedidaprazoexex;
        ";
        $this->execute($sql);
    }
}
