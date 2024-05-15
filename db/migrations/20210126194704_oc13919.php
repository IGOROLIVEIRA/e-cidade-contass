<?php

use Phinx\Migration\AbstractMigration;

class Oc13919 extends AbstractMigration
{
    public function up(){
        $sql = "
        BEGIN;

            select fc_startsession();
        
            -- Inserção do menu no Módulo Compras
        
            insert into db_menu(id_item, id_item_filho, menusequencia, modulo) 
            values (31, (select id_item from db_itensmenu where funcao = 'emp1_empconsultaaut001.php'), (select max(menusequencia)+1 from db_menu where modulo = 28), 28);
        
            -- Inserção do menu no Módulo Contratos

            insert into db_menu(id_item, id_item_filho, menusequencia, modulo) 
            values (31, (select id_item from db_itensmenu where funcao = 'emp1_empconsultaaut001.php'), (select max(menusequencia)+1 from db_menu where modulo = 8251), 8251);
        
        COMMIT;
        ";
        $this->execute($sql);
    }

    public function down(){
        $sql = "
            -- Exclui os menus de Autorização de Empenho dos módulos Contrato e Compras

            DELETE from db_menu where id_item_filho = (select id_item from db_itensmenu where funcao = 'emp1_empconsultaaut001.php' and modulo in (28, 8251));
        ";
        $this->execute($sql);
    }
}
