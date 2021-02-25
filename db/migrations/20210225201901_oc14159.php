<?php

use Phinx\Migration\AbstractMigration;

class Oc14159 extends AbstractMigration
{
    public function up()
    {
        $sSql = <<<'SQL'
        CREATE TABLE  IF NOT EXISTS arrecadacao.abatimentoutilizacaodestino
        (
          k170_utilizacao integer NOT NULL,
          k170_numpre integer NOT NULL,
          k170_numpar integer NOT NULL,
          k170_receit integer NOT NULL,
          k170_hist integer NOT NULL,
          k170_tipo integer NOT NULL,
          k170_valor numeric(15,2) DEFAULT 0,
          CONSTRAINT abatimentoutilizacaodestino_utilizacao_fk FOREIGN KEY (k170_utilizacao)
              REFERENCES arrecadacao.abatimentoutilizacao (k157_sequencial) MATCH SIMPLE
              ON UPDATE NO ACTION ON DELETE NO ACTION
        )
        WITH (
          OIDS=TRUE
        );
        ALTER TABLE arrecadacao.abatimentoutilizacaodestino
          OWNER TO ecidade;
        GRANT ALL ON TABLE arrecadacao.abatimentoutilizacaodestino TO ecidade;
        GRANT SELECT ON TABLE arrecadacao.abatimentoutilizacaodestino TO dbseller;
        GRANT SELECT ON TABLE arrecadacao.abatimentoutilizacaodestino TO plugin;
        GRANT ALL ON TABLE arrecadacao.abatimentoutilizacaodestino TO usersrole;

SQL;

        $this->execute($sSql);
    }

}