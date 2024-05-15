<?php

use Phinx\Migration\AbstractMigration;

class Oc13668 extends AbstractMigration
{
    public function change(){
        
        $sql = "

            ALTER TABLE pcmater 
                ADD COLUMN pc01_dataalteracao DATE,
                ADD COLUMN pc01_justificativa varchar(100);


            CREATE TABLE historicoitem(
                pc96_sequencial SERIAL PRIMARY KEY,
                pc96_codigomaterial BIGINT NOT NULL,
                pc96_usuario BIGINT NOT NULL,
                pc96_dataalteracao DATE NOT NULL,
                pc96_dataservidor DATE NOT NULL,
                pc96_horaalteracao TIMESTAMP NOT NULL,
                pc96_descricaoanterior VARCHAR(120)
            );

            

        ";
        $this->execute($sql);

    }
 
}
