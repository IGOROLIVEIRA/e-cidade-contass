<?php

use Phinx\Migration\AbstractMigration;

class Oc17280HotFixQuadro extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
            ALTER TABLE "contabilidade"."quadrosuperavitdeficit" RENAME COLUMN "c241_anousu" TO "c241_ano";
SQL;

        $this->execute($sql);
    }

    public function down()
    {

    }
}
