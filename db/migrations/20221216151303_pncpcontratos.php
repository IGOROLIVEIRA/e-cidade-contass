<?php

use Phinx\Migration\AbstractMigration;

class Pncpcontratos extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

            INSERT INTO db_menu VALUES(32,(select id_item from db_itensmenu where descricao = 'PNCP'),5,8251);

            INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Publicacao de Contrato', 'Publicacao de Contrato', 'aco1_pncppublicacaocontrato001.php', 1, 1, 'Publicacao de Contrato', 't');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where desctec like'%PNCP' and funcao = ' '),(select max(id_item) from db_itensmenu),1,8251);

            CREATE TABLE acocontratopncp(
                            ac213_sequencial          int8 NOT NULL,
                            ac213_contrato            int8 NOT NULL,
                            ac213_usuario			  int8 NOT NULL,
                            ac213_dtlancamento        date NOT NULL,
                            ac213_numerocontrolepncp  text NOT NULL,
                            ac213_situacao			  int8 NOT NULL,
                            ac213_instit              int8 NOT NULL,
                            ac213_ano				  int8 NOT NULL,	
                            ac213_sequencialpncp      int8 NOT NULL,
                            PRIMARY KEY (ac213_sequencial),
                            FOREIGN KEY (ac213_contrato) REFERENCES acordo (ac16_sequencial)
                        );

            ALTER TABLE acocontratopncp
            ADD CONSTRAINT fk_id_acsituacaocontratopncp FOREIGN KEY (ac213_situacao) REFERENCES licsituacaocontrolepncp(l214_sequencial);
            
            --criando sequencia
            CREATE SEQUENCE acocontratopncp_ac213_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;

            CREATE TABLE licitacao.liccategoriaprocesso(
                l216_codigo          int8 NOT NULL,
                l216_liclicita       int8,
                l216_descr			 character varying(30) ,
               
                PRIMARY KEY (l216_codigo),
                FOREIGN KEY (l216_liclicita) REFERENCES liclicita (l20_codigo));

            
              --criando sequencia
            CREATE SEQUENCE liccategoriaprocesso_l216_codigo_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;   

            INSERT INTO licitacao.liccategoriaprocesso
	        (l216_codigo,l216_descr)	
            VALUES 
            (1,'Cessão'),
            (2,'Compras'),
            (3,'Informática (TIC)'),
            (4,'Internacional'),
            (5,'Locação Imóveis'),
            (6,'Mão de Obra'),
            (7,'Obras'),
            (8,'Serviços'),
            (9,'Serviços de Engenharia'),
            (10,'Serviços de Saúde');    


        ALTER TABLE liclicita ADD l20_categoriaprocesso character varying(30);

        INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Publicação de Empenho', 'Publicação de Empenho', 'lic1_publicacaoempenhopncp.php', 1, 1, 'Publicação de Empenho', 't');
        INSERT INTO db_menu VALUES((select id_item from db_itensmenu where desctec like'%PNCP' and funcao = ' '),(select max(id_item) from db_itensmenu),4,381);
        
    COMMIT;

SQL;
        $this->execute($sql);
    } 
}