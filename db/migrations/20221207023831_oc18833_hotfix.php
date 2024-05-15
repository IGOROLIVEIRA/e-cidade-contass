<?php

use Phinx\Migration\AbstractMigration;

class Oc18833Hotfix extends AbstractMigration
{
    public function up()
    {
        $sql = "
        select fc_startsession();

        begin;

        alter table transfescolafora add column ed104_c_concletapa char(1);
        
        insert into db_syscampo values ((select max(codcam)+1 from db_syscampo),'ed104_c_concletapa', 'char(1)', 'Aluno concluindo etapa',null,'Aluno concluindo etapa',1,'f','t','f',0,'text','Aluno concluindo etapa');


        commit;
    
    ";

    $this->execute($sql);
    }
}
