<?php

use Phinx\Migration\AbstractMigration;

class Oc19763 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
            -- This script only contains the table creation statements and does not fully represent the table in the database. It's still missing: indices, triggers. Do not use it as a backup.

            create sequence public.aop122023_si139_sequencial_seq
            increment 1
            minvalue 1
            maxvalue 9223372036854775807
            start 1
            cache 1;

            create sequence public.aop132023_si140_sequencial_seq
            increment 1
            minvalue 1
            maxvalue 9223372036854775807
            start 1
            cache 1;

            ALTER TABLE "public"."aop112023"
            ADD COLUMN "si138_codco" int8 NOT NULL DEFAULT 0;

            -- Table Definition
            CREATE TABLE "public"."aop122023" (
                "si139_sequencial" int8 NOT NULL DEFAULT 0,
                "si139_tiporegistro" int8 NOT NULL DEFAULT 0,
                "si139_codreduzido" int8 NOT NULL DEFAULT 0,
                "si139_tipodocumento" varchar(2) NOT NULL,
                "si139_nrodocumento" varchar(15),
                "si139_codctb" int8 DEFAULT 0,
                "si139_codfontectb" int8 DEFAULT 0,
                "si139_desctipodocumentoop" varchar(50),
                "si139_dtemissao" date NOT NULL,
                "si139_vldocumento" float8 NOT NULL DEFAULT 0,
                "si139_mes" int8 NOT NULL DEFAULT 0,
                "si139_reg10" int8 NOT NULL DEFAULT 0,
                "si139_instit" int4 DEFAULT 0,
                CONSTRAINT "aop122023_reg10_fk" FOREIGN KEY ("si139_reg10") REFERENCES "public"."aop102023"("si137_sequencial"),
                PRIMARY KEY ("si139_sequencial")
            );

            -- This script only contains the table creation statements and does not fully represent the table in the database. It's still missing: indices, triggers. Do not use it as a backup.

            -- Table Definition
            CREATE TABLE "public"."aop132023" (
                "si140_sequencial" int8 NOT NULL DEFAULT 0,
                "si140_tiporegistro" int8 NOT NULL DEFAULT 0,
                "si140_codreduzidoop" int8 NOT NULL DEFAULT 0,
                "si140_tiporetencao" varchar(4) NOT NULL,
                "si140_descricaoretencao" varchar(50),
                "si140_vlretencao" float8 NOT NULL DEFAULT 0,
                "si140_vlantecipado" float8 NOT NULL DEFAULT 0,
                "si140_mes" int8 NOT NULL DEFAULT 0,
                "si140_reg10" int8 NOT NULL DEFAULT 0,
                "si140_instit" int8 DEFAULT 0,
                CONSTRAINT "aop132023_reg10_fk" FOREIGN KEY ("si140_reg10") REFERENCES "public"."aop102023"("si137_sequencial"),
                PRIMARY KEY ("si140_sequencial")
            );
SQL;
        $this->execute($sql);
    }
}
