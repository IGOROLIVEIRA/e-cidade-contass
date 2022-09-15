<?php

use Phinx\Migration\AbstractMigration;

class Oc18356 extends AbstractMigration
{
    public function up()
    {
        $sql="BEGIN;

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'ac35_justificativa', 'text' ,'Justificativa', '', 'Justificativa', 200, false, false, false, 0, 'text', 'Justificativa');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'acordoposicaoaditamento'), (select codcam from db_syscampo where nomecam = 'ac35_justificativa'), 9, 0);

        ALTER TABLE acordoposicaoaditamento ADD COLUMN ac35_justificativa text;



        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'si03_justificativa', 'text' ,'Justificativa', '', 'Justificativa', 200, false, false, false, 0, 'text', 'Justificativa');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'apostilamento'), (select codcam from db_syscampo where nomecam = 'si03_justificativa'), 16, 0);

        ALTER TABLE apostilamento ADD COLUMN si03_justificativa text;


        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'ac10_justificativa', 'text' ,'Justificativa', '', 'Justificativa', 200, false, false, false, 0, 'text', 'Justificativa');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'acordomovimentacao'), (select codcam from db_syscampo where nomecam = 'ac10_justificativa'), 9, 0);

        ALTER TABLE acordomovimentacao ADD COLUMN ac10_justificativa text;

        COMMIT;";

        $this->execute($sql);

    }
}
