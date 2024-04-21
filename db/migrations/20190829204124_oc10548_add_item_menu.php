<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc10548AddItemMenu extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();
        
        --Insere Itens ao Menu De/Para
        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Siope', 'Siope','',1,1,'Siope','true');

        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'De/Para Naturezas Siope', 'De/Para Naturezas Siope','con4_siopearqdespesa.php',1,1,'De/Para Naturezas Siope','t');

        INSERT INTO db_menu VALUES (3962, (select max(id_item) from db_itensmenu)-1, (select max(menusequencia) from db_menu where id_item = 3962 and modulo = 2000025)+1, 2000025);

        INSERT INTO db_menu VALUES ((select max(id_item) from db_itensmenu)-1, (select max(id_item) from db_itensmenu), 1, 2000025);

        --Insere Itens ao Menu STN
        
        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Gerar Siope', 'Gerar Siope','con4_gerarsiope.php',1,1,'Gerar Siope','true');

        INSERT INTO db_menu VALUES (32, (select max(id_item) from db_itensmenu), (select max(menusequencia) from db_menu where id_item = 32 and modulo = 2000025)+1, 2000025);

        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Gerar Siope Folha', 'Gerar Siope Folha','pes1_siope.php',1,1,'Gerar Siope Folha','true');

        INSERT INTO db_menu VALUES (32, (select max(id_item) from db_itensmenu), (select max(menusequencia) from db_menu where id_item = 32 and modulo = 2000025)+1, 2000025);
        
        COMMIT;

SQL;
        $this->execute($sql);

    }
}