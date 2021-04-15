<?php

use Phinx\Migration\AbstractMigration;

class Oc14432 extends AbstractMigration
{
    public function up(){
        $sql = "
            BEGIN;

            SELECT fc_startsession();

            ALTER TABLE ralic102021 ADD COLUMN si180_qtdlotes INTEGER DEFAULT NULL;
            ALTER TABLE ralic112021 ADD COLUMN si181_nrolote INTEGER DEFAULT NULL;

            -- Cria a tabela com alguns novos campos para atender as alterações do edital para 2021

            create table obrasdadoscomplementareslote(
                db150_sequencial bigint not null,
                db150_codobra bigint not null,
                db150_pais integer not null,
                db150_estado integer not null,
                db150_municipio integer not null,
                db150_distrito varchar(100),
                db150_bairro varchar(100),
                db150_numero integer,
                db150_logradouro varchar(100),
                db150_latitude numeric,
                db150_longitude numeric,
                db150_classeobjeto integer,
                db150_grupobempublico integer,
                db150_subgrupobempublico integer,
                db150_atividadeobra integer,
                db150_atividadeservico integer,
                db150_descratividadeservico varchar(150),
                db150_atividadeservicoesp integer,
                db150_descratividadeservicoesp varchar(150),
                db150_lote integer,
                db150_bdi numeric,
                db150_cep varchar(8),
                CONSTRAINT db150_codobra_fk 
                    FOREIGN KEY(db150_codobra) REFERENCES obrascodigos(db151_codigoobra)
            );
            
            ALTER TABLE obrasdadoscomplementareslote ADD CONSTRAINT db150_lote_fk
            FOREIGN key(db150_lote) REFERENCES liclicitemlote(l04_codigo);
            
            CREATE SEQUENCE obrasdadoscomplementareslote_db150_sequencial_seq
              START WITH 1
              INCREMENT BY 1
              NO MINVALUE
              NO MAXVALUE
              CACHE 1;
            
            ALTER TABLE ONLY obrasdadoscomplementareslote
                  ADD CONSTRAINT obrasdadoscomplementareslote_sequ_pk PRIMARY KEY (db150_sequencial);
            COMMIT;

        ";
        $this->execute($sql);
    }

    public function down(){
        $sql = "
            BEGIN;

            SELECT fc_startsession();

            ALTER TABLE ralic102021 DROP COLUMN si180_qtdlotes;
            ALTER TABLE ralic112021 DROP COLUMN si181_nrolote;

            DROP TABLE obrasdadoscomplementares2021;
            DROP SEQUENCE obrasdadoscomplementares2021_db150_sequencial_seq;

            COMMIT;
        ";
        $this->execute($sql);
    }
}
