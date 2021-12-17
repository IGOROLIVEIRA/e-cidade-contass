<?php

use Phinx\Migration\AbstractMigration;

class Oc15323 extends AbstractMigration
{
    public function change()
    {
        $sql = "
            INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Comparativo de Rubricas','Comparativo de Rubricas','pes2_plabasesrubricasesocial001.php',1,1,'Comparativo de Rubricas','t');
            INSERT INTO db_menu VALUES(2456,(select max(id_item) from db_itensmenu),102,952);
        ";
        $this->execute($sql);
    }
}
