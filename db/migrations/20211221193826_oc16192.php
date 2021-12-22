<?php

use Phinx\Migration\AbstractMigration;

class Oc16192 extends AbstractMigration
{


        public function up()
        {

                $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        ALTER TABLE orcprojeto ADD COLUMN o39_justi varchar(500);

        INSERT INTO db_syscampo
                ( codcam,nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
        VALUES
                ((select max(codcam)+1 from db_syscampo),'o39_justi', 'varchar(500)', 'Justificativa', '0', 'Justificativa', 500, false, false, false, 0, 'text', 'Justificativa');
       
        INSERT INTO db_sysarqcamp 
                (codarq, codcam, seqarq, codsequencia) 
        VALUES 
                (('969'), (select codcam from db_syscampo where nomecam = 'o39_justi'), 14, 0);       


        COMMIT;

SQL;
                $this->execute($sql);
        }
}
