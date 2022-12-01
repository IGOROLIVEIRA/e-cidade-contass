<?php

use Phinx\Migration\AbstractMigration;

class Oc18833 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            select fc_startsession();

            begin;

            alter table obstransferencia add column ed283_c_concletapa char(1) not null;
            
            insert into db_syscampo values ((select max(codcam)+1 from db_syscampo),'ed283_c_concletapa', 'char(1)', 'Aluno concluindo etapa',null,'Aluno concluindo etapa',1,'f','t','f',0,'text','Aluno concluindo etapa');

            update obstransferencia set ed283_c_concletapa = 1;

            commit;
        
        ";

        $this->execute($sql);
    }
}
