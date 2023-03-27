<?php

use Phinx\Migration\AbstractMigration;

class Oc20005exec extends AbstractMigration
{
    public function up()
    {
        $sql = "ALTER TABLE bpdcasp102022 ADD si208_vlativocircudemaiscredicurtoprazo float8 NOT NULL DEFAULT 0;
                ALTER TABLE bpdcasp102022 ADD si208_vlativonaocircumantidovenda float8 NOT NULL DEFAULT 0;        
                ALTER TABLE bpdcasp102022 ADD si208_vlativonaocircurlp float8 NOT NULL DEFAULT 0;
                ALTER TABLE bpdcasp102022 ADD si208_vlativocircuativobio float8 NOT NULL DEFAULT 0;
                ALTER TABLE bpdcasp102023 ADD si208_vlativocircudemaiscredicurtoprazo float8 NOT NULL DEFAULT 0;
                ALTER TABLE bpdcasp102023 ADD si208_vlativonaocircumantidovenda float8 NOT NULL DEFAULT 0;        
                ALTER TABLE bpdcasp102023 ADD si208_vlativonaocircurlp float8 NOT NULL DEFAULT 0;
                ALTER TABLE bpdcasp102023 ADD si208_vlativocircuativobio float8 NOT NULL DEFAULT 0;

                ALTER TABLE bpdcasp102022 ALTER COLUMN si208_exercicio DROP NOT NULL;
                ALTER TABLE bpdcasp102022 ALTER COLUMN si208_vlativonaocircucredilongoprazo DROP NOT NULL;
                ALTER TABLE bpdcasp102022 ALTER COLUMN si208_vlativonaocircuinvestemplongpraz DROP NOT NULL;
                
                ALTER TABLE bpdcasp102023 DROP COLUMN si208_exercicio;
                ALTER TABLE bpdcasp102023 DROP COLUMN si208_vlativonaocircucredilongoprazo;
                ALTER TABLE bpdcasp102023 DROP COLUMN si208_vlativonaocircuinvestemplongpraz;

                ALTER TABLE dfcdcasp102022 ADD si219_vlreceitatributaria float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102022 ADD si219_vlreceitacontribuicao float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102022 ADD si219_vlreceitapatrimonial float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102022 ADD si219_vlreceitaagropecuaria float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102022 ADD si219_vlreceitaindustrial float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102022 ADD si219_vlreceitaservicos float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102022 ADD si219_vlremuneracaodisponibilidade float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102022 ADD si219_vloutrasreceitas float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102022 ADD si219_vltransferenciarecebidas float8 NOT NULL DEFAULT 0;

                ALTER TABLE dfcdcasp102022 ALTER si219_vltranscorrenterecebida DROP NOT NULL;
                ALTER TABLE dfcdcasp102022 ALTER si219_vloutrosingressosoperacionais DROP NOT NULL;

                ALTER TABLE dfcdcasp102023 ADD si219_vlreceitatributaria float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102023 ADD si219_vlreceitacontribuicao float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102023 ADD si219_vlreceitapatrimonial float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102023 ADD si219_vlreceitaagropecuaria float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102023 ADD si219_vlreceitaindustrial float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102023 ADD si219_vlreceitaservicos float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102023 ADD si219_vlremuneracaodisponibilidade float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102023 ADD si219_vloutrasreceitas float8 NOT NULL DEFAULT 0;
                ALTER TABLE dfcdcasp102023 ADD si219_vltransferenciarecebidas float8 NOT NULL DEFAULT 0;

                ALTER TABLE dfcdcasp102023 ALTER si219_vltranscorrenterecebida DROP NOT NULL;
                ALTER TABLE dfcdcasp102023 ALTER si219_vloutrosingressosoperacionais DROP NOT NULL;

                ";
        $this->execute($sql);
    }
}