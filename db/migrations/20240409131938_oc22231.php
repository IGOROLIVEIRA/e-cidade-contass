<?php

use Phinx\Migration\AbstractMigration;

class Oc22231 extends AbstractMigration
{
    public function up()
    {
        $this->novosDados();
        $this->verificaDados();
    }

    public function novosDados()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();
                    CREATE TABLE IF NOT EXISTS efdreinfr2010 (
                                        efd05_sequencial          int8 DEFAULT 0 NOT NULL,
                                        efd05_mescompetencia      character varying(2) NOT NULL,
                                        efd05_cnpjprestador       character varying(14) NOT NULL,
                                        efd05_estabelecimento     character varying(500) NULL,
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

                    CREATE SEQUENCE IF NOT EXISTS efdreinfr2010_efd05_sequencial_seq
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

    public function verificaDados()
    {
        $sqlConsulta = $this->query("SELECT 1 FROM information_schema.tables WHERE table_name = 'efdreinfr2010'");
        $resultado =  $sqlConsulta->fetchAll(\PDO::FETCH_ASSOC);

        if ($resultado) {

            $sql = <<<SQL

            BEGIN;
            
            SELECT fc_startsession();

                ALTER TABLE efdreinfr2010 ALTER COLUMN efd05_estabelecimento TYPE varchar(500) USING efd05_estabelecimento::varchar(500);
        
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
