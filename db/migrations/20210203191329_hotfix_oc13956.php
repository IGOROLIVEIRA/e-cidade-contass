<?php

use Phinx\Migration\AbstractMigration;

class HotfixOc13956 extends AbstractMigration
{
    public function change(){
        $sql = "
            begin;

            select fc_startsession();

            -- Exclui o menu Fornecedor nos módulos TCE/MG e STN

            DELETE FROM db_menu 
                WHERE id_item IN (2000018, 2000025) 
                AND id_item_filho = 3962;


            -- Cadastra o menu 'Cadastro' nos módulos TCE/MG e STN respectivamente
            INSERT INTO db_menu(id_item, id_item_filho, menusequencia, modulo)
                VALUES(2000018, 29, 1, 2000018), 
                      (2000025, 29, 1, 2000025);
        ";

        $this->execute($sql);
    }
}
