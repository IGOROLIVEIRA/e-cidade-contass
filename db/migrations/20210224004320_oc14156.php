<?php

use Phinx\Migration\AbstractMigration;

class Oc14156 extends AbstractMigration
{
    public function up()
    {
        $sSql = <<<'SQL'
        CREATE TABLE IF NOT EXISTS arrecadacao.abatimentocorrecao
        (
          k167_sequencial integer NOT NULL DEFAULT 0,
          k167_valorantigo double precision NOT NULL,
          k167_valorcorrigido double precision NOT NULL,
          k167_data date NOT NULL,
          k167_abatimento integer,
          CONSTRAINT abatimentocorrecao_sequ_pk PRIMARY KEY (k167_sequencial),
          CONSTRAINT abatimentocorrecao_abatimento_fk FOREIGN KEY (k167_abatimento)
              REFERENCES arrecadacao.abatimento (k125_sequencial) MATCH SIMPLE
              ON UPDATE NO ACTION ON DELETE NO ACTION
        )
        WITH (
          OIDS=TRUE
        );
        ALTER TABLE arrecadacao.abatimentocorrecao
          OWNER TO ecidade;
        GRANT ALL ON TABLE arrecadacao.abatimentocorrecao TO ecidade;
        GRANT SELECT ON TABLE arrecadacao.abatimentocorrecao TO dbseller;
        GRANT SELECT ON TABLE arrecadacao.abatimentocorrecao TO plugin;

SQL;

        $this->execute($sSql);
    }
}
