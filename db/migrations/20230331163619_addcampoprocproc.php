<?php

use Phinx\Migration\AbstractMigration;

class Addcampoprocproc extends AbstractMigration
{

    public function up()
    {
        $sql = "alter table pcproc add column pc80_categoriaprocesso int4";
        $this->execute($sql);
    }
}
