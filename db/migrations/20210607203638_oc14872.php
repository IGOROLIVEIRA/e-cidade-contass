<?php

use Classes\PostgresMigration;

class Oc14872 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        -- ADICIONA CAMPO A TABELA PARAMETROS DO EMPENHO
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 FROM db_syscampo), 'e30_obrigactapagliq',  'bool', 'Obriga Conta Pagadora na Liquidação', 'f', 'Obriga Conta Pagadora na Liquidação', 1, 'f', 'f', 'f', 5, 'text', 'Obriga Conta Pagadora na Liquidação');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empparametro'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'e30_obrigactapagliq'), 22, 0);

        ALTER TABLE empparametro ADD COLUMN e30_obrigactapagliq boolean DEFAULT 'f';

        COMMIT;

SQL;
        $this->execute($sql);
    }

}