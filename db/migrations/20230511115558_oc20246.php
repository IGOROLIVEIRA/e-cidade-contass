<?php

use Phinx\Migration\AbstractMigration;

class Oc20246 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        UPDATE db_itensmenu
        SET descricao = 'Lançamentos - Frequência', help = 'Lançamentos - Frequência', desctec = 'Lançamentos - Frequência'
        WHERE funcao = 'edu4_lancdiario001.php';


        INSERT INTO db_itensmenu VALUES (
            (SELECT max(id_item)+1 FROM db_itensmenu),
            'Lançamentos - Conteúdo',
            'Lançamentos - Conteúdo',
            'edu4_lancdiario002.php',
            1,
            1,
            'Lançamentos - Conteúdo',
            't');

        INSERT INTO db_menu VALUES(
            (SELECT id_item FROM db_menu WHERE id_item_filho = (SELECT id_item FROM db_itensmenu WHERE desctec LIKE'%Lançamentos%' AND funcao = 'edu4_lancdiario001.php')),
            (SELECT max(id_item) from db_itensmenu),
            (SELECT MAX(menusequencia)+1 AS COUNT FROM db_menu WHERE id_item = 1100930),
            1100747);
        ";

        $this->execute($sql);
    }
}
