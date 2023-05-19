<?php

use Phinx\Migration\AbstractMigration;

class Oc20027 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        BEGIN; 
        
        insert into db_itensmenu values ((select max(id_item)+ 1 from db_itensmenu),'Aditamentos','Aditamentos',
        'aco2_impressaoaditamentos001.php',1,1,'Aditamentos','t');

        INSERT INTO db_menu VALUES(30,(select max(id_item) from db_itensmenu),1014,8251);

        COMMIT;
        
        ";

        $this->execute($sql);
    }
}
