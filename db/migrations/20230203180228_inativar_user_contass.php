<?php

use Phinx\Migration\AbstractMigration;

class InativarUserContass extends AbstractMigration
{

    public function up()
    {
        $sql = "
            update db_usuarios set usuarioativo=2 where login = 'cess.contass';
            update db_usuarios set usuarioativo=2 where login = 'crb.contass';
            update db_usuarios set usuarioativo=2 where login = 'jdrp.contass';
        ";
        $this->execute($sql);
    }
}
