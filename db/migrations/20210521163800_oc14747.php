<?php

use Phinx\Migration\AbstractMigration;

class Oc14747 extends AbstractMigration
{
    public function up()
    {
      $sql = "

      BEGIN;

      SELECT fc_startsession();

      create table configuracoes.manutencaoacordo(
        manutac_sequencial bigint not null,
        manutac_codunidsubanterior bigint not null,
        manutac_acordo bigint not null
      );

      CREATE SEQUENCE manutencaoacordo_manutac_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;

      create table configuracoes.manutencaolicitacao(
        manutlic_sequencial bigint not null,
        manutlic_codunidsubanterior bigint,
        manutlic_licitacao bigint not null
      );

      CREATE SEQUENCE manutencaolicitacao_manutlic_sequencial_seq
        START WITH 1
        INCREMENT BY 1
        NO MINVALUE
        NO MAXVALUE
        CACHE 1;


      ALTER TABLE configuracoes.manutencaolicitacao ADD CONSTRAINT manutencaolicitacao_liclicita_fk FOREIGN KEY (manutlic_licitacao) REFERENCES licitacao.liclicita(l20_codigo);
      ALTER TABLE configuracoes.manutencaoacordo ADD CONSTRAINT manutencaoacordo_acordo_fk FOREIGN KEY (manutac_acordo) REFERENCES acordos.acordo(ac16_sequencial);

      COMMIT;

        ";

      $this->execute($sql);
    }

    public function down()
    {

    }
}
