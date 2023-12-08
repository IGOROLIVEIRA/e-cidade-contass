<?php

use Phinx\Migration\AbstractMigration;

class HotfixOc21168 extends AbstractMigration
{
    public function change()
    {
        $sSql = 

        "begin;

        DELETE FROM db_menu 
        where id_item = 4001478 and id_item_filho = (select id_item from db_itensmenu where funcao = 'm4_alteraobservacao.php');
        
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao ='Manutenção de Lançamentos (Patrimonial)'),(select id_item from db_itensmenu where funcao = 'm4_alteraobservacao.php'),7,1);
        
        commit;";

        $this->execute($sSql);
    }
}
