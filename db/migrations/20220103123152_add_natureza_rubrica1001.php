<?php

use Phinx\Migration\AbstractMigration;

class AddNaturezaRubrica1001 extends AbstractMigration
{
    public function up()
    {
        $sql = "INSERT INTO rubricasesocial values ('1001','Subsídio')";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DELETE FROM rubricasesocial WHERE e990_sequencial = '1001'";
        $this->execute($sql);
    }
}
