BEGIN;

select fc_startsession();

INSERT INTO db_itensmenu VALUES (3000264, 'Saldo Ctb Fonte', '','con1_conctbsaldo001.php',1,1,'','t');

INSERT INTO db_menu VALUES (29,3000264,(select max(menusequencia)+1 from db_menu where id_item = 29),209);


DROP TABLE IF EXISTS conctbsaldo CASCADE;

DROP SEQUENCE IF EXISTS conctbsaldo_ces02_sequencial_seq;

CREATE SEQUENCE conctbsaldo_ces02_sequencial_seq
INCREMENT 1
MINVALUE 1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

CREATE TABLE conctbsaldo(
ces02_sequencial                int8 NOT NULL default 0,
ces02_codcon            int8 NOT NULL default 0,
ces02_reduz             int8 NOT NULL default 0,
ces02_fonte             int8 NOT NULL default 0,
ces02_valor             float8 NOT NULL default 0,
ces02_anousu            int8 NOT NULL default 0,
ces02_inst              int8 default 0,
CONSTRAINT conctbsaldo_sequ_pk PRIMARY KEY (ces02_sequencial));

ALTER TABLE conctbsaldo
ADD CONSTRAINT conctbsaldo_fonte_fk FOREIGN KEY (ces02_fonte)
references orctiporec;

ALTER TABLE conctbsaldo
ADD CONSTRAINT conctbsaldo_codcon_fk FOREIGN KEY (ces02_codcon,ces02_anousu)
REFERENCES conplano;

COMMIT;