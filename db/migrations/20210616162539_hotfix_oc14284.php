<?php

use Phinx\Migration\AbstractMigration;

class HotfixOc14284 extends AbstractMigration
{
    public function up()
    {
      $this->execute("ALTER TABLE material.matparaminstit ALTER COLUMN m10_consumo_imediato SET DEFAULT false;");
    }
}
