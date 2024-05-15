<?php

use Phinx\Migration\AbstractMigration;

class Oc18458 extends AbstractMigration
{

    public function up()
    {
        $sql=" BEGIN;
        
        INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'situacaoitem','cadastro da situação do item de uma licitacao','l217','2022-09-14','cadastro da situação do item de uma licitacao',0,'f','f','f','f');


        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l217_sequencial','int8' ,'Cód. Sequencial','', 'Cód. Sequencial',8,false, false, false, 1, 'int8', 'Cód. Sequencial');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l217_codsituacao','int8' ,'Cód. identificador','', 'CCód. identificador',8,false, false, false, 1, 'int8', 'Cód. identificador');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l217_descr','varchar' ,'Descricao da Situação','', 'Descricao da Situação',255 ,false, false, false, 0, 'varchar', 'Descricao da Situação');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l217_ativo','bool' ,'Alterações da leiaute','', 'Alterações da leiaute',10 ,false, false, false, 0, 'bool', 'Alterações da leiaute');



        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l217_sequencial'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l217_codsituacao'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l217_descr'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l217_ativo'), 4, 0);


        CREATE TABLE situacaoitem(
        l217_sequencial int8 NOT NULL default 0,
        l217_codsituacao int8 NOT NULL default 0,
        l217_descr varchar(255) NOT NULL,
        l217_ativo bool NOT NULL default true);


        CREATE SEQUENCE situacaoitem_l217_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;


        ALTER TABLE situacaoitem ADD PRIMARY KEY (l217_sequencial);


        INSERT INTO situacaoitem values (1,1,'Em Andamento',true);
        INSERT INTO situacaoitem values (2,2,'Homologado ',true);
        INSERT INTO situacaoitem values (3,3,'Anulado ',true);
        INSERT INTO situacaoitem values (4,4,'Deserto',true);
        INSERT INTO situacaoitem values (5,5,'Fracassado',true);





        INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'situacaoitemcompra','Acompanhamento do processo licitatorio','l218','2022-09-14','Acompanhamento do processo licitatorio',0,'f','f','f','f');


        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l218_codigo','int8' ,'Cód. Sequencial','', 'Cód. Sequencial',8,false, false, false, 1, 'int8', 'Cód. Sequencial');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l218_codigolicitacao','int8' ,'Cód Licitacao','', 'Cód Licitacao',8,false, false, false, 1, 'int8', 'Cód Licitacao');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l218_pcorcamitemlic','int8' ,'Cód pcorcamjulg','', 'Cód pcorcamjulg',8,false, false, false, 1, 'int8', 'Cód pcorcamjulg');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l218_liclicitem','int8' ,'Cód. liclicitem','', 'Cód. liclicitem',8,false, false, false, 1, 'int8', 'Cód. liclicitem');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l218_pcmater','int8' ,'Cód. pcmater','', 'Cód. pcmater',8,false, false, false, 1, 'int8', 'Cód. pcmater');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l218_motivoanulacao','int8' ,'Motivo anulação','', 'Motivo anulação',8,false, false, false, 1, 'int8', 'Motivo anulação');



        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l218_codigo'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l218_codigolicitacao'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l218_pcorcamitemlic'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l218_liclicitem'), 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l218_pcmater'), 5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l218_motivoanulacao'), 6, 0);


        CREATE TABLE situacaoitemcompra(
        l218_codigo int8 NOT NULL default 0,
        l218_codigolicitacao int8 NOT NULL default 0,
        l218_pcorcamitemlic int8 NOT NULL default 0,
        l218_liclicitem int8 NOT NULL default 0,
        l218_pcmater int8 NOT NULL default 0,
        l218_motivoanulacao varchar(255));


        CREATE SEQUENCE situacaoitemcompra_l218_codigo_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;


        ALTER TABLE situacaoitemcompra ADD PRIMARY KEY (l218_codigo);

        ALTER TABLE situacaoitemcompra ADD CONSTRAINT situacaoitemcompra_liclicita_fk
        FOREIGN KEY (l218_codigolicitacao) REFERENCES liclicita (l20_codigo);

        ALTER TABLE situacaoitemcompra ADD CONSTRAINT situacaoitemcompra_pcorcamitem_fk
        FOREIGN KEY (l218_pcorcamitemlic) REFERENCES pcorcamitem (pc22_orcamitem);

        ALTER TABLE situacaoitemcompra ADD CONSTRAINT situacaoitemcompra_liclicitem_fk
        FOREIGN KEY (l218_liclicitem) REFERENCES liclicitem (l21_codigo);


        
         

        INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'situacaoitemlic','Acompanhamento do item do processo licitatorio','l219','2022-09-14','Acompanhamento do item do processo licitatorio',0,'f','f','f','f');

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l219_codigo','int8' ,'Cód. Sequencial','', 'Cód. Sequencial',8,false, false, false, 1, 'int8', 'Cód. Sequencial');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l219_situacao','int8' ,'Cód Situação','', 'Cód Situação',8,false, false, false, 1, 'int8', 'Cód Situação');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l219_data','date' ,'Data mudança de situação','', 'Data mudança de situação',16	,false, false, false, 0, 'date', 'Data mudança de situação');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l219_id_usuario','int8' ,'Usuario','', 'Usuario',16	,false, false, false, 0, 'int8', 'Usuario');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l219_hora','varchar' ,'hora','', 'hora',5	,false, false, false, 0, 'varchar', 'hora');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l219_codigo'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l219_situacao'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l219_data'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l219_id_usuario'), 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l219_hora'), 5, 0);
        
        
        
        CREATE TABLE situacaoitemlic(
        l219_codigo int8 NOT NULL default 0,
        l219_situacao int8 NOT NULL default 0,
        l219_data date NOT NULL,
        l219_id_usuario int8 NOT NULL,
        l219_hora varchar(5) NOT NULL);



        ALTER TABLE situacaoitemlic ADD CONSTRAINT situacaoitemlic_situacaoitemcompra_fk
        FOREIGN KEY (l219_codigo) REFERENCES situacaoitemcompra (l218_codigo);

        ALTER TABLE situacaoitemlic ADD CONSTRAINT situacaoitemlic_situacaoitem_fk
        FOREIGN KEY (l219_situacao) REFERENCES situacaoitem (l217_sequencial);

        COMMIT;
        
        ";

        $this->execute($sql);
    }
}
