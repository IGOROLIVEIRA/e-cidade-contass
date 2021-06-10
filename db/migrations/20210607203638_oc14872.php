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

        -- ADICIONA CAMPO DA CONTA PAGADORA A ORDEM
        ALTER TABLE pagordem ADD COLUMN e50_contapag INTEGER;

        ALTER TABLE pagordem ADD CONSTRAINT empagetipo_conta_fk FOREIGN KEY (e50_contapag) REFERENCES empagetipo (e83_codtipo);

        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'e50_contapag','int4','Conta Pagadora','','Conta Pagadora',11,false,false,false,0,'int4','Conta Pagadora');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT codarq FROM db_sysarquivo where nomearq = 'pagordem' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'e50_contapag'), 8, 0);

        COMMIT;

SQL;
        $this->execute($sql);
    }

}