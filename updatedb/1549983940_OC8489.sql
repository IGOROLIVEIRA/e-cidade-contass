BEGIN;
select fc_startsession();


  -- Name: pessoaflpgo102019; Type: TABLE; Schema: public; Owner: dbportal; Tablespace:


  CREATE TABLE IF NOT EXISTS pessoaflpgo102019 (
      si193_sequencial bigint DEFAULT 0 NOT NULL,
      si193_tiporegistro bigint DEFAULT 0 NOT NULL,
      si193_tipodocumento bigint DEFAULT 0 NOT NULL,
      si193_nrodocumento character varying(14) NOT NULL,
      si193_nome character varying(120) NOT NULL,
      si193_indsexo character varying(1),
      si193_datanascimento date,
      si193_tipocadastro bigint DEFAULT 0 NOT NULL,
      si193_justalteracao character varying(100),
      si193_mes bigint DEFAULT 0 NOT NULL,
      si193_inst bigint DEFAULT 0
  );


  ALTER TABLE IF EXISTS pessoaflpgo102019 OWNER TO dbportal;


  -- Name: pessoaflpgo102019_si193_sequencial_seq; Type: SEQUENCE; Schema: public; Owner: dbportal


  DROP SEQUENCE IF EXISTS pessoaflpgo102019_si193_sequencial_seq;
  CREATE SEQUENCE pessoaflpgo102019_si193_sequencial_seq
      START WITH 1
      INCREMENT BY 1
      NO MINVALUE
      NO MAXVALUE
      CACHE 1;


  ALTER TABLE IF EXISTS pessoaflpgo102019_si193_sequencial_seq OWNER TO dbportal;

  ALTER TABLE IF EXISTS pessoaflpgo102019
      ADD CONSTRAINT pessoaflpgo102019_sequ_pk PRIMARY KEY (si193_sequencial);


COMMIT;

