<?php

use Phinx\Migration\AbstractMigration;

class Oc13171 extends AbstractMigration
{
    public function up()
    {
        $this->execute("update discla set dtaute = dtcla where codcla in (3116,3117,3118,3120,3121,3124,3127,3128,3129,3130,3217,3303) and dtaute is null");
    }

    public function down()
    {
        $this->execute("update discla set dtaute = null where codcla in (3116,3117,3118,3120,3121,3124,3127,3128,3129,3130,3217,3303) and dtaute = dtcla");
    }
}
