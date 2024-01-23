<?php

use Phinx\Migration\AbstractMigration;

class Oc21798 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu),'Metas de Arrecadação de Receita', 'Metas de Arrecadação de Receita','con4_metasarrecadacaoreceita.php',1,1,'Metas de Arrecadação de Receita','true');
        INSERT INTO db_menu VALUES (32, (select max(id_item) from db_itensmenu), (select max(menusequencia) from db_menu where id_item = 32 and modulo = 116)+1, 116);

        CREATE TABLE orcmetasarrecadacaoreceita (
                    o203_sequencial          int8 DEFAULT 0 NOT NULL,
                    o203_exercicio      character varying(4) NOT NULL,
                    o203_bimestre01          float8 NULL,
                    o203_bimestre02           float8 NULL,
                    o203_bimestre03       float8 NULL,
                    o203_bimestre04          float8 NULL,
                    o203_bimestre05          float8 NULL,
                    o203_bimestre06       float8 NULL,
                    o203_instit 	       bigint NOT NULL,
                    o203_totalbimestres       float8 NULL
                );
                
        CREATE SEQUENCE orcmetasarrecadacaoreceita_o203_sequencial_seq
            START WITH 1
            INCREMENT BY 1
            NO MINVALUE
            NO MAXVALUE
            CACHE 1;

    COMMIT; 

SQL;
        $this->execute($sql);
    } 
}