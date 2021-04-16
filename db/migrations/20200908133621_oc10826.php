<?php

use Classes\PostgresMigration;

class Oc10826 extends PostgresMigration
{

  public function up()
  {
    $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c202_mesreferenciasicom', 'int8', 'Mês de Referência SICOM', 0, 'Mês de Referência SICOM', 10, FALSE, FALSE, FALSE, 1, 'text', 'Mês de Referência SICOM');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='consexecucaoorc' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c202_mesreferenciasicom'), 13, 0);

        ALTER TABLE consexecucaoorc ADD COLUMN c202_mesreferenciasicom bigint NOT NULL DEFAULT 0;

        UPDATE consexecucaoorc SET c202_mesreferenciasicom = c202_mescompetencia;

        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c201_codfontrecursos', 'int4', 'Fonte de Recursos', 0, 'Fonte de Recursos', 3, FALSE, FALSE, FALSE, 1, 'text', 'Fonte de Recursos');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='consvalorestransf' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c201_codfontrecursos'), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'consvalorestransf')), 0);

        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c202_codfontrecursos', 'int4', 'Fonte de Recursos', 0, 'Fonte de Recursos', 3, FALSE, FALSE, FALSE, 1, 'text', 'Fonte de Recursos');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='consexecucaoorc' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c202_codfontrecursos'), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'consexecucaoorc')), 0);

        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c203_codfontrecursos', 'int4', 'Fonte de Recursos', 0, 'Fonte de Recursos', 3, FALSE, FALSE, FALSE, 1, 'text', 'Fonte de Recursos');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq='consdispcaixaano' LIMIT 1), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c203_codfontrecursos'), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq = (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'consdispcaixaano')), 0);

        COMMIT;

SQL;
    $this->execute($sql);
  }

}