<?php

use Phinx\Migration\AbstractMigration;

class Oc19964v3 extends AbstractMigration
{
    
    public function up()
    {
        $sql = "BEGIN;
        
        INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'empordemtabela','Itens da ordem de tabela','l223','2022-08-22','Itens da ordem de tabela',0,'f','f','f','f');


        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l223_sequencial','int8' ,'Cod Sequencial','', 'Cod Sequencial',10,false, false, false, 1, 'int8', 'Cod Sequencial');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l223_pcmaterordem','int8' ,'Item da ordem de compras','', 'Item da ordem de compras',10	,false, false, false, 1, 'int8', 'Item da ordem de compras');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l223_pcmatertabela','int8' ,'Item referente a tabela ','', 'Item referente a tabela ',10	,false, false, false, 1, 'int8', 'Item referente a tabela ');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l223_quant','float8' ,'Quantidade','', 'Quantidade',15	,false, false, false, 4, 'float8', 'Quantidade');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l223_vlrn','float8' ,'Valor unitario','', 'Valor unitario',10	,false, false, false, 4, 'float8', 'Valor unitario');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l223_total','float8' ,'Valor total','', 'Valor total',10	,false, false, false, 4, 'float8', 'Valor total');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l223_numemp','int8' ,'Cod Empenho','', 'Cod Empenho',10	,false, false, false, 1, 'int8', 'Cod Empenho');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l223_codordem','int8' ,'Cod ordem','', 'Cod ordem',10	,false, false, false, 1, 'int8', 'Cod ordem');
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l223_descr','varchar' ,'Descricao item tabela','', 'Descricao item tabela',300	,false, false, false, 1, 'varchar', 'Descricao item tabela');
        
        
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l223_sequencial')		 	, 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l223_pcmaterordem')			 	, 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l223_pcmatertabela')		 	, 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l223_quant')		 	, 5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l223_vlrn')		 	, 6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l223_total')		 	, 7, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l223_numemp')		 	, 8, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l223_codordem')		 	, 9, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l223_descr')		 	, 10, 0);
        
        
        CREATE TABLE empordemtabela(
        l223_sequencial         int8 NOT NULL default 0,
        l223_pcmaterordem          int8 NOT NULL default 0,
        l223_pcmatertabela                int8 NOT NULL default 0,
        l223_quant                float8 NOT NULL default 0,
        l223_vlrn                float8 NOT NULL default 0,
        l223_total                float8 NOT NULL default 0,
        l223_numemp                int8 NOT NULL default 0,
        l223_codordem                int8 default 0,
        l223_descr varchar(300));
        
        
        CREATE SEQUENCE empordemtabela_l223_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;
        
        COMMIT;";

        $this->execute($sql);

    }
}
