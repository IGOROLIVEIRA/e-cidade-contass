<?php

use Phinx\Migration\AbstractMigration;

class Oc18991 extends AbstractMigration
{

    public function up()
    {
        $sql =
            "BEGIN;
            INSERT INTO db_syscampo values ((select max(codcam)+1 from db_syscampo), 've01_codigoant', 'int4', 'Código Anterior','0', 'Código Anterior', 11, false, false, false, 1, 'text', 'Código Anterior');
            COMMIT;
        ";

        $this->execute($sql);
    }
}
