<?php

use Phinx\Migration\AbstractMigration;

class Oc8339menus extends AbstractMigration
{
    public function up()
    {
        $sql = "
        select fc_startsession();
      
        -- Cadastro de itens do menu
        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Publicação Termo de Ratificação', 'Publicação Termo de Ratificação', ' ', 1, 1, 'Publicação Termo de Ratificação', 't');
        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Inclusão', 'Inclusão', 'lic1_publicratificacao001.php', 1, 1, 'Inclusão', 't');
        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Alteração', 'Alteração', 'lic1_publicratificacao002.php', 1, 1, 'Alteração', 't');
        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Exclusão', 'Exclusão', 'lic1_publicratificacao003.php', 1, 1, 'Exclusão', 't');
        
        -- Cadastro de Menus
        INSERT INTO db_menu VALUES (1818, (select max(id_item)-3 from db_itensmenu),9, 381);
        INSERT INTO db_menu VALUES ((select max(id_item)-3 from db_itensmenu), (select max(id_item)-2 from db_itensmenu), 1, 381);
        INSERT INTO db_menu VALUES ((select max(id_item)-3 from db_itensmenu), (select max(id_item)-1 from db_itensmenu), 2, 381);
        INSERT INTO db_menu VALUES ((select max(id_item)-3 from db_itensmenu), (select max(id_item) from db_itensmenu), 3, 381)";
        $this->execute($sql);
    }

}
