<?php

use Phinx\Migration\AbstractMigration;

class Oc21481 extends AbstractMigration
{
    public function up()
    {
        $sSql =
        "
        BEGIN;

        ALTER TABLE acordo ADD COLUMN ac16_vigenciaindeterminada bool DEFAULT FALSE;
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'ac16_vigenciaindeterminada','bool','Vigência Indeterminada','', 'Vigência Indeterminada',11,false, false, false, 1, 'bool', 'Vigência Indeterminada');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'acordo'), (select codcam from db_syscampo where nomecam = 'ac16_vigenciaindeterminada'), 28, 0);

        ALTER TABLE acordoposicao ADD COLUMN ac26_criterioreajuste int;
        ALTER TABLE acordoposicao ADD COLUMN ac26_descricaoreajuste varchar (300);

        COMMIT;

        ";

        $this->execute($sSql);
    }
}
