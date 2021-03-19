<?php

use Phinx\Migration\AbstractMigration;

class NotaskReplicaArquivos extends AbstractMigration
{
    public function up(){
        $sql = "
        CREATE TABLE hablic112021 (
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
        
        ALTER TABLE ONLY hablic112021 ADD CONSTRAINT hablic112021_sequ_pk PRIMARY KEY (si58_sequencial);
        
        CREATE INDEX hablic112021_si58_reg10_index ON hablic112021 USING btree (si58_mes);
        
        ALTER TABLE ONLY hablic112021 ADD CONSTRAINT hablic112021_reg10_fk FOREIGN KEY (si58_reg10) REFERENCES hablic102021(si57_sequencial);
        
        ";

        $this->execute($sql);
    }

    public function down(){
        $sql = "
            drop index hablic112021_si58_reg10_index;
            drop table hablic112021;        
        ";

        $this->execute($sql);
    }
}
