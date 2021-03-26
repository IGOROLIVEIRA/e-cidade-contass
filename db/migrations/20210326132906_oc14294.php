<?php

use Phinx\Migration\AbstractMigration;

class Oc14294 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            BEGIN;
            SELECT fc_startsession();

            INSERT INTO db_syscampo
            VALUES (
                (SELECT max(codcam) + 1 FROM db_syscampo), 'e30_lqddataserv', 'bool', 'Permite liquidação com data superior a data do servidor',
                'f', 'Liquidação c/ data superior ao servidor', 1, FALSE, FALSE, FALSE, 5, 'text', 'Conta única FUNDEB');

            INSERT INTO db_sysarqcamp
            VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empparametro'),
                (SELECT codcam FROM db_syscampo WHERE nomecam = 'e30_lqddataserv'),
                (SELECT max(seqarq) + 1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empparametro')), 0);

            ALTER TABLE empparametro ADD COLUMN e30_lqddataserv boolean DEFAULT false;

            COMMIT;";

        $this->execute($sql);
    }
}
