BEGIN;
ALTER TABLE acordo ADD column ac16_licitacao int8;
ALTER TABLE acordo ADD CONSTRAINT acordo_liclicita_fk
FOREIGN KEY (ac16_licitacao) REFERENCES liclicita (l20_codigo);
COMMIT;