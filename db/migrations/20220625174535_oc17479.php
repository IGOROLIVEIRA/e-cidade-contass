<?php

use Phinx\Migration\AbstractMigration;

class Oc17479 extends AbstractMigration
{
    public function up()
    {
        $sql = "INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Execu��o de Excesso de Arrecada��o', 'Execu��o de Excesso de Arrecada��o', 'orc2_execucaoexcessoarrecadacao001.php', 1, 1, 'Execu��o de Excesso de Arrecada��o', 't');
        INSERT INTO db_menu VALUES(4149, (select max(id_item) from db_itensmenu), 6, 116);";
        $this->execute($sql);

        $sql = "INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Execu��o de Superavit', 'Execu��o de Superavit', 'orc2_execucaosuperavit001.php', 1, 1, 'Execu��o de Superavit', 't');
        INSERT INTO db_menu VALUES(4149, (select max(id_item) from db_itensmenu), 7, 116);";
        $this->execute($sql);
    }
}
