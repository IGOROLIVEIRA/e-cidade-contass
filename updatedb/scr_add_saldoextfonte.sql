BEGIN;

INSERT INTO db_itensmenu VALUES (3000254, 'Saldo Ext Fonte', '','con1_conextsaldo001.php',1,1,'','t');

INSERT INTO db_menu VALUES (29,3000254,(select max(menusequencia)+1 from db_menu where id_item = 29),209);


DROP TABLE IF EXISTS conextsaldo CASCADE;

DROP SEQUENCE IF EXISTS conextsaldo_ces01_sequencial_seq;

CREATE SEQUENCE conextsaldo_ces01_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE conextsaldo(
ces01_sequencial                int8 NOT NULL default 0,
ces01_codcon            int8 NOT NULL default 0,
ces01_reduz             int8 NOT NULL default 0,
ces01_fonte             int8 NOT NULL default 0,
ces01_valor             float8 NOT NULL default 0,
ces01_anousu            int8 NOT NULL default 0,
ces01_inst              int8 default 0,
CONSTRAINT conextsaldo_sequ_pk PRIMARY KEY (ces01_sequencial));

ALTER TABLE conextsaldo
ADD CONSTRAINT conextsaldo_fonte_fk FOREIGN KEY (ces01_fonte)
references orctiporec;

ALTER TABLE conextsaldo
ADD CONSTRAINT conextsaldo_codcon_fk FOREIGN KEY (ces01_codcon,ces01_anousu)
REFERENCES conplano;

COMMIT;