<?php

use Phinx\Migration\AbstractMigration;

class Oc13094 extends AbstractMigration
{

    public function up()
    {
        $sql = "

        SELECT fc_startsession();

        UPDATE cfautent SET k11_tipautent = 2;";

        $this->execute($sql);
    }

    public function down()
    {

    }
}
