<?php

use Phinx\Migration\AbstractMigration;

class Oc17714 extends AbstractMigration
{
    public function up()
    {
        $sql = 'ALTER TABLE "contabilidade"."quadrosuperavitdeficit" ADD COLUMN "c241_instit" int4 DEFAULT 1;';
        $this->execute($sql);
    }

    public function down()
    {
        $sql = 'ALTER TABLE "contabilidade"."quadrosuperavitdeficit" DROP COLUMN "c241_instit";';
        $this->execute($sql);
    }
}
