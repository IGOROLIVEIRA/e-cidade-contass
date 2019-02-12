BEGIN;
select fc_startsession();
  ALTER TABLE ONLY balancete192019
      ADD CONSTRAINT fk_balancete192019_reg10_fk FOREIGN KEY (si186_reg10) REFERENCES balancete102019(si177_sequencial);

  ALTER TABLE ONLY balancete262019 DROP COLUMN IF EXISTS si196_naturezareceita;
COMMIT;
