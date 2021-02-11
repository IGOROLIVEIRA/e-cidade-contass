<?php

use Classes\PostgresMigration;

class Oc14033 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
  
        BEGIN;
        SELECT fc_startsession();

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Saldos Transferência CTB', 'Saldos Transferência CTB', '', 1, 1, 'Saldos Transferência CTB', 't');

        INSERT INTO db_menu VALUES (
                    (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'TCE/MG') AND descricao = 'Cadastros'), 
                    (SELECT max(id_item) FROM db_itensmenu), 
                    (SELECT CASE
                        WHEN (SELECT count(*) FROM db_menu WHERE db_menu.id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT id_item FROM db_modulos WHERE nome_modulo = 'TCE/MG') AND descricao = 'Relatórios')) = 0 THEN 1 
                        ELSE (SELECT max(menusequencia)+1 as count FROM db_menu WHERE id_item = (SELECT db_menu.id_item_filho FROM db_menu INNER JOIN db_itensmenu ON db_menu.id_item_filho = db_itensmenu.id_item WHERE modulo = (SELECT db_modulos.id_item FROM db_modulos WHERE nome_modulo = 'TCE/MG') AND descricao = 'Relatórios')) 
                    END), 
                    (SELECT id_item FROM db_modulos WHERE nome_modulo = 'TCE/MG')
                );

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Inclusão', 'Inclusão', 'sic1_saldotransfctb001.php', 1, 1, 'Inclusão', 't');

        INSERT INTO db_menu VALUES ((SELECT max(id_item) FROM db_itensmenu where descricao = 'Saldos Transferência CTB'), (SELECT max(id_item) from db_itensmenu), 1, (select id_item FROM db_modulos where nome_modulo = 'TCE/MG'));

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Alteração', 'Alteração', 'sic1_saldotransfctb002.php', 1, 1, 'Alteração', 't');

        INSERT INTO db_menu VALUES ((SELECT max(id_item) FROM db_itensmenu where descricao = 'Saldos Transferência CTB'), (SELECT max(id_item) from db_itensmenu), 2, (select id_item FROM db_modulos where nome_modulo = 'TCE/MG'));

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Exclusão', 'Exclusão', 'sic1_saldotransfctb003.php', 1, 1, 'Exclusão', 't');

        INSERT INTO db_menu VALUES ((SELECT max(id_item) FROM db_itensmenu where descricao = 'Saldos Transferência CTB'), (SELECT max(id_item) from db_itensmenu), 3, (select id_item FROM db_modulos where nome_modulo = 'TCE/MG'));


        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo),'saldotransfctb','Saldos Transferência CTB','si202','2021-02-08','Saldos Transferência CTB',0,'f','f','f','f');

        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod='sicom'), (SELECT max(codarq) FROM db_sysarquivo));

        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si202_seq','int8','Sequencial','', 'Sequencial',11,false,false,false,0,'int8','Sequencial');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si202_codctb','int8','Código CTB','', 'Código CTB',11,false,false,false,1,'int8','Código CTB');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si202_codfontrecursos','int4','Fonte','', 'Fonte',3,false,false,false,1,'int4','Fonte');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si202_saldofinal','float8','Saldo Final','0', 'Saldo Final',14,false,false,false,4,'text','Saldo Final');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si202_anousu','int4','Ano','', 'Ano',10,false,false,false,0,'text','Ano');
        INSERT INTO db_syscampo VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'si202_instit','int4','Instituição','0', 'Instituição',10,false,false,false,1,'int4','Instituição');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si202_seq'), 			1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si202_codctb'), 			2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si202_codfontrecursos'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si202_saldofinal'), 		4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si202_anousu'), 			5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((SELECT max(codarq) FROM db_sysarquivo), (SELECT codcam FROM db_syscampo WHERE nomecam = 'si202_instit'), 			6, 0);

        CREATE TABLE saldotransfctb(
            si202_seq 				bigint not null,
            si202_codctb            bigint not null,
            si202_codfontrecursos   bigint not null,
            si202_saldofinal        double precision DEFAULT 0 NOT NULL,
            si202_anousu            bigint DEFAULT 0 NOT NULL,
            si202_instit           	bigint DEFAULT 0 NOT NULL);


        CREATE SEQUENCE saldotransfctb_si202_seq_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;

        ALTER TABLE saldotransfctb ADD PRIMARY KEY (si202_seq);        
                
        COMMIT;

SQL;
    $this->execute($sql);
  }

}