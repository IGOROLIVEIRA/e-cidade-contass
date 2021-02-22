<?php

use Phinx\Migration\AbstractMigration;

class Oc14109 extends AbstractMigration
{
    public function up(){
        $sql = "
                BEGIN;

                SELECT fc_startsession();
                
                ALTER TABLE acordo ADD COLUMN ac16_providencia integer;
                
                CREATE TABLE providencia(codigo integer PRIMARY KEY, descricao varchar(20));
                
                INSERT INTO providencia(codigo, descricao)
                VALUES (1, 'Finalizado'),
                       (2, 'Aditado');
                
                COMMIT;
        ";

        $this->execute($sql);

    }

    public function down(){
        $sql = "
                BEGIN;

                SELECT fc_startsession();
                
                DROP TABLE providencia;

                ALTER TABLE acordo DROP COLUMN ac16_providencia;

                COMMIT;
        ";

        $this->execute($sql);
        
    }
}
