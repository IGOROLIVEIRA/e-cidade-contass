<?php

use Phinx\Migration\AbstractMigration;

class Addmenuimportacao extends AbstractMigration
{
   
    public function up()
    {
        $sql = "
        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Obter dados', 'Obter dados', 'lic1_obterdadospncp.php', 1, 1, 'Obter dados', 't');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao='PNCP'),(select max(id_item) from db_itensmenu),5,381);
        ";

        $this->execute($sql);
    }
}
