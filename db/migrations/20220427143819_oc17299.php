<?php

use Phinx\Migration\AbstractMigration;

class Oc17299 extends AbstractMigration
{


    public function up()
    {
        $sql = "
        alter table protparam add column p90_protocolosigiloso bool null default false;

        create table permanexo(
            p202_sequencial int8 not null default 0,
            p202_tipo  varchar(200) not null,
            CONSTRAINT permanexo_seq_pk PRIMARY KEY (p202_sequencial)
        
        );
        
        create sequence permanexo_p202_sequencial_seq 
        increment 1
        minvalue 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;
        
        CREATE TABLE public.perfispermanexo (
            p203_permanexo int8 NOT NULL DEFAULT 0,
            p203_perfil int8 NOT NULL DEFAULT 0,
            CONSTRAINT perfispermanexo_permanexo_perfil_pk PRIMARY KEY (p203_permanexo, p203_perfil),
            CONSTRAINT perfispermanexo_permanexo_fk FOREIGN KEY (p203_permanexo) REFERENCES permanexo(p202_sequencial) DEFERRABLE
        );
        
        INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Permiss�es nos anexos','Permiss�es nos anexos','',1,1,'Permiss�es nos anexos','t');
        INSERT INTO db_menu VALUES(29,(select max(id_item) from db_itensmenu),1003,604);
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclus�o','Inclus�o','pro1_permanexo001.php',1,1,'Inclus�o','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Permiss�es nos anexos%'),(select max(id_item) from db_itensmenu),1,604);
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Altera��o','Altera��o','pro1_permanexo002.php',1,1,'Altera��o','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Permiss�es nos anexos%'),(select max(id_item) from db_itensmenu),2,604);
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclus�o','Exclus�o','pro1_permanexo003.php',1,1,'Exclus�o','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Permiss�es nos anexos%'),(select max(id_item) from db_itensmenu),3,604);
        
        
        ALTER TABLE protprocessodocumento ADD column p01_nivelacesso int8;  
        
        
        ALTER TABLE protprocessodocumento ADD CONSTRAINT protprocessodocumento_p01_nivelacesso_fk FOREIGN KEY(p01_nivelacesso) REFERENCES permanexo(p202_sequencial);";
        $this->execute($sql);
    }
}
