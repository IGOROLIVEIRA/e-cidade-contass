<?php

use Phinx\Migration\AbstractMigration;

class Ocsicomam2023 extends AbstractMigration
{

    public function up()
    {
        $sql = "BEGIN;
        ALTER TABLE contratos102023 ADD si83_indcriterioreajuste INT; 
        ALTER TABLE contratos102023 ADD si83_tipocriterioreajuste  VARCHAR(2);
        ALTER TABLE contratos102023 ADD si83_databasereajuste DATE;
        ALTER TABLE contratos102023 ADD si83_indiceunicoreajuste VARCHAR(2);
        ALTER TABLE contratos102023 ADD si83_periodicidadereajuste VARCHAR(2);
        ALTER TABLE contratos102023 ADD si83_dscreajuste VARCHAR(300);
        ALTER TABLE contratos102023 ADD si83_dscindice VARCHAR(300);
        
        ALTER TABLE contratos112023 ADD si84_nroLote INT;
        COMMIT;";
        $this->execute($sql);
    }
}
