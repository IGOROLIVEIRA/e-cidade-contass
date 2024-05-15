<?php

use Phinx\Migration\AbstractMigration;

class Oc18252 extends AbstractMigration
{
    
    public function up()
    {
        $sql= "BEGIN;
        Alter table parametroscontratos Add pc01_liberarsaldoposicao boolean;
        COMMIT;
        BEGIN;
        UPDATE parametroscontratos SET pc01_liberarsaldoposicao = 'f';
        COMMIT;
        ";
    }
}
