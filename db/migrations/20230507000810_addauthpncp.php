<?php

use Phinx\Migration\AbstractMigration;

class Addauthpncp extends AbstractMigration
{

    public function up()
    {
        $sql = "
            alter table licitaparam add l12_loginpncp varchar(40);
            alter table licitaparam add l12_passwordpncp varchar(20);
        ";

        $this->execute($sql);
    }
}
