<?php

use Phinx\Migration\AbstractMigration;

class Oc19781v3 extends AbstractMigration
{
     public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

        ALTER TABLE dipr ADD c236_tipocadastro int8 NULL;
        ALTER TABLE dipr ADD c236_dtAtoNormaCriRPPS date NULL;
        ALTER TABLE dipr ADD c236_nroAtoNormaSegreMassa int8 NULL;
        ALTER TABLE dipr ADD c236_dtAtoNormaSegreMassa date NULL;
        ALTER TABLE dipr ADD c236_planoDefAtuarial int8 NULL;
        ALTER TABLE dipr ADD c236_atoNormPlanoDefAt int8 NULL;
        ALTER TABLE dipr ADD c236_dtAtoPlanoDefAt date NULL;

        ALTER TABLE diprbaseprevidencia ADD c238_valorjuros numeric NULL;
        ALTER TABLE diprbaseprevidencia ADD c238_valormulta numeric NULL;
        ALTER TABLE diprbaseprevidencia ADD c238_valoratualizacaomonetaria numeric NULL;
        ALTER TABLE diprbaseprevidencia ADD c238_valortotaldeducoes numeric NULL;


        ALTER TABLE diprdeducoes ADD c239_datarepasse date NULL;

        ALTER TABLE dipraportes ADD c240_datarepasse date NULL;

        ALTER TABLE dipr102023 RENAME COLUMN si230_coddipr TO si230_tipocadastro;
        ALTER TABLE dipr102023 ADD si230_nroAtoNormaSegreMassa int8 NULL;
        ALTER TABLE dipr102023 ADD si230_dtAtoNormaSegreMassa date NULL;
        ALTER TABLE dipr102023 ADD si230_planoDefAtuarial int8 NULL;
        ALTER TABLE dipr102023 ADD si230_atoNormPlanoDefAt int8 NULL;
        ALTER TABLE dipr102023 ADD si230_dtAtoPlanoDefAt date NULL;
        ALTER TABLE dipr102023 ADD si230_dtatonormativo date NULL;
        ALTER TABLE dipr102023 DROP COLUMN si230_exercicioato;


        ALTER TABLE dipr202023 DROP COLUMN si231_coddipr;

        ALTER TABLE dipr302023 DROP COLUMN si232_coddipr;
        ALTER TABLE dipr302023 ADD si232_valorjuros numeric NULL;
        ALTER TABLE dipr302023 ADD si232_valormulta numeric NULL;
        ALTER TABLE dipr302023 ADD si232_valoratualizacaomonetaria numeric NULL;
        ALTER TABLE dipr302023 ADD si232_valortotaldeducoes numeric NULL;


        ALTER TABLE dipr402023 ADD si233_datarepasse date NULL;
        ALTER TABLE dipr402023 DROP COLUMN si233_coddipr;

        ALTER TABLE dipr502023 DROP COLUMN si234_coddipr;
        ALTER TABLE dipr502023 DROP COLUMN si234_exercicioato;
        ALTER TABLE dipr502023 DROP COLUMN si234_atonormativo;

        ALTER TABLE dipr502023 ADD si234_datarepasse date NULL;

    COMMIT;

SQL;
        $this->execute($sql);
    } 
}