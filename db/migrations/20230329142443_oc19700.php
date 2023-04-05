<?php

use Phinx\Migration\AbstractMigration;

class Oc19700 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        select fc_startsession();

        begin;

        select setval('db_itensmenu_id_item_seq', (select max(id_item) from db_itensmenu));
        
        insert into db_itensmenu values (nextval('db_itensmenu_id_item_seq'),'Itens Licitados (Novo)','Itens Licitados (Novo)','lic1_itenslicitados001.php',1,1,'Itens Licitados (Novo)','t');
        
        insert into db_menu values(1797,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 1797),381);

        commit;
        
        ";

$this->execute($sql);
    }
}
