<?php

use Phinx\Migration\AbstractMigration;

class Ocsicomlayout2023 extends AbstractMigration
{


    public function up()
    {
        $sql = "
        BEGIN;
        ALTER TABLE acordo ADD ac16_reajuste BOOLEAN; 
        ALTER TABLE acordo ADD ac16_criterioreajuste  INT;
        ALTER TABLE acordo ADD ac16_datareajuste DATE;
        ALTER TABLE acordo ADD ac16_indicereajuste INT;
        ALTER TABLE acordo ADD ac16_periodoreajuste VARCHAR(50);
        ALTER TABLE acordo ADD ac16_descricaoreajuste VARCHAR(300);
        ALTER TABLE acordo ADD ac16_descricaoindice VARCHAR(300);


        ALTER TABLE acordoposicao ADD ac26_indicereajuste INT;
        ALTER TABLE acordoposicao ADD ac26_percentualreajuste VARCHAR(50);
        ALTER TABLE acordoposicao ADD ac26_descricaoindice VARCHAR(300);

        ALTER TABLE apostilamento ADD si03_indicereajuste INT;
        ALTER TABLE apostilamento ADD si03_percentualreajuste VARCHAR(50);
        ALTER TABLE apostilamento ADD si03_descricaoindice VARCHAR(300);
        COMMIT;
        ";

        $this->execute($sql);
    }
}
