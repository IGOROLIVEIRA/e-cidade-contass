<?php

use Classes\PostgresMigration;

class Oc10548AddItemMenu extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();
        
        --Insere Itens ao Menu
        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Siope', 'Siope','',1,1,'Siope','true');

        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'De/Para Naturezas Siope', 'De/Para Naturezas Siope','con4_siopenaturezasiope.php',1,1,'De/Para Naturezas Siope','t');

        INSERT INTO db_menu VALUES (3962, (select max(id_item) from db_itensmenu)-1, (select max(menusequencia) from db_menu where id_item = 3962 and modulo = 2000025)+1, 2000025);

        INSERT INTO db_menu VALUES ((select max(id_item) from db_itensmenu)-1, (select max(id_item) from db_itensmenu), 1, 2000025);
        
        COMMIT;

SQL;
        $this->execute($sql);

    }
}