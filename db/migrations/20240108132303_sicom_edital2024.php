<?php

use Phinx\Migration\AbstractMigration;

class SicomEdital2024 extends AbstractMigration
{

    public function up()
    {
        $sql = "
                ALTER TABLE ralic102024
                ALTER COLUMN si180_codorgaoresp TYPE INTEGER USING si180_codorgaoresp::INTEGER;

                ALTER TABLE ralic102024 add column si180_emailcontato varchar(200);

                ALTER TABLE ralic112024 add column si181_utilizacaoplanilhamodelo int8;

                ALTER TABLE redispi102024 add column si183_emailcontato varchar(200);

                ALTER TABLE redispi112024 add column si184_utilizacaoplanilhamodelo int8;

        ";

        $this->execute($sql);
    }
}
