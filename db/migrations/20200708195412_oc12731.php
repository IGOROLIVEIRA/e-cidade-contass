<?php

use Phinx\Migration\AbstractMigration;

class Oc12731 extends AbstractMigration
{
    public function up()
    {
        $sql = "

        INSERT INTO db_menu VALUES (
            1818, 
            (SELECT id_item from db_itensmenu where descricao ilike 'Adesão de registro%'), 
            (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 1818), 
            (381));
";
        $this->execute($sql);
    }
}
