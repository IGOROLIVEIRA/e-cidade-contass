<?php

use Phinx\Migration\AbstractMigration;

class Oc14163 extends AbstractMigration
{
    public function up(){
        $sql = "
            BEGIN;

            SELECT fc_startsession();
        
            ALTER TABLE cfpatriinstituicao 
                ADD COLUMN t59_termodeguarda boolean DEFAULT FALSE;

            ALTER TABLE bensguarda 
                ADD COLUMN t21_representante varchar(80),
                ADD COLUMN t21_cpf varchar(11);
        
            COMMIT;
        
        ";
        $this->execute($sql);
    }

    public function down(){
        $sql = "
            BEGIN;

            SELECT fc_startsession();
        
            ALTER TABLE cfpatriinstituicao 
                DROP COLUMN t59_termodeguarda;

            ALTER TABLE bensguarda
                DROP COLUMN t21_representante,
                DROP COLUMN t21_cpf;
        
            COMMIT;
        ";
        $this->execute($sql);
    }
}
