<?php

use Phinx\Migration\AbstractMigration;

class Oc10887 extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL
CREATE TABLE bemfoto(t54_sequencial integer NOT NULL DEFAULT 0,
                     t54_numbem integer NOT NULL DEFAULT 0,
                     t54_id_usuario integer not null DEFAULT 0,
                     t54_data date NOT NULL,
                     t54_hora character(5) NOT NULL,
                     t54_fotoativa boolean DEFAULT TRUE,
                     t54_principal boolean NOT NULL DEFAULT FALSE,
                     t54_arquivofoto oid);

CREATE INDEX bemfoto_sequ_pk ON bemfoto USING btree (t54_sequencial);
CREATE INDEX bemfoto_bem_in ON bemfoto USING btree (t54_numbem);
CREATE INDEX bemfoto_principal_in ON bemfoto USING btree (t54_principal);
CREATE INDEX bemfotos_usuario_in ON bemfoto USING btree (t54_id_usuario);

CREATE SEQUENCE bemfoto_t54_sequencial_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE ONLY bemfoto ADD CONSTRAINT bemfoto_numbem_fk FOREIGN KEY (t54_numbem) REFERENCES bens(t52_bem);
ALTER TABLE ONLY bemfoto ADD CONSTRAINT bemfoto_usuario_fk FOREIGN KEY (t54_id_usuario) REFERENCES db_usuarios(id_usuario);

UPDATE db_itensmenu set funcao = 'pat1_bensglobalabas001.php' where id_item = 3840;
UPDATE db_itensmenu set funcao = 'pat1_bensglobalabas002.php' where id_item = 5151;

SQL;

        $this->execute($sql);
    }

    public function down()
    {
        $this->execute("drop table bemfoto");
        $this->execute("DROP SEQUENCE bemfoto_t54_sequencial_seq");
        $this->execute("UPDATE db_itensmenu set funcao = 'pat1_bensglobal001.php' where id_item = 3840");
        $this->execute("UPDATE db_itensmenu set funcao = 'pat1_bensaltlote001.php' where id_item = 5151");
    }
}
