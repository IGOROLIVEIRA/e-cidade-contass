<?php

use Classes\PostgresMigration;

class Oc13532 extends PostgresMigration
{
    public function up()
    {
        $sql = "
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Arquivo SICOOB CNAB 240', 'Arquivo SICOOB CNAB 240','pes2_sicoob240cnab001.php',1,1,'','t');
        INSERT INTO db_menu VALUES (7908,(SELECT id_item FROM db_itensmenu WHERE descricao = 'Arquivo SICOOB CNAB 240'),5,952);
        ";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        DELETE FROM db_menu where id_item_filho = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Arquivo SICOOB CNAB 240');
        DELETE FROM db_itensmenu WHERE descricao = 'Arquivo SICOOB CNAB 240';
        ";

        $this->execute($sql);
    }
}
