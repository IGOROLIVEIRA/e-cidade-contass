<?php

use Phinx\Migration\AbstractMigration;

class Oc16571HotFix4 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        -- Migration: Topico 2
        ALTER TABLE "public"."aoc112022"
        ADD COLUMN "si39_justificativa" text;

        ALTER TABLE "public"."aoc142022"
        ADD COLUMN "si42_nrocontratoop" varchar(30),
        ADD COLUMN "si42_dataassinaturacontratoop" date;

        -- Migration: Topico 3

        ALTER TABLE "public"."ext202022"
        ADD COLUMN "si165_exerciciocompdevo" int4 DEFAULT 0;

        -- Migration: Topico 4
        ALTER TABLE "public"."rec112022"
        ADD COLUMN "si26_nrocontratoop" varchar(30),
        ADD COLUMN "si26_dataassinaturacontratoop" date;

        -- Topico 5
        ALTER TABLE "public"."arc202022"
        ADD COLUMN "si31_regularizacaorepasseestornada" int4 NOT NULL DEFAULT 0,
        ADD COLUMN "si31_exercicioestornada" int4 DEFAULT 0,
        ADD COLUMN "si31_emendaparlamentarestornada" int4 NOT NULL DEFAULT 0;

        ALTER TABLE "public"."arc212022"
        ADD COLUMN "si32_nrocontratoop" varchar(30),
        ADD COLUMN "si32_dataassinaturacontratoop" date;
        COMMIT;

SQL;

        $this->execute($sql);
    }
}
