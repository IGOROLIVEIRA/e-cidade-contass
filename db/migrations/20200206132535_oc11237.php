<?php

use Classes\PostgresMigration;

class Oc11237 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        -- CRIA COLUNA ANO NAS TABELAS
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c210_anousu', 'int4', 'Ano', '', 'Ano', 4, false, true, false, 0, 'text', 'Ano');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'vinculopcaspmsc'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c210_anousu'), 3, 0);

        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c211_anousu', 'int4', 'Ano', '', 'Ano', 4, false, true, false, 0, 'text', 'Ano');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'elemdespmsc'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c211_anousu'), 3, 0);

        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c212_anousu', 'int4', 'Ano', '', 'Ano', 4, false, true, false, 0, 'text', 'Ano');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'natdespmsc'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'c212_anousu'), 3, 0);

        -- ALTERA ESTRUTURA DAS TABELAS
        ALTER TABLE vinculopcaspmsc ADD COLUMN c210_anousu integer NOT NULL DEFAULT 0;
        
        ALTER TABLE elemdespmsc ADD COLUMN c211_anousu integer NOT NULL DEFAULT 0;
        
        ALTER TABLE natdespmsc ADD COLUMN c212_anousu integer NOT NULL DEFAULT 0;
        
        -- ATUALIZA VALORES
        UPDATE vinculopcaspmsc SET c210_anousu = '2019';
        
        UPDATE elemdespmsc SET c211_anousu = '2019';

        UPDATE natdespmsc SET c212_anousu = '2019';     
        
        -- ADICIONA ITEM A VIRADA
        INSERT INTO db_viradacaditem VALUES((SELECT MAX(c33_sequencial)+1 FROM db_viradacaditem), 'DE/PARA MSC, SIOPE, SIOPS');

        COMMIT;

SQL;
        $this->execute($sql);
    }

}