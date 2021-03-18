<?php

use Phinx\Migration\AbstractMigration;

class Oc13956 extends AbstractMigration
{
    public function change(){
        $sql = "

        BEGIN;

        select fc_startsession();

        -- Alteração do menu para cadastro de fornecedor no módulo Compras

        DELETE FROM db_menu WHERE id_item = 9198 AND id_item_filho = 3962;

        INSERT INTO db_menu(id_item, id_item_filho, menusequencia, modulo)
            VALUES (9198, 3963, 1, 28);
    
        INSERT INTO db_menu(id_item, id_item_filho, menusequencia, modulo)
            values(9198, 3964, 1, 28);
        
        INSERT INTO db_menu(id_item, id_item_filho, menusequencia, modulo)
            values(9198, 3965, 1, 28);	


        -- Alteração do menu para cadastro de fornecedor no módulo Licitação
        
        UPDATE db_itensmenu 
            SET descricao = 'Fornecedor',
                help = 'Cadastro de Pcforne',
                desctec = 'Cadastro de Pcforne'
            WHERE id_item = 3962;


        UPDATE db_menu
            SET menusequencia = 35
            WHERE id_item = 3962
                AND modulo = 381
                AND menusequencia = 38;

        COMMIT;

        ";

        $this->execute($sql);
    }

}
