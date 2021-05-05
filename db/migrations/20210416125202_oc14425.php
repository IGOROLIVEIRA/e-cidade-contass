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

                CREATE TABLE caixa.conciliacaobancaria (k171_conta int8, k171_saldo float4, k171_data date);
                ALTER TABLE caixa.conciliacaobancaria OWNER TO dbportal;

                CREATE TABLE caixa.conciliacaobancarialancamento (k172_conta int8,k172_data date,k172_numcgm int8,k172_coddoc int8,k172_codigo varchar(255),k172_valor float8,k172_dataconciliacao date);
                ALTER TABLE caixa.conciliacaobancarialancamento OWNER TO dbportal;

                INSERT INTO db_syscampo
                VALUES (
                    (SELECT max(codcam) + 1 FROM db_syscampo), 'k171_conta', 'text', 'Conta Bancária Conciliada',
                    NULL, 'Conta Bancária Conciliada', 10, TRUE, FALSE, FALSE, 1, 'text', 'Conta Bancária Conciliada');

                INSERT INTO db_sysarqcamp
                VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'conciliacaobancaria'),
                    (SELECT codcam FROM db_syscampo WHERE nomecam = 'k171_conta'),
                    (SELECT max(seqarq) + 1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'conciliacaobancaria')), 0);

                INSERT INTO db_syscampo
                VALUES (
                    (SELECT max(codcam) + 1 FROM db_syscampo), 'k171_saldo', 'float8', 'Saldo Conciliado',
                    NULL, 'Saldo Conciliado', 10, TRUE, FALSE, FALSE, 1, 'text', 'Saldo Conciliado');

                INSERT INTO db_sysarqcamp
                VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'conciliacaobancaria'),
                    (SELECT codcam FROM db_syscampo WHERE nomecam = 'k171_saldo'),
                    (SELECT max(seqarq) + 1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'conciliacaobancaria')), 0);

                INSERT INTO db_syscampo
                VALUES (
                    (SELECT max(codcam) + 1 FROM db_syscampo), 'k171_data', 'date', 'Data da Conciliação',
                    NULL, 'Data da Conciliação', 10, TRUE, FALSE, FALSE, 1, 'text', 'Data da Conciliação');

                INSERT INTO db_sysarqcamp
                    VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'conciliacaobancaria'),
                    (SELECT codcam FROM db_syscampo WHERE nomecam = 'k171_data'),
                    (SELECT max(seqarq) + 1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'conciliacaobancaria')), 0);
            COMMIT;";

        $this->execute($sql);
    }
}
