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

        ALTER TABLE vinculopcaspmsc 
            DROP CONSTRAINT vinculopcaspmsc_c210_pcaspestrut_c210_mscestrut,
            ADD CONSTRAINT vinculopcaspmsc_c210_pcaspestrut_c210_mscestrut_c210_anousu PRIMARY KEY (c210_pcaspestrut, c210_mscestrut, c210_anousu);

        DROP INDEX vinculopcaspmsc_index;
    
        CREATE UNIQUE INDEX vinculopcaspmsc_index ON vinculopcaspmsc(c210_pcaspestrut, c210_mscestrut, c210_anousu);
        
        ALTER TABLE elemdespmsc ADD COLUMN c211_anousu integer NOT NULL DEFAULT 0;

        ALTER TABLE elemdespmsc 
            DROP CONSTRAINT elemdespmsc_c211_elemdespestrut_c211_mscestrut,
            ADD CONSTRAINT elemdespmsc_c211_elemdespestrut_c211_mscestrut_c211_anousu PRIMARY KEY (c211_elemdespestrut, c211_mscestrut, c211_anousu);

        DROP INDEX elemdespmsc_index;
    
        CREATE UNIQUE INDEX elemdespmsc_index ON elemdespmsc(c211_elemdespestrut,c211_mscestrut,c211_anousu);
        
        ALTER TABLE natdespmsc ADD COLUMN c212_anousu integer NOT NULL DEFAULT 0;
        
        ALTER TABLE natdespmsc 
            DROP CONSTRAINT natdespmsc_c212_natdespestrut_c212_mscestrut,
            ADD CONSTRAINT natdespmsc_c212_natdespestrut_c212_mscestrut_c212_anousu PRIMARY KEY (c212_natdespestrut, c212_mscestrut, c212_anousu);

        DROP INDEX natdespmsc_index;
    
        CREATE UNIQUE INDEX natdespmsc_index ON natdespmsc(c212_natdespestrut, c212_mscestrut, c212_anousu);
        
        -- ATUALIZA VALORES
        UPDATE vinculopcaspmsc SET c210_anousu = '2019';
        
        UPDATE elemdespmsc SET c211_anousu = '2019';

        UPDATE natdespmsc SET c212_anousu = '2019';     
        
        -- ADICIONA ITEM A VIRADA
        INSERT INTO db_viradacaditem VALUES((SELECT MAX(c33_sequencial)+1 FROM db_viradacaditem), 'DE/PARA MSC, SIOPE, SIOPS');

        -- REALIZA VIRADA DOS ITENS 2019 PARA 2020
        
        SELECT fc_duplica_exercicio('vinculopcaspmsc', 'c210_anousu', 2019, 2020,null);
        
        SELECT fc_duplica_exercicio('elemdespmsc', 'c211_anousu', 2019, 2020,null);
        
        SELECT fc_duplica_exercicio('natdespmsc', 'c212_anousu', 2019, 2020,null);

        COMMIT;

SQL;
        $this->execute($sql);
    }

}