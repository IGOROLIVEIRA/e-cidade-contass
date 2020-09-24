<?php

use Classes\PostgresMigration;

class Oc13242 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 FROM db_syscampo), 'e30_prazoentordcompra',  'int4', 'Dias de prazo para entrada da ordem de c', '0', 'Dias de prazo para entrada da ordem de compra', 2, 'f', 'f', 'f', 1, 'text', 'Dias de prazo paraprazoentrordcomp de c');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empparametro'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'e30_prazoentordcompra'), 23, 0);

        ALTER TABLE empparametro ADD COLUMN e30_prazoentordcompra integer DEFAULT 30;

        COMMIT;

SQL;
        $this->execute($sql);
    }

}