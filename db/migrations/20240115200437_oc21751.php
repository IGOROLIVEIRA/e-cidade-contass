<?php

use Phinx\Migration\AbstractMigration;

class Oc21751 extends AbstractMigration
{

    public function up()
    {
        $sSql  = "BEGIN;
                    ALTER TABLE contratos102024 ADD COLUMN si83_vigenciaindeterminada int;
                    ALTER TABLE contratos102024 ALTER COLUMN si83_datafinalvigencia DROP NOT NULL;
                    ALTER TABLE contratos102024 RENAME COLUMN si83_codorgaoresp TO si83_cnpjorgaoentresp;
                    ALTER TABLE contratos102024 ALTER COLUMN si83_cnpjorgaoentresp TYPE VARCHAR(14);
                    ALTER TABLE contratos202024 ADD COLUMN si87_codunidadesubatual varchar(8);
                    ALTER TABLE contratos202024 ADD COLUMN si87_criterioreajuste int;
                    ALTER TABLE contratos202024 ADD COLUMN si87_descricaoreajuste varchar (300);
                    ALTER TABLE contratos202024 RENAME COLUMN si87_dscreajuste TO si87_descricaoindice;
                    ALTER TABLE contratos302024 ADD COLUMN si89_codunidadesubatual varchar(8);
                    ALTER TABLE contratos302024 ADD COLUMN si89_criterioreajuste int;
                    ALTER TABLE contratos302024 ADD COLUMN si89_descricaoindice varchar (300);
                    ALTER TABLE contratos402024 ADD COLUMN si91_codunidadesubatual varchar (8);
                    ALTER TABLE contratos112024 ADD COLUMN si84_obrordem int;
                    ALTER TABLE contratos212024 ADD COLUMN si88_obrordem int;
                  COMMIT;
      
        ";
    }
}
