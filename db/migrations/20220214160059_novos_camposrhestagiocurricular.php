<?php

use Phinx\Migration\AbstractMigration;

class NovosCamposrhestagiocurricular extends AbstractMigration
{

    public function up()
    {
        $sql = "
        begin;
        
        alter table rhestagiocurricular ADD COLUMN h83_naturezaestagio varchar(1);
        alter table rhestagiocurricular ADD COLUMN h83_nivelestagio int8;
        alter table rhestagiocurricular ADD COLUMN h83_numapoliceseguro int8;
        
        commit;
        ";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        begin;
        
        alter table rhestagiocurricular DROP COLUMN h83_naturezaestagio;
        alter table rhestagiocurricular DROP COLUMN h83_nivelestagio;
        alter table rhestagiocurricular DROP COLUMN h83_numapoliceseguro;
        
        commit;
        ";
        $this->execute($sql);
    }
}
