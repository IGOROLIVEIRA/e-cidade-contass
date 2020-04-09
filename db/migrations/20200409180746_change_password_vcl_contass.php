<?php

use Phinx\Migration\AbstractMigration;

class ChangePasswordVclContass extends AbstractMigration
{
    public function up()
    {
        $this->execute("update db_usuarios set senha = '738518283e0a0ae3fc1b7948d20f3cc1b590e5f5' where login = 'vcl.contass'");
    }

    public function down()
    {
        
    }
}
