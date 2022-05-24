<?php

use Phinx\Migration\AbstractMigration;

class Educacao extends AbstractMigration
{

    public function up()
    {
        $sql = "
            UPDATE necessidade SET ed48_c_descr = 'TRANSTORNO DO ESPECTRO AUTISTA' WHERE ed48_i_codigo = 109;
        ";
        $this->execute($sql);
    }

}
