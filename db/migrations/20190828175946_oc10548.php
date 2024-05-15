<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc10548 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();
        
        --Inserção dos campo no dicionário
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'o55_tipoensino', 'int4', 'Tipo de Ensino - Siope', '', 'Tipo de Ensino - Siope', 1, FALSE, FALSE, FALSE, 1, 'text', 'Tipo de Ensino - Siope');

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
        VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'o55_tipopasta', 'int4', 'Tipo de Pasta - Siope', '', 'Tipo de Pasta - Siope', 1, FALSE, FALSE, FALSE, 1, 'text', 'Tipo de Pasta - Siope');
        
        -- Vínculo tabelas com campo
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='orcprojativ' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'o55_tipoensino'), 14, 0);

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia)
        VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='orcprojativ' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'o55_tipopasta'), 15, 0);

        -- Alter table
        ALTER TABLE orcprojativ ADD COLUMN o55_tipoensino integer;

        ALTER TABLE orcprojativ ADD COLUMN o55_tipopasta integer;

        -- Atualiza valores dos campos
        UPDATE orcprojativ SET o55_tipoensino = 7;

        UPDATE orcprojativ SET o55_tipopasta = 3;

        -- Altera colunas para not null
        ALTER TABLE orcprojativ ALTER COLUMN o55_tipoensino SET NOT NULL;
        
        ALTER TABLE orcprojativ ALTER COLUMN o55_tipopasta SET NOT NULL;        

        COMMIT;

SQL;
        $this->execute($sql);
    }

}


