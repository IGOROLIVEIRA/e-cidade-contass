<?php

use Phinx\Migration\AbstractMigration;

class SetUserIfoContassToAdmin extends AbstractMigration
{
    public function change()
    {
        $this->execute("update db_usuarios set administrador = 1 where login = 'ifo.contass'");
    }
}
