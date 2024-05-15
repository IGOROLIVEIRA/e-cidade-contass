<?php

use Phinx\Migration\AbstractMigration;

class Oc21320 extends AbstractMigration
{
    public function up()
    {
        $this->verificaDados();
        $this->novosDados();
    }   
    public function novosDados()
    {
        $sqlConsulta = $this->query("SELECT * FROM db_itensmenu WHERE funcao = 'efd1_reinf4099evento001.php'");
        $resultado = $sqlConsulta->fetchAll(\PDO::FETCH_ASSOC);

        $sqlConsulta2 = $this->query("SELECT * FROM db_itensmenu WHERE funcao = 'efd1_reinf2055evento001.php'");
        $resultado2 = $sqlConsulta2->fetchAll(\PDO::FETCH_ASSOC);

        if ($resultado && !$resultado2) {

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
                try {
                        $this->execute($sql);
                } catch (\Exception $e) {
                        echo "Erro ao executar consulta SQL: " . $e->getMessage();
                }
        } 
}
    public function verificaDados()
    {
        $sqlConsulta = $this->query("SELECT * FROM db_sysmodulo WHERE descricao = 'EFD-Reinf'");
        $resultado = $sqlConsulta->fetchAll(\PDO::FETCH_ASSOC);

        $sqlConsulta2 = $this->query("SELECT EXISTS (
                                        SELECT 1
                                        FROM   information_schema.tables 
                                        WHERE  table_schema = 'public'
                                        AND    table_name = 'efdreinfr4010'
                                );");
        $resultado2 = $sqlConsulta2->fetchAll(\PDO::FETCH_ASSOC);

        if (!$resultado && !$resultado2) {
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
                
                        CREATE SEQUENCE IF NOT EXISTS efdreinfr4010_efd03_sequencial_seq START WITH 1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;
        
        COMMIT;
        SQL;

                        try {
                                $this->execute($sql);
                        } catch (\Exception $e) {
                                echo "Erro ao executar consulta SQL: " . $e->getMessage();
                        }
                }
    }        

                


}