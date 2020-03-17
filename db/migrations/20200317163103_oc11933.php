<?php

use Classes\PostgresMigration;

class Oc11933 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'e30_atestocontinterno',  'bool', 'Atesto do Controle Interno', 'f', 'Atesto do Controle Interno', 1, 'f', 'f', 'f', 5, 'text', 'Atesto do Controle Interno');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empparametro'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'e30_atestocontinterno'), 22, 0);

        ALTER TABLE empparametro ADD COLUMN e30_atestocontinterno boolean DEFAULT 'f';

        COMMIT;

SQL;
        $this->execute($sql);
    }

}