<?php

use Phinx\Migration\AbstractMigration;

class Pncp extends AbstractMigration
{

    public function up()
    {
        $sql = "
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo),'l213_numerocontrolepncp','varchar(28)','Código PNCP','','Código PNCP',28,false,false,false,1,'text','Código PNCP');
                INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo),'l215_ata','varchar(28)','Código Ata PNCP','','Código Ata PNCP',28,false,false,false,1,'text','Código Ata PNCP');

                INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'PNCP', 'PNCP', ' ', 1, 1, 'PNCP', 't');
                INSERT INTO db_menu VALUES(1818,(select max(id_item) from db_itensmenu),16,381);

                INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Publicação de Aviso', 'Publicação de Aviso', 'lic1_pncpavisolicitacao001.php', 1, 1, 'Publicação de Aviso', 't');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where desctec like'%PNCP' and funcao = ' '),(select max(id_item) from db_itensmenu),1,381);

                INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Publicação Resultados', 'Publicação Resultados', 'lic1_pncpresultadolicitacao001.php', 1, 1, 'Publicação Resultados', 't');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where desctec like'%PNCP' and funcao = ' '),(select max(id_item) from db_itensmenu),2,381);  
                
                INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Publicação Ata Registro Preço', 'Publicação Ata Registro Preço', 'lic1_publicacaoatapncp.php', 1, 1, 'Publicação Ata Registro Preço', 't');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where desctec like'%PNCP' and funcao = ' '),(select max(id_item) from db_itensmenu),3,381);

                CREATE TABLE licontroleatarppncp(
                    l215_sequencial           int8 NOT NULL,
                    l215_licitacao            int8 NOT NULL,
                    l215_usuario			  int8 NOT NULL,
                    l215_dtlancamento         date NOT NULL,
                    l215_numerocontrolepncp   text NOT NULL,
                    l215_situacao			  int8 NOT NULL,
                    l215_ata 			  	  int8 NOT NULL,
                    l215_anousu 			  int8 NOT NULL,
                    PRIMARY KEY (l215_sequencial),
                    FOREIGN KEY (l215_licitacao) REFERENCES liclicita (l20_codigo)
                );
    
        ";
        $this->execute($sql);
    }
}
