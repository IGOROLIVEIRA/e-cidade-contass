<?php

use Phinx\Migration\AbstractMigration;

class AlterarTabelahablic112021 extends AbstractMigration
{
    public function up(){
        $sql = "
        DROP TABLE IF EXISTS hablic112022 CASCADE;
        
        CREATE TABLE hablic112022 (
            si58_sequencial bigint DEFAULT 0 NOT NULL,
            si58_tiporegistro bigint DEFAULT 0 NOT NULL,
            si58_codorgao character varying(2) NOT NULL,
            si58_codunidadesub character varying(8) NOT NULL,
            si58_exerciciolicitacao bigint DEFAULT 0 NOT NULL,
            si58_nroprocessolicitatorio character varying(12) NOT NULL,
            si58_tipodocumentocnpjempresahablic bigint DEFAULT 0 NOT NULL,
            si58_cnpjempresahablic character varying(14) NOT NULL,
            si58_tipodocumentosocio bigint DEFAULT 0 NOT NULL,
            si58_nrodocumentosocio character varying(14) NOT NULL,
            si58_tipoparticipacao bigint DEFAULT 0 NOT NULL,
            si58_mes bigint DEFAULT 0 NOT NULL,
            si58_reg10 bigint DEFAULT 0 NOT NULL,
            si58_instit bigint DEFAULT 0
        );

        ALTER TABLE ONLY hablic112022 ADD CONSTRAINT hablic112022_sequ_pk PRIMARY KEY (si58_sequencial);
        
        CREATE INDEX hablic112022_si58_reg10_index ON hablic112022 USING btree (si58_mes);
        
        ALTER TABLE ONLY hablic112022 ADD CONSTRAINT hablic112022_reg10_fk FOREIGN KEY (si58_reg10) REFERENCES hablic102022(si57_sequencial);        
        ";

        $this->execute($sql);
    }

    public function down(){
        $sql = "
            drop index hablic112022_si58_reg10_index;
            drop table hablic112022;        
        ";

        $this->execute($sql);
    }
}
