<?php

use Classes\PostgresMigration;

class Oc13832 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        INSERT INTO orcsuplemtipo
            SELECT 1020 AS o48_tiposup,
                    'ATO ADMINISTRATIVO DE ALTERACAO DO ELEMENTO DE DESPESA' AS o48_descr,
                    7 AS o48_coddocsup,
                    51 AS o48_coddocred,
                    0 AS o48_arrecadmaior,
                    'f' AS o48_superavit,
                    7 AS o48_suplcreditoespecial,
                    51 AS o48_redcreditoespecial;

        INSERT INTO orcsuplemtipo
            SELECT 1021 AS o48_tiposup,
                    'ATO ADMINISTRATIVO DE ALTERACAO DE MODALIDADE DE APLICACAO' AS o48_descr,
                    7 AS o48_coddocsup,
                    51 AS o48_coddocred,
                    0 AS o48_arrecadmaior,
                    'f' AS o48_superavit,
                    7 AS o48_suplcreditoespecial,
                    51 AS o48_redcreditoespecial;

        INSERT INTO orcsuplemtipo
            SELECT 1022 AS o48_tiposup,
                    'ATO ADMINISTRATIVO DE ALTERACAO DE FUNÇÃO E SUBFUNCAO' AS o48_descr,
                    7 AS o48_coddocsup,
                    51 AS o48_coddocred,
                    0 AS o48_arrecadmaior,
                    'f' AS o48_superavit,
                    7 AS o48_suplcreditoespecial,
                    51 AS o48_redcreditoespecial;

        INSERT INTO orcsuplemtipo
            SELECT 1023 AS o48_tiposup,
                    'SUPLEMENTACAO DE CREDITOS ESPECIAIS POR REDUCAO' AS o48_descr,
                    56 AS o48_coddocsup,
                    57 AS o48_coddocred,
                    0 AS o48_arrecadmaior,
                    'f' AS o48_superavit,
                    56 AS o48_suplcreditoespecial,
                    57 AS o48_redcreditoespecial;

        INSERT INTO orcsuplemtipo
            SELECT 1024 AS o48_tiposup,
                    'SUPLEMENTACAO DE CREDITOS ESPECIAIS POR SUPERAVIT FINANCEIRO' AS o48_descr,
                    60 AS o48_coddocsup,
                    0 AS o48_coddocred,
                    0 AS o48_arrecadmaior,
                    't' AS o48_superavit,
                    60 AS o48_suplcreditoespecial,
                    0 AS o48_redcreditoespecial;

        INSERT INTO orcsuplemtipo
            SELECT 1025 AS o48_tiposup,
                    'SUPLEMENTACAO DE CREDITO ESPECIAL ARRECADACAO A MAIOR' AS o48_descr,
                    61 AS o48_coddocsup,
                    0 AS o48_coddocred,
                    58 AS o48_arrecadmaior,
                    'f' AS o48_superavit,
                    61 AS o48_suplcreditoespecial,
                    0 AS o48_redcreditoespecial;                    

        UPDATE db_itensmenu
        SET descricao = 'Lei de Alteração Orçamentária',
            help = 'Lei de Alteração Orçamentária',
            desctec = 'Lei de Alteração Orçamentária'
        WHERE descricao = 'Projeto de Lei';

        UPDATE db_syscampo 
        SET descricao = 'Data de Sanção da Lei',
            rotulo = 'Data de Sanção da Lei',
            rotulorel = 'Data de Sanção da Lei'
        WHERE nomecam = 'o138_data';

        UPDATE db_syscampo 
        SET descricao = 'Texto da Lei',
            rotulo = 'Texto da Lei',
            rotulorel = 'Texto da Lei'
        WHERE nomecam = 'o138_textolei';

        COMMIT;

SQL;
    $this->execute($sql);
 	}

}