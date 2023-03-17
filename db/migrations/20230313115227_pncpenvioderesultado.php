<?php

use Phinx\Migration\AbstractMigration;

class Pncpenvioderesultado extends AbstractMigration
{

    public function up()
    {
        $sql = "
            INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Publicacar Resultado', 'Publicacar Resultado', 'com1_pncpresultadodispensaporvalor001.php', 1, 1, 'Publicacar Resultado', 't');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where desctec like'%PNCP' and funcao = ' '),(select max(id_item) from db_itensmenu),2,28);
        ";
        $this->execute($sql);
    }
}
