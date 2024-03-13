<?php

use Phinx\Migration\AbstractMigration;

class Oc22068 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        ALTER TABLE bpdcasp102023 ADD si208_vlativonaocircucredilongoprazo double precision NOT NULL DEFAULT 0;
        ALTER TABLE bpdcasp102023 ADD si208_vlativonaocircuinvestemplongpraz double precision NOT NULL DEFAULT 0;
        ALTER TABLE bpdcasp712023 ADD column si215_codfontrecursos24 int4 NOT NULL DEFAULT 0;

        ALTER TABLE bpdcasp102024 ADD si208_vlativonaocircucredilongoprazo double precision NOT NULL DEFAULT 0;
        ALTER TABLE bpdcasp102024 ADD si208_vlativonaocircuinvestemplongpraz double precision NOT NULL DEFAULT 0;
        ALTER TABLE bpdcasp712024 ADD column si215_codfontrecursos24 int4 NOT NULL DEFAULT 0;

        ALTER TABLE rpsd112023 ADD si190_codco varchar(4) NULL; 
        ALTER TABLE rpsd112024 ADD si190_codco varchar(4) NULL;
        
        ALTER TABLE bodcasp302023 RENAME COLUMN si203_vlamortizaoutrasdivinter TO si203_vlamortizadividacontratualinternas;
        ALTER TABLE bodcasp302023 RENAME COLUMN si203_vlamortizaoutrasdivext TO si203_vlamortizadividacontratualexternas;
        ALTER TABLE bodcasp202023 DROP COLUMN si202_vlsaldoexeantrecredad;

        ALTER TABLE bodcasp302024 RENAME COLUMN si203_vlamortizaoutrasdivinter TO si203_vlamortizadividacontratualinternas;
        ALTER TABLE bodcasp302024 RENAME COLUMN si203_vlamortizaoutrasdivext TO si203_vlamortizadividacontratualexternas;
        ALTER TABLE bodcasp202024 DROP COLUMN si202_vlsaldoexeantrecredad;

        ALTER TABLE bpdcasp102023 DROP COLUMN si208_vlativonaocircuinvestemplongpraz;
        ALTER TABLE bpdcasp102023 DROP COLUMN si208_vlativonaocircucredilongoprazo;
        ALTER TABLE bpdcasp102023 DROP COLUMN si208_vlativonaocircuvpdantecipada;
        ALTER TABLE bpdcasp102023 DROP COLUMN si208_vlativonaocircuestoques;

        ALTER TABLE bpdcasp102024 DROP COLUMN si208_vlativonaocircuinvestemplongpraz;
        ALTER TABLE bpdcasp102024 DROP COLUMN si208_vlativonaocircucredilongoprazo;
        ALTER TABLE bpdcasp102024 DROP COLUMN si208_vlativonaocircuvpdantecipada;
        ALTER TABLE bpdcasp102024 DROP COLUMN si208_vlativonaocircuestoques;
        
        COMMIT;

SQL;
        $this->execute($sql);
    }
}