<?php

use Phinx\Migration\AbstractMigration;

class Oc22144 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Capa de Processo de Compra', 'Capa de Processo de Compra', 'com2_capaprocesso001.php', 1, 1, 'Capa de Processo de Compra', 't');
            INSERT INTO db_menu VALUES(30,(select max(id_item) from db_itensmenu),1018,18);
        ";
        $this->execute($sql);
    }
}
