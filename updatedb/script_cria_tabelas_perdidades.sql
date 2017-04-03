SELECT fc_startsession();
BEGIN;

CREATE TABLE IF NOT EXISTS contabilidade.inscricaorestosapagarprocessados
(
  c107_sequencial integer NOT NULL DEFAULT 0,
  c107_usuario integer NOT NULL DEFAULT 0,
  c107_instit integer NOT NULL DEFAULT 0,
  c107_ano integer NOT NULL DEFAULT 0,
  c107_processado boolean DEFAULT false,
  CONSTRAINT inscricaorestosapagarprocessados_sequ_pk PRIMARY KEY (c107_sequencial),
  CONSTRAINT inscricaorestosapagarprocessados_instit_fk FOREIGN KEY (c107_instit)
      REFERENCES configuracoes.db_config (codigo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT inscricaorestosapagarprocessados_usuario_fk FOREIGN KEY (c107_usuario)
      REFERENCES configuracoes.db_usuarios (id_usuario) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=TRUE
);
ALTER TABLE contabilidade.inscricaorestosapagarprocessados
  OWNER TO dbportal;
GRANT ALL ON TABLE contabilidade.inscricaorestosapagarprocessados TO dbportal;
GRANT SELECT ON TABLE contabilidade.inscricaorestosapagarprocessados TO dbseller;
GRANT SELECT ON TABLE contabilidade.inscricaorestosapagarprocessados TO plugin;
COMMIT;
begin;

CREATE TABLE contabilidade.conlancaminscrestosapagarprocessados
(
  c108_sequencial integer NOT NULL DEFAULT 0,
  c108_codlan integer NOT NULL DEFAULT 0,
  c108_inscricaorestosapagarprocessados integer DEFAULT 0,
  CONSTRAINT conlancaminscrestosapagarprocessados_sequ_pk PRIMARY KEY (c108_sequencial),
  CONSTRAINT conlancaminscrestosapagarprocessados_codlan_fk FOREIGN KEY (c108_codlan)
      REFERENCES contabilidade.conlancam (c70_codlan) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT conlancaminscrestosapagarprocessados_inscricaorestosapagarna FOREIGN KEY (c108_inscricaorestosapagarprocessados)
      REFERENCES contabilidade.inscricaorestosapagarprocessados (c107_sequencial) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=TRUE
);
ALTER TABLE contabilidade.conlancaminscrestosapagarprocessados
  OWNER TO dbportal;
GRANT ALL ON TABLE contabilidade.conlancaminscrestosapagarprocessados TO dbportal;
GRANT SELECT ON TABLE contabilidade.conlancaminscrestosapagarprocessados TO dbseller;
GRANT SELECT ON TABLE contabilidade.conlancaminscrestosapagarprocessados TO plugin;

CREATE INDEX conlancaminscrestosapagarprocessados_inscricaorestosapagarna
  ON contabilidade.conlancaminscrestosapagarprocessados
  USING btree
  (c108_inscricaorestosapagarprocessados);


CREATE INDEX conlancaminscrestosapagarprocessadosaminscrestosapagarprocessad
  ON contabilidade.conlancaminscrestosapagarprocessados
  USING btree
  (c108_codlan);
commit;

BEGIN;
CREATE INDEX inscricaorestosapagarprocessados_instit_in
  ON contabilidade.inscricaorestosapagarprocessados
  USING btree
  (c107_instit);
COMMIT;
BEGIN;
CREATE INDEX inscricaorestosapagarprocessados_usuario_in
  ON contabilidade.inscricaorestosapagarprocessados
  USING btree
  (c107_usuario);
COMMIT;
BEGIN;
CREATE SEQUENCE inscricaorestosapagarprocessados_c107_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 17
  CACHE 1;
ALTER TABLE inscricaorestosapagarprocessados_c107_sequencial_seq
  OWNER TO dbportal;
COMMIT;
BEGIN;
CREATE SEQUENCE conlancaminscrestosapagarprocessados_c108_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 3229
  CACHE 1;
ALTER TABLE conlancaminscrestosapagarprocessados_c108_sequencial_seq
  OWNER TO dbportal;

commit;