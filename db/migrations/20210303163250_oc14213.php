<?php

use Phinx\Migration\AbstractMigration;

class Oc14213 extends AbstractMigration
{

    public function up()
    {
        $sSql = "
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),'Bases - Rúbricas eSocial', 'Bases - Rúbricas eSocial','pes2_relbasesrubricasesocial001.php',1,1,'','t');
        INSERT INTO db_menu VALUES (2456,(SELECT id_item FROM db_itensmenu WHERE funcao = 'pes2_relbasesrubricasesocial001.php'),(SELECT MAX(menusequencia)+1 FROM db_menu WHERE id_item = 2456 AND modulo = 952),952);
        ";

        $this->execute($sSql);
    }

    public function down()
    {
        $sSql = "
        DELETE FROM db_menu where id_item_filho = (SELECT id_item FROM db_itensmenu WHERE funcao = 'pes2_relbasesrubricasesocial001.php');
        DELETE FROM db_itensmenu WHERE funcao = 'pes2_relbasesrubricasesocial001.php';
        ";

        $this->execute($sSql);
    }
}
