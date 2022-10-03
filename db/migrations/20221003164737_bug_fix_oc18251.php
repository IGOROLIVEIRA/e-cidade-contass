<?php

use Phinx\Migration\AbstractMigration;

class BugFixOc18251 extends AbstractMigration
{
    public function up()
    {

        $sSql="
        select fc_startsession();

        begin;

        alter table licitaparam add l12_pncp bool;
        
        update licitaparam SET l12_pncp = false;

        commit;
        ";

        $this->execute($sSql);

    }
}
