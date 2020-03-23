<?php

use Classes\PostgresMigration;

class Oc11933 extends PostgresMigration
{

    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        SELECT fc_startsession();

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 FROM db_syscampo), 'e30_atestocontinterno',  'bool', 'Atesto do Controle Interno', 'f', 'Atesto do Controle Interno', 1, 'f', 'f', 'f', 5, 'text', 'Atesto do Controle Interno');

        INSERT INTO db_sysarqcamp VALUES ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empparametro'), (SELECT codcam FROM db_syscampo WHERE nomecam = 'e30_atestocontinterno'), 22, 0);

        ALTER TABLE empparametro ADD COLUMN e30_atestocontinterno boolean DEFAULT 'f';

        INSERT INTO db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
            SELECT (SELECT max(id_item)+1 FROM db_itensmenu), 'Controle Interno', 'Controle Interno', '', 1, 1, 'Controle Interno', 't'
                WHERE NOT EXISTS ( 
                    SELECT 1 FROM db_itensmenu WHERE descricao='Controle Interno'
                );

        INSERT INTO db_sysmodulo VALUES((select max(codmod)+1 from db_sysmodulo),'Controle Interno','Controle Interno','2020-03-18','t');
        
        INSERT INTO db_modulos (id_item, nome_modulo, descr_modulo, imagem, temexerc, nome_manual)
            SELECT (SELECT id_item FROM db_itensmenu WHERE descricao='Controle Interno'), 'Controle Interno', 'Controle Interno', '', 't', 'controle_interno'
                WHERE NOT EXISTS (
                    SELECT 1 FROM db_modulos WHERE nome_modulo='Controle Interno'
                );
        
        INSERT INTO atendcadareamod (at26_sequencia, at26_codarea, at26_id_item)
	        SELECT (SELECT max(at26_sequencia)+1 FROM atendcadareamod), 2, (SELECT id_item FROM db_modulos WHERE nome_modulo='Controle Interno')
		        WHERE NOT EXISTS (
				    SELECT 1 FROM atendcadareamod WHERE at26_id_item = (SELECT id_item FROM db_modulos WHERE nome_modulo='Controle Interno')
			    );

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Procedimentos', 'Procedimentos', '', 1, 1, 'Procedimentos do módulo controle interno', 't');
        
        INSERT INTO db_menu VALUES ((SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno'), 
                                    (SELECT max(id_item) FROM db_itensmenu), 
                                    (SELECT CASE
                                        WHEN (SELECT count(*) FROM db_menu WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')) = 0 THEN 1 
                                        ELSE (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = (SELECT id_item FROM db_itensmenu WHERE descricao = 'Controle Interno')) 
                                    END), 
                                    (select id_item FROM db_modulos where nome_modulo = 'Controle Interno'));
        
        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Atesto do Controle Interno', 'Atesto do Controle Interno', 'cin4_atestocontint.php', 1, 1, 'Atesto do Controle Interno', 't');
        
        INSERT INTO db_menu VALUES ((SELECT max(id_item) from db_itensmenu)-1, (SELECT max(id_item) from db_itensmenu), 1, (select id_item FROM db_modulos where nome_modulo = 'Controle Interno'));

        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'empautorizliberado','Autorização de Empenho Liberado','e232','2021-03-23','Autorização de Empenho Liberado',0,'f','f','f','f');
        
        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT id_item FROM db_modulos WHERE nome_modulo='Controle Interno'), (SELECT max(codarq) FROM db_sysarquivo));
        
        -- INSERE db_syscampo
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'e232_sequencial'	 		,'int4' 	,'Sequencial'		,'', 'Sequencial'		 ,11	,false, false, false, 1, 'int4', 'Sequencial');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'e232_autori'	 			,'int4' 	,'Cod Autorização' 	,'', 'Cod Autorização'	 ,11	,false, false, false, 1, 'int4', 'Cod Autorização');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'e232_id_usuario'			,'int4' 	,'Cod Usuário'		,'', 'Cod Usuário'		 ,11	,false, false, false, 1, 'int4', 'Data Lançamento');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'e232_data'  				,'date' 	,'Data'				,'', 'Data'				 ,10	,false, false, false, 1, 'date', 'Data');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'e232_hora'    			,'char(5)' 	,'Hora'				,'', 'Hora'			 	 ,5		,false, true, false,  0, 'text', 'Hora');
        
        -- INSERE db_sysarqcamp
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'e232_sequencial')  , 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'e232_autori') 	  , 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'e232_id_usuario')  , 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'e232_data')		  , 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'e232_hora')		  , 5, 0);
        
        --DROP TABLE:
        DROP TABLE IF EXISTS empautorizliberado CASCADE;
        --Criando drop sequences
        
        -- TABELAS E ESTRUTURA
        
        -- Módulo: Controle Interno
        CREATE TABLE empautorizliberado(
        e232_sequencial		int4 not null default 0,
        e232_autori			int4 not null default 0,
        e232_id_usuario		int4 not null default null,
        e232_data		 	date  default null,
        e232_hora			character(5));
        
        
        -- Criando  sequences
        CREATE SEQUENCE contint_e232_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;
        
        -- CHAVE ESTRANGEIRA
        ALTER TABLE empautorizliberado ADD PRIMARY KEY (e232_sequencial);
        
        ALTER TABLE empautorizliberado ADD CONSTRAINT empautorizliberado_empautoriza_fk
        FOREIGN KEY (e232_autori) REFERENCES empautoriza (e54_autori);
        
        ALTER TABLE empautorizliberado ADD CONSTRAINT empautorizliberado_usuarios_fk
        FOREIGN KEY (e232_id_usuario) REFERENCES db_usuarios (id_usuario);

        COMMIT;

SQL;
        $this->execute($sql);
    }

}