<?php

use Classes\PostgresMigration;

class Oc13621 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;
        SELECT fc_startsession();

        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si53_instit','int4','Instituição','','Instituição',11,false,false,false,1,'int4','Instituição');
        
        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'riscofiscal'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si53_instit'), 7, 0);

        UPDATE db_syscampo SET rotulo = 'Descrição do Risco' WHERE nomecam = 'si53_dscriscofiscal';

        UPDATE db_syscampo SET rotulo = 'Descrição da Providência' WHERE nomecam = 'si54_dscprovidencia';

        ALTER TABLE riscofiscal ALTER COLUMN si53_dscriscofiscal drop not null;
        
        ALTER TABLE riscofiscal ADD COLUMN si53_instit int4;

        COMMIT;        
SQL;
        $this->execute($sql);
    }
}
