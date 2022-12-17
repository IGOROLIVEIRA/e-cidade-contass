<?php

use Phinx\Migration\AbstractMigration;

class Oc18303HotFix extends AbstractMigration
{
    public function up()
    {
        $sql = "BEGIN; ALTER TABLE escola.regenciahorario ADD ed58_d_data date NULL; COMMIT;";
        $this->execute($sql);
    }
}
