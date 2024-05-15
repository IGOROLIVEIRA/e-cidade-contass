<?php

use Phinx\Migration\AbstractMigration;

class HotfixRolContratos extends AbstractMigration
{

    public function up()
    {
        $sql = "INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Rol de Contratos (Novo)', 'Rol de Contratos (Novo)', 'ac16_relatoriorolcontratos.php', 1, 1, 'Rol de Contratos (Novo)', 't');
        INSERT INTO db_menu VALUES(30,(select max(id_item) from db_itensmenu),1013,8251);";
        $this->execute($sql);
    }
}
