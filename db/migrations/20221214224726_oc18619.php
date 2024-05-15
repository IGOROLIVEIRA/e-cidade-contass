<?php

use Phinx\Migration\AbstractMigration;

class Oc18619 extends AbstractMigration
{
    
    public function up()
    {
        $nomeCampo = "k29_liquidacaodataanterior";
        $descricaoCampo = "Liquidação c/ data anterior a última";
        $sql = "
            BEGIN;
                SELECT fc_startsession();
                
                -- Insere novo campo
                INSERT INTO db_syscampo
                VALUES (
                    (SELECT max(codcam) + 1 FROM db_syscampo), '{$nomeCampo}', 'bool', '{$descricaoCampo}',
                    'f', '{$descricaoCampo}', 1, FALSE, FALSE, FALSE, 5, 'select', '{$descricaoCampo}');

                INSERT INTO db_sysarqcamp
                VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'caiparametro'),
                    (SELECT codcam FROM db_syscampo WHERE nomecam = '{$nomeCampo}'),
                    (SELECT max(seqarq) + 1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'caiparametro')), 0);

                ALTER TABLE caiparametro ADD COLUMN {$nomeCampo} bool DEFAULT NULL;
            COMMIT";
        $this->execute($sql);
    }
}
