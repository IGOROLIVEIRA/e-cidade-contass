<?php

use Phinx\Migration\AbstractMigration;

class oc18136 extends AbstractMigration
{
    public function up()
    {
        $this->execute("update cnae set q71_descr = 'Cabeleireiros, manicure e pedicure' where substring(q71_estrutural, 2) = '9602501';");
    }

    public function down()
    {
        $this->execute("update cnae set q71_descr = 'Cabeleireiros' where substring(q71_estrutural, 2) = '9602501';");
    }
}
