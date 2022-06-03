<?php

use Phinx\Migration\AbstractMigration;

class Oc17565 extends AbstractMigration
{
    public function up()
    {
        $sql = "select fc_startsession();
        
        begin;
        
        select setval('db_itensmenu_id_item_seq', (SELECT max(id_item) FROM db_itensmenu));

        insert into db_itensmenu values (nextval('db_itensmenu_id_item_seq'),'Extrato de Contrato (Novo)','Extrato de Contrato (Novo)','aco2_extratodecontrato001.php',1,1,'extrato de contrato','t');
        
        insert into db_menu (id_item,id_item_filho,menusequencia,modulo) values (30,(select id_item from db_itensmenu where descricao = 'Extrato de Contrato (Novo)'),(select max(menusequencia) from db_menu where id_item = 30)+1,8251);

        commit;";

        $this->execute($sql);
    }
}
