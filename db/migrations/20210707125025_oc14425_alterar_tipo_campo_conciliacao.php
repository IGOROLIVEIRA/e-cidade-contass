<?php

use Phinx\Migration\AbstractMigration;

class Oc14425AlterarTipoCampoConciliacao extends AbstractMigration
{
  public function up()
  {
      $this->execute('ALTER TABLE "caixa"."conciliacaobancaria" ALTER COLUMN "k171_saldo" SET DATA TYPE float8;');
  }

  public function down() {}
}
