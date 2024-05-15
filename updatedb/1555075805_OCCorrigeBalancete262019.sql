BEGIN;
select fc_startsession();

ALTER TABLE balancete262019 RENAME COLUMN si196_saldofinalpessoaatributossf TO si196_saldofinalpessoaatributosf;

COMMIT;
