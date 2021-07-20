<?php

use Phinx\Migration\AbstractMigration;

class Oc15115 extends AbstractMigration
{
  public function up()
  {
    $sql = "ALTER TABLE empenho.empautoriza ADD e54_desconto _bool NULL";
    $this->execute($sql);
  }
}
