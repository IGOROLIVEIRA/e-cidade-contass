<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Sigaf3 extends PostgresMigration
{

    public function up()
    {
        $sql = "
            alter table farmacia.far_matersaude  add column fa01_i_catmat int4;
        ";
        $this->execute($sql);
    }
}
