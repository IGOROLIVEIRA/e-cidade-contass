<?php

use Phinx\Migration\AbstractMigration;

class Notaskmenupca extends AbstractMigration
{
    public function up()
    {
        $sql= "
            UPDATE db_menu SET id_item=8987, menusequencia=5, modulo=2000018  WHERE id_item_filho=3000100;
        ";
        $this->execute($sql);
    }
}
