<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Sigaf4 extends PostgresMigration
{
    public function up()
    {
        $sql = "
            alter table ambulatorial.unidades add column sd02_i_tipounidade int4;
        ";
        $this->execute($sql);
    }
}
