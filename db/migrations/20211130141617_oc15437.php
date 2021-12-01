<?php

use Phinx\Migration\AbstractMigration;

class Oc15437 extends AbstractMigration
{
   
    public function up()
    {
        $sql = " INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Acordo','Manutencao de acordo','m4_acordo.php',1,1,'Manutencao de acordo','t');
        INSERT INTO db_menu VALUES(4001474,(select max(id_item) from db_itensmenu),3,1);
        INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Protocolo','Manutencao de protocolo','m4_protocolo.php',1,1,'Manutencao de protocolo','t');
        INSERT INTO db_menu VALUES(4001474,(select max(id_item) from db_itensmenu),4,1);"

        $this->execute($sql);
    }
}
