<?php

use Phinx\Migration\AbstractMigration;

class Oc17479 extends AbstractMigration
{
    public function up()
    {
        $sql = "INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Execução de Excesso de Arrecadação', 'Execução de Excesso de Arrecadação', 'orc2_execucaoexcessoarrecadacao001.php', 1, 1, 'Execução de Excesso de Arrecadação', 't');
        INSERT INTO db_menu VALUES(4149, (select max(id_item) from db_itensmenu), 6, 116);";
        $this->execute($sql);

        $sql = "INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Execução de Superavit', 'Execução de Superavit', 'orc2_execucaosuperavit001.php', 1, 1, 'Execução de Superavit', 't');
        INSERT INTO db_menu VALUES(4149, (select max(id_item) from db_itensmenu), 7, 116);";
        $this->execute($sql);
    }
}
