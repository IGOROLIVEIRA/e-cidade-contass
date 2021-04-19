<?php

use Phinx\Migration\AbstractMigration;

class Oc14425 extends AbstractMigration
{
    public function up()
    {
        $nomeCampo = "k29_conciliacaobancaria";
        $sql = "
            BEGIN;
                SELECT fc_startsession();
                UPDATE db_itensmenu SET itemativo = 2 WHERE id_item IN (2000029, 147883);
                UPDATE db_permissao SET permissaoativa = 2 WHERE id_item IN (2000029, 147883) AND anousu >= 2021;

                INSERT INTO db_syscampo
                VALUES (
                    (SELECT max(codcam) + 1 FROM db_syscampo), '{$nomeCampo}', 'date', 'Implantação da Conciliação Bancária',
                    NULL, 'Implantação da Conciliação Bancária', 10, TRUE, FALSE, FALSE, 1, 'text', 'Implantação da Conciliação Bancária');

                INSERT INTO db_sysarqcamp
                VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'caiparametro'),
                    (SELECT codcam FROM db_syscampo WHERE nomecam = '{$nomeCampo}'),
                    (SELECT max(seqarq) + 1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'caiparametro')), 0);

                ALTER TABLE caiparametro ADD COLUMN {$nomeCampo} date DEFAULT NULL;
            COMMIT;";

        $this->execute($sql);
    }
}
