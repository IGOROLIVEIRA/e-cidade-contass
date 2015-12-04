BEGIN;
SELECT fc_startsession();
ALTER TABLE bensbaix ADD column t55_destino int8 null;
ALTER TABLE bensbaix
ADD CONSTRAINT bensbaix_destino_fk FOREIGN KEY (t55_destino)
REFERENCES cgm(z01_numcgm);
COMMIT;
