<?php

use Phinx\Migration\AbstractMigration;

class Ocsicom2023migration extends AbstractMigration
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
        
        ALTER TABLE contratos202023 ADD si87_percentualReajuste float;
        ALTER TABLE contratos202023 ADD si87_indiceUnicoReajuste INT;
        ALTER TABLE contratos202023 ADD si87_dscReajuste VARCHAR(300);
        
        ALTER TABLE contratos212023 ADD si88_nroLote int;
        
        ALTER TABLE contratos302023  ADD si89_percentualReajuste float;
        ALTER TABLE contratos302023  ADD si89_indiceUnicoReajuste int;
        ALTER TABLE contratos302023  ADD si89_dscReajuste VARCHAR(300);
        
        ALTER TABLE ralic102023 ADD si180_dtaberturaenvelopes date;
        ALTER TABLE ralic102023 ADD si180_tipoorcamento INT; 
        
        ALTER TABLE contratos102023 ALTER COLUMN si83_objetocontrato TYPE varchar(1000);

        CREATE TABLE partlic102023(
        si203_sequencial		 int8 NOT NULL default 0,
        si203_tiporegistro			 int8 NOT NULL default 0,
        si203_codorgao		 varchar(2) NOT NULL,
        si203_codunidadesub		 varchar(8) NOT NULL,
        si203_exerciciolicitacao			 int8 NOT NULL default 0,
        si203_nroprocessolicitatorio	 int8 NOT NULL default 0,
        si203_tipodocumento		 int8 NOT NULL default 0,
        si203_nrodocumento		 varchar(14),
        si203_mes		 int8 NOT NULL default 0,
        si203_instit		 int8 default 0);
            
        CREATE SEQUENCE partlic102023_si203_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;
        
        COMMIT;";


        $this->execute($sql);

    }
}
