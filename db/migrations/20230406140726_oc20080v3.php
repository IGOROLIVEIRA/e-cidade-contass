<?php

use Phinx\Migration\AbstractMigration;

class Oc20080v3 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

        ALTER TABLE linhatransporte ADD tre06_datalimite date NULL;
        ALTER TABLE linhatransporte ADD tre06_kmidaevolta real NULL;
        ALTER TABLE linhatransporte ADD tre06_valorkm real NULL;
        ALTER TABLE linhatransporte ADD tre06_numcgm int8 NULL;

        ALTER TABLE linhatransporte ALTER COLUMN tre06_nome TYPE varchar(250) USING tre06_nome::varchar;

        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Lançar Frequência', 'Menu Frequência', 'tra1_linhafrequencia001.php', 1, 1, 'Menu Frequência', 't');

        INSERT INTO db_menu VALUES (32, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = 32 and modulo = 7147), 7147); 

        INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Faturamento das Linhas', 'Menu Faturamento das Linhas', 'tra1_faturamentolinhas011.php', 1, 1, 'Menu Faturamento das Linhas', 't');

        INSERT INTO db_menu VALUES (30, (select max(id_item) from db_itensmenu), (select max(menusequencia)+1 from db_menu where id_item = 30 and modulo = 7147), 7147);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
                VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'tre06_datalimite', 'date', 'Data limite', 0, 'Data limite', 1, FALSE, FALSE, FALSE, 1, 'text', 'Data limite,');

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
                VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'tre06_kmidaevolta', 'int8', 'KM Ida e Volta (Diário)', 0, 'KM Ida e Volta (Diário)', 1, FALSE, FALSE, FALSE, 1, 'text', 'KM Ida e Volta (Diário)');

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
                VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'tre06_valorkm', 'int8', 'Valor do KM', 0, 'Valor do KM', 1, FALSE, FALSE, FALSE, 1, 'text', 'Valor do KM');
                
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
                VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'tre06_numcgm', 'int8', 'CGM', 0, 'CGM', 1, FALSE, FALSE, FALSE, 1, 'text', 'CGM');        
                
        CREATE TABLE IF NOT EXISTS transporteescolar.linhafrequencia (
            tre13_sequencial int8 NOT NULL,
            tre13_linhatransporte int8 NOT NULL,
            tre13_data date NOT NULL,
            CONSTRAINT linhafrequencia_pkey PRIMARY KEY (tre13_sequencial),
            CONSTRAINT linhafrequencia_tre13_linhatransporte_fkey FOREIGN KEY (tre13_linhatransporte) REFERENCES transporteescolar.linhatransporte(tre06_sequencial)
        );

        DROP SEQUENCE IF EXISTS linhafrequencia_tre13_sequencial_seq;
        CREATE SEQUENCE linhafrequencia_tre13_sequencial_seq
            START WITH 1
            INCREMENT BY 1
            NO MINVALUE
            NO MAXVALUE
            CACHE 1;

    COMMIT;

SQL;
        $this->execute($sql);
    } 
}