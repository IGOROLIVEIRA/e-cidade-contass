<?php

use Phinx\Migration\AbstractMigration;

class Oc21751 extends AbstractMigration
{

    public function up()
    {
        $sSql  = "BEGIN;
                    ALTER TABLE contratos102024 add column si83_vigenciaindeterminada int;
                    ALTER TABLE contratos102024 ALTER COLUMN si83_datafinalvigencia DROP NOT NULL;
                    ALTER TABLE contratos102024 RENAME COLUMN si83_codorgaoresp TO si83_cnpjorgaoentresp;
                    ALTER TABLE contratos102024 ALTER COLUMN si83_cnpjorgaoentresp TYPE VARCHAR(14);
                    ALTER TABLE contratos202024 add column si87_codunidadesubatual varchar(8);
                  COMMIT;
      
        ";
    }
}
