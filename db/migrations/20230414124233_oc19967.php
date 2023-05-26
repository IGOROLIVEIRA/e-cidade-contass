<?php

use Phinx\Migration\AbstractMigration;

class Oc19967 extends AbstractMigration
{

    public function up()
    {
        $sql =  "begin;

        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Lan�amento de Manuten��o','Lan�amento de Manuten��o','',1,1,'Lan�amento de Manuten��o','t');
        
        INSERT INTO db_menu VALUES(32,(select max(id_item) from db_itensmenu),16,439);
        
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclus�o','Inclus�o','pat1_lancmanutencao001.php',1,1,'Inclus�o','t');
        
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao ='Lan�amento de Manuten��o'),(select max(id_item) from db_itensmenu),1,439);

        -- INSERE tabela no dicionario de dados
INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'bemmanutencao','Cadastro de Manuten��o de Bens','t98','2023-04-18','Cadastro de Manuten��o de Bens',0,'f','f','f','f');

-- INSERE CAMPOS
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_sequencial','int8' ,'C�d. Sequencial','', 'C�d. Sequencial',11,false, false, false, 1, 'int8', 'C�d. Sequencial');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_bem','int8' ,'C�d. do Bem','', 'C�d. do Bem',11,false, false, false, 1, 'int8', 'C�d. do Bem');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_data','date' ,'Data','', 'Data',8,false, false, false, 1, 'date', 'Data');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_descricao','varchar(500)' ,'Descri��o da Manuten��o','', 'Descri��o da Manuten��o',10,false, false, false, 1, 'varchar(500)', 'Descri��o da Manuten��o');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_vlrmanut','float' ,'Valor da Manuten��o','', 'Valor da Manuten��o',15,false, false, false, 1, 'float', 'Valor da Manuten��o');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_idusuario','int' ,'Id do Usuario','', 'Usuario',10,false, false, false, 1, 'int', 'Usuario');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_dataservidor','date' ,'Data da Manuten��o','', 'Data da Manuten��o',8,false, false, false, 1, 'date', 'Data da Manuten��o');
INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 't98_horaservidor','time' ,'Horario da Manuten��o','', 'Horario da Manuten��o',8,false, false, false, 1, 'time', 'Horario da Manuten��o');



-- INSERE VINCULO DO CAMPO COM A TABELA
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_sequencial'), 1, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_bem'), 2, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_data'), 3, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_descricao'), 4, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_vlrmanut'), 5, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_idusuario'), 6, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_dataservidor'), 7, 0);
INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 't98_horaservidor'), 8, 0);


CREATE TABLE bemmanutencao (
	t98_sequencial int8 not null
    ,t98_bem int NOT NULL 
    ,t98_data date not null
    ,t98_descricao  varchar(500) not null
    ,t98_vlrmanut float not null
    ,t98_idusuario int not null
    ,t98_dataservidor date not null
    ,t98_horaservidor time not null);
        
       
CREATE SEQUENCE bemmanutencao_t98_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;


ALTER TABLE bemmanutencao ADD PRIMARY KEY (t98_sequencial);

ALTER TABLE bemmanutencao ADD CONSTRAINT bemmanutencao_patrimonio_fk
FOREIGN KEY (t98_bem) REFERENCES bens (t52_bem);
        
        commit;";

        $this->execute($sql);
    }
}
