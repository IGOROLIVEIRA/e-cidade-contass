<?php

use Phinx\Migration\AbstractMigration;

class Oc21321 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

        
        CREATE TABLE empefdreinf (
                    efd60_sequencial     bigint DEFAULT 0 NOT NULL,
                    efd60_numemp         int8,
                    efd60_codemp         varchar(15),
                    efd60_anousu         int8,
                    efd60_cessaomaoobra  int8,
                    efd60_aquisicaoprodrural int8,
                    efd60_instit          int8, 
                    efd60_possuicno       int8,
                    efd60_numcno          varchar(15),
                    efd60_indprestservico int8,
                    efd60_prescontricprb int8,
                    efd60_tiposervico    int8, 
                    efd60_prodoptacp     int8 
        );
            
        CREATE SEQUENCE empefdreinf_efd60_sequencial_seq
                        START WITH 1
                        INCREMENT BY 1
                        NO MINVALUE
                        NO MAXVALUE
                        CACHE 1;

        ALTER TABLE empempenho ADD e60_codco varchar(4) NULL;

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'e60_codco', 'int8', 'CO', 0, 'CO', 4, FALSE, FALSE, FALSE, 1, 'text', 'CO');
        
    COMMIT; 

SQL;
        $this->execute($sql);
    } 
}