<?php

use Phinx\Migration\AbstractMigration;

class Oc21142v3 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

        -- INSERE db_sysmodulo
        INSERT INTO db_sysmodulo VALUES((SELECT max(codmod)+1 FROM db_sysmodulo), 'EFD-Reinf', 'EFD-Reinf', '2023-09-06', 't');

        -- INSERE db_modulos
        INSERT INTO db_modulos VALUES((SELECT max(id_item)+1 FROM db_modulos), 'EFD-Reinf', 'EFD-Reinf', '', 't', 'efd-reinf');

        -- INSERE atendcadareamod
        INSERT INTO atendcadareamod VALUES((SELECT max(at26_sequencia)+1 FROM atendcadareamod), 2, (SELECT max(id_item) FROM db_modulos));

        -- INSERE db_usermod
        INSERT INTO db_usermod VALUES(1, 1, (SELECT max(id_item) FROM db_modulos));

        -- INSERE db_sysarquivo
        INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo), 'efdreinf', 'Escrituração Fiscal Digital de Retenções e Outras Informações Fiscais', 'efd01', '2023-09-06', 'EFD-Reinf', 0, 'f', 'f', 'f', 'f');

        -- INSERE db_sysarqmod
        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod LIKE '%EFD-Reinf%'), (SELECT max(codarq) FROM db_sysarquivo));


        -- Inserindo menu Consultas
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_modulos), 31, 2, (SELECT max(id_item) FROM db_modulos));   

        -- Inserindo itens de menu
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'Consultar Eventos EFD-Reinf', 'Consultar de Eventos EFD-Reinf', '', 1, 1, 'Consultar de Eventos EFD-Reinf', 't');
        INSERT INTO db_menu VALUES(31, (SELECT max(id_item) FROM db_itensmenu), 1, (SELECT max(id_item) FROM db_modulos));

        -- Menus 
        -- Inserindo menu R-4010 Pessoa física
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'R-4010 Pessoa física', 'R-4010 Pagamentos/créditos a beneficiário pessoa física', 'efd3_reinf4010evento001.php', 1, 1, 'R-4010 Pagamentos/créditos a beneficiário pessoa física', 't');
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_itensmenu where descricao like 'Consultar Eventos EFD-Reinf'), (SELECT max(id_item) FROM db_itensmenu), 1, (SELECT max(id_item) FROM db_modulos));

        -- Menus
        -- Inserindo menu R-4020 Pessoa jurídica
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'R-4020 Pessoa jurídica', 'R-4020 Pagamentos/créditos a beneficiário pessoa jurídica', 'efd3_reinf4020evento001.php', 1, 1, 'R-4020 Pagamentos/créditos a beneficiário pessoa jurídica', 't');
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_itensmenu where descricao like 'Consultar Eventos EFD-Reinf'), (SELECT max(id_item) FROM db_itensmenu), 2, (SELECT max(id_item) FROM db_modulos));

        -- Menus
        -- Inserindo menu R- 4099 Fechamento/reabertura dos eventos
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'R- 4099 Fechamento/reabertura dos eventos', 'R- 4099 Fechamento/reabertura dos eventos', 'efd3_reinf4099evento001.php', 1, 1, 'R- 4099 Fechamento/reabertura dos eventos', 't');
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_itensmenu where descricao like 'Consultar Eventos EFD-Reinf'), (SELECT max(id_item) FROM db_itensmenu), 3, (SELECT max(id_item) FROM db_modulos));

        -- Inserindo menu Procedimentos
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_modulos), 32, 3, (SELECT max(id_item) FROM db_modulos));

        -- Inserindo itens de menu
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'Envio de Eventos EFD-Reinf', 'Envio de Eventos EFD-Reinf', '', 1, 1, 'Envio de Eventos EFD-Reinf', 't');
        INSERT INTO db_menu VALUES(32, (SELECT max(id_item) FROM db_itensmenu), 1, (SELECT max(id_item) FROM db_modulos));

        -- Menus 
        -- Inserindo menu R-4010 Pessoa física
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'R-4010 Pessoa física', 'R-4010 Pagamentos/créditos a beneficiário pessoa física', 'efd1_reinf4010evento001.php', 1, 1, 'R-4010 Pagamentos/créditos a beneficiário pessoa física', 't');
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_itensmenu where descricao like 'Envio de Eventos EFD-Reinf'), (SELECT max(id_item) FROM db_itensmenu), 1, (SELECT max(id_item) FROM db_modulos));

        -- Menus
        -- Inserindo menu R-4020 Pessoa jurídica
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'R-4020 Pessoa jurídica', 'R-4020 Pagamentos/créditos a beneficiário pessoa jurídica', 'efd1_reinf4020evento001.php', 1, 1, 'R-4020 Pagamentos/créditos a beneficiário pessoa jurídica', 't');
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_itensmenu where descricao like 'Envio de Eventos EFD-Reinf'), (SELECT max(id_item) FROM db_itensmenu), 2, (SELECT max(id_item) FROM db_modulos));

        -- Menus
        -- Inserindo menu R- 4099 Fechamento/reabertura dos eventos
        INSERT INTO db_itensmenu VALUES((SELECT max(id_item)+1 FROM db_itensmenu), 'R- 4099 Fechamento/reabertura dos eventos', 'R- 4099 Fechamento/reabertura dos eventos', 'efd1_reinf4099evento001.php', 1, 1, 'R- 4099 Fechamento/reabertura dos eventos', 't');
        INSERT INTO db_menu VALUES((SELECT max(id_item) FROM db_itensmenu where descricao like 'Envio de Eventos EFD-Reinf'), (SELECT max(id_item) FROM db_itensmenu), 3, (SELECT max(id_item) FROM db_modulos));


        CREATE TABLE efdreinfr4099 (
                    efd01_sequencial     bigint DEFAULT 0 NOT NULL,
                    efd01_mescompetencia character varying(2) NOT NULL,
                    efd01_anocompetencia character varying(4) NOT NULL,
                    efd01_cgm            int8 NOT NULL,
                    efd01_tipo           bigint NOT NULL,
                    efd01_ambiente       bigint NOT NULL,
                    efd01_instit 	     bigint NOT NULL,
                    efd01_protocolo 	 character varying(50),
                    efd01_status  	     int8 NULL,
                    efd01_descResposta   character varying(500) NULL,
                    efd01_dscResp  	     character varying(500) NULL,
                    efd01_dataenvio 	 character varying(50) NULL
                );
            
        CREATE SEQUENCE efdreinfr4099_efd01_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
                
                

        CREATE TABLE efdreinfr4020 (
                    efd02_sequencial          int8 DEFAULT 0 NOT NULL,
                    efd02_mescompetencia      character varying(2) NOT NULL,
                    efd02_cnpjbeneficiario    character varying(14) NOT NULL,
                    efd02_identificadorop     int8 NOT NULL,
                    efd02_ambiente            bigint NOT NULL,
                    efd02_instit 	      bigint NOT NULL,
                    efd02_anocompetencia      character varying(4) NOT NULL,
                    efd02_naturezarendimento  int8 NOT NULL,
                    efd02_valorbruto          float8 NULL,
                    efd02_valorbase           float8 NULL,
                    efd02_valorirrf           float8 NULL,
                    efd02_datafg              date   NOT NULL,
                    efd02_protocolo 	      character varying(50) null,
                    efd02_dataenvio 	      character varying(50) NULL,
                    efd02_numcgm              int8 NOT NULL,
                    efd02_status    	      int8 NULL,
                    efd02_descResposta        character varying(500) NULL,
                    efd02_dscResp  	      character varying(500) NULL
                
                );
            
        CREATE SEQUENCE efdreinfr4020_efd02_sequencial_seq
                START WITH 1
                INCREMENT BY 1
                NO MINVALUE
                NO MAXVALUE
                CACHE 1;
                


        CREATE TABLE efdreinfr4010 (
                    efd03_sequencial          int8 DEFAULT 0 NOT NULL,
                    efd03_mescompetencia      character varying(2) NOT NULL,
                    efd03_cpfbeneficiario     character varying(11) NOT NULL,
                    efd03_identificadorop     int8 NOT NULL,
                    efd03_ambiente            bigint NOT NULL,
                    efd03_instit 	      bigint NOT NULL,
                    efd03_anocompetencia      character varying(4) NOT NULL,
                    efd03_naturezarendimento  int8 NOT NULL,
                    efd03_valorbruto          float8 NULL,
                    efd03_valorbase           float8 NULL,
                    efd03_valorirrf           float8 NULL,
                    efd03_datafg              date   NOT NULL,
                    efd03_protocolo 	      character varying(50) null,
                    efd03_dataenvio 	      character varying(50) NULL,
                    efd03_numcgm              int8 NOT NULL,
                    efd03_status    	      int8 NULL,
                    efd03_descResposta        character varying(500) NULL,
                    efd03_dscResp  	      character varying(500) NULL
                
                );
            
        CREATE SEQUENCE efdreinfr4010_efd03_sequencial_seq
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