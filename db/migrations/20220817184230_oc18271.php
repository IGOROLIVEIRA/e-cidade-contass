<?php

use Phinx\Migration\AbstractMigration;

class Oc18271 extends AbstractMigration
{
    public function up()
    {
        $sql = "begin;

        select fc_startsession();

        insert into db_syscampo values ((select max(codcam)+1 from db_syscampo),'pc01_instit','int4','Instituição',0,'Instituição',4,'f','f','f',1,'text','Instituição');
        insert into db_syscampo values ((select max(codcam)+1 from db_syscampo),'pc01_codmaterant','int4','Cod Mat Ant',0,'Cod Mat Ant',4,'f','f','f',1,'text','Cod Mat Ant');
       
        ";

        $this->execute($sql);
    }
}
