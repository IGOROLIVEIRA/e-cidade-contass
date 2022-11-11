<?php

use Phinx\Migration\AbstractMigration;

class Hotfixoc18252 extends AbstractMigration
{
    
    public function change()
    {
        $sql= "BEGIN;
        Alter table parametroscontratos Add pc01_liberarsaldoposicao boolean;
        COMMIT;
        BEGIN;
        UPDATE parametroscontratos SET pc01_liberarsaldoposicao = 'f';
        COMMIT;
        ";
        
        $this->execute($sql);
    }
}
