<?php

use Phinx\Migration\AbstractMigration;

class Alteradatarecdocumentacao extends AbstractMigration
{

    public function up()
    {
        $sql = "UPDATE liclicita
        SET l20_recdocumentacao = l20_dataaberproposta
        WHERE l20_recdocumentacao IS NULL
            AND l20_dataaberproposta IS NOT NULL";

        $this->execute($sql);
    }
}
