<?php

use Phinx\Migration\AbstractMigration;

class Oc21541 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        select fc_startsession();
        
        begin;
        
        alter table rhfuncao add column rh37_dedicacaoexc bool default 'f';

        insert into db_syscampo values ((select max(codcam)+1 from db_syscampo),'rh37_dedicacaoexc','bool','Dedicação Exclusiva','false','Dedicação Exclusiva',1,'t','f','f',5,'text','Dedicação Exclusiva');
        
        commit;";

        $this->execute($sql);
    }
}
