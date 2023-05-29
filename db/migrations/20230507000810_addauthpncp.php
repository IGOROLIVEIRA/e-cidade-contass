<?php

use Phinx\Migration\AbstractMigration;

class Addauthpncp extends AbstractMigration
{

    public function up()
    {
        $sql = "
            alter table licitaparam add l12_loginpncp varchar(40);
            alter table licitaparam add l12_passwordpncp varchar(20);
            

            CREATE SEQUENCE licontroleatarppncp_l215_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;
        ";

        $this->execute($sql);
    }
}
