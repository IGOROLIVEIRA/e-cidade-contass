<?php

use Phinx\Migration\AbstractMigration;

class RelatorioGeralVeiculos extends AbstractMigration
{

    public function up()
    {
        $sql = "
                select fc_startsession();
        
                begin;

                select setval('db_itensmenu_id_item_seq', (select max(id_item) from db_itensmenu));
                
                insert into db_itensmenu values (nextval('db_itensmenu_id_item_seq'),'Geral Veiculos (Novo)','Geral Veiculos (Novo)','vei2_geralveiculos001.php',1,1,'Geral Veiculos (Novo)','t');
                
                insert into db_menu values(5336,(select max(id_item) from db_itensmenu),(select max(menusequencia)+1 from db_menu where id_item = 5336),633);

                commit;
        
              ";
        
        $this->execute($sql);
    }
}
