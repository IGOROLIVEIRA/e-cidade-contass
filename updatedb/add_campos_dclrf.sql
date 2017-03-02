BEGIN;
SELECT fc_startsession();

-- Operações nas tabelas

ALTER TABLE dadoscomplementareslrf ADD COLUMN si170_passivosreconhecidos            float8 NOT NULL default 0;
ALTER TABLE dadoscomplementareslrf ADD COLUMN si170_vltransfobrigemindiv            float8 NOT NULL default 0;
ALTER TABLE dadoscomplementareslrf ADD COLUMN si170_vldotatualizadaincentcontrib    float8 NOT NULL default 0;
ALTER TABLE dadoscomplementareslrf ADD COLUMN si170_vlempenhadoicentcontrib         float8 NOT NULL default 0;
ALTER TABLE dadoscomplementareslrf ADD COLUMN si170_vldotatualizadaincentinstfinanc float8 NOT NULL default 0;
ALTER TABLE dadoscomplementareslrf ADD COLUMN si170_vlempenhadoincentinstfinanc     float8 NOT NULL default 0;


COMMIT;
