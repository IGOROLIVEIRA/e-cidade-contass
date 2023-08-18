<?php

use Phinx\Migration\AbstractMigration;

class Oc20323hotfixv3 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

        ALTER TABLE conhist ADD c50_ativo bool DEFAULT TRUE;

        -- Insere novo campo
        INSERT INTO db_syscampo
            VALUES (
            (SELECT max(codcam) + 1 FROM db_syscampo), 'c50_ativo', 'bool', 'Ativo',
            'f', 'Ativo', 1, FALSE, FALSE, FALSE, 5, 'select', 'Ativo');

        INSERT INTO db_sysarqcamp
            VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'conhist'),
            (SELECT codcam FROM db_syscampo WHERE nomecam = 'c50_ativo'),
            (SELECT max(seqarq) + 1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'conhist')), 0);
    COMMIT;

SQL;
        $this->execute($sql);
    } 
}