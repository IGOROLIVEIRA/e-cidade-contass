<?php

use Classes\PostgresMigration;;

class Oc12734 extends PostgresMigration
{
    public function up()
    {
        $sql = <<<SQL
                -- Table: caixa.disrec_desconto_integral

                -- DROP TABLE caixa.disrec_desconto_integral;

                CREATE TABLE caixa.disrec_desconto_integral
                (
                  codcla integer NOT NULL DEFAULT 0,
                  k00_receit integer DEFAULT 0,
                  vlrrec double precision DEFAULT 0,
                  idret integer DEFAULT 0,
                  instit integer NOT NULL,
                  CONSTRAINT disrec_codcla_fk FOREIGN KEY (codcla)
                      REFERENCES caixa.discla (codcla) MATCH FULL
                      ON UPDATE NO ACTION ON DELETE NO ACTION DEFERRABLE INITIALLY IMMEDIATE,
                  CONSTRAINT disrec_instit_fk FOREIGN KEY (instit)
                      REFERENCES configuracoes.db_config (codigo) MATCH FULL
                      ON UPDATE NO ACTION ON DELETE NO ACTION DEFERRABLE INITIALLY IMMEDIATE
                )
                WITH (
                  OIDS=TRUE
                );
                ALTER TABLE caixa.disrec_desconto_integral
                  OWNER TO ecidade;
                GRANT ALL ON TABLE caixa.disrec_desconto_integral TO ecidade;
                GRANT SELECT ON TABLE caixa.disrec_desconto_integral TO dbseller;
                GRANT SELECT ON TABLE caixa.disrec_desconto_integral TO plugin;
                GRANT ALL ON TABLE caixa.disrec_desconto_integral TO usersrole;

                -- Index: caixa.disrec_desconto_integral_codcla_in

                -- DROP INDEX caixa.disrec_desconto_integral_codcla_in;

                CREATE INDEX disrec_desconto_integral_codcla_in
                  ON caixa.disrec_desconto_integral
                  USING btree
                  (codcla);

                -- Index: caixa.disrec_desconto_integral_idret_in

                -- DROP INDEX caixa.disrec_desconto_integral_idret_in;

                CREATE INDEX disrec_desconto_integral_idret_in
                  ON caixa.disrec_desconto_integral
                  USING btree
                  (idret);

                -- Index: caixa.disrec_desconto_integral_instit_in

                -- DROP INDEX caixa.disrec_desconto_integral_instit_in;

                CREATE INDEX disrec_desconto_integral_instit_in
                  ON caixa.disrec_desconto_integral
                  USING btree
                  (instit);

                -- Index: caixa.disrec_desconto_integral_receit_in

                -- DROP INDEX caixa.disrec_desconto_integral_receit_in;

                CREATE INDEX disrec_desconto_integral_receit_in
                  ON caixa.disrec_desconto_integral
                  USING btree
                  (k00_receit);


                -- Trigger: tg_disrec_inc on caixa.disrec_desconto_integral

                -- DROP TRIGGER tg_disrec_inc ON caixa.disrec_desconto_integral;

                CREATE TRIGGER tg_disrec_desconto_integral_inc
                  AFTER INSERT OR UPDATE
                  ON caixa.disrec_desconto_integral
                  FOR EACH ROW
                  EXECUTE PROCEDURE fc_disrec_inc();

                commit;


SQL;
        $this->execute($sql);
    }

    public function down()
    {
        $this->table('disrec_desconto_integral', array('schema' => 'caixa'))->drop();
    }
}
