<?php

use Phinx\Migration\AbstractMigration;

class Oc20291v3 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

        UPDATE configuracoes.db_syscampo
        SET descricao='Data inicio participação',rotulo='Data inicio participação', rotulorel='Data inicio participação'
        WHERE nomecam = 'c215_datainicioparticipacao';

        UPDATE configuracoes.db_syscampo
        SET descricao='Data fim participação', rotulo='Data fim participação', rotulorel='Data fim participação'
        WHERE nomecam = 'c215_datafimparticipacao';

    COMMIT;

SQL;
        $this->execute($sql);
    } 
}