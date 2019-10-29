<?php

use Classes\PostgresMigration;

class Oc10927 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;

        SELECT fc_startsession();
        
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'c222_previdencia', 'bool', 'Previdência Sim/Não', 'f', 'Previdência', 1, false, false, false, 5, 'text', 'Previdência');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'naturdessiope'), (select codcam from db_syscampo where nomecam = 'c222_previdencia'), 4, 0);

        ALTER TABLE naturdessiope ADD COLUMN c222_previdencia boolean DEFAULT false;

        UPDATE naturdessiope SET c222_previdencia = 'f';

        COMMIT;

SQL;
        $this->execute($sql);
    }

}
