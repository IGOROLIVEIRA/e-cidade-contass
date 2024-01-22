<?php

use Phinx\Migration\AbstractMigration;

class Oc21450 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        ALTER TABLE iderp112023 ADD COLUMN si180_codco varchar NOT NULL DEFAULT '0000';
        ALTER TABLE iderp112023 ADD COLUMN si180_disponibilidadecaixa int8 NOT NULL DEFAULT 0;

        ALTER TABLE iderp112024 ADD COLUMN si180_codco varchar NOT NULL DEFAULT '0000';
        ALTER TABLE iderp112024 ADD COLUMN si180_disponibilidadecaixa int8 NOT NULL DEFAULT 0;
        ";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        ALTER TABLE iderp112023 DROP COLUMN si180_codco;
        ALTER TABLE iderp112023 DROP COLUMN si180_disponibilidadecaixa;

        ALTER TABLE iderp112024 DROP COLUMN si180_codco;
        ALTER TABLE iderp112024 DROP COLUMN si180_disponibilidadecaixa;
        ";

        $this->execute($sql);
    }
}
