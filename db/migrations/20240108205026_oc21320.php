<?php

use Phinx\Migration\AbstractMigration;

class Oc21320 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

       -- Alterando Sequencia no Menu

        UPDATE configuracoes.db_menu
        SET menusequencia = 6
        WHERE id_item_filho = (select id_item from db_itensmenu where funcao = 'efd1_reinf4099evento001.php') ;

        UPDATE configuracoes.db_menu
        SET menusequencia = 5
        WHERE id_item_filho = (select id_item from db_itensmenu where funcao = 'efd1_reinf4020evento001.php') ;

        UPDATE configuracoes.db_menu
        SET menusequencia = 4
        WHERE id_item_filho = (select id_item from db_itensmenu where funcao = 'efd1_reinf4010evento001.php') ;

        UPDATE configuracoes.db_menu
        SET menusequencia = 6
        WHERE id_item_filho = (select id_item from db_itensmenu where funcao = 'efd3_reinf4099evento001.php') ;

        UPDATE configuracoes.db_menu
        SET menusequencia = 5
        WHERE id_item_filho = (select id_item from db_itensmenu where funcao = 'efd3_reinf4020evento001.php') ;

        UPDATE configuracoes.db_menu
        SET menusequencia = 4
        WHERE id_item_filho = (select id_item from db_itensmenu where funcao = 'efd3_reinf4010evento001.php') ; 
 
 
        -- Menus evento 2010
        -- Inserindo menu R-2010
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'R-2010 Retenção de contribuição previdenciária - Serviços Tomados','R-2010 Retenção de contribuição previdenciária - Serviços Tomados', 'efd1_reinf2010evento001.php', 1, 1, 'R-2010 Retenção de contribuição previdenciária - Serviços Tomados', 't');
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_itensmenu where descricao like 'Envio de Eventos EFD-Reinf'), (SELECT max(id_item) FROM db_itensmenu),1, (SELECT max(id_item) FROM db_modulos));
       
        -- Inserindo menu R- 2010
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'R-2010 Retenção de contribuição previdenciária - Serviços Tomados', 'R-2010 Retenção de contribuição previdenciária - Serviços Tomados', 'efd3_reinf2010evento001.php', 1, 1, 'R-2010 Retenção de contribuição previdenciária - Serviços Tomados', 't');
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_itensmenu where descricao like 'Consultar Eventos EFD-Reinf'), (SELECT max(id_item) FROM db_itensmenu), 1, (SELECT max(id_item) FROM db_modulos));
 
        -- Menus evento 2055
        -- Inserindo menu R-2055
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'R-2055 Aquisição de produção rural','R-2055 Aquisição de produção rural', 'efd1_reinf2055evento001.php', 1, 1, 'R-2055 Aquisição de produção rural', 't');
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_itensmenu where descricao like 'Envio de Eventos EFD-Reinf'), (SELECT max(id_item) FROM db_itensmenu),2, (SELECT max(id_item) FROM db_modulos));
        
        -- Inserindo menu R- 2055
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'R-2055 Aquisição de produção rural', 'R-2055 Aquisição de produção rural', 'efd3_reinf2055evento001.php', 1, 1, 'R-2055 Aquisição de produção rural', 't');
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_itensmenu where descricao like 'Consultar Eventos EFD-Reinf'), (SELECT max(id_item) FROM db_itensmenu), 2, (SELECT max(id_item) FROM db_modulos));
        
        -- Menus eventos 2098 e 2099
        -- Inserindo menu R-2098 e 2099
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'R-2099 e R-2098 Fechamento/reabertura dos eventos','R-2099 e R-2098 Fechamento/reabertura dos eventos', 'efd1_reinf2099evento001.php', 1, 1, 'R-2099 e R-2098 Fechamento/reabertura dos eventos', 't');
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_itensmenu where descricao like 'Envio de Eventos EFD-Reinf'), (SELECT max(id_item) FROM db_itensmenu),3, (SELECT max(id_item) FROM db_modulos));
        
        -- Inserindo menu R- 2099 Fechamento/reabertura dos eventos
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'R-2099 e R-2098 Fechamento/reabertura dos eventos ', 'R-2099 e R-2098 Fechamento/reabertura dos eventos ', 'efd3_reinf2099evento001.php', 1, 1, 'R-2099 e R-2098 Fechamento/reabertura dos eventos ', 't');
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_itensmenu where descricao like 'Consultar Eventos EFD-Reinf'), (SELECT max(id_item) FROM db_itensmenu), 3, (SELECT max(id_item) FROM db_modulos));
     

        CREATE TABLE efdreinfr2099 (
                    efd04_sequencial     bigint DEFAULT 0 NOT NULL,
                    efd04_mescompetencia character varying(2) NOT NULL,
                    efd04_anocompetencia character varying(4) NOT NULL,
                    efd04_cgm            int8 NOT NULL,
                    efd04_tipo           bigint NOT NULL,
                    efd04_ambiente       bigint NOT NULL,
                    efd04_instit 	 bigint NOT NULL,
                    efd04_protocolo 	 character varying(50),
                    efd04_status  	 int8 NULL,
                    efd04_descResposta   character varying(500) NULL,
                    efd04_dscResp  	 character varying(500) NULL,
                    efd04_dataenvio 	 character varying(50) null,
                    efd04_servicoprev    int8 NOT NULL,
                    efd04_producaorural   int8 NOT NULL
                );
            
        CREATE SEQUENCE efdreinfr2099_efd04_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
                

        CREATE TABLE efdreinfr2010 (
                    efd05_sequencial          int8 DEFAULT 0 NOT NULL,
                    efd05_mescompetencia      character varying(2) NOT NULL,
                    efd05_cnpjprestador       character varying(14) NOT NULL,
                    efd05_estabelecimento     character varying(50) NULL,
                    efd05_ambiente            bigint NOT NULL,
                    efd05_instit 	      bigint NOT NULL,
                    efd05_anocompetencia      character varying(4) NOT NULL,
                    efd05_valorbruto          float8 NULL,
                    efd05_valorbase           float8 NULL,
                    efd05_valorretidocp       float8 NULL,
                    efd05_protocolo 	      character varying(50) null,
                    efd05_dataenvio 	      character varying(50) NULL,
                    efd05_indprestservico     character varying(250) NULL,
                    efd05_optantecprb         int8 NOT NULL,
                    efd05_status    	      int8 NULL,
                    efd05_descResposta        character varying(500) NULL,
                    efd05_dscResp  	      character varying(500) NULL
                
                );
            
        CREATE SEQUENCE efdreinfr2010_efd05_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;



        CREATE TABLE efdreinfnotasr2010 (
                    efd06_sequencial     bigint DEFAULT 0 NOT NULL,
                    efd06_mescompetencia character varying(2) NOT NULL,
                    efd06_anocompetencia character varying(4) NOT NULL,
                    efd06_cnpjprestador  character varying(14) NOT NULL,
                    efd06_tipoServico    character varying(200) NULL,
                    efd06_ambiente       bigint NOT NULL,
                    efd06_instit 	     bigint NOT NULL,
                    efd06_protocolo 	 character varying(50),
                    efd06_serie  	     character varying(50),
                    efd06_numDocto       character varying(50) NULL,
                    efd06_numeroop  	 character varying(50) NULL,
                    efd06_dtEmissaoNF 	 character varying(50) NULL,
                    efd06_vlrBruto       float8  NULL,
                    efd06_vlrBase        float8  NULL,
                    efd06_vlrRetido      float8  NULL
                );
            
        CREATE SEQUENCE efdreinfnotasr2010_efd06_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
                
        
        CREATE TABLE efdreinfr2055 (
            efd07_sequencial          int8 DEFAULT 0 NOT NULL,
            efd07_mescompetencia      character varying(2) NOT NULL,
            efd07_cpfcnpjprodutor    character varying(14) NOT NULL,
            efd07_ambiente            bigint NOT NULL,
            efd07_instit 	          bigint NOT NULL,
            efd07_anocompetencia      character varying(4) NOT NULL,
            efd07_valorbruto          float8 NULL,
            efd07_valorcp             float8 NULL,
            efd07_valorgilrat         float8 NULL,
            efd07_valorsenar          float8 NULL,
            efd07_protocolo 	      character varying(50) null,
            efd07_dataenvio 	      character varying(50) NULL,
            efd07_status    	      int8 NULL,
            efd07_descResposta        character varying(500) NULL,
            efd07_dscResp  	      character varying(500) NULL
        
        );
       
        CREATE SEQUENCE efdreinfr2055_efd07_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
                
        CREATE TABLE efdreinfnotasr2055 (
                    efd08_sequencial       bigint DEFAULT 0 NOT NULL,
                    efd08_mescompetencia   character varying(2) NOT NULL,
                    efd08_anocompetencia   character varying(4) NOT NULL,
                    efd08_cpfcnpjprodutor character varying(14) NOT NULL,
                    efd08_indaquisicao     character varying(500) NULL,
                    efd08_ambiente         bigint NOT NULL,
                    efd08_instit 	   bigint NOT NULL,
                    efd08_protocolo 	   character varying(50),
                    efd08_serie  	   character varying(50),
                    efd08_numnotafiscal    character varying(50) NULL,
                    efd08_numeroop  	 character varying(50) NULL,
                    efd08_numemp  	 character varying(50) NULL,
                    efd08_dtEmissaoNF 	 character varying(50) NULL,
                    efd08_vlrBruto       float8  NULL,
                    efd08_vlrCP          float8  NULL,
                    efd08_vlrGilrat      float8  NULL,
                    efd08_vlrSenar       float8  NULL
                );
            
        CREATE SEQUENCE efdreinfnotasr2055_efd08_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;       
                
         
    COMMIT; 

SQL;
        $this->execute($sql);
    } 
}