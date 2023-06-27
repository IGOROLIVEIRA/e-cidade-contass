<?php

use Phinx\Migration\AbstractMigration;

class Oc20432 extends AbstractMigration
{

    public function up()
    {
        $sSql = "
        
        BEGIN;
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),
        'Credenciados','Credenciados','lic2_credenciados001.php',1,1,'Credenciados','t');
                
        INSERT INTO db_menu VALUES(1797,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 1797 and modulo = 381),381);
        
        COMMIT;
        ";

        $this->execute($sSql);
    }
}
