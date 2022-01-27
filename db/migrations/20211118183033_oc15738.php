<?php

use Classes\PostgresMigration;

class Oc15738 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        -- ADICIONA CAMPO A TABELA LOTE
        ALTER TABLE cadastro.lote ADD COLUMN j34_histortestadaint text;

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 FROM db_syscampo), 'j34_histortestadaint','text ','Histórico - Testadas Internas','','Histórico - Testadas Internas',500,'t','t','f',0,'text','Histórico - Testadas Internas');
        
        INSERT INTO db_sysarqcamp VALUES (19, (SELECT codcam FROM db_syscampo WHERE nomecam = 'j34_histortestadaint'), 12, 0);
        
        COMMIT;        

SQL;
        $this->execute($sql);
    }

}
