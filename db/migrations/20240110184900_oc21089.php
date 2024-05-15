<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc21089 extends PostgresMigration
{

  public function up()
  {
      $this->_run();
  }

  public function down()
  {
    $sql = "
      BEGIN;
        ALTER TABLE licitemobra DROP COLUMN obr06_ordem;
      COMMIT;";
    $this->execute($sql);

  }

  private function _run()
  {
      $sql = "
        BEGIN;
          ALTER TABLE licitemobra ADD COLUMN obr06_ordem int4;
        COMMIT;";
      $this->execute($sql);
  }
}
