BEGIN;

ALTER TABLE tiporeferenciacalculo alter column la61_tiporeferencialnumerico drop not null;
ALTER TABLE tiporeferenciacalculo alter column la61_atributobase drop not null;
ALTER TABLE tiporeferenciacalculo alter column la61_tipocalculo drop not null;

COMMIT;