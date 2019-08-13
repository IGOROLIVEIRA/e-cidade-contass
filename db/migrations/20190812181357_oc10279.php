<?php

use Phinx\Migration\AbstractMigration;

class Oc10279 extends AbstractMigration
{
    public function up()
    {
      $this->execute("UPDATE db_syscampo SET descricao = 'Combustível', rotulo = 'Combustível', rotulorel = 'Combustível' WHERE codcam = 10982");
    }

    public function down(){

    }
}
