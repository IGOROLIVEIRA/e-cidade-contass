<?php

use Phinx\Migration\AbstractMigration;

class Oc14425AlterarTipoCampo extends AbstractMigration
{
    public function up()
    {
        $this->execute('ALTER TABLE "caixa"."conciliacaobancarialancamento" ALTER COLUMN "k172_valor" SET DATA TYPE float8;');
    }

    public function down() {}
}
