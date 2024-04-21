<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc11509 extends PostgresMigration
{
    public function up()
    {
        $sql = "INSERT INTO licpregao VALUES (0,'1900-01-01','1900-01-01',1,0,0,1)";
        $this->execute($sql);
        $refTable = $this->table('liclicita',array('schema' => 'licitacao'));
        $refTable->addForeignKey('l20_equipepregao','public.licpregao','l45_sequencial',array('constraint' => 'liclicita_licpregao_fk'))
                 ->update();
    }

    public function donw()
    {
        
    }
}
