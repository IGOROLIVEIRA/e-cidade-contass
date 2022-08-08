<?php

use Phinx\Migration\AbstractMigration;

class Relatorio1010 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        begin;
            INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Relatorio Tabela de Rubricas ', 'Relatorio Tabela de Rubricas', 'con4_reltabrubricas001.php', 1, 1, 'Relatorio Tabela de Rubricas', 't');
            INSERT INTO db_menu VALUES(30,(select max(id_item) from db_itensmenu),1,10216);
        commit;
        ";
        $this->execute($sql);
    }
}
