begin;
CREATE TABLE inscricaorestosapagaremliquidacao(
c107_sequencial		int4 NOT NULL default 0,
c107_ano		int4 NOT NULL default 0,
c107_processado		bool NOT NULL default 'f',
c107_usuario		int4 NOT NULL default 0,
c107_instit		int4 default 0,
CONSTRAINT inscricaorestosapagaremliquidacao_sequ_pk PRIMARY KEY (c107_sequencial));
ALTER TABLE inscricaorestosapagaremliquidacao
ADD CONSTRAINT inscricaorestosapagaremliquidacao_usuario_fk FOREIGN KEY (c107_usuario)
REFERENCES db_usuarios;
ALTER TABLE inscricaorestosapagaremliquidacao
ADD CONSTRAINT inscricaorestosapagaremliquidacao_instit_fk FOREIGN KEY (c107_instit)
REFERENCES db_config;
CREATE SEQUENCE inscricaorestosapagaremliquidacao_c107_sequencial_seq start 1;
commit;
