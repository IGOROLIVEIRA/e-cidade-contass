--Cria tabela veiccaddestino
select fc_startsession();
begin;
CREATE TABLE veiculos.veiccaddestino
(
  ve75_sequencial integer NOT NULL DEFAULT 0,
  ve75_destino character varying(145) NOT NULL,
  CONSTRAINT veiccaddestino_sequ_pk PRIMARY KEY (ve75_sequencial),
  CONSTRAINT veiccadcentral_ve75_destino_in UNIQUE (ve75_destino)
);
ALTER TABLE veiculos.veiccaddestino
  OWNER TO dbportal;

CREATE SEQUENCE veiccaddestino_ve75_sequencial_seq
  INCREMENT 1
  MINVALUE 1
  MAXVALUE 9223372036854775807
  START 1
  CACHE 1;
ALTER TABLE veiccaddestino_ve75_sequencial_seq
  OWNER TO dbportal;

commit;