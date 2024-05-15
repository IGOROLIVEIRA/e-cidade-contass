<?php

use Phinx\Migration\AbstractMigration;

class Oc18229Ajuste extends AbstractMigration
{

    public function up()
    {
        $sql = "INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Textos padrões Publicação','Textos padrões Publicação','',1,1,'Textos padrões Publicação','t');
        INSERT INTO db_menu VALUES(3470,(select max(id_item) from db_itensmenu),206,381);
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Inclusão','Inclusão','lic1_lictextopublicacao001.php',1,1,'Inclusão','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Textos padrões Publicação%'),(select max(id_item) from db_itensmenu),1,381);
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteração','Alteração','lic1_lictextopublicacao002.php',1,1,'Alteração','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Textos padrões Publicação%'),(select max(id_item) from db_itensmenu),2,381);
        
        INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','lic1_lictextopublicacao003.php',1,1,'Exclusão','t');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Textos padrões Publicação%'),(select max(id_item) from db_itensmenu),3,381);
        

        INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'lictextopublicacao','textos padrões publicação','l214','2022-08-25','textos padrões publicação',0,'f','f','f','f');

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l214_sequencial','int8' ,'Cód. Sequencial','', 'Cód. Sequencial',11,false, false, false, 1, 'int8', 'Cód. Sequencial');

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo),'l214_tipo','varchar(150)' ,'Tipo','', 'Tipo',150,false, false, false, 0, 'text', 'Tipo');

        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l214_texto','text' ,'Texto','','Texto',999999,false, false, false, 0, 'text', 'Descrição da Tabela');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l214_sequencial'), 1, 0);

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l214_tipo'), 2, 0);

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'l214_texto'), 3, 0);

        create table lictextopublicacao(
        l214_sequencial int8 not null default 0,
        l214_tipo  varchar(150) not null,
        l214_texto text not null,
        CONSTRAINT lictextopublicacao_seq_pk PRIMARY KEY (l214_sequencial));

        create sequence lictextopublicacao_l214_sequencial_seq 
        increment 1
        minvalue 1
        MAXVALUE 9223372036854775807
        START 3
        CACHE 1;
        
        INSERT INTO lictextopublicacao VALUES (1,'Aviso de Licitação', 'Processo Licitatório nº \$l20_edital Modalidade \$l20_codtipocomdescr nº \$l20_numero. Critério de Julgamento: \$l20_tipliticacao. Base Legal:\$l20_leidalicitacao. Objeto:\$l20_objeto. Data:\$l20_recdocumentacao. No endereço: \$l20_localentrega. \$instituição, data sistema (formato 01 de Janeiro de 2022.');

        INSERT INTO lictextopublicacao VALUES (2,'Aviso de Chamamento Público:', 'Processo nº \$l20_edital Modalidade \$l20_codtipocomdescr nº \$l20_numero. Base Legal: \$l20_leidalicitacao. Objeto: \$l20_objeto. Data:\$l20_recdocumentacao. No endereço: \$l20_localentrega. \$instituição, data sistema (formato 01 de Janeiro de 2022.');";

        $this->execute($sql);
    }
}
