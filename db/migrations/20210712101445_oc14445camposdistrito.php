<?php

use Classes\PostgresMigration;

class Oc14445camposdistrito extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        -- ADICIONA CAMPO A TABELA LOTE
        ALTER TABLE cadastro.lote ADD COLUMN j34_distrito integer;
        ALTER TABLE cadastro.lote ALTER COLUMN j34_distrito SET DEFAULT 1;

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 FROM db_syscampo), 'j34_distrito','int8 ','Identificação do Distrito onde o lote está localizado,','0','Distrito',4,'f','f','f',1,'text','Distrito');
        
        INSERT INTO db_sysarqcamp VALUES (19, (SELECT codcam FROM db_syscampo WHERE nomecam = 'j34_distrito'), 12, 0);
        
        -- ADICIONA CAMPO A TABELA IPTUBASE
        ALTER TABLE cadastro.iptubase ADD COLUMN j01_unidade character varying(10);

        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'j01_unidade','varchar(10)','Identificação da Unidade onde a matrícula está localizada','','Unidade',10,'f','t','f',0,'text','Unidade');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (27, (SELECT codcam FROM db_syscampo WHERE nomecam = 'j01_unidade'), 7, 0);

        -- ADICIONA CAMPO A TABELA DB_CONFIG
        ALTER TABLE configuracoes.db_config ADD COLUMN db21_usadistritounidade boolean;
        UPDATE configuracoes.db_config SET db21_usadistritounidade = false;

        COMMIT;        

SQL;
        $this->execute($sql);
    }

}
