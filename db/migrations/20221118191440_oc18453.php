<?php

use Phinx\Migration\AbstractMigration;

class Oc18453 extends AbstractMigration
{

    public function up()
    {
        $sql =
            "BEGIN;

            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Importar','Importar','com1_pcmaterimportacao001.php',1,1,'Importar','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao ='Materiais/Serviços'),(select max(id_item) from db_itensmenu),4,28);

            CREATE TABLE importacaoitens(
                pc96_sequencial int8  default 0,
                pc96_descricao varchar(100),
                pc96_codmater int8 not null,
                CONSTRAINT pk_importacao primary key(pc96_sequencial,pc96_codmater)
            
            );
                     
            CREATE SEQUENCE importacaoitens_pc96_sequencial_seq
                                      INCREMENT 1
                                      MINVALUE 1
                                      MAXVALUE 9223372036854775807
                                      START 1
                                      CACHE 1;
                                      
            
                                      ALTER TABLE importacaoitens ADD CONSTRAINT importacaoitens_pcmater_fk
                                      FOREIGN KEY (pc96_codmater) REFERENCES pcmater (pc01_codmater);
                                      
            INSERT INTO db_sysarquivo VALUES((select max(codarq)+1 from db_sysarquivo),'importacaoitens','cadastro de importação de itens','pc96','2022-12-05','cadastro de importação de itens',0,'f','f','f','f');
                                                                
            INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((select codmod from db_sysmodulo where nomemod like '%compras%'), (select max(codarq) from db_sysarquivo));
                                                                
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'pc96_sequencial','int8' ,'Cód. Sequencial','', 'Cód. Sequencial',11	,false, false, false, 1, 'int8', 'Cód. Sequencial');
            
            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'pc96_descricao','text' ,'Descricao da importacao','', 'Descricao da importacao',10	,false, false, false, 0, 'text', 'Descricao da importacao');
            
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'pc96_sequencial'),1, 0);
                                      
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'pc96_descricao'), 2, 0);

            COMMIT;";

        $this->execute($sql);
    }
}
