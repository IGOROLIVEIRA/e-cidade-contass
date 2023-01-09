<?php

use Phinx\Migration\AbstractMigration;

class Oc19352 extends AbstractMigration
{
  
    public function up()
    {
        $sql = "
            select fc_startsession();
            
            begin;

            select setval('db_itensmenu_id_item_seq', (select max(id_item) from db_itensmenu));
            
            insert into db_itensmenu values (nextval('db_itensmenu_id_item_seq'),'Declaração de Transferência','Declaração de Transferência','edu2_declaracaoconclusao001.php',1,1,'Declaração de Transferência','t');
            
            insert into db_menu values(1101109,(select max(id_item) from db_itensmenu),15,1100747);

            commit";

        $this->execute($sql);
    }
}
