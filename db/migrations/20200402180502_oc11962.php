<?php

use Classes\PostgresMigration;

class Oc11962 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();
        
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'De/Para Pcasp Caspweb', 'De/Para Pcasp Caspweb', '', 1, 1, 'De/Para Pcasp Caspweb', 't');
        
        INSERT INTO db_menu VALUES (29, (SELECT max(id_item) from db_itensmenu), (SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = 29 AND modulo = 209), 209);
        
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Inclusão', '', 'con1_concaspweb001.php', 1, 1, '', 't');
        
        INSERT INTO db_menu VALUES ((SELECT max(id_item)-1 FROM db_itensmenu), (SELECT max(id_item) from db_itensmenu), 1, (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Contabilidade'));
        
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Exclusão', '', 'con1_concaspweb003.php', 1, 1, '', 't');
        
        INSERT INTO db_menu VALUES ((SELECT max(id_item)-2 FROM db_itensmenu), (SELECT max(id_item) from db_itensmenu), 2, (SELECT id_item FROM db_modulos WHERE nome_modulo = 'Contabilidade'));
        
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Gerar Balancete Caspweb', 'Gerar Balancete Caspweb', 'con4_balancetecaspweb.php', 1, 1, 'Gerar Balancete Caspweb', 't');
        
        INSERT INTO db_menu VALUES (3332, (SELECT max(id_item) from db_itensmenu), (SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = 3332 AND modulo = 209), 209);
        
        -- CRIA TABELA VINCULO CASPWEB
        
        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES ((select max(codarq)+1 from db_sysarquivo), 'vinculocaspweb', 'Vinculo Caspweb', 'c232 ', '2020-04-02', 'Vinculo Caspweb', 0, false, false, false, false);
         
        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod VALUES (32, (select max(codarq) from db_sysarquivo));
         
        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'c232_estrutecidade', 	'varchar(15) ', 'E-Cidade',	'', 'E-Cidade', 15, false, true, false, 0, 'text', 'E-Cidade');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'c232_estrutcaspweb',	'varchar(15)', 	'Caspweb', 	'', 'Caspweb', 	15, false, true, false, 0, 'text', 'Caspweb');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'c232_anousu', 		    'int4',         'Ano', 	    '', 'Ano',       4, false, true, false, 0, 'text', 'Ano');
         
        -- INSERE db_sysarqcamp
        INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c232_estrutecidade'), 1, 0);
        INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c232_estrutcaspweb'), 2, 0);
        INSERT INTO db_sysarqcamp VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'c232_anousu'), 3, 0);
         
        --DROP TABLE:
        DROP TABLE IF EXISTS vinculocaspweb CASCADE;
        
        -- CRIA TABELA
        CREATE TABLE vinculocaspweb(
            c232_estrutecidade varchar(15) NOT NULL , 
            c232_estrutcaspweb varchar(15) NOT NULL, 
            c232_anousu integer NOT NULL DEFAULT 0 
            );
        
        CREATE UNIQUE INDEX vinculocaspweb_index ON vinculocaspweb(c232_estrutecidade,c232_estrutcaspweb,c232_anousu);

        -- Atualiza descrição do item de virada
        UPDATE db_viradacaditem SET c33_descricao = 'DE/PARA MSC, SIOPE, SIOPS, CASPWEB' WHERE c33_sequencial = 34;
        
        COMMIT;


SQL;
        $this->execute($sql);
    }

}