<?php

use Phinx\Migration\AbstractMigration;

class Oc18922 extends AbstractMigration
{
    
    public function up()
    {
        $sql = "BEGIN;
        
        INSERT INTO db_itensmenu VALUES((select max(id_item) + 1 from db_itensmenu),'Notificações','Notificações','func_acordosavencer.php',1,1,'Notificações','t');
        INSERT INTO db_menu VALUES(8251,(select max(id_item) from db_itensmenu),(select max(menusequencia) + 1 from db_menu where id_item = 8251 and modulo = 8251),8251);
        
        INSERT INTO db_itensmenu VALUES((select max(id_item) + 1 from db_itensmenu),'Notificações','Notificações','func_edital.php',1,1,'Notificações','t');
        INSERT INTO db_menu VALUES(381,(select max(id_item) from db_itensmenu),(select max(menusequencia) + 1 from db_menu where id_item = 381 and modulo = 381),381);

        INSERT INTO db_itensmenu VALUES((select max(id_item) + 1 from db_itensmenu),'Notificações','Notificações','db_procreceber.php',1,1,'Notificações','t');
        INSERT INTO db_menu VALUES(604,(select max(id_item) from db_itensmenu),(select max(menusequencia) + 1 from db_menu where id_item = 604 and modulo = 604),604);

        INSERT INTO db_itensmenu VALUES((select max(id_item) + 1 from db_itensmenu),'Notificações','Notificações','mat2_estoqponto.php',1,1,'Notificações','t');
        INSERT INTO db_menu VALUES(480,(select max(id_item) from db_itensmenu),(select max(menusequencia) + 1 from db_menu where id_item = 480 and modulo = 480),480);

        COMMIT;
        ";
        
        $this->execute($sql);

    }
}
